<? if (isset($this->params['pass'][0])): ?>
	<?= $form->create('Employee', array('url' => array($this->params['pass']['0']), 'inputDefaults' => array('label' => false, 'div' => false))); ?>
<? else: ?>
	<?= $form->create('Employee', array('inputDefaults' => array('label' => false, 'div' => false))); ?>
<? endif; ?>
<table>
	<tr>
		<th>Name</th>
		<td><?= $form->input('name'); ?></td>
		<th>Username</th>
		<td><?= $form->input('username'); ?></td>
	</tr>
	<tr>
		<th>Password</th>
		<td><?= $form->input('password'); ?></td>
		<th>Password Confirm</th>
		<td><?= $form->input('password_confirm'); ?></td>
	</tr>
	<tr>
		<th>Profit Discount Percent (%)</th>
		<td><?= $form->input('profit_percent'); ?></td>
		<th>Permissions</th>
		<td>
			<?= $form->input('rank', array('type' => 'select', 'options' => array(1 => 'Technician', 5 => 'Cashier', 8 => 'Manager', 9 => 'Owner'))); ?>
		</td>
	</tr>
</table>
<?= $form->end('Submit'); ?>