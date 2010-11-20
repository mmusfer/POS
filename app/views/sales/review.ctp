<div id="page">
	<div class="center">
		<h1><?= Configure::read('Settings.name'); ?></h1>
		<h4><?= Configure::read('Settings.address'); ?></h4>
		<h5>Sale Invoice #00000</h5>
	</div>
	<table>
		<tr>
			<td width='33%'>
				Employee: <?= Employee::$auth['name']; ?>
				<? if (!empty($customer['Customer']['id']) && ($customer['Customer']['id'] != 0)): ?>
					<br />Customer: <?= $customer['Customer']['name']; ?>
				<? endif; ?>
			</td>
			<td width='33%'>
				Date: <?= strftime('%d/%m/%Y', time()); ?>
				<br />Time: <?= strftime('%r', time()); ?>
			</td>
			<td width='34%'>
				<?= $html->image($barcode->output('S00000')); ?>
			</td>
		</tr>
	</table>
	<table>
		<tr>
			<th>#</th>
			<th>Name</th>
			<th>Quantity</th>
			<th>Discount</th>
			<th>Total</th>
		</tr>
		<? foreach($sold_items as $item): ?>
		<tr>
			<td width="10%">#</td>
			<td width="30%">
				<?= $item['name']; ?>
				<? if ($item['serialized']): ?>
					<br />(S/N: <?= $item['serial']; ?>)
				<? endif; ?>
			</td>
			<td width="20%"><?= $item['quantity']; ?></td>
			<td width="20%"><?= $number->currency($item['discount']); ?></td>
			<td width="20%"><?= $number->currency($item['net_price']); ?></td>
		</tr>
		<? endforeach; ?>
	</table>
	<table style="width:50%;" align="right">
		<tr>
			<th>Total</th>
			<td><?= $number->currency($sale['total']); ?></td>
		</tr>
		<tr>
			<th>Payment</th>
			<td><?= (!empty($sale['payment'])) ? $number->currency($sale['payment']) : '0.00'; ?></td>
		</tr>
		<tr>
			<th>Balance</th>
			<td><?= $number->currency($sale['balance']); ?></td>
		</tr>
	</table>
	<div style="display:none;">
	<?= $form->end(''); ?>
	</div>
	<?= $html->link(
		$html->image('icons/actions/accept.png', array('alt' => 'Finish', 'title' => 'Finish')).' Submit Sale',
		array('action' => 'finish'),
		array('escape' => false, 'class' => 'finish button')
	); ?>
	<br /><br />
	<?= $html->link(
		$html->image('icons/actions/delete.png', array('alt' => 'Edit', 'title' => 'Edit')).' Edit Sale',
		array('action' => 'add'),
		array('escape' => false, 'class' => 'clear button')
	); ?>
</div>
<script>
$('.finish').click(function() {
	var test = confirm('Are you sure you want to process the sale?');
	if (!test) return false;
});
</script>