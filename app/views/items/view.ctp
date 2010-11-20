<table>
	<tr>
		<th>Name</th>
		<td><?= $item['Item']['name']; ?></td>
		<th>Barcode</th>
		<td><?= $item['Item']['barcode']; ?></td>
	</tr>
	<tr>
		<th>Description</th>
		<td colspan="2"><?= $item['Item']['desc']; ?></td>
		<th><?= ($item['Item']['serialized']) ? 'Serialized' : ''; ?></th>
	</tr>
	<tr>
		<th>Category</th>
		<td><?= ($item['Category']['name']) ? $item['Category']['name'] : ''; ?></td>
		<th>Supplier</th>
		<td><?= ($item['Supplier']['name']) ? $item['Supplier']['name'] : ''; ?></td>
	</tr>
	<tr>
		<th>Cost Price</th>
		<td><?= $number->currency($this->data['Item']['cost_price']); ?></td>
		<th>Sell Price</th>
		<td><?= $number->currency($item['Item']['sell_price']); ?></td>
	</tr>
	<tr>
		<th>Stock</th>
		<td><?= $item['Item']['stock']; ?></td>
		<th>Reorder Level</th>
		<td><?= $item['Item']['reorder_level']; ?></td>
	</tr>
</table>
<table>
	<tr>
		<th>Stock</th>
		<th>Change</th>
		<th>New Stock</th>
		<th>Reason</th>
		<th>Employee</th>
		<th>Time</th>
	</tr>
	<? foreach ($item_tracks as $item_track): ?>
	<tr>
	<td><?= $item_track['ItemTrack']['stock'] - $item_track['ItemTrack']['change']; ?></td>
		<td><?= (!empty($item_track['ItemTrack']['change'])) ? $item_track['ItemTrack']['change'] : 0; ?></td>
		<td><?= (!empty($item_track['ItemTrack']['stock'])) ? $item_track['ItemTrack']['stock'] : 0; ?></td>
		<td><?= $item_track['ItemTrack']['reason']; ?></td>
		<td><?= ($item_track['Employee']['name']) ? $item_track['Employee']['name'] : ''; ?></td>
		<td><?= strftime('%a, %b %e %Y at %I:%M %p', strtotime($item_track['ItemTrack']['created'])); ?></td>
	</tr>
	<? endforeach; ?>
</table>