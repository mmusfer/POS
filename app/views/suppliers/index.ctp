<table>
	<tr>
		<th><?= $paginator->sort('Name', 'name'); ?></th>
		<th><?= $paginator->sort('Item Count', 'item_count'); ?></th>
		<th>Actions</th>
	</tr>
	<? foreach ($suppliers as $supplier): ?>
	<tr>
		<td><?= $supplier['Supplier']['name']; ?></td>
		<td><?= $supplier['Supplier']['item_count']; ?></td>
		<td width="15%"><?= $this->element('actions', array('id' => $supplier['Supplier']['id'], 'view' => 1, 'edit' => 1, 'delete' => '1')); ?></td>
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