<?= $html->link($html->image('icons/actions/print.png').' Print', 'javascript:print();', array('class'=>'button', 'escape' => false)); ?><br /><br />
<div id="page">
	<div class="center">
		<h1><?= Configure::read('Settings.name'); ?></h1>
		<h4><?= Configure::read('Settings.address'); ?></h4>
		<h5>Sale Receipt #<?= $sale['Sale']['id']; ?></h5>
	</div>
	<table>
		<tr>
			<td width='33%'>
				Employee: <?= $sale['Employee']['name']; ?>
				<? if (!empty($sale['Customer']['id']) && ($sale['Customer']['id'] != 0)): ?>
					<br />Customer: <?= $sale['Customer']['name']; ?>
				<? endif; ?>
			</td>
			<td width='33%'>
				Date: <?= strftime('%a, %b %e %Y', strtotime($sale['Sale']['created'])); ?>
				<br />Time: <?= strftime('%I:%M %p', strtotime($sale['Sale']['created'])); ?>
			</td>
			<td width='34%'>
				<?= $html->image($barcode->output('S'.$sale['Sale']['id'])); ?>
			</td>
		</tr>
	</table>
	<table class="print">
		<tr>
			<th>#</th>
			<th>Name</th>
			<th>Quantity</th>
			<th>Discount</th>
			<th>Total</th>
		</tr>
		<? foreach($sale['SoldItem'] as $item): ?>
		<tr>
			<td width="10%"><?= $item['Item']['cat_id']; ?></td>
			<td width="30%">
				<?= $item['Item']['name']; ?>
				<? if ($item['Item']['serialized']): ?>
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
			<td><?= $number->currency($sale['Sale']['total']); ?></td>
		</tr>
		<tr>
			<th>Payment</th>
			<td><?= $number->currency($sale['Sale']['payment']); ?></td>
		</tr>
		<tr>
			<th>Balance</th>
			<td><?= $number->currency($sale['Sale']['balance']); ?></td>
		</tr>
	</table>
	<?= Configure::read('Settings.sell_message'); ?>
</div>