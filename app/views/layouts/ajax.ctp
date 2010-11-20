<?= $this->element('dashboard'); ?>
<?= $this->element('action_bar'); ?>
<?= $this->element('form_errors'); ?>
<?= $session->flash('auth'); ?>
<? if ($messages = $session->read('Message.flash')): ?>
	<? foreach ($messages as $k => $v): ?>
		<?= $session->flash('flash.'.$k); ?>
	<? endforeach; ?>
<? endif; ?>
<?= $content_for_layout; ?>
<script type="text/javascript">
$(function() {
	$('.button, input:submit').button();
	$("input[type=text]:first").focus();
	$('.form-error').parent().css({'background-color': '#fcc'});
	$(".combobox").combobox();
});
</script>
