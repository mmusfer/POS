<?
class Request extends AppModel
{
	public $hasMany = array('TicketRequest');
	public $virtualFields = array(
		'search' => 'CONCAT(Request.name, " (", Request.id, ")")',
	);
	public $validate = array(
		'name' => array(
			'rule' => 'notEmpty',
			'required' => true,
			'message' => 'Name cannot be empty!',
		),
		'price' => array(
			'rule' => 'numeric',
			'required' => true,
			'message' => 'Price must be a number!',
		),
		'min_price' => array(
			'rule' => 'numeric',
			'required' => true,
			'message' => 'Minimum price must be a number!',
		),
	);
	public function beforeSave()
	{
		$this->data['Request']['employee_id'] = Employee::$auth['id'];
		return true;
	}
}