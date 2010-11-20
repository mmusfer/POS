<h5><?= $html->image('icons/messages.png');?> My Messages</h5>
<? if (!empty($message)): ?>
	<? if (!empty($message['Parent']['id'])): ?>
	<div class="my-message" id="message-<?=$message['Parent']['id']; ?>">
		<div class="details">
			Subject: <?= $message['Parent']['subject']; ?><br />
			Sender: <?= $message['Parent']['Sender']['name']; ?>
			<div class="time"><?= strftime('%H:%m %b %d %Y', strtotime($message['Parent']['created'])); ?></div>
			<div class="actions">
				<? if ($message['Parent']['Sender']['id'] !== Employee::$auth['id']): ?>
				<?= $html->link(
					$html->image('icons/actions/reply.png'),
					array('plugin' => 'messages', 'controller' => 'messages', 'action' => 'reply_form', $message['Parent']['Sender']['id'], $message['Parent']['id']),
					array('escape' => false, 'class' => 'reply')
				); ?>
				<? endif; ?>
				<?= $html->link(
					$html->image('icons/actions/delete.png'),
					array('plugin' => 'messages', 'controller' => 'messages', 'action' => 'delete', $message['Parent']['id']),
					array('escape' => false, 'class' => 'delete')
				); ?>
			</div>
		</div>
		<div class="text">
			<?= $message['Parent']['text']; ?>
		</div>
	</div>
	<? endif; ?>
	<div class="my-message" id="message-<?=$message['Message']['id']; ?>">
		<div class="details">
			Subject: <?= $message['Message']['subject']; ?><br />
			Sender: <?= $message['Sender']['name']; ?>
			<div class="time"><?= strftime('%H:%M %b %d %Y', strtotime($message['Message']['created'])); ?></div>
			<div class="actions">
				<? if ($message['Sender']['id'] !== Employee::$auth['id']): ?>
				<?= $html->link(
					$html->image('icons/actions/reply.png'),
					array('plugin' => 'messages', 'controller' => 'messages', 'action' => 'message_form', $message['Sender']['id'], $message['Message']['id']),
					array('escape' => false, 'class' => 'reply')
				); ?>
				<? endif; ?>
				<?= $html->link(
					$html->image('icons/actions/delete.png'),
					array('plugin' => 'messages', 'controller' => 'messages', 'action' => 'delete', $message['Message']['id']),
					array('escape' => false, 'class' => 'delete')
				); ?>
			</div>
		</div>
		<div class="text">
			<?= $message['Message']['text']; ?>
		</div>
	</div>
<? endif; ?>	
<div id="message-form"></div>
<?= $html->link(
	'Return to message list',
	array('plugin' => 'messages', 'controller' => 'messages', 'action' => 'index'),
	array('class' => 'return button')
); ?>
<script>
$(document).ready(function(){
	$('a.return').click(function (e) {
		e.preventDefault();
		$.ajax({
			url: $(this).attr('href'),
			beforeSend: function () { $("#messages").css({opacity: 0}, 2000); },
			success: function (data) { $("#messages").html(data); $("#messages").css({opacity: 1}, 2000); }
		});
	});
	$('.my-message a.reply').click(function (e) {
		e.preventDefault();
		$.ajax({
			url: $(this).attr('href'),
			beforeSend: function () { $("#messages").css({opacity: 0}, 2000); },
			success: function (data) { $("#message-form").html(data); $("#messages").css({opacity: 1}, 2000); $('input#MessageSubject').focus(); }
		});
	});
	$('.my-message a.delete').click(function (e) {
		e.preventDefault();
		var test = confirm('Are you sure?');
		if (!test) return false;
		$.ajax({ type: 'POST',
			url: $(this).attr('href'),
			beforeSend: function () { $("#messages").css({opacity: 0}, 2000); },
			success: function (data) { $("#messages").html(data); $("#messages").css({opacity: 1}, 2000); }
		});
	});
});
</script>
<style>
.my-message:hover{background:#ddd;}
.my-message .details{text-align:left;}
.my-message .time{font-size:75%;position:absolute;top:5px;right:10px;}
.my-message .actions{position:absolute;top:25px;right:10px;}
.my-message .text{border-top:2px solid #999;margin-top:10px;padding:5px;text-align:left;}
</style>