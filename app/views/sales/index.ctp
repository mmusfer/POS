<table>
	<tr>
		<th><?= $paginator->sort('Id', 'id'); ?></th>
		<th><?= $paginator->sort('Customer', 'customer_id'); ?></th>
		<th><?= $paginator->sort('Total', 'total'); ?></th>
		<th><?= $paginator->sort('Employee', 'employee_id'); ?></th>
		<th><?= $paginator->sort('Time', 'created'); ?></th>
		<th>Actions</th>
	</tr>
	<? foreach ($sales as $sale): ?>
	<tr>
		<td class="id"><?= $sale['Sale']['id']; ?></td>
		<td><?= ($sale['Customer']['name']) ? $sale['Customer']['name'] : 'Anonymous'; ?></td>
		<td><?= $number->currency($sale['Sale']['total']); ?></td>
		<td><?= $sale['Employee']['name']; ?></td>
		<td><?= strftime('%a, %b %e %Y at %I:%M %p', strtotime($sale['Sale']['created'])); ?></td>
		<td width="15%">
			<?= $html->link(
				$html->image('icons/actions/refund.png', array('alt' => 'Refund', 'title' => 'Refund')),
				array('action' => 'refund', $sale['Sale']['id']),
				array('escape' => false, 'id' => 'refund-'.$sale['Sale']['id'], 'class' => 'button refund')
			); ?>
			<?= $this->element('actions', array('id' => $sale['Sale']['id'], 'view' => 1, 'delete' => 1)); ?>
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