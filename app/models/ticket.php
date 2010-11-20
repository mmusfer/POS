<?
class Ticket extends AppModel
{
	public $belongsTo = array('Employee','Customer','Technician' => array('className' => 'Employee', 'foreign_key' => 'technician_id'));
	public $hasMany = array('TicketRequest');
	public $validate = array(
		'total' => array(
			'numeric' => array(
				'rule' => array('comparison', '>', 0),
				'on' => 'create',
				'required' => true,
				'message' => 'Total must be a number!'
			),
		),
		'customer_id' => array(
			'numeric' => array(
				'rule' => 'numeric',
				'on' => 'create',
				'required' => true,
				'message' => 'You must select a customer!'
			),
		),
		'technician_id' => array(
			'numeric' => array(
				'rule' => 'numeric',
				'on' => 'create',
				'required' => true,
				'message' => 'You must select a technician!'
			),
		),
	);
	public function beforeSave()
	{
		$this->data['Ticket']['employee_id'] = Employee::$auth['id'];
		return true;
	}
	public function done($id = null)
	{
		if ($id != null)
		{
			$this->id = $id;
			$ticket = $this->find('first', array('conditions' => array('Ticket.id' => $id), 'contain' => array('TicketRequest')));
			$requests = $ticket['TicketRequest'];
			$count = count($requests);
			$done = true;
			foreach ($requests as $request)
				if ($request['status'] != 1)
					$done = false;
			if ($done)
				$this->saveField('status', 1);
			return true;
		}
		return false;
	}
}