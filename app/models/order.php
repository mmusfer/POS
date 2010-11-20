<?
class Order extends AppModel {
	public $belongsTo = array('Employee', 'Supplier');
	public $hasMany = array('OrderedItem');
	public $validate = array(
		'total' => array(
			'rule' => 'numeric',
			'required' => true,
			'message' => 'Total must be a number!'
		),
		'discount' => array(
			'numeric' => array(
				'rule' => 'numeric',
				'required' => true,
				'message' => 'Discount amount must be a number!'
			),
		),
	);
	function beforeSave()
	{
		$this->data['Order']['employee_id'] = Employee::$auth['id'];
		return true;
	}
	public function check_payment()
	{
		if (($this->data['Order']['payment'] >= $this->data['Order']['total'])
		&& (($this->data['Order']['payment'] - $this->data['Order']['due']) == $this->data['Order']['total']))
			return true;
		else
			return false;
	}
}