<?// pr($session->read('Sale')); ?>
<?// pr($session->read('SoldItem')); ?>
<?= $form->create('Sale', array('inputDefaults' => array('label' => false, 'div' => false))); ?>
<h5>Sale #<?= $sale['Sale']['id']; ?></h5>
<table>
	<tr>
		<th width="30%">Customer:</th>
		<td><?= $session->read('Customer.name'); ?></td>
	</tr>
	<tr>
		<th width="30%">Employee:</th>
		<td><?= $session->read('Employee.name'); ?></td>
	</tr>
</table>
<table>
	<tr>
		<th>Name</th>
		<th>Quantity</th>
		<th>Discount</th>
		<th>Total</th>
		<th>Refund</th>
	</tr>
	<? foreach($sale['SoldItem'] as $item): ?>
	<tr>
		<td width="30%">
			<?= $item['Item']['name']; ?>
			<? if ($item['Item']['serialized']): ?>
				<br />(S/N: <?= $item['serial']; ?>)
			<? endif; ?>
		</td>
		<td width="20%"><?= $item['quantity']; ?></td>
		<td width="20%"><?= $number->currency($item['discount']); ?></td>
		<td width="20%"><?= $number->currency($item['net_price']); ?></td>
		<td width="10%">
			<?= $html->link(
				$html->image('icons/actions/refund.png'), array('action' => 'refund_item', $item['id']),
				array('escape' => false, 'class' => 'refund button')
			); ?>
		</td>
	</tr>
	<? endforeach; ?>
</table>
<table style="width:50%;" align="right">
	<tr>
		<th>Old Total</th>
		<td><?= $number->currency($sale['Sale']['total']); ?></td>
	</tr>
	<tr>
		<th>New Total</th>
		<td><?= $number->currency($sale['Sale']['total']-$sale['Sale']['payment']); ?></td>
	</tr>
	<tr>
		<th>Current Balance</th>
		<td><?= $number->currency($sale['Sale']['balance']); ?></td>
	</tr>
</table>
<div style="display:none;"><?= $form->end(''); ?></div>
<?= $html->link(
	$html->image('icons/actions/accept.png', array('alt' => 'Refund', 'title' => 'Refund')).' Confirm Refund',
	array('action' => 'refund'),
	array('escape' => false, 'class' => 'finish button')
); ?>
<br /><br />
<?= $html->link(
	$html->image('icons/actions/delete.png', array('alt' => 'Delete', 'title' => 'Delete')).' Cancel Sale',
	array('action' => 'clear'),
	array('escape' => false, 'class' => 'clear button')
); ?>
<script type="text/javascript">
$(function() {
	$('form').submit(function (e) {
		e.preventDefault();
		$.ajax({
			type: 'POST',
			url: $(this).attr('action'),
			data: $(this).serialize(),
			beforeSend: function () { $("#content").css({opacity: 0.2}, 500); $('#spinner').show(); },
			success: function (data) { $("#content").html(data); $("#content").css({opacity: 1}, 500); $('#spinner').hide(); }
		});
	});
});
</script>