<?php
class TodosController extends TodosAppController
{
	public $layout = 'ajax';
	public function isAuthorized()
	{
		return true;
	}
	public function index()
	{
		$this->set('todos', $this->Todo->find_my_todos());
		if (!$this->RequestHandler->isAjax())
			$this->autoRender = false;
		$this->render('index');
	}
	public function add()
	{	
		$this->Todo->save($this->data);
		$this->index();
	}
	public function edit()
	{
		$this->autoRender = false;
		$this->Todo->id = str_replace('todo-', '', $this->data['Todo']['id']);
		if ($this->Todo->saveField('text', $this->data['Todo']['text']))
			echo $this->data['Todo']['text'];
		else
			echo $this->Todo->field('text');
	}
	public function delete($id = null)
	{
		$this->Todo->remove($id);
		$this->index();
	}
}