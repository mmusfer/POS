<?php
class Todo extends TodosAppModel
{
	public $validate = array(
		'text' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'required' => true,
				'message' => 'Todo can not be empty!'
			)
		)
	);
	public function find_my_todos()
	{
		return $this->find('all', array('conditions' => array('Todo.employee_id' => Employee::$auth['id'], 'Todo.deleted' => 0)));
	}
	public function beforeSave()
	{
		$this->data['Todo']['employee_id'] = Employee::$auth['id'];
		return true;
	}
}