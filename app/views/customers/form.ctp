<? if (isset($this->params['pass'][0])): ?>
	<?= $form->create('Customer', array('url' => array($this->params['pass']['0']), 'inputDefaults' => array('label' => false, 'div' => false))); ?>
<? else: ?>
	<?= $form->create('Customer', array('inputDefaults' => array('label' => false, 'div' => false))); ?>
<? endif; ?>
<table>
	<tr>
		<th>Name</th>
		<td><?= $form->input('name'); ?></td>
		<th>Email</th>
		<td><?= $form->input('email'); ?></td>
	</tr>
	<tr>
		<th>Mobile</th>
		<td><?= $form->input('mobile'); ?></td>
		<th>Phone</th>
		<td><?= $form->input('phone'); ?></td>
	</tr>
</table>
<?= $form->end('Submit'); ?>