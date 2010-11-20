<?
class Employee extends AppModel
{
	static $auth;
	public $validate = array(
		'name' => array(
			'rule' => 'notEmpty',
			'required' => true,
			'message' => 'Name cannot be empty!'
		),
		'username' => array(
			'alphaNumeric' => array(
				'rule' => 'alphaNumeric',
				'required' => true,
				'message' => 'Username can only contain letters and numbers!'
			),
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'message' => 'Username can not be empty!'
			),
		),
		'password' => array(
			'alphaNumeric' => array(
				'rule' => 'alphaNumeric',
				'required' => true,
				'message' => 'Password can only contain letters and numbers!'
			),
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'message' => 'Password can not be empty!'
			),
			'comparePassword' => array(
				'rule' => 'comparePassword',
				'message' => 'Password and confirm mismatch!'
			),
		),
		'password_confirm' => array(
			'alphaNumeric' => array(
				'rule' => 'alphaNumeric',
				'required' => true,
				'message' => 'Password can only contain letters and numbers!',
			),
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'message' => 'Password confirm can not be empty!',
			),
		),
		'rank' => array(
			'numeric' => array(
				'rule' => 'numeric',
				'message' => 'Rank must be a number!',
			),
		),
	);
	public $virtualFields = array(
		'search' => 'CONCAT(Employee.name, " (", Employee.username, ")")',
	);
	public function comparePassword()
	{
		if ($this->data['Employee']['password'] == $this->data['Employee']['password_confirm'])
			return true;
		else
			return false;
	}
}