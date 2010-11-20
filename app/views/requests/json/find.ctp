<? if (!empty($result)): ?><? $count = count($result) - 1; ?>
[<? foreach ($result as $row): ?>
{ "id": "<?= $row['Request']['id']; ?>", "value": "<?= $row['Request']['name']; ?>" }<? if ($count != 0): ?>,<? $count--; ?><? endif; ?>
<? endforeach; ?>]<? endif; ?>