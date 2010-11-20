<?= $form->create('Order', array('inputDefaults' => array('label' => false, 'div' => false))); ?>
<table>
	<tr>
		<th>Supplier:</th>
		<td><?= $form->input('Order.supplier_id', array('class' => 'combobox', 'options' => $suppliers, 'value' => $session->read('Order.supplier_id'))); ?></td>
	</tr>
	<tr>
		<th>Invoice #:</th>
		<td><?= $form->input('Order.invoice_no', array('class' => 'invoice_no', 'value' => $session->read('Order.invoice_no'))); ?></td>
	</tr>
</table>
<table>
	<tr>
		<th>Find item:</th>
		<td><?= $form->input('Item.name'); ?></td>
	</tr>
</table>
<table>
	<tr>
		<th width="25%">Item</th>
		<th width="25%">Cost Price</th>
		<th width="25%">Quantity</th>
		<th width="20%">Total Price</th>
		<th width="5%">X</th>
	</tr>
	<? if ($session->check('OrderedItem')): ?>
		<? foreach($session->read('OrderedItem') as $key => $item): ?>
		<tr class="item<?= ($item['no_supply']) ? ' warning' : ''; ?>">
			<td><?= $item['name']; ?></td>
			<td><input class="cost_price" name="data[OrderedItem][<?= $key; ?>][cost_price]" type="text" maxlength="8" value="<?= $item['cost_price']; ?>" /></td>
			<td><input class="quantity" name="data[OrderedItem][<?= $key; ?>][quantity]" type="text" maxlength="11" value="<?= $item['quantity']; ?>" /></td>
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
		<td colspan="5">No items added!</td>
	</tr>
	<? endif; ?>
</table>
<table style="width:50%;" align="right">
	<tr>
		<th>Total</th>
		<td><?= $number->currency($session->read('Order.total')); ?></td>
	</tr>
	<tr>
		<th>Discount</th>
		<td><?= $form->input('Order.discount', array('class' => 'discount', 'value' => $session->read('Order.discount'))); ?></td>
	</tr>
	<tr>
		<th>Payment</th>
		<td><?= $form->input('Order.payment', array('class' => 'payment', 'value' => $session->read('Order.payment'))); ?></td>
	</tr>
	<tr>
		<th>Balance</th>
		<td><?= $number->currency($session->read('Order.balance')); ?></td>
	</tr>
</table>
<div style="display:none;">
<?= $form->end(''); ?>
</div>
<?= $html->link(
	$html->image('icons/actions/accept.png', array('alt' => 'Finish', 'title' => 'Finish')).' Review Order',
	array('action' => 'review'),
	array('escape' => false, 'class' => 'finish button')
); ?>
<br /><br />
<?= $html->link(
	$html->image('icons/actions/delete.png', array('alt' => 'Delete', 'title' => 'Delete')).' Cancel Order',
	array('action' => 'clear'),
	array('escape' => false, 'class' => 'clear button')
); ?>
<script type="text/javascript">
$(function() {
	$("#ItemName").autocomplete({
		source: "<?= $html->url(array('controller' => 'items', 'action' => 'find', 'ext' => 'json')); ?>",
		select: function(event, ui) {
			$.ajax({
				url: "<?= $html->url(array('action' => 'add_item')); ?>/"+ui.item.id,
				success: function(data) { $('#content').html(data); }
			});
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
	$('.quantity, .cost_price, .discount, .payment, .invoice_no, .supplier_id, .combobox').live('change', function() {
		$('form').submit();
	});
});
</script>