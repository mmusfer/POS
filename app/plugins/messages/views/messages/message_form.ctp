<?= $form->create('Message', array('action' => 'add', 'inputDefaults' => array('label' => false, 'div' => false))); ?>
	<? if (!empty($receiver)): ?>
		To: <?= $receiver['Employee']['name']; ?><br />
		<?= $form->hidden('Message.receiver_id', array('value' => $receiver['Employee']['id'])); ?>
	<? else: ?>
		To: <?= $form->input('Message.receiver_id', array('class' => 'combobox', 'options' => $employees)); ?><br />
	<? endif; ?>
	<? if (!empty($message)): ?>
	<?= $form->hidden('Message.reply_to', array('value' => $message['Message']['id'])); ?>
		Reply To: <?= $message['Message']['subject']; ?><br />
	<? endif; ?>
	Subject: <?= $form->input('Message.subject', array('value' => '')); ?><br />
	<?= $form->input('Message.text', array('value' => '')); ?>
<?= $form->end('Send message'); ?>
<script>
$(document).ready(function(){
	$('.combobox').combobox();
	$('#messages form').submit(function (e) {
		e.preventDefault();
		$.ajax({
			type: 'POST',
			url: $('#messages form').attr('action'),
			data: 'data%5BMessage%5D%5Breceiver_id%5D='+$('#MessageReceiverId').val()+'&data%5BMessage%5D%5Bsubject%5D='+$('input#MessageSubject').val()+'&data%5BMessage%5D%5Btext%5D='+$('textarea#MessageText').val().replace(/\n/g, '<br />\n')+'&data%5BMessage%5D%5Breply_to%5D='+$('input#MessageReplyTo').val(),
			beforeSend: function () { $("#messages").css({opacity: 0}, 2000); },
			success: function (data) { $("#messages").html(data); $("#messages").css({opacity: 1}, 2000); }
		});
	});
});
</script>
<style>
#home #messages #message-form{width:339px;margin:5px 10px;padding:5px 10px;-moz-border-radius:10px;background:#eee;border:1px solid #999;text-align:left;}
#home #messages #message-form textarea{width:315px;height:100px;margin:5px 0;padding:5px;text-align:left;font-size:80%;}
</style>