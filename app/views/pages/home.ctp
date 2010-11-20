<? if (Employee::$auth['rank'] == 1): ?>
<div id="tickets">
	<h3>Open Tickets</h3>
	<div class="ticket">
		<div id="ticket-id" class="center">
			<span>No Open Tickets! Good job!</span>
		</div>
	</div>
</div>
<? endif; ?>
<div id="home">
	<div id="todos">
		<h3>My Todos</h3>
		<div class="todo">Nothing to do!</div>
	</div>
	<div id="messages">
		<h3><?= $html->image('icons/messages.png');?> My Messages</h3>
		<div class="my-message">No messages!</div>
	</div>
</div>
<script type="text/javascript">
$(function () {
	$.ajax({
		beforeSend: function () { $("#tickets").css({opacity: 0}, 2000); },
		success: function (data) { $("#tickets").html(data); $("#tickets").css({opacity: 1}, 2000); },
		url: "<?= $html->url(array('controller' => 'tickets', 'action' => 'technician_index')); ?>"
	});
	$.ajax({
		beforeSend: function () { $("#todos").css({opacity: 0}, 2000); },
		success: function (data) { $("#todos").html(data); $("#todos").css({opacity: 1}, 2000); },
		url: "<?= $html->url(array('plugin' => 'todos', 'controller' => 'todos', 'action' => 'index')); ?>"
	});
	$.ajax({
		beforeSend: function () { $("#messages").css({opacity: 0}, 2000); },
		success: function (data) { $("#messages").html(data); $("#messages").css({opacity: 1}, 2000); },
		url: "<?= $html->url(array('plugin' => 'messages', 'controller' => 'messages', 'action' => 'index')); ?>"
	});
});
</script>