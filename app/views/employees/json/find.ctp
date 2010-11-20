<? if (!empty($result)): ?><? $count = count($result) - 1; ?>
[<? foreach ($result as $row): ?>
{ "id": "<?= $row['Employee']['id']; ?>", "value": "<?= $row['Employee']['name']; ?>" }<? if ($count != 0): ?>,<? $count--; ?><? endif; ?>
<? endforeach; ?>]<? endif; ?>