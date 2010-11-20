<table>
	<tr>
		<th><?= $paginator->sort('Id', 'cat_id'); ?></th>
		<th><?= $paginator->sort('Name', 'name'); ?></th>
		<th><?= $paginator->sort('Category', 'category_id'); ?></th>
		<th><?= $paginator->sort('Sell Price', 'sell_price'); ?></th>
		<th><?= $paginator->sort('Cost Price', 'cost_price'); ?></th>
		<th><?= $paginator->sort('Stock', 'stock'); ?></th>
		<th>Actions</th>
	</tr>
	<? foreach ($items as $item): ?>
	<tr>
		<td class="id"><?= $item['Item']['cat_id']; ?></td>
		<td><?= $item['Item']['name']; ?></td>
		<td><?= $html->link($item['Category']['name'], array('controller' => 'categories', 'action' => 'view', $item['Category']['id'])); ?></td>
		<td><?= $number->currency($item['Item']['sell_price']); ?></td>
		<td><?= $number->currency($item['Item']['cost_price']); ?></td>
		<td><?= $item['Item']['stock']; ?></td>
		<td width='15%'><?= $this->element('actions', array('id' => $item['Item']['id'], 'view' => 1, 'edit' => 1, 'delete' => 1)); ?></td>
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