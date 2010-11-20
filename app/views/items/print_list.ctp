<h1><?= Configure::read('Settings.name'); ?></h1>
<h4>Inventory</h4>
<table>
	<thead>
		<tr>
			<th>Barcode</th>
			<th>Name</th>
			<th>Category</th>
			<th>Price</th>
			<th>Cost Price</th>
			<th>Stock</th>
		</tr>
	</thead>
	<? foreach ($items as $item): ?>
	<tr>
		<td class="barcode"><?= $html->image($barcode->output('I'.$item['Item']['barcode'])); ?></td>
		<td><?= $item['Item']['name']; ?></td>
		<td><?= $html->link($item['Category']['name'], array('controller' => 'categories', 'action' => 'view', $item['Category']['id'])); ?></td>
		<td><?= $number->currency($item['Item']['sell_price']); ?></td>
		<td><?= $number->currency($item['Item']['cost_price']); ?></td>
		<td><?= $item['Item']['stock']; ?></td>
	</tr>
	<? endforeach; ?>
</table>
<script type="text/javascript">
$(function() {
	print();
});
</script>