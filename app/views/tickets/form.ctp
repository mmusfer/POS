<?= $form->create('Ticket', array('inputDefaults' => array('label' => false, 'div' => false))); ?>
<table>
	<tr>
		<th width="50%">Customer:</th>
		<th>Devices:</th>
	</tr>
	<tr>
		<td>
			<?= $form->input('Ticket.customer_id', array('class' => 'combobox', 'options' => $customers, 'value' => $session->read('Ticket.customer_id'))); ?>
			<?= $html->link(
				$html->image('icons/actions/add.png'),
				array('controller' => 'customers', 'action' => 'add'),
				array('id' => 'add-customer', 'class' => 'button', 'escape' => false)
			); ?>
		</td>
		<td rowspan="3">
			<? $count = 0; ?>
			<? foreach($devices_list as $device): ?>
				<input type="checkbox" id="Devices<?= $count; ?>" class="checkbox"<?= (!empty($devices[$count])) ? ' checked="checked"' : ''; ?>>
				<label for="Devices<?= $count; ?>"><?= $device; ?></label>
				<? $count++; ?>
			<? endforeach; ?>
			<?= $form->input('Ticket.devices', array('type' => 'hidden', 'value' => $session->read('Ticket.devices'))); ?>
		</td>
	</tr>
	<tr>
		<th>Technician:</th>
	</tr>
	<tr>
		<td>
			<?= $form->input('Ticket.technician_id', array('class' => 'combobox', 'options' => $technicians, 'value' => $session->read('Ticket.technician_id'))); ?>
		</td
	</tr>
	<tr>
	</tr>
	<tr>
	</tr>
</table>
<table>
	<tr>
		<th>Add request:</th>
		<td><?= $form->input('Request.name'); ?></td>
	</tr>
</table>
<table>
	<tr>
		<th width="45%">Request</th>
		<th width="45%">Price</th>
		<th width="10%">X</th>
	</tr>
	<? if (count($session->read('TicketRequest')) > 0): ?>
		<? foreach($session->read('TicketRequest') as $key => $request): ?>
		<tr class="request">
			<td><?= $request['name']; ?></td>
			<td><?= $form->input('TicketRequest.'.$key.'.price', array('class' => 'price', 'value' => $session->read('TicketRequest.'.$key.'.price'))); ?></td>
			<td>
				<?= $html->link(
					$html->image('icons/actions/refresh.png', array('alt' => 'Edit', 'title' => 'Edit')),
					array('action' => 'edit_request', $key),
					array('escape' => false, 'class' => 'edit', 'style' => 'display:none;')
				);?>
				<?= $html->link(
					$html->image('icons/actions/delete.png', array('alt' => 'Delete', 'title' => 'Delete')),
					array('action' => 'delete_request', $key),
					array('escape' => false, 'class' => 'delete')
				); ?>
			</td>
		</tr>
		<? endforeach; ?>
	<? else: ?>
	<tr id="no-requests-row">
		<td colspan="3">No requests added!</td>
	</tr>
	<? endif; ?>
</table>
<table style="width:50%;" align="right">
	<tr>
		<th>Finish Date</th>
		<td><?= $form->input('Ticket.finish-date', array('value' => ($session->read('Ticket.finish')) ? strftime('%b %d %Y', strtotime($session->read('Ticket.finish'))) : strftime('%b %d %Y', time()))); ?></td>
	</tr>
	<tr>
		<th>Finish Time</th>
		<td><?= $form->input('Ticket.finish-hour', array('value' => ($session->read('Ticket.finish')) ? strftime('%H:00', strtotime($session->read('Ticket.finish'))) : strftime('%H:00', time()),
			'options' => array('10:00'=>'10:00 AM','11:00'=>'11:00 AM','12:00'=>'12:00 AM','16:00'=>'04:00 PM','17:00'=>'05:00 PM',
				'18:00'=>'06:00 PM','19:00'=>'07:00 PM','20:00'=>'08:00 PM','21:00'=>'09:00 PM','22:00'=>'10:00 PM','23:00'=>'11:00 PM')
		)); ?></td>
	</tr>
	<tr>
		<th>Total</th>
		<td><?= $number->currency($session->read('Ticket.total')); ?></td>
	</tr>
</table>
<?= $form->hidden('Ticket.finish'); ?>
<div style="display:none;">
<?= $form->end(''); ?>
</div>
<br />
<?= $html->link(
	$html->image('icons/actions/accept.png', array('alt' => 'Finish', 'title' => 'Finish')).' Finish Ticket',
	array('action' => 'finish'), array('escape' => false, 'class' => 'finish button')
); ?>
<br /><br />
<?= $html->link(
	$html->image('icons/actions/delete.png', array('alt' => 'Clear', 'title' => 'Clear')).' Clear Ticket',
	array('action' => 'clear'), array('escape' => false, 'class' => 'clear button')
); ?>
<script type="text/javascript">
$(function() {
	$("a#add-customer").nyroModal({blocker: "#content",ltr: false,width: 600});
	$('.checkbox').button({icons: {primary:'ui-icon-minus'}});
	$('input#TicketFinish-date').datepicker({dateFormat: 'M dd yy'});
	$("#RequestName").autocomplete({
		source: "<?= $html->url(array('controller' => 'requests', 'action' => 'find', 'ext' => 'json')); ?>",
		select: function(event, ui)
		{
			$('#spinner').show();
			$('#content').css({'opacity': 0.25});
			$.ajax({
				url: "<?= $html->url(array('action' => 'add_request')); ?>/"+ui.item.id,
				success: function(data)
				{
					$('#content').html(data);
				}
			});
			$('#spinner').hide();
			$('#content').css({'opacity': 1});
		}
	});
});
$('.checkbox').click(function() {
	if ($(this).attr('checked') == true)
		{ $(this).button("option", "icons", {primary:'ui-icon-check'}); }
	else
		{ $(this).button("option", "icons", {primary:'ui-icon-minus'}); }
});
$('input.price, input#TicketFinish-date, select#TicketFinish-hour').change(function() {
	$('form').submit();
});
$('.ui-autocomplete-input').live('change', function() {
	$('form').submit();
});
$('form').submit(function(e) {
	var devices = '';
	$('input.checkbox:checked').each(function() {
		devices = devices + $(this).next('label').text() + ', ';
	});
	$('#TicketDevices').attr('value', devices.replace(/,\s$/, ''));
	e.preventDefault();
	$.ajax({
		type: 'POST',
		url: $(this).attr('action'),
		data: $(this).serialize(),
		beforeSend: function () { $("#content").css({opacity: 0.2}, 500); $('#spinner').show(); },
		success: function (data) { $("#content").html(data); $("#content").css({opacity: 1}, 500); $('#spinner').hide(); }
	});
});
$('.finish').click(function() {
	var test = confirm('Are you sure you want to process the sale?');
	if (!test)
	{
		return false;
	}
});
</script>