<? if (isset($this->params['pass'][0])): ?>
	<?= $form->create('Setting', array('url' => array($this->params['pass']['0']), 'inputDefaults' => array('label' => false, 'div' => false))); ?>
<? else: ?>
	<?= $form->create('Setting', array('inputDefaults' => array('label' => false, 'div' => false))); ?>
<? endif; ?>
<table>
	<tr>
		<th>Name</th>
		<th>Value</th>
	</tr>
	<tr>
		<td><?= $this->data['Setting']['name']; ?></td>
		<td><?= $form->input('value', array('label' => false)); ?></td>
	</tr>
</table>
<?= $form->end('Submit')?>