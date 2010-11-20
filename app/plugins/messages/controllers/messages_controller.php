<?php
class MessagesController extends MessagesAppController
{
	public $layout = 'ajax';
	public function isAuthorized()
	{
		return true;
	}
	public function index()
	{
		$this->set('messages', $this->Message->find_my_messages());
		if (!$this->RequestHandler->isAjax())
			$this->autoRender = false;
		$this->render('index');
	}
	public function view($id = null)
	{
		$this->set('message', $this->Message->find('first', array('conditions' => array('Message.id' => $id, 'Message.receiver_id' => Employee::$auth['id']))));
	}
	public function message_form($receiver_id = null, $message_id = null)
	{
		$this->loadModel('Employee');
		if ($receiver_id == null)
			$this->set('employees', $this->Employee->find('list', array('conditions' => array('Employee.id !=' => Employee::$auth['id']))));
		else
			$this->set('receiver', $this->Employee->find('first', array('conditions' => array('Employee.id' => $receiver_id))));
		if ($message_id != null)
			$this->set('message', $this->Message->find('first', array('conditions' => array('Message.id' => $message_id))));
	}
	public function add()
	{
		$this->data['Message']['sender_id'] = Employee::$auth['id'];
		$this->Message->create();
		$this->Message->save($this->data);
		$this->redirect(array('action' => 'index'));
	}
	public function delete($id = null)
	{
		$this->Message->remove($id);
		$this->redirect(array('action' => 'index'));
	}
}