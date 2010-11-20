<?
class Sale extends AppModel
{
	public $belongsTo = array('Employee', 'Customer');
	public $hasMany = array('SoldItem');
	public $validate = array(
		'total' => array(
			'numeric' => array(
				'rule' => 'numeric',
				'required' => true,
				'message' => 'Total must be a number!'
			),
		),
		'payment' => array(
			'numeric' => array(
				'rule' => 'numeric',
				'required' => true,
				'message' => 'Payment amount must be a number!'
			),
			'check_payment' => array(
				'rule' => 'check_payment',
				'message' => 'Payment must be more than total price!'
			),
		),
		'balance' => array(
			'numeric' => array(
				'rule' => 'numeric',
				'required' => true,
				'message' => 'Balance amount must be a number!'
			),
		),
	);
	public function beforeSave()
	{
		$this->data['Sale']['employee_id'] = Employee::$auth['id'];
		return true;
	}
	public function check_payment()
	{
		if ($this->data['Sale']['payment'] >= $this->data['Sale']['total'])
			return true;
		else
			return false;
	}
}