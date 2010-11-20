<table>
	<tr>
		<th><?= $paginator->sort('Name', 'name'); ?></th>
		<th><?= $paginator->sort('Mobile', 'mobile'); ?></th>
		<th><?= $paginator->sort('Phone', 'phone'); ?></th>
		<th><?= $paginator->sort('Email', 'email'); ?></th>
		<th>Options</th>
	</tr>
	<? foreach ($customers as $customer): ?>
	<tr>
		<td><?= $customer['Customer']['name']; ?></td>
		<td><?= $customer['Customer']['mobile']; ?></td>
		<td><?= $customer['Customer']['phone']; ?></td>
		<td><?= $customer['Customer']['email']; ?></td>
		<td width="15%"><?= $this->element('actions', array('id' => $customer['Customer']['id'], 'view' => 1, 'edit' => 1, 'delete' => 1)); ?></td>
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