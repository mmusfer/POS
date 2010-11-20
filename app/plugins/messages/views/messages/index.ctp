<h5><?= $html->image('icons/messages.png');?> My Messages</h5>
<? if (!empty($messages)): ?>
	<? foreach ($messages as $message): ?>
	<div class="my-message">
		<div id="message-<?=$message['Message']['id']; ?>" class="title">
			<?= $message['Sender']['name']; ?>:
			"<?= $message['Message']['subject']; ?>"
			<span class="time"><?= strftime('%H:%M %b %d %Y', strtotime($message['Message']['modified'])); ?></span>
		</div>
	</div>
	<? endforeach; ?>
<? else: ?>
	<div class="my-message">No messages!</div>
<? endif; ?>
<?= $html->link(
	'Send message',
	array('plugin' => 'messages', 'controller' => 'messages', 'action' => 'message_form'),
	array('class' => 'add button')
); ?>
<div id="message-form"></div>
<script>
$(document).ready(function(){
	$('.my-message').click(function (e) {
		$.ajax({
			url: "<?= $html->url(array('plugin' => 'messages', 'controller' => 'messages', 'action' => 'view')); ?>/"+$(this).find('.title').attr('id').replace('message-', ''),
			beforeSend: function () { $("#messages").css({opacity: 0}, 2000); },
			success: function (data) { $("#messages").html(data); $("#messages").css({opacity: 1}, 2000); }
		});
	});
	$('#messages a.add').click(function (e) {
		$(this).hide();
		e.preventDefault();
		$.ajax({
			url: $(this).attr('href'),
			beforeSend: function () { $("#messages").css({opacity: 0}, 2000); },
			success: function (data) { $("#message-form").html(data); $("#messages").css({opacity: 1}, 2000); $('input#MessageSubject').focus(); }
		});
	});
	$('#messages form').submit(function (e) {
		e.preventDefault();
		$.ajax({
			type: 'POST',
			url: $('#messages form').attr('action')+'/'+$('select#MessageReceiverId').val(),
			data: 'data%5BMessage%5D%5Bsubject%5D='+$('textarea#MessageText').val()+'&data%5BMessage%5D%5Btext%5D='+$('textarea#MessageText').val().replace(/\n/g, '<br />\n'),
			beforeSend: function () { $("#messages").css({opacity: 0}, 2000); },
			success: function (data) { $("#messages").html(data); $('#messags').css({opacity: 1}, 2000); }
		});
	});
});
</script>