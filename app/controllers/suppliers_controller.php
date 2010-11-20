<?php
class SuppliersController extends AppController
{
	public function isAuthorized()
	{
		if (Employee::$auth['rank'] >= 8)
			return true;
	}
	public function index()
	{
		$this->paginate['Supplier'] = array(
			'order' => 'Supplier.id ASC',
			'conditions' => array('Supplier.deleted' => '0'),
			'limit' => 10
		);
		$this->set('suppliers', $this->paginate('Supplier'));
	}
	public function add()
	{
		if (!empty($this->data))
		{
			$this->data['Supplier']['employee_id'] = $this->Auth->user('id');
			$this->Supplier->create();
			if ($this->Supplier->save($this->data))
				$this->flash('Supplier "'.$this->data['Supplier']['name'].'" added successfully!', 'success', array('action' => 'index'));
			else
				$this->flash('Could not save supplier!', 'error');
		}
		$this->render('form');
	}
	public function edit($id = null)
	{
		$this->check($id, 'Supplier');
		$this->Supplier->id = $id;
		if (empty($this->data))
			$this->data = $this->Supplier->read();
		elseif ($this->Supplier->save($this->data))
			$this->flash('Supplier "'.$this->data['Supplier']['name'].'" edited successfully!', 'success', array('action' => 'index'));
		$this->render('form');
	}
	public function delete($id = null)
	{
		$this->check($id, 'Supplier');
		if ($this->Supplier->remove($id))
			$this->flash('Supplier deleted successfully!', 'success', array('action' => 'index'));
	}
}