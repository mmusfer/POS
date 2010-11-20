<?php
class RequestsController extends AppController
{
	public $uses = array('Request','Ticket');
	public function isAuthorized()
	{
		if (Employee::$auth['rank'] >= 8)
			return true;
		elseif ((Employee::$auth['rank'] >= 5) && ($this->action == 'find'))
			return true;
	}
	public function index() {
		$this->paginate['Request'] = array(
			'contain' => array(),
			'order' => 'Request.id DESC',
			'conditions' => array('Request.deleted' => '0'),
			'limit' => 10
		);
		$this->set('requests', $this->paginate('Request'));
	}
	public function add() {
		if (!empty($this->data))
			$this->Request->create();
			if ($this->Request->save($this->data))
				$this->flash('New request created!', 'success', array('action' => 'index'));
			else
				$this->flash('Could not save request!', 'error');
		$this->render('form');
	}
	public function edit($id = null)
	{
		$this->check($id, 'Request');
		$this->Request->id = $id;
		if (empty($this->data))
			$this->data = $this->Request->read();
		elseif ($this->Request->save($this->data))
			$this->flash('Request "'.$this->data['Request']['name'].'" edited successfully!', 'success', array('action' => 'index'));
		$this->render('form');
	}
}