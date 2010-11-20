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
		$this->paginate['Item'] = array(
			'contain' => array('Category','Supplier'),
			'limit' => 6,
			'order' => 'Item.id ASC',
			'conditions' => array('Item.deleted' => '0')
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
				$this->Item->track($id, $this->data['Item']['stock']);
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