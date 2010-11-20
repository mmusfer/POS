<div id="login">
	<h1>Login</h1>
	<?= $form->create('Employee'); ?>
		<?= $form->input('username', array('type' => 'text', 'label' => 'Login ID')); ?>
		<?= $form->input('password'); ?>
	<?= $form->end('Login'); ?>
</div>
<script>
$(function() {
	$('#content').css('background', 'transparent').css('border', 'none');
});
</script>