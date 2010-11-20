<?php
class SettingsController extends AppController
{
	public function isAuthorized()
	{
		if (Employee::$auth['rank'] == 9)
			return true;
	}
	public function index()
	{
		$this->set('settings', $this->Setting->find('all'));
	}
	public function edit($id = null)
	{
		$this->check($id, 'Setting');
		$this->Setting->id = $id;
		if (empty($this->data))
			$this->data = $this->Setting->read();
		elseif ($this->Setting->save($this->data))
			$this->flash('Settings edited successfully!', 'success', array('action' => 'index'));
		$this->render('form');
	}
}