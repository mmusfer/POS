<div id="user-bar">
	<? if (Employee::$auth): ?>
		Welcome: <?= $this->Session->read('Auth.Employee.name'); ?>
		<?= $html->link('(Logout)',array('controller' => 'employees', 'action' => 'logout'),array('id' => 'logout')); ?>
	<? endif; ?>
	<div id='time'></div>
</div>
<br />