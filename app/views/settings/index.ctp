<table>
	<tr>
		<th>Name</th>
		<th>Value</th>
		<th>Actions</th>
	</tr>
	<? foreach ($settings as $setting): ?>
	<tr>
		<td><?= $setting['Setting']['name']; ?></td>
		<td><?= $setting['Setting']['value']; ?></td>
		<td width="5%"><?= $this->element('actions', array('id' => $setting['Setting']['id'], 'edit' => 1)); ?></td>
	</tr>
	<? endforeach; ?>
</table>