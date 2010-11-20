<? if (isset($this->params['pass'][0])): ?>
	<?= $form->create('Item', array('url' => array($this->params['pass']['0']), 'inputDefaults' => array('label' => false, 'div' => false))); ?>
<? else: ?>
	<?= $form->create('Item', array('inputDefaults' => array('label' => false, 'div' => false))); ?>
<? endif; ?>
<table>
	<tr>
		<th>Name</th>
		<td><?= $form->input('name'); ?></td>
		<th>Barcode</th>
		<td><?= $form->input('barcode'); ?></td>
	</tr>
	<tr>
		<th>Description</th>
		<td colspan="2"><?= $form->input('desc'); ?></td>
		<th><?= $form->input('serialized'); ?> Serialized</th>
	</tr>
	<tr>
		<th>Category</th>
		<td><?= $form->input('Category.name'); ?></td>
		<th>Supplier</th>
		<td><?= $form->input('Supplier.name'); ?></td>
	</tr>
	<tr>
		<th>Cost Price</th>
		<td>
			<? if (Employee::$auth['rank'] == 9): ?>
				<?= $form->input('cost_price'); ?>
			<? else: ?>
				<?= $number->currency($this->data['Item']['cost_price']); ?>
			<? endif; ?>
		</td>
		<th>Sell Price</th>
		<td><?= $form->input('sell_price'); ?></td>
	</tr>
	<tr>
		<th>Stock</th>
		<td>
			<? if (Employee::$auth['rank'] == 9): ?>
				<?= $form->input('stock'); ?>
			<? else: ?>
				<?= ($this->data['Item']['stock']) ? $this->data['Item']['stock'] : 0 ; ?>
			<? endif; ?>
		</td>
		<th>Reorder Level</th>
		<td><?= $form->input('reorder_level'); ?></td>
	</tr>
</table>
<?= $form->end('Submit'); ?>
<script>
$(function() {
	$("#CategoryName").autocomplete({
		source: "<?= $html->url(array('controller' => 'categories', 'action' => 'find', 'ext' => 'json')); ?>",
		select: function(event, ui) {
			this.value = ui.item.label;
		}
	});
	$("#SupplierName").autocomplete({
		source: "<?= $html->url(array('controller' => 'suppliers', 'action' => 'find', 'ext' => 'json')); ?>",
		select: function(event, ui) {
			this.value = ui.item.label;
		}
	});
});
</script>