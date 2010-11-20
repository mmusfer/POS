<?= $form->create('Sale', array('inputDefaults' => array('label' => false, 'div' => false))); ?>
<table>
	<tr>
		<th>Customer:</th>
		<td>
			<?= $form->input('Sale.customer_id', array('class' => 'combobox', 'options' => $customers, 'value' => ($session->read('Sale.customer_id')) ? $session->read('Sale.customer_id') : 0)); ?>
			<?= $html->link(
				$html->image('icons/actions/add.png'),
				array('controller' => 'customers', 'action' => 'add'),
				array('id' => 'add-customer', 'class' => 'button', 'escape' => false)
			); ?>
		</td>
	</tr>
</table>
<table>
	<tr>
		<th>Find item:</th>
		<td><?= $form->input('Item.name', array('value' => '')); ?></td>
	</tr>
</table>
<table>
	<tr>
		<th width="20%">Item</th>
		<th width="15%">Sell Price</th>
		<th width="25%">Quantity</th>
		<th width="15%">Discount</th>
		<th width="20%">Total Price</th>
		<th width="5%">X</th>
	</tr>
	<? if ($session->check('SoldItem')): ?>
		<? foreach($session->read('SoldItem') as $key => $item): ?>
		<tr class="item">
			<td><?= $item['name']; ?></td>
			<td><?= $number->currency($item['sell_price']); ?></td>
			<? if ($item['serialized']): ?>
			<td>S/N: <input class="serial" name="data[SoldItem][<?= $key; ?>][serial]" type="text" maxlength="32" value="<?= $item['serial']; ?>" /></td>
			<? else: ?>
			<td><input class="quantity" name="data[SoldItem][<?= $key; ?>][quantity]" type="text" maxlength="11" value="<?= $item['quantity']; ?>" /></td>
			<? endif;?>
			<td><input class="discount" name="data[SoldItem][<?= $key; ?>][discount]" type="text" maxlength="8" value="<?= $item['discount']; ?>" /></td>
			<td><?= $number->currency($item['net_price']); ?></td>
			<td>
				<?= $html->link(
					$html->image('icons/actions/delete.png', array('alt' => 'Delete', 'title' => 'Delete')),
					array('action' => 'delete_item', $key),
					array('escape' => false, 'class' => 'delete')
				); ?>
			</td>
		</tr>
		<? endforeach; ?>
	<? else: ?>
	<tr id="no-items-row">
		<td colspan="6">No items added!</td>
	</tr>
	<? endif; ?>
</table>
<table style="width:50%;" align="right">
	<tr>
		<th>Total</th>
		<td><?= $number->currency($session->read('Sale.total')); ?></td>
	</tr>
	<tr>
		<th>Payment</th>
		<td><?= $form->input('Sale.payment', array('class' => 'payment', 'value' => $session->read('Sale.payment'))); ?></td>
	</tr>
	<tr>
		<th>Balance</th>
		<td><?= $number->currency($session->read('Sale.balance')); ?></td>
	</tr>
</table>
<div style="display:none;">
<?= $form->end(''); ?>
</div>
<?= $html->link(
	$html->image('icons/actions/accept.png', array('alt' => 'Finish', 'title' => 'Finish')).' Review Sale',
	array('action' => 'review'),
	array('escape' => false, 'class' => 'finish button')
); ?>
<br /><br />
<?= $html->link(
	$html->image('icons/actions/delete.png', array('alt' => 'Delete', 'title' => 'Delete')).' Cancel Sale',
	array('action' => 'clear'),
	array('escape' => false, 'class' => 'clear button')
); ?>
<script type="text/javascript">
$(function() {
	$("a#add-customer").nyroModal({blocker: "#content",ltr: false,width: 600});
	$("#ItemName").autocomplete({
		source: "<?= $html->url(array('controller' => 'items', 'action' => 'find', 'ext' => 'json')); ?>",
		select: function(event, ui) {
			$('#spinner').show();
			$('#content').css({'opacity': 0.25});
			$.ajax({
				url: "<?= $html->url(array('action' => 'add_item')); ?>/"+ui.item.id,
				success: function(data) {
					$('#content').html(data);
				},
			});
			$('#spinner').hide();
			$('#content').css({'opacity': 1});
		}
	});
	$('form').submit(function (e) {
		e.preventDefault();
		$.ajax({
			type: 'POST',
			url: $(this).attr('action'),
			data: $(this).serialize(),
			beforeSend: function () { $("#content").css({opacity: 0.2}, 500); $('#spinner').show(); },
			success: function (data) { $("#content").html(data); $("#content").css({opacity: 1}, 500); $('#spinner').hide(); }
		});
	});
});
$('.quantity, .serial, .discount, .payment').change(function() {
	$('form').submit();
});
$('.ui-autocomplete-input').live('change', function() {
	$('form').submit();
});
</script>