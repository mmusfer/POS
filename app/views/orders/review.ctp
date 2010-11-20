<div id="page">
	<div class="center">
		<h1><?= Configure::read('Settings.name'); ?></h1>
		<h4><?= Configure::read('Settings.address'); ?></h4>
		<h5>Order Invoice #00000</h5>
	</div>
	<table>
		<tr>
			<td width='33%'>
				Employee: <?= Employee::$auth['name']; ?>
				<br />Supplier: <?= $supplier['Supplier']['name']; ?>
				<br />Invoice #: <?= $order['invoice_no']; ?>
			</td>
			<td width='33%'>
				Date: <?= strftime('%d/%m/%Y', time()); ?>
				<br />Time: <?= strftime('%r', time()); ?>
			</td>
			<td width='34%'>
				<?= $html->image($barcode->output('O00000')); ?>
			</td>
		</tr>
	</table>
	<table>
		<tr>
			<th>#</th>
			<th>Name</th>
			<th>Unit Price</th>
			<th>Quantity</th>
			<th>Total Price</th>
		</tr>
		<? foreach($ordered_items as $item): ?>
		<tr>
			<td width="10%">#</td>
			<td width="30%"><?= $item['name']; ?></td>
			<td width="20%"><?= $number->currency($item['cost_price']); ?></td>
			<td width="20%"><?= $item['quantity']; ?></td>
			<td width="20%"><?= $number->currency($item['net_price']); ?></td>
		</tr>
		<? endforeach; ?>
	</table>
	<table style="width:50%;" align="right">
		<tr>
			<th>Total</th>
			<td><?= $number->currency($order['total']); ?></td>
		</tr>
		<tr>
			<th>Discount</th>
			<td><?= $number->currency($order['discount']); ?></td>
		</tr>
		<tr>
			<th>Payment</th>
			<td><?= (!empty($order['payment'])) ? $number->currency($order['payment']) : '0.00'; ?></td>
		</tr>
		<tr>
			<th>Balance</th>
			<td><?= (!empty($order['Order']['balance'])) ? $number->currency($order['Order']['balance']) : '0.00'; ?></td>
		</tr>
	</table>
	<div style="display:none;">
	<?= $form->end(''); ?>
	</div>
	<?= $html->link(
		$html->image('icons/actions/accept.png', array('alt' => 'Finish', 'title' => 'Finish')).' Submit Order',
		array('action' => 'finish'),
		array('escape' => false, 'class' => 'finish button')
	); ?>
	<br /><br />
	<?= $html->link(
		$html->image('icons/actions/delete.png', array('alt' => 'Edit', 'title' => 'Edit')).' Edit Order',
		array('action' => 'add'),
		array('escape' => false, 'class' => 'clear button')
	); ?>
</div>
<script>
$('.finish').click(function() {
	var test = confirm('Are you sure you want to process the order?');
	if (!test) return false;
});
</script>