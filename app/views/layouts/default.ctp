<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?= $html->charset(); ?>
	<title>POS: <?= $title_for_layout; ?></title>
	<?= $html->script(array('jquery','jquery.ui','jquery.plugins')); ?>
	<?= $scripts_for_layout; ?>
	<?= $html->css(array('jquery-ui/start','nyroModal','style')); ?>
	<?= $html->css('print', 'stylesheet', array('media' => 'print')); ?>
</head>
<body>
<div id="wrapper">
	<div id="header">
		<?= $this->element('user_bar'); ?>
		<? if ((Employee::$auth) && ($this->params['controller'] != 'pages')): ?>
			<?= $this->element('user_panel'); ?>
		<? endif ;?>
		<?= $html->image('logo.gif', array('alt' => 'POS', 'id' => 'logo'));?>
	</div>
	<?= $html->image('ajaxLoader.gif', array('id' => 'spinner', 'alt' => 'Loading...'));?>
	<div id="content">
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
	</div>
	<div id="footer">
		<?= Configure::read('Settings.name'); ?>
	</div>
	<script type="text/javascript">
	$(function() {
		$('.button, input:submit').button();
		$("input[type=text]:first").focus();
		$('.form-error').parent().css({'background-color': '#fcc'});
		$(".combobox").combobox();
		$('#time').jclock({format: '%a, %b %d, %Y | %I:%M:%S %P', fontSize: 13});
	});
	</script>
</div>
</body>
</html>