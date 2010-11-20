<?php
class PagesController extends AppController
{
	public $uses = array();
	public function isAuthorized()
	{
		return true;
	}
	public function home()
	{
	}
}