<?php
class OrdersController extends AppController
{
	public $uses = array('Order');
	public function isAuthorized()
	{
		if (Employee::$auth['rank'] >= 8)
			return true;
	}
	public function index()
	{
		$this->paginate['Order'] = array(
			'contain' => array('Supplier', 'Employee'),
			'order' => 'Order.id DESC',
			'conditions' => array('Order.deleted' => '0'),
			'limit' => 10
		);
		$this->set('orders', $this->paginate('Order'));
	}
		public function view($id = null)
		{
		$this->check($id, 'Order');
		$this->set('order', $this->Order->find('first', array(
			'conditions' => array('Order.id' => $id),
			'contain' => array('OrderedItem' => array('Item'), 'Employee', 'Supplier')
		)));
	}
	public function add()
	{
		$this->loadModel('Supplier');
		$this->set('suppliers', $this->Supplier->find('list'));
		$this->update_order();
		$this->render('form');
	}
	public function review()
	{	
		$this->update_order();
		if ($this->check_items())
		{
			$this->loadModel('Supplier');
			$this->set('supplier', $this->Supplier->find('first', array('conditions' => array('id' => $this->Session->read('Order.supplier_id')))));
			$this->set('order', $this->Session->read('Order'));
			$this->set('ordered_items', $this->Session->read('OrderedItem'));
		}
		else
			$this->flash('No items added to order!', 'error', array('action' => 'add'));
	}
	public function finish()
	{
		if ($this->check_items())
		{
			$this->update_order();
			unset($this->data);
			$this->data['Order'] = $this->Session->read('Order');
			$this->data['OrderedItem'] = $this->Session->read('OrderedItem');
			$this->Order->create();
			if ($this->Order->saveAll($this->data))
			{
				$this->clear(false);
				$this->redirect(array('action' => 'view', $this->Order->id));
			}
			$this->flash('Could not save order!', 'error', array('action' => 'add'));
		}
		else
			$this->flash('No items added to order!', 'error', array('action' => 'add'));
	}
	public function update_order()
	{
		if (!empty($this->data['Order']['supplier_id']))
			$this->Session->write('Order.supplier_id', $this->data['Order']['supplier_id']);
		if (!empty($this->data['Order']['invoice_no']))
			$this->Session->write('Order.invoice_no', $this->data['Order']['invoice_no']);
		$order = $this->Session->read('Order');
		$ordered_items = $this->Session->read('OrderedItem');
		$total = 0;
		if ($this->check_items())
		{
			foreach ($ordered_items as $key => $ordered_item)
				$this->edit_item($key);
			$ordered_items = $this->Session->read('OrderedItem');
			foreach ($ordered_items as $key => $ordered_item)
				$total += (float) $ordered_item['net_price'];
		}
		$this->Session->write('Order.total', $total);
		if ((!empty($this->data['Order']['discount'])) || ($this->data['Order']['discount'] === 0))
			$this->Session->write('Order.discount', $this->data['Order']['discount']);
		if ((!empty($this->data['Order']['payment'])) || ($this->data['Order']['payment'] === 0))
			$this->Session->write('Order.payment', $this->data['Order']['payment']);
		$payment = $this->Session->read('Order.payment');
		$discount = $this->Session->read('Order.discount');
		$this->Session->write('Order.balance', ($total - $payment - $discount));
	}
	public function check_items()
	{
		if (count($this->Session->read('OrderedItem')) > 0)
			return true;
		else
			return false;
	}
	public function check_item($id)
	{
		if ($this->Session->check('OrderedItem.'.$id))
		{
			$supplier_id = $this->Session->read('Order.supplier_id');
			if (!empty($supplier_id))
			{
				$item_supplier_id = $this->Session->read('OrderedItem.'.$id.'.supplier_id');
				if ($supplier_id == $item_supplier_id)
					$this->Session->write('OrderedItem.'.$id.'.no_supply', 0);
				else
					$this->Session->write('OrderedItem.'.$id.'.no_supply', 1);
			}
			return true;
		}
		else
			$this->flash('Item does not exists in order!', 'error', array('action' => 'add'));
	}
	public function add_item($id = null)
	{
		$this->loadModel('Item');
		$item = $this->Item->find('first', array(
			'conditions' => array('Item.id' => $id), 'contain' => array(), 'fields' => array('Item.id','Item.name','Item.cost_price','Item.supplier_id'))
		);
		if (empty($item))
			$this->flash('Could not find item!', 'error', array('action' => 'add'));
		$item = $item['Item'];
		$item['item_id'] = $item['id'];
		unset($item['id']);
		$ordered_items = $this->Session->read('OrderedItem');
		$count = 0;
		$item_in_order = false;
		if (!empty($ordered_items))
			foreach($ordered_items as $key => $ordered_item)
			{
				if ($key >= $count)
					$count = $key;
				if ($ordered_item['item_id'] == $item['item_id'])
					$item_in_order = $key;
			}
			$count++;
		if ($item_in_order !== false)
		{
			$count = $item_in_order;
			$item = $this->Session->read('OrderedItem.'.$count);
			$item['quantity']++;
			$item['net_price'] = (float) $item['cost_price'] * $item['quantity'];
		}
		else
		{
			$item['quantity'] = 1;
			$item['net_price'] = (float) $item['cost_price'];
			$item['no_supply'] = 0;
		}
		$this->Session->write('OrderedItem.'.$count, $item);
		$this->check_item($count);
		$this->update_order();
		$this->redirect(array('action' => 'add'));
	}
	public function edit_item($id = null)
	{
		$this->check_item($id);
		if (!empty($this->data['OrderedItem'][$id]))
		{
			$item = $this->Session->read('OrderedItem.'.$id);
			$item['cost_price'] = $this->data['OrderedItem'][$id]['cost_price'];
			$item['quantity'] = (!empty($this->data['OrderedItem'][$id]['quantity'])) ? $this->data['OrderedItem'][$id]['quantity'] : 1 ;
			$item['net_price'] = (float) $item['cost_price'] * $item['quantity'];
			$this->Session->write('OrderedItem.'.$id, $item);
		}
	}
	public function delete_item($id = null)
	{
		$this->check_item($id);
		$this->Session->delete('OrderedItem.'.$id);
		$this->update_order();
		$this->redirect(array('action' => 'add'));
	}
	public function clear($redirect = true)
	{
		$this->Session->delete('Order');
		$this->Session->delete('OrderedItem');
		$order = array('total' => 0, 'payment' => 0, 'balance' => 0, 'discount' => 0, 'invoice_no' => '');
		$this->Session->write('Order', $order);
		if ($redirect)
			$this->redirect(array('action' => 'add'));
	}
}