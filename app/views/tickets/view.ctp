<?= $html->link($html->image('icons/actions/print.png').' Print', 'javascript:print();', array('class'=>'button', 'escape' => false)); ?><br /><br />
<div id="ticket-page">
	<div class="center">
		<h1><?= Configure::read('Settings.name'); ?></h1>
		<h4><?= Configure::read('Settings.address'); ?></h4>
		<h5>Maintenance Ticket #<?= $ticket['Ticket']['id']; ?></h5>
	</div>
	<table>
		<tr>
			<td width='33%'>
				Technician: <?= $ticket['Technician']['name']; ?>
				<br />Customer: <?= $ticket['Customer']['name']; ?>
			</td>
			<td width='33%'>
				Date: <?= strftime('%a, %b %e %Y', strtotime($ticket['Ticket']['created'])); ?>
				<br />Time: <?= strftime('%I:%M %p', strtotime($ticket['Ticket']['created'])); ?>
			</td>
			<td width='34%'>
				<?= $html->image($barcode->output('T'.$ticket['Ticket']['id'])); ?>
			</td>
		</tr>
	</table>
	EFT: <?= strftime('%a, %b %e %Y at %I:%M %p', strtotime($ticket['Ticket']['finish'])); ?><br />
	<? if ($ticket['Ticket']['created'] != $ticket['Ticket']['modified']): ?>
	Finish Time: <?= strftime('%a, %b %e %Y at %I:%M %p', strtotime($ticket['Ticket']['finish'])); ?><br />
	<? endif; ?>
	Devices: <?= $ticket['Ticket']['devices']; ?>
	<br />
	<table class="print">
		<tr>
			<th>Name</th>
			<th>Price</th>
		</tr>
		<? foreach($ticket['TicketRequest'] as $request): ?>
		<tr>
			<td><?= $request['Request']['name']; ?></td>
			<td><?= $number->currency($request['price']); ?></td>
		</tr>
		<? endforeach; ?>
	</table>
	<table style="width:50%" align="right">
		<? if ($ticket['Ticket']['additional_costs'] != 0): ?>
		<tr>
			<th width="50%">Additional Costs</th>
			<td><?= $number->currency($ticket['Ticket']['additional_costs']); ?></td>
		</tr>
		<? endif; ?>
		<tr>
			<th>Total</th>
			<td><?= $number->currency($ticket['Ticket']['total']); ?></td>
		</tr>
	</table>
<?= Configure::read('Settings.sell_message'); ?>
</div>