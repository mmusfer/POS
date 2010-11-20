<?php
class CategoriesController extends AppController
{
	public function isAuthorized()
	{
		if (Employee::$auth['rank'] >= 8)
			return true;
	}
	public function index()
	{
		$this->paginate['Category'] = array(
			'order' => 'Category.id ASC',
			'conditions' => array('Category.deleted' => '0'),
			'limit' => 10
		);
		$this->set('categories', $this->paginate('Category'));
	}
	public function add()
	{
		if (!empty($this->data))
		{
			$this->Category->create();
			if ($this->Category->save($this->data))
				$this->flash('Category "'.$this->data['Category']['name'].'" added successfully!', 'success', array('action' => 'index'));
			else
				$this->flash('Could not save category!', 'error');
		}
		$this->render('form');
	}
	public function edit($id = null)
	{
		$this->check($id, 'Category');
		$this->Category->id = $id;
		if (empty($this->data))
			$this->data = $this->Category->read();
		else
		{
			if ($this->Category->save($this->data))
				$this->flash('Category "'.$this->data['Category']['name'].'" edited successfully!', 'success', array('action' => 'index'));
		}
		$this->render('form');
	}
	public function delete($id = null)
	{
		$this->check($id, 'Category');
		if ($this->Category->remove($id))
			$this->flash('Category deleted successfully!', 'success', array('action' => 'index'));
		else
			$this->flash('Could not delete employee!', 'error', array('action' => 'index'));
	}
}