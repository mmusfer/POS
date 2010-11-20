<table>
	<tr>
		<th><?= $paginator->sort('Id', 'id'); ?></th>
		<th><?= $paginator->sort('Customer', 'customer_id'); ?></th>
		<th><?= $paginator->sort('Cost', 'total'); ?></th>
		<th><?= $paginator->sort('Technician', 'technician_id'); ?></th>
		<th><?= $paginator->sort('EFT', 'finish'); ?></th>
		<th>Actions</th>
	</tr>
	<? foreach ($tickets as $ticket): ?>
	<tr class="<?=($ticket['Ticket']['status'] == 2) ? 'ticket-payed' : '';?><?=($ticket['Ticket']['status'] == 1) ? 'ticket-finished' : '';?><?=($ticket['Ticket']['status'] == 0) ? 'ticket-working' : '';?>">
		<td class="id"><?= $ticket['Ticket']['id']; ?></td>
		<td><?= $ticket['Customer']['name']; ?></td>
		<td><?= $ticket['Ticket']['total']; ?></td>
		<td><?= $ticket['Technician']['name']; ?></td>
		<td><?= strftime('%a, %b %e %Y at %I:%M %p', strtotime($ticket['Ticket']['finish'])); ?></td>
		<td width="20%">
			<? if ((Employee::$auth['rank'] >= 5) && ($ticket['Ticket']['status'] == 1)): ?>
				<?= $html->link(
					$html->image('icons/actions/pay.png', array('alt' => 'Pay', 'title' => 'Pay')),
					array('action' => 'pay', $ticket['Ticket']['id']),
					array('escape' => false, 'id' => 'pay-'.$ticket['Ticket']['id'], 'class' => 'button pay')
				); ?>
			<? endif; ?>
			<? if ((Employee::$auth['rank'] == 1) && ($ticket['Ticket']['status'] == 0)): ?>
				<?= $html->link(
					$html->image('icons/actions/track.png', array('alt' => 'Track', 'title' => 'Track')),
					array('action' => 'track', $ticket['Ticket']['id']),
					array('escape' => false, 'id' => 'track-'.$ticket['Ticket']['id'], 'class' => 'button track')
				); ?>
			<? endif; ?>
			<?= $html->link(
				$html->image('icons/actions/ticket.png', array('alt' => 'Ticket', 'title' => 'Ticket')),
				array('action' => 'ticket', $ticket['Ticket']['id']),
				array('escape' => false, 'id' => 'ticket-'.$ticket['Ticket']['id'], 'class' => 'button ticket')
			); ?>
			<?= $this->element('actions', array('id' => $ticket['Ticket']['id'], 'view' => 1, 'delete' => 1)); ?>
		</td>
	</tr>
	<? endforeach; ?>
</table>
<? $paginator->options(array(
	'update' => '#content',
	'before' => $js->get('#spinner')->effect('fadeIn', array('buffer' => false)),
	'complete' => $js->get('#spinner')->effect('fadeOut', array('buffer' => false)),
)); ?>
<?= $paginator->prev('<< Previous ', null, null, array('class' => 'disabled')); ?>
<?= $paginator->counter(); ?>
<?= $paginator->next(' Next >>', null, null, array('class' => 'disabled')); ?>
<?= $js->writeBuffer(); ?>