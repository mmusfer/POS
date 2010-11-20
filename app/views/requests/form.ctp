<? if (isset($this->params['pass'][0])): ?>
	<?= $form->create('Request', array('url' => array($this->params['pass']['0']), 'inputDefaults' => array('label' => false, 'div' => false))); ?>
<? else: ?>
	<?= $form->create('Request', array('inputDefaults' => array('label' => false, 'div' => false))); ?>
<? endif; ?>
<table>
	<tr>
		<th>Name</th>
		<th>Price</th>
		<th>Minimum Price</th>
	</tr>
	<tr>
		<td><?= $form->input('name'); ?></td>
		<td><?= $form->input('price'); ?></td>
		<td><?= $form->input('min_price'); ?></td>
	</tr>
</table>
<?= $form->end('Submit'); ?>
