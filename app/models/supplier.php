<?
class Supplier extends AppModel
{
	public $hasMany = array('Item');
	public $virtualFields = array('search' => 'CONCAT(Supplier.name, " (", Supplier.id, ")")');
	public $validates = array(
		'name' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'required' => true,
				'message' => 'Name field cannot be empty!',
			),
		),
		'email' => array(
			'email' => array(
				'rule' => 'email',
				'required' => false,
				'message' => 'Email field cannot be empty!'
			),
		),
		'mobile' => array(
			'mobile-range' => array(
				'rule' => array('range', 966500000000, 966599999999),
				'required' => false,
				'message' => 'Please check mobile number!'
			),
		),
		'phone' => array(
			'phone-range' => array(
				'rule' => array('range', 96610000000, 96699999999),
				'required' => false,
				'message' => 'Please check the phone number!'
			),
		),
	);
	public function beforeSave()
	{
		$this->data['Supplier']['employee_id'] = Employee::$auth['id'];
		return true;
	}
}