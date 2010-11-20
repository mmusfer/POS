<table>
	<tr>
		<th><?= $paginator->sort('Name', 'name'); ?></th>
		<th><?= $paginator->sort('Price', 'price'); ?></th>
		<th><?= $paginator->sort('Minimum Price', 'min_price'); ?></th>
		<th>Actions</th>
	</tr>
	<? foreach ($requests as $request): ?>
	<tr>
		<td><?= $request['Request']['name']; ?></td>
		<td><?= $number->currency($request['Request']['price']); ?></td>
		<td><?= $number->currency($request['Request']['min_price']); ?></td>
		<td width="10%"><?= $this->element('actions', array('id' => $request['Request']['id'], 'edit' => 1, 'delete' => 1)); ?></td>
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