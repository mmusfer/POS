<div id="ticket-page">
	<div class="center">
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
	Finish Time: <?= strftime('%a, %b %e %Y at %I:%M %p', strtotime($ticket['Ticket']['modified'])); ?><br />
	Devices: <?= $ticket['Ticket']['devices']; ?>
	<br />
	<table class="print">
		<tr>
			<th>#</th>
			<th>Name</th>
			<th>Price</th>
		</tr>
		<? foreach($ticket['TicketRequest'] as $request): ?>
		<tr>
			<td><?= $request['Request']['id']; ?></td>
			<td><?= $request['Request']['name']; ?></td>
			<td><?= $number->currency($request['price']); ?></td>
		</tr>
		<? endforeach; ?>
	</table>
	<?= $form->create('Ticket', array('url' => array($this->params['pass']['0']))); ?>
	<table style="width:50%" align="right">
		<tr>
			<th>Additional Costs</th>
			<td><?= $form->input('additional_costs', array('value' => $this->data['Ticket']['additional_costs'],'label' => false, 'div' => false,'style' => 'width:80%;')); ?> SR</td>
		</tr>
		<tr>
			<th>Total</th>
			<td><?= $number->currency($ticket['Ticket']['total']); ?></td>
		</tr>
	</table>
	<br />
	<?= $form->end('Make Payment'); ?>
</div>