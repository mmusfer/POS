<h5><?= $html->image('icons/todos.png');?> My Todos</h5>
<? if (!empty($todos)): ?>
	<? foreach ($todos as $todo): ?>
	<div class="todo">
		<div id="todo-<?= $todo['Todo']['id']; ?>" class="text"><?= $todo['Todo']['text']; ?></div>
		<div class="time"><?= strftime('%H:%M %b %d %Y', strtotime($todo['Todo']['modified'])); ?></div>
		<div class="actions">
			<?= $html->link(
				$html->image('icons/actions/edit.png'),
				array('plugin' => 'todos', 'controller' => 'todos', 'action' => 'edit', $todo['Todo']['id']),
				array('escape' => false, 'class' => 'edit')
			); ?>
			<?= $html->link(
				$html->image('icons/actions/delete.png'),
				array('plugin' => 'todos', 'controller' => 'todos', 'action' => 'delete', $todo['Todo']['id']),
				array('escape' => false, 'class' => 'delete')
			); ?>
		</div>
	</div>
	<? endforeach; ?>
<? else: ?>
	<div class="todo">Nothing to do!</div>
<? endif; ?>
<?= $form->create('Todo', array('action' => 'add')); ?>
	<?= $form->input('Todo.text', array('label' => 'Add Todo:', 'value' => '')); ?>
<?= $form->end(); ?>
<script>
$(document).ready(function(){
	$('.todo .text').editable($('.todo .text').next().next().find('.edit').attr('href'), { id: 'data[Todo][id]', name: 'data[Todo][text]' });
	$('.todo a.edit').click(function (e) {
		e.preventDefault();
		$(this).parent().parent().find('.text').click();
	});
	$('.todo a.delete').click(function (e) {
		e.preventDefault();
		var test = confirm('Are you sure?');
		if (!test) return false;
		$.ajax({ type: 'POST',
			url: $(this).attr('href'),
			beforeSend: function () { $("#todos").css({opacity: 0}, 2000); },
			success: function (data) { $("#todos").html(data); $("#todos").css({opacity: 1}, 2000); }
		});
	});
	$('#todos form').submit(function (e) {
		e.preventDefault();
		$.ajax({
			type: 'POST',
			url: $('#todos form').attr('action'),
			data: 'data%5BTodo%5D%5Btext%5D='+$('input#TodoText').val(),
			beforeSend: function () { $("#todos").css({opacity: 0}); },
			success: function (data) { $("#todos").html(data); $("#todos").css({opacity: 1}); }
		});
	});
});
</script>