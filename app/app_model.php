<?php
class AppModel extends Model
{
	public $actsAs = array('Containable');
	public $recursive = 0;
	
	public function remove($id)
	{
		$this->id = $id;
		$this->saveField('deleted', 1);
		return true;
	}
	public function nameExistsOrCreate($name)
	{
		$data = $this->findByName($name);
		if ($data != null)
			return $data;
		else
		{
			$data[$this->alias]['name'] = $name;
			$this->create();
			if ($this->save($data))
				return $this->read();
		}
		return false;
	}
}