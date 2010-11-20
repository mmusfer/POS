<? if (($this->params['action'] == 'index') || ($this->params['action'] == 'home')): ?>
<div id="dash-list">
	<? if ($this->params['controller'] == 'pages'): ?>
		<? if (Employee::$auth['rank'] >= 5): ?>
			<?= $html->link(
				'<div>'.$html->image('icons/sales.png').'<br />Sales</div>',
				array('controller' => 'sales'),
				array('escape' => false, 'id' => 'sales')
			); ?>
			<?= $html->link(
				'<div>'.$html->image('icons/tickets.png').'<br />Tickets</div>',
				array('controller' => 'tickets'),
				array('escape' => false, 'id' => 'tickets-link')
			); ?>
			<?= $html->link(
				'<div>'.$html->image('icons/customers.png').'<br />Customers</div>',
				array('controller' => 'customers'),
				array('escape' => false, 'id' => 'customers')
			); ?>
		<? endif; ?>
		<? if (Employee::$auth['rank'] >= 8): ?>
			<?= $html->link(
				'<div>'.$html->image('icons/items.png').'<br />Items</div>',
				array('controller' => 'items'),
				array('escape' => false, 'id' => 'items')
			); ?>
		<? endif; ?>
		<? if (Employee::$auth['rank'] == 9): ?>
			<?= $html->link(
				'<div>'.$html->image('icons/settings.png').'<br />Settings</div>',
				array('controller' => 'settings'),
				array('escape' => false, 'id' => 'settings')
			); ?>
		<? endif; ?>
	<? elseif (($this->params['controller'] == 'items') || ($this->params['controller'] == 'orders') || ($this->params['controller'] == 'packages')
	|| ($this->params['controller'] == 'categories') || ($this->params['controller'] == 'suppliers')): ?>
		<? if (Employee::$auth['rank'] >= 8): ?>
			<?= $html->link(
				'<div>'.$html->image('icons/orders.png').'<br />Orders</div>',
				array('controller' => 'orders'),
				array('escape' => false, 'id' => 'orders')
			); ?>
			<?= $html->link(
				'<div>'.$html->image('icons/packages.png').'<br />Packages</div>',
				array('controller' => 'packages'),
				array('escape' => false, 'id' => 'packages')
			); ?>
			<?= $html->link(
				'<div>'.$html->image('icons/categories.png').'<br />Categories</div>',
				array('controller' => 'categories'),
				array('escape' => false, 'id' => 'categories')
			); ?>
			<?= $html->link(
				'<div>'.$html->image('icons/suppliers.png').'<br />Suppliers</div>',
				array('controller' => 'suppliers'),
				array('escape' => false, 'id' => 'suppliers')
			); ?>
		<? endif; ?>
	<? elseif ((($this->params['controller'] == 'tickets') && ($this->params['action'] != 'view')) || ($this->params['controller'] == 'requests')): ?>
		<? if (Employee::$auth['rank'] >= 5): ?>
			<?= $html->link(
				'<div>'.$html->image('icons/requests.png').'<br />Requests</div>',
				array('controller' => 'requests'),
				array('escape' => false, 'id' => 'requests')
			); ?>
		<? endif; ?>
	<? elseif (($this->params['controller'] == 'settings') || ($this->params['controller'] == 'reports') || ($this->params['controller'] == 'employees')): ?>
		<?= $html->link(
			'<div>'.$html->image('icons/employees.png').'<br />Employees</div>',
			array('controller' => 'employees'),
			array('escape' => false, 'id' => 'employees')
		); ?>
		<?= $html->link(
			'<div>'.$html->image('icons/Reports.png').'<br />Reports</div>',
			array('controller' => 'reports'),
			array('escape' => false, 'id' => 'reports')
		); ?>
	<? endif; ?>
</div>
<? endif; ?>