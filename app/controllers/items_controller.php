<?php
class ItemsController extends AppController
{
	public function isAuthorized()
	{
		if (Employee::$auth['rank'] == 9)
			return true;
		elseif ((Employee::$auth['rank'] >= 8) && ($this->action !== 'stock'))
			return true;
		elseif ((Employee::$auth['rank'] >= 5) && ($this->action == 'find'))
			return true;
	}
	public function index()
	{
		$conditions = array('Item.deleted' => '0');
		if (isset($this->params['named']['name'])) $conditions['Item.name LIKE'] = '%'.$this->params['named']['name'].'%';
		if (isset($this->params['named']['barcode'])) $conditions['Item.barcode LIKE'] = '%'.$this->params['named']['barcode'].'%';
		if (isset($this->params['named']['desc'])) $conditions['Item.desc LIKE'] = '%'.$this->params['named']['desc'].'%';
		if (isset($this->params['named']['serialized'])) $conditions['Item.serialized'] = $this->params['named']['serialized'];
		if (isset($this->params['named']['supplier_id'])) $conditions['Item.supplier_id'] = $this->params['named']['supplier_id'];
		if (isset($this->params['named']['category'])) $conditions['Category.name'] = $this->params['named']['category'];
		if (isset($this->params['named']['stock'])) $conditions['Item.stock >='] = $this->params['named']['stock'];
		if (isset($this->params['named']['cost_price'])) $conditions['Item.cost_price >='] = $this->params['named']['cost_price'];
		if (isset($this->params['named']['sell_price'])) $conditions['Item.sell_price >='] = $this->params['named']['sell_price'];
		if (isset($this->params['named']['stock'])) $conditions['Item.stock >='] = $this->params['named']['stock'];
		if (isset($this->params['named']['reorder_level'])) $conditions['Item.reorder_level >='] = $this->params['named']['reorder_level'];
		$this->paginate['Item'] = array(
			'contain' => array('Category','Supplier'),
			'limit' => 10,
			'order' => 'Item.id ASC',
			'conditions' => $conditions
		);
		$this->set('items', $this->paginate('Item'));
	}
	public function print_list()
	{
		$items = $this->Item->find('all', array(
			'contain' => array('Category','Supplier'),
			'order' => 'Item.cat_id ASC',
			'conditions' => array('Item.deleted' => '0')
		));
		$this->set('items', $items);
	}
	public function add() {
		if (!empty($this->data))
		{
			$this->Item->create();
			if ($this->Item->save($this->data))
				$this->flash('Item "'.$this->data['Item']['name'].'" added successfully!', 'success', array('action' => 'index'));
			else
				$this->flash('Could not save item!', 'error');
		}
		$this->render('form');
	}
	public function edit($id = null)
	{
		$this->check($id, 'Item');
		$this->Item->id = $id;
		if (empty($this->data))
			$this->data = $this->Item->read();
		else
		{
			if ($this->Item->field('stock') !== $this->data['Item']['stock'])
				$this->Item->stock_change($id, $this->data['Item']['stock'], 'Item edited by:'.Employee::$auth['name']);
			if ($this->Item->save($this->data))
				$this->flash('Item "'.$this->data['Item']['name'].'" edited successfully!', 'success', array('action' => 'index'));
		}
		$this->render('form');
	}
	public function view($id = null)
	{
		$this->check($id, 'Item');
		$this->Item->id = $id;
		$this->loadModel('ItemTrack');
		$this->set('item', $this->Item->find('first', array('conditions' => array('Item.id' => $id), 'contain' => array('ItemTrack','Category','Supplier'))));
		$this->set('item_tracks', $this->ItemTrack->find('all', array('conditions' => array('ItemTrack.item_id' => $id), 'contain' => array('Employee' => array('fields' => 'name')))));
	}
	public function delete($id = null)
	{
		$this->check($id, 'Item');
		if ($this->Item->remove($id))
			$this->flash('Item deleted successfully!', 'success', array('action' => 'index'));
	}
	public function item_row($id = null, $count = null, $cost = null)
	{
		$id = ($id) ? $id : $this->params['url']['id'];
		$count = ($count) ? $count : 0;
		$this->set('item', $this->Item->findById($id));
		$this->set('count', $count);
		$this->set('cost', $cost);
	}
}