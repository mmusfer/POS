<?
class ItemTrack extends AppModel
{
	public $belongsTo = array('Item','Employee');
	public function track($id, $stock, $change, $reason)
	{
		$item_track = array('ItemTrack' => array(
			'item_id' => $id,
			'stock' => $stock,
			'change' => $change,
			'reason' => $reason,
			'employee_id' => Employee::$auth['id']
		));
		$this->create();
		if ($this->save($item_track))
			return true;
		return false;
	}
}