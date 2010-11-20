<?
class SoldItem extends AppModel
{
	public $belongsTo = array('Sale','Item');
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
			'numeric' => array(
				'rule' => 'numeric',
				'message' => 'Incorrect discount!',
			),
		),
		'net_price' => array(
			'numeric' => array(
				'rule' => 'numeric',
				'message' => 'Incorrect net price!',
			),
		),	
	);
	public function afterSave()
	{
		$item = $this->read();
		$reason = 'Sale #'.$item['Sale']['id'];
		if ($item['Item']['serialized'] == 1)
			$reason = 'Sale #'.$item['Sale']['id'].' (S/N: '.$item['SoldItem']['serial'].')';
		$this->Item->stock_change($item['Item']['id'], -$item['SoldItem']['quantity'], $reason);
	}
}