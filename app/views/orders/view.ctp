<?= $html->link($html->image('icons/actions/print.png').' Print', 'javascript:print();', array('class'=>'button', 'escape' => false)); ?><br /><br />
<div id="page">
	<div class="center">
		<h1><?= Configure::read('Settings.name'); ?></h1>
		<h4><?= Configure::read('Settings.address'); ?></h4>
		<h5>Order Invoice #<?= $order['Order']['id']; ?></h5>
	</div>
	<table>
		<tr>
			<td width='33%'>
				Employee: <?= $order['Employee']['name']; ?>
				<br />Supplier: <?= $order['Supplier']['name']; ?>
				<br />Invoice #: <?= $order['Order']['invoice_no']; ?>
			</td>
			<td width='33%'>
				Date: <?= strftime('%a, %b %e %Y', strtotime($order['Order']['created'])); ?>
				<br />Time: <?= strftime('%I:%M %p', strtotime($order['Order']['created'])); ?>
			</td>
			<td width='34%'>
				<?= $html->image($barcode->output('O'.$order['Order']['id'])); ?>
			</td>
		</tr>
	</table>
	<table class="print">
		<tr>
			<th>#</th>
			<th>Name</th>
			<th>Unit Price</th>
			<th>Quantity</th>
			<th>Total Price</th>
		</tr>
		<? foreach($order['OrderedItem'] as $item): ?>
		<tr>
			<td width="10%"><?= $item['Item']['cat_id']; ?></td>
			<td width="30%"><?= $item['Item']['name']; ?></td>
			<td width="20%"><?= $number->currency($item['cost_price']); ?></td>
			<td width="20%"><?= $item['quantity']; ?></td>
			<td width="20%"><?= $number->currency($item['net_price']); ?></td>
		</tr>
		<? endforeach; ?>
	</table>
	<table style="width:50%;" align="right">
		<tr>
			<th>Total</th>
			<td><?= $number->currency($order['Order']['total']); ?></td>
		</tr>
		<tr>
			<th>Discount</th>
			<td><?= $number->currency($order['Order']['discount']); ?></td>
		</tr>
		<tr>
			<th>Payment</th>
			<td><?= (!empty($order['Order']['payment'])) ? $number->currency($order['Order']['payment']) : '0.00'; ?></td>
		</tr>
		<tr>
			<th>Balance</th>
			<td><?= (!empty($order['Order']['balance'])) ? $number->currency($order['Order']['balance']) : '0.00'; ?></td>
		</tr>
	</table>
	<?= Configure::read('Settings.sell_message'); ?>
</div>