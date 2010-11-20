<?
class Item extends AppModel {
	public $belongsTo = array(
		'Supplier' => array('counterCache' => true, 'counterScope' => array('Item.deleted' => 0)),
		'Category' => array('counterCache' => true, 'counterScope' => array('Item.deleted' => 0))
	);
	public $hasMany = array('ItemTrack');
	public $virtualFields = array(
		'search' => 'CONCAT(Item.name, " (", Item.barcode, ")")',
		'cat_id' => 'CONCAT(Item.category_id, Item.id)'
	);
	public $validate = array(
		'name' => array(
			'rule' => 'notEmpty',
			'required' => true,
			'message' => 'Name cannot be empty!',
		),
		'barcode' => array(
			'notEmpty-barcode' => array(
				'rule' => 'notEmpty',
				'required' => true,
				'message' => 'Barcode can not be empty!',
			),
			'numeric-barcode' => array(
				'rule' => 'numeric',
				'required' => true,
				'message' => 'Barcode must be a number!',
			),
		),
		'sell_price' => array(
			'rule' => 'numeric',
			'required' => true,
			'message' => 'Sell price must be a number!',
		),
		'cost_price' => array(
			'rule' => 'numeric',
			'required' => true,
			'message' => 'Cost price must be a number!',
		),
		'stock' => array(
			'rule' => 'numeric',
			'required' => false,
			'message' => 'Stock must be a number!',
		),
		'reorder_level' => array(
			'rule' => 'numeric',
			'required' => true,
			'message' => 'Reorder level must be a number!',
		),
	);
	public function stock_change($id, $change, $reason)
	{
		$this->id = $id;
		$stock = $this->field('stock') + $change;
		if ($this->ItemTrack->track($id, $stock, $change, $reason))
			if ($this->saveField('stock', $stock))
				return true;
		return false;
	}
	public function supply($item, $reason)
	{
		$this->id = $item['item_id'];
		$current_stock = $this->field('stock');
		$current_cost_price = $this->field('cost_price');
		$added_stock = $item['quantity'];
		$added_cost_price = $item['cost_price'];
		$this->stock_change($item['item_id'], $added_stock, $reason);
		$cost_price = ((($current_cost_price * $current_stock) + ($added_cost_price * $added_stock)) / ($added_stock + $current_stock));
		$this->saveField('cost_price', $cost_price);
	}
	public function beforeSave()
	{
		$this->data['Item']['employee_id'] = Employee::$auth['id'];
		if (!empty($this->data['Category']['name']))
		{
			$category = $this->Category->nameExistsOrCreate($this->data['Category']['name']);
			if ($category != false)
				$this->data['Item']['category_id'] = $category['Category']['id'];
		}
		if (!empty($this->data['Supplier']['name']))
		{
			$supplier = $this->Supplier->nameExistsOrCreate($this->data['Supplier']['name']);
			if ($supplier != false)
				$this->data['Item']['supplier_id'] = $supplier['Supplier']['id'];
		}
		return true;
	}
}