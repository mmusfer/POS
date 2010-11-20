<table>
	<tr>
		<th><?= $paginator->sort('Id', 'id'); ?></th>
		<th><?= $paginator->sort('Name', 'name'); ?></th>
		<th><?= $paginator->sort('Item Count', 'item_count'); ?></th>
		<th>Actions</th>
	</tr>
	<? foreach ($categories as $category): ?>
	<tr>
		<td class="id"><?= $category['Category']['id']; ?></td>
		<td><?= $category['Category']['name']; ?></td>
		<td><?= $category['Category']['item_count']; ?></td>
		<td width="15%"><?= $this->element('actions', array('id' => $category['Category']['id'], 'view' => 1, 'edit' => 1, 'delete' => '1')); ?></td>
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