<?php
class CustomersController extends AppController
{
	public function isAuthorized()
	{
		if (Employee::$auth['rank'] >= 5)
			return true;
	}
	public function index()
	{
		$this->paginate['Customer'] = array(
			'order' => 'Customer.id ASC',
			'conditions' => array('Customer.deleted' => '0'),
			'limit' => 10
		);
		$this->set('customers', $this->paginate('Customer'));
	}
	public function add()
	{
		if (!empty($this->data))
		{
			$this->Customer->create();
			if ($this->Customer->save($this->data))
				$this->flash('Customer "'.$this->data['Customer']['name'].'" added successfully!', 'success', array('action' => 'index'));
			else
				$this->flash('Could not save customer!', 'error');
		}
		$this->render('form');
	}
	public function edit($id = null)
	{
		$this->check($id, 'Customer');
		$this->Customer->id = $id;
		if (empty($this->data))
			$this->data = $this->Customer->read();
		elseif ($this->Customer->save($this->data))
			$this->flash('Customer "'.$this->data['Customer']['name'].'" edited successfully!', 'success', array('action' => 'index'));
		$this->render('form');
	}
	public function delete($id = null)
	{
		$this->check($id, 'Customer');
		if ($this->Customer->remove($id))
			$this->flash('Customer deleted successfully!', 'success', array('action' => 'index'));
	}
}