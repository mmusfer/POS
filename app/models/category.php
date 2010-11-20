<?
class Category extends AppModel
{
	public $hasMany = array('Item');
	public $virtualFields = array('search' => 'CONCAT(Category.name, " (", Category.id, ")")');
	public $validate = array(
		'name' => array(
			'rule' => 'notEmpty',
			'required' => true,
			'message' => 'Name cannot be empty!',
		),
	);
	public function beforeSave()
	{
		$this->data['Category']['employee_id'] = Employee::$auth['id'];
		return true;
	}
}