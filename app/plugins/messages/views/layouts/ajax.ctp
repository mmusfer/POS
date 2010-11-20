<?= $this->element('form_errors'); ?>
<?= $content_for_layout; ?>
<script>
$(function() {
	$('.form-error').parent().css({'background-color': '#fcc'});
	$('input:submit, .button').button();
});
</script>
<?= $js->writeBuffer(); ?>