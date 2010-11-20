<?php
class TicketsController extends AppController {
	public function isAuthorized()
	{
		if (Employee::$auth['rank'] >= 5)
			return true;
		elseif ((Employee::$auth['rank'] == 1) && (($this->action == 'technician_index') || ($this->action == 'track')))
			return true;
	}
	public function index()
	{
		$this->paginate['Ticket'] = array(
			'contain' => array('Customer','Employee','Technician'),
			'order' => 'Ticket.id DESC',
			'conditions' => array('Ticket.deleted' => '0'),
			'limit' => 10
		);
		$this->set('tickets', $this->paginate('Ticket'));
	}
	public function technician_index()
	{
		$this->set('tickets', $this->Ticket->find('all', array(
			'conditions' => array('Ticket.technician_id' => Employee::$auth['id'], 'Ticket.status' => 0),
			'contain' => array('Customer','TicketRequest' => array('Request'))
		)));
	}
	public function track($id = null)
	{
		$this->loadModel('TicketRequest');
		$this->TicketRequest->done($id);
		$this->autoRender = false;
		return 1;
	}
	public function pay($id = null)
	{
		$this->check($id, 'Ticket');
		$this->set('ticket', $this->Ticket->find('first', array(
			'conditions' => array('Ticket.id' => $id),
			'contain' => array('Technician' => array('fields' => 'Technician.name'),'TicketRequest' => array('Request'), 'Customer' => array('fields' => 'Customer.name'))
		)));
		if ($this->RequestHandler->isPost())
		{
			$this->Ticket->id = $id;
			if (empty($this->data['Ticket']['additional_costs']))
				$this->data['Ticket']['additional_costs'] = 0;
			else
				$this->data['Ticket']['total'] = $this->data['Ticket']['additional_costs'] + $this->Ticket->field('total');
			$this->data['Ticket']['status'] = 2;
			if ($this->Ticket->save($this->data))
				$this->redirect(array('action' => 'view', $id));
		}
	}
	public function view($id = null)
	{
		$this->check($id, 'Ticket');
		$this->set('ticket', $this->Ticket->find('first', array(
			'conditions' => array('Ticket.id' => $id),
			'contain' => array('Technician' => array('fields' => 'Technician.name'),'TicketRequest' => array('Request'), 'Customer' => array('fields' => 'Customer.name'))
		)));
	}
	public function ticket($id = null)
	{
		$this->check($id, 'Ticket');
		$this->set('ticket', $this->Ticket->find('first', array(
			'conditions' => array('Ticket.id' => $id),
			'contain' => array('Technician' => array('fields' => 'Technician.name'),'TicketRequest' => array('Request'), 'Customer' => array('fields' => 'Customer.name'))
		)));
	}
	public function add()
	{
		$this->loadModel('Customer');
		$this->loadModel('Employee');
		$this->set('customers', $this->Customer->find('list', array('conditions' => array('Customer.id !=' => 0))));
		$this->set('technicians', $this->Employee->find('list', array('conditions' => array('Employee.rank' => 1))));
		$this->update_ticket();
		$devices_list = array('Laptop','Charger','HDD','Modem','Bag','CD','Pen');
		$this->set('devices', $this->get_devices($this->Session->read('Ticket.devices'), $devices_list));
		$this->set('devices_list', $devices_list);
		$this->render('form');
	}
	public function finish()
	{
		if ($this->check_requests())
		{
			$this->update_ticket();
			unset($this->data);
			$this->data['Ticket'] = $this->Session->read('Ticket');
			$this->data['Ticket']['finish'] = strftime('%Y-%m-%d %H:00:00', strtotime($this->data['Ticket']['finish']));
			$this->data['TicketRequest'] = $this->Session->read('TicketRequest');
			$this->Ticket->create();
			if ($this->Ticket->saveAll($this->data))
			{
				$this->clear(false);
				$this->redirect(array('action' => 'ticket', $this->Ticket->id));
			}
			$this->flash('Could not save ticket!', 'error', array('action' => 'add'));
		}
		else
			$this->flash('No requests added to ticket!', 'error', array('action' => 'add'));
	}
	public function update_ticket()
	{
		if ((!empty($this->data['Ticket']['finish-date'])) && (!empty($this->data['Ticket']['finish-hour'])))
			$this->Session->write('Ticket.finish', $this->data['Ticket']['finish-date'] . ' ' . $this->data['Ticket']['finish-hour']. ':00');
		if (!empty($this->data['Ticket']['devices']))
			$this->Session->write('Ticket.devices', $this->data['Ticket']['devices']);
		if (!empty($this->data['Ticket']['customer_id']))
			$this->Session->write('Ticket.customer_id', $this->data['Ticket']['customer_id']);
		if (!empty($this->data['Ticket']['technician_id']))
			$this->Session->write('Ticket.technician_id', $this->data['Ticket']['technician_id']);
		$ticket_requests = $this->Session->read('TicketRequest');
		$total = 0;
		if ($this->check_requests())
			foreach ($ticket_requests as $key => $ticket_request)
			{
				$this->edit_request($key);
				$ticket_request['price'] = $this->Session->read('TicketRequest.'.$key.'.price');
				$total += (float) $ticket_request['price'];
			}
		$this->Session->write('Ticket.total', $total);
	}
	public function check_requests()
	{
		if (count($this->Session->read('TicketRequest')) > 0)
			return true;
		else
			return false;
	}
	public function check_request($id)
	{
		if ($this->Session->check('TicketRequest.'.$id))
			return true;
		else
			return false;
	}
	public function get_devices($customer_devices = array(), $devices_list = array())
	{
		if (!empty($customer_devices))
		{
			$current_devices = explode(', ', $customer_devices);
			foreach ($devices_list as $k => $v)
				$devices[$k] = false;
			foreach ($current_devices as $d)
				$devices[array_search($d, $devices_list)] = true;
			return $devices;
		}
		return array();
	}
	public function add_request($id = null)
	{
		$this->loadModel('Request');
		$request = $this->Request->find('first', array(
			'conditions' => array('id' => $id), 'contain' => array(),
			'fields' => array('Request.id','Request.name','Request.price','Request.min_price'))
		);
		if (empty($request))
			$this->flash('Could not add request!', 'error', array('action' => 'add'));
		$request = $request['Request'];
		$request['request_id'] = $request['id'];
		unset($request['id']);
		$ticket_requests = $this->Session->read('TicketRequest');
		$count = 0;
		if (!empty($ticket_requests))
			foreach ($ticket_requests as $key => $ticket_request)
				if ($key >= $count)
					$count = $key;
		$count++;
		$this->Session->write('TicketRequest.'.$count, $request);
		$this->update_ticket();
		$this->redirect(array('action' => 'add'));
	}
	public function edit_request($id = null)
	{
		$this->check_request($id);
		if (!empty($this->data['TicketRequest'][$id]))
		{
			$request = $this->Session->read('TicketRequest.'.$id);
			if ($this->data['TicketRequest'][$id]['price'] >= $request['min_price'])
				$request['price'] = (float) $this->data['TicketRequest'][$id]['price'];
			else
				$this->flash('You are out of your discount limit!','warning');
			$this->Session->write('TicketRequest.'.$id, $request);
		}
	}
	public function delete_request($id = null)
	{
		$this->check_request($id);
		$this->Session->delete('TicketRequest.'.$id);
		$this->update_ticket();
		$this->redirect(array('action' => 'add'));
	}
	public function clear($redirect = true)
	{
		$this->Session->delete('Ticket');
		$this->Session->delete('TicketRequest');
		$ticket = array(
			'total' => 0
		);
		$this->Session->write('Ticket', $ticket);
		if ($redirect)
			$this->redirect(array('action' => 'add'));
	}
}