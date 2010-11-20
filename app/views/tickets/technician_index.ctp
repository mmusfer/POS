<h3>Open Tickets</h3>
<? if (!empty($tickets)): ?>
	<? foreach ($tickets as $ticket): ?>
	<div class="ticket">
		<div id="ticket-<?= $ticket['Ticket']['id']; ?>" class="title">
			<span class='id'>Ticket #<?= $ticket['Ticket']['id']; ?></span>
			<span class="time">EFT: <?= strftime('%H:%M %b %d %Y', strtotime($ticket['Ticket']['finish'])); ?></span>
		</div>
		<div class="ticket-details">
			<div class="ticket-customer">Customer: <?= (!empty($ticket['Customer']['name'])) ? $ticket['Customer']['name'] : 'Guest'; ?></div>
			<div class="ticket-devices">Devices: <?= (!empty($ticket['Ticket']['devices'])) ? $ticket['Ticket']['devices'] : 'None'; ?></div>
			<? foreach ($ticket['TicketRequest'] as $request): ?>
				<div class='ticket-request'>Request: <?= $request['Request']['name']; ?></div>
				<? if ($request['status'] != 1): ?>
					<?= $html->link(
						$html->image('icons/actions/accept.png'),
						array('controller' => 'tickets', 'action' => 'track', $request['id']),
						array('escape' => false, 'class' => 'track')
					); ?>
				<? endif; ?>
			<? endforeach; ?>
		</div>
	</div>
	<? endforeach; ?>
<? else: ?>
<div class="ticket">
	<div id="ticket-id" class="center">
		<span class='id'>No Open Tickets! Good job!</span>
	</div>
</div>	
<? endif; ?>
<script>
$('.ticket .track').click(function (e) {
	e.preventDefault();
	$.ajax({
		url: $(this).attr('href'),
		beforeSend: function () { $("#tickets").css({opacity: 0}, 2000); },
		success: function (data)
		{
			if (data = 1)
			{
				$.ajax({
					beforeSend: function () { $("#tickets").css({opacity: 0}, 2000); },
					success: function (data) { $("#tickets").html(data); $("#tickets").css({opacity: 1}, 2000); },
					url: "<?= $html->url(array('controller' => 'tickets', 'action' => 'technician_index')); ?>"
				});
				$('#tickets').removeClass();
			}
		}
	});
});
$(function(){
	$('#tickets').accordion({header: "div.ticket .title", collapsible: true, active: false });
});
</script>