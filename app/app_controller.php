<?php
class AppController extends Controller
{
	public $components = array('Session','RequestHandler','Auth','Acl');
	public $helpers = array('Html','Form','Session','Text','Number','Ajax','Js' => 'Jquery','Paginator', 'Barcode');

	public function beforeFilter()
	{
		$this->RequestHandler->setContent('json', 'text/x-json');
		$this->Auth->userModel = 'Employee';
		$this->Auth->loginAction = array('controller' => 'employees', 'action' => 'login');
		$this->Auth->logoutRedirect = array('controller' => 'employees', 'action' => 'login');
		$this->Auth->loginError = 'Sorry, incorrect credentials.';
		$this->Auth->authError = 'You don\'t have permission to access this page.';
		$this->Auth->authorize = 'controller';
		$this->getSettings();
		App::import('Model','Employee');
		$auth = $this->Auth->user();
		Employee::$auth = $auth['Employee'];
		$this->Session->write('Employee.id', Employee::$auth['id']);
	}
	public function flash($message, $type = 'notice', $redirect = false)
	{
		$messages = (array) $this->Session->read('Message.flash');
		$messages[] = array(
			'message' => $message,
			'element' => 'default',
			'params' => array('class' => $type.'-message')
		);
		$this->Session->write('Message.flash', $messages);
		if ($redirect)
			$this->redirect($redirect);
	}
	public function check($id = null, $model = null)
	{
		if (($id != null) && ($model != null))
			if ($this->{$model}->find('count', array('conditions' => array($model.'.id' => $id, $model.'.deleted' => 0))) === 1)
				return;
		$this->flash('Selected record does not exists!', 'error', array('action' => 'index'));
	}
	public function find($term = null, $field = 'search')
	{
		$term = ($term) ? $term : $this->params['url']['term'];
		$field = ($field) ? $field : $this->params['url']['field'];
		if (!empty($this->params['named']['supplier_id']))
			$conditions = array($this->modelClass.'.'.$field.' LIKE' => '%'.$term.'%', $this->modelClass.'.supplier_id' => $this->params['named']['supplier_id'], $this->modelClass.'.deleted' => 0);
		else
			$conditions = array($this->modelClass.'.'.$field.' LIKE' => '%'.$term.'%', $this->modelClass.'.deleted' => 0);
		$result = $this->{$this->modelClass}->find('all', array('conditions' => $conditions));
		if (!empty($result))
		{
			$this->set('result', $result);
		}
		else
			return;
	}
	public function getSettings()
	{
		if ($this->Session->check('Settings'))
		{
			$settings = $this->Session->read('Settings');
				foreach ($settings as $setting)
					Configure::write('Settings.'.$setting['Setting']['name'], $setting['Setting']['value']);
		}
		else
		{
			$this->loadModel('Setting');
			$settings = $this->Setting->find('all');
			$this->Session->write('Settings', $settings);
			foreach ($settings as $setting)
				Configure::write('Settings.'.$setting['Setting']['name'], $setting['Setting']['value']);
		}
	}
}