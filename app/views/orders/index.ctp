<table>
	<tr>
		<th><?= $paginator->sort('Supplier', 'supplier_id'); ?></th>
		<th><?= $paginator->sort('Total', 'total'); ?></th>
		<th><?= $paginator->sort('Employee', 'employee_id'); ?></th>
		<th><?= $paginator->sort('Time', 'created'); ?></th>
		<th>Actions</th>
	</tr>
	<? foreach ($orders as $order): ?>
	<tr>
		<td><?= ($order['Supplier']['name']) ? $order['Supplier']['name'] : 'Anonymous'; ?></td>
		<td><?= $number->currency($order['Order']['total']); ?></td>
		<td><?= $order['Employee']['name']; ?></td>
		<td><?= strftime('%a, %b %e %Y at %I:%M %p', strtotime($order['Order']['created'])); ?></td>
		<td width="10%"><?= $this->element('actions', array('id' => $order['Order']['id'], 'view' => 1, 'delete' => 1)); ?></td>
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