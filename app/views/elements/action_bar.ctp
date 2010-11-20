<div id="action-bar">
<? if ($this->params['action'] == 'index'): ?>
	<?= $html->link(
		'New',
		array('action' => 'add'),
		array('escape' => false, 'class' => 'button add', 'id' => 'add')
	); ?>
	<? if ($this->params['controller'] == 'employees'): ?>
		<script type="text/javascript">$(function() {$("a.add").nyroModal({blocker: "#content",ltr: false,width: 600});});</script>
	<? endif; ?>
	<?= $html->link(
		'Search',
		'search',
		array('escape' => false, 'class' => 'button', 'id' => 'search')
	); ?>
	<?= $html->link(
		'Print',
		array('action' => 'print_list'),
		array('escape' => false, 'class' => 'button', 'id' => 'print')
	); ?>
<? endif; ?>
</div>