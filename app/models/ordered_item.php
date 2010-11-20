<?
class OrderedItem extends AppModel
{
	public $belongsTo = array('Order','Item');
	public $validate = array(
		'quantity' => array(
			'quantity-1' => array(
				'rule' => 'notEmpty',
				'required' => true,
				'message' => 'Incorrect quantity!',
			),
			'quantity-2' => array(
				'rule' => 'numeric',
				'message' => 'Incorrect quantity!',
			),
		),
		'discount' => array(
			'rule' => 'numeric',
			'message' => 'Incorrect discount amount!',
		),
		'net_price' => array(
			'rule' => 'numeric',
			'message' => 'Incorrect price!',
		)		
	);
	public function afterSave()
	{
		if (!empty($this->data['OrderedItem'][0]))
			foreach($this->data['OrderedItem'] as $item)
				$this->Item->supply($item);
		else
			$this->Item->supply($this->data['OrderedItem']);
	}
}