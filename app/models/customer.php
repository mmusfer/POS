<?
class Customer extends AppModel
{
	public $hasMany = array('Sale');
	public $virtualFields = array('search' => 'CONCAT(Customer.name, " (", Customer.mobile, ")")');
	public $validate = array(
		'name' => array(
			'rule' => 'notEmpty',
			'required' => true,
			'message' => 'Name cannot be empty!',
		),
	);
	public function beforeSave()
	{
		$this->data['Customer']['employee_id'] = Employee::$auth['id'];
		return true;
	}
}