<?php
class EmployeesController extends AppController {
	public function beforeFilter()
	{
		parent::beforeFilter();
		$this->Auth->allow('login');
	}
	public function beforeRender()
	{
		unset($this->data['Employee']['password']);
		unset($this->data['Employee']['password_confirm']);
	}
 	public function isAuthorized()
{
		if (Employee::$auth['rank'] == 9)
			return true;
		elseif ($this->action == 'logout')
			return true;
	}
	public function index()
	{
		$this->paginate['Employee'] = array(
			'order' => 'Employee.id ASC',
			'conditions' => array('Employee.deleted' => '0'),
			'limit' => 10
		);
		$this->set('employees', $this->paginate('Employee'));
	}
	public function login()
	{
	}
	public function logout()
	{
		$this->flash('You have been logged out!', 'success');
		$this->redirect($this->Auth->logout());
	}
	public function add()
	{
		if (!empty($this->data))
		{
			$this->Employee->create();
			$this->data['Employee']['password_confirm'] = $this->Auth->password($this->data['Employee']['password_confirm']);
			$this->data['Employee']['profit_percent'] = (100-$this->data['Employee']['profit_percent'])/100;
			$this->Employee->create();
			if ($this->Employee->save($this->data))
				$this->flash('Employee "'.$this->data['Employee']['name'].'" added successfully!', 'success', array('action' => 'index'));
			else
				$this->flash('Could not save employee!', 'error');
		}
		$this->render('form');
	}
	public function edit($id = null)
	{
		$this->check($id, 'Employee');
		$this->Employee->id = $id;
		if (empty($this->data))
		{
			$this->data = $this->Employee->read();
			$this->data['Employee']['profit_percent'] = (1-$this->data['Employee']['profit_percent'])*100;
		}
		else
		{
			$this->data['Employee']['profit_percent'] = (100-$this->data['Employee']['profit_percent'])/100;
			if ($this->Employee->save($this->data))
				$this->flash('Employee "'.$this->data['Employee']['name'].'" edited successfully!', 'success', array('action' => 'index'));
		}
		$this->render('form');
	}
	public function delete($id = null)
	{
		$this->check($id, 'Employee');
		if ($this->Employee->remove($id))
			$this->flash('Employee deleted successfully!', 'success', array('action' => 'index'));
		else
			$this->flash('Could not delete employee!', 'error', array('action' => 'index'));
	}
}