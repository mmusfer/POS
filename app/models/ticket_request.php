<?
class TicketRequest extends AppModel
{
	public $belongsTo = array('Ticket','Request');
	public $validate = array(
		'price' => array(
			'numeric' => array(
				'rule' => 'numeric',
				'required' => true,
				'message' => 'Price must be more than 0!',
			),
			'notEmpty' => array(
				'rule' => array('comparison', '>', 0),
				'message' => 'Price must be more than 0!',
			),
		)
	);
	public function done($id = null)
	{
		if ($id != null)
		{
			$this->id = $id;
			$this->saveField('status', 1);
			$this->Ticket->done($this->field('ticket_id'));
			return true;
		}
		return false;
	}
}