<?php
class SalesController extends AppController
{
	public $uses = array('Sale');
	public function isAuthorized()
	{
		if (Employee::$auth['rank'] >= 5)
			return true;
	}
	public function index()
	{
		$this->paginate['Sale'] = array(
			'contain' => array('Customer', 'Employee'),
			'order' => 'Sale.id DESC',
			'conditions' => array('Sale.deleted' => '0'),
			'limit' => 10
		);
		$this->set('sales', $this->paginate('Sale'));
	}
	public function view($id = null)
	{
		$this->check($id, 'Sale');
		$this->set('sale', $this->Sale->find('first', array(
			'conditions' => array('Sale.id' => $id),
			'contain' => array('SoldItem' => array('Item'), 'Employee', 'Customer')))
		);
	}
	public function refund($id = null)
	{
		$this->update_sale();
		$this->render('form');
	}
	public function add()
	{
		$this->loadModel('Customer');
		$this->set('customers', $this->Customer->find('list'));
		$this->update_sale();
		$this->render('form');
	}
	public function review()
	{
		$this->update_sale();
		if ($this->check_items())
		{
			$this->loadModel('Customer');
			$this->set('customer', $this->Customer->find('first', array('conditions' => array('id' => $this->Session->read('Sale.customer_id')))));
			$this->set('sale', $this->Session->read('Sale'));
			$this->set('sold_items', $this->Session->read('SoldItem'));
		}
		else
			$this->flash('No items added to sale!', 'error', array('action' => 'add'));
	}
	public function finish()
	{
		if ($this->check_items())
		{
			$this->update_sale();
			unset($this->data);
			$this->data['Sale'] = $this->Session->read('Sale');
			$this->data['SoldItem'] = $this->Session->read('SoldItem');
			$this->Sale->create();
			if ($this->Sale->saveAll($this->data))
			{
				$this->clear(false);
				$this->redirect(array('action' => 'view', $this->Sale->id));
			}
			$this->flash('Could not save sale!', 'error', array('action' => 'add'));
		}
		else
			$this->flash('No items added to sale!', 'error', array('action' => 'add'));
	}
	public function update_sale()
	{
		if (!empty($this->data['Sale']['customer_id']))
			$this->Session->write('Sale.customer_id', $this->data['Sale']['customer_id']);
		$sold_items = $this->Session->read('SoldItem');
		$total = 0;
		if ($this->check_items())
		{
			foreach ($sold_items as $key => $sold_item)
				$this->edit_item($key);
			$sold_items = $this->Session->read('SoldItem');
			foreach ($sold_items as $key => $sold_item)
				$total += (float) $sold_item['net_price'];
		}
		$this->Session->write('Sale.total', $total);
		if (!empty($this->data['Sale']['payment']))
			$this->Session->write('Sale.payment', $this->data['Sale']['payment']);
		$this->Session->write('Sale.balance', ($total - $this->Session->read('Sale.payment')));
		
	}
	public function check_items()
	{	
		if (count($this->Session->read('SoldItem')) > 0)
			return true;
		else
			return false;
	}
	public function check_item($id)
	{
		if ($this->Session->check('SoldItem.'.$id))
			return true;
		else
			return false;
	}
	public function add_item($id = null)
	{
		$this->loadModel('Item');
		$item = $this->Item->find('first', array(
			'conditions' => array('Item.id' => $id), 'contain' => array(), 'fields' => array('Item.id','Item.name','Item.sell_price','Item.cost_price','Item.serialized','Item.stock'))
		);
		if (empty($item))
			$this->flash('Could not find item!', 'error', array('action' => 'add'));
		$item = $item['Item'];
		$item['item_id'] = $item['id'];
		unset($item['id']);
		$sold_items = $this->Session->read('SoldItem');
		$count = 0;
			$item_count = 0;
			$item_in_sale = false;
		if (!empty($sold_items))
		{
			foreach($sold_items as $key => $sold_item)
			{
				if ($key >= $count)
					$count = $key;
				if ($sold_item['item_id'] == $item['item_id'])
				{
					$item_in_sale = $key;
					$item_count++;
				}
			}
			$count++;
		}
		if (($item['serialized'] == 1) || (($item_in_sale === false) && ($item['serialized'] == 0)))
		{
			if (($item['stock'] <= $item_count) || ($item['stock'] <= 0))
				$this->flash($item['name'].' stock finished!','warning', array('action' => 'add'));
			$item['serial'] = '';
			$item['quantity'] = 1;
			$item['discount'] = (float) 0.00;
			$item['net_price'] = (float) $item['sell_price'];
		}
		else
		{
			$count = $item_in_sale;
			$item = $this->Session->read('SoldItem.'.$count);
			if ($item['stock'] <= $sold_item['quantity'])
				$this->flash($item['name'].' stock finished!','warning', array('action' => 'add'));
			$item['quantity']++;
			$item['net_price'] = (float) $item['sell_price'] * $item['quantity'] - $item['discount'];
		}
		$this->Session->write('SoldItem.'.$count, $item);
		$this->redirect(array('action' => 'add'));
	}
	public function edit_item($id = null)
	{
		$this->check_item($id);
		if (!empty($this->data['SoldItem'][$id]))
		{
			$item = $this->Session->read('SoldItem.'.$id);
			$item['serial'] = (!empty($this->data['SoldItem'][$id]['serial'])) ? $this->data['SoldItem'][$id]['serial'] : '';
			if (!empty($this->data['SoldItem'][$id]['quantity']))
				if (($this->data['SoldItem'][$id]['quantity'] > 0) && ($item['stock'] >= $this->data['SoldItem'][$id]['quantity']))
					$item['quantity'] = $this->data['SoldItem'][$id]['quantity'];
				else
				{
					$item['quantity'] = $item['stock'];
					$this->flash($item['name'].' stock finished!','warning');
				}
			if (!empty($this->data['SoldItem'][$id]['discount']) || ($this->data['SoldItem'][$id]['discount'] == 0))
			{
				$profit = ($item['sell_price'] - $item['cost_price']) * $item['quantity'];
				$profit_percent = ($profit - $this->data['SoldItem'][$id]['discount']) / $profit;
				if ($profit_percent >= Employee::$auth['profit_percent'])
					$item['discount'] = $this->data['SoldItem'][$id]['discount'];
				else
					$this->flash('You are out of your discount limit!','warning');
			}
			$item['net_price'] = (float) $item['sell_price'] * $item['quantity'] - $item['discount'];
			$this->Session->write('SoldItem.'.$id, $item);
		}
	}
	public function delete_item($id = null)
	{
		$this->check_item($id);
		$this->Session->delete('SoldItem.'.$id);
		$this->update_sale();
		$this->redirect(array('action' => 'add'));
	}
	public function clear($redirect = true)
	{
		$this->Session->delete('Sale');
		$this->Session->delete('SoldItem');
		$sale = array('total' => 0.00, 'payment' => 0.00, 'balance' => 0.00);
		$this->Session->write('Sale', $sale);
		if ($redirect)
			$this->redirect(array('action' => 'add'));
	}
}