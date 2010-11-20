<?php
class ReportsController extends AppController
{
	public $uses = array();
	public $helpers = array('FlashChart');
	public function isAuthorized()
	{
		if (Employee::$auth['rank'] == 9)
			return true;
	}
	public function index()
	{
	}
}