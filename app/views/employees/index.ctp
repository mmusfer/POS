<table>
	<tr>
		<th><?= $paginator->sort('Name', 'name'); ?></th>
		<th><?= $paginator->sort('Login ID', 'username'); ?></th>
		<th><?= $paginator->sort('Rank', 'rank'); ?></th>
		<th>Actions</th>
	</tr>
	<? foreach ($employees as $employee): ?>
	<tr>
		<td><?= $employee['Employee']['name']; ?></td>
		<td><?= $employee['Employee']['username']; ?></td>
		<td>
			<?= ($employee['Employee']['rank'] == 9) ? 'Owner' : 
			(($employee['Employee']['rank'] == 8) ? 'Manager' : 
			(($employee['Employee']['rank'] == 5) ? 'Cashier' : 'Technician')) ; ?>
		</td>
		<td width='15%'><?= $this->element('actions', array('id' => $employee['Employee']['id'], 'view' => 1, 'edit' => 1, 'delete' => 1)); ?></td>
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