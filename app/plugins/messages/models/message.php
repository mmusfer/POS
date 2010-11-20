<?php
class Message extends MessagesAppModel
{
	public $recursive = 3;
	public $belongsTo = array(
		'Parent' => array('className' => 'Message', 'foreignKey' => 'reply_to'),
		'Sender' => array('className' => 'Employee', 'foreignKey' => 'sender_id', 'fields' => array('Sender.id', 'Sender.name')),
		'Receiver' => array('className' => 'Employee', 'foreignKey' => 'receiver_id', 'fields' => array('Receiver.id', 'Receiver.name'))
	);
	public $validate = array(
		'subject' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'required' => true,
				'message' => 'Subject can not be empty!'
			)
		),
		'text' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'required' => true,
				'message' => 'Message can not be empty!'
			)
		)
	);
	public function find_my_messages()
	{
		return $this->find('all', array(
			'conditions' => array('Message.receiver_id' => Employee::$auth['id'], 'Message.deleted' => 0),
			'contain' => array('Sender' => array('fields' => array('Sender.id','Sender.name')))
		));
	}
	public function beforeSave()
	{
//		$this->data['Message']['sender_id'] = Employee::$auth['id'];
		return true;
	}
}