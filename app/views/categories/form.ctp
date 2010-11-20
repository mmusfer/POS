<? if (isset($this->params['pass'][0])): ?>
	<?= $form->create('Category', array('url' => array($this->params['pass']['0']), 'inputDefaults' => array('label' => false, 'div' => false))); ?>
<? else: ?>
	<?= $form->create('Category', array('inputDefaults' => array('label' => false, 'div' => false))); ?>
<? endif; ?>
<table>
	<tr>
		<th>Name</th>
		<td><?= $form->input('name'); ?></td>
</table>
<?= $form->end('Submit'); ?>