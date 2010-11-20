<div id="user-panel">
	<?= $html->link(
		'<div>'.$html->image('icons/home.png').'</div>',
		'/', array('escape' => false, 'id' => 'home-page')
	); ?>
	<? if (Employee::$auth['rank'] >= 5): ?>
		<?= $html->link(
			'<div>'.$html->image('icons/sales.png').'</div>', array('controller' => 'sales', 'action' => 'index'),
			array('escape' => false, 'id' => ($this->params['controller'] == 'sales') ? 'current' : null)
		); ?>
		<?= $html->link(
			'<div>'.$html->image('icons/tickets.png').'</div>', array('controller' => 'tickets', 'action' => 'index'),
			array('escape' => false, 'id' => ($this->params['controller'] == 'tickets') ? 'current' : null)
		); ?>
		<?= $html->link(
			'<div>'.$html->image('icons/items.png').'</div>', array('controller' => 'items', 'action' => 'index'),
			array('escape' => false, 'id' => ($this->params['controller'] == 'items') ? 'current' : null)
		); ?>
	<? endif; ?>
	<? if (Employee::$auth['rank'] >= 9): ?>
		<?= $html->link(
			'<div>'.$html->image('icons/settings.png').'</div>', array('controller' => 'settings', 'action' => 'index'),
			array('escape' => false, 'id' => ($this->params['controller'] == 'settings') ? 'current' : null)
		); ?>
	<? endif; ?>
	<? if (($this->params['controller'] == 'requests') || ($this->params['controller'] == 'orders')
	|| ($this->params['controller'] == 'employees') || ($this->params['controller'] == 'reports')
	|| ($this->params['controller'] == 'packages') || ($this->params['controller'] == 'categories')
	|| ($this->params['controller'] == 'suppliers')  || ($this->params['controller'] == 'customers')): ?>
	<?= $html->link(
		'<div>'.$html->image('icons/'.$this->params['controller'].'.png').'</div>', array('controller' => $this->params['controller']),
		array('escape' => false, 'id' => 'current')
	); ?>
	<? endif; ?>
</div>