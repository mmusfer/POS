<? if (!empty($result)): ?><? $count = count($result) - 1; ?>
[<? foreach ($result as $row): ?>
{ "id": "<?= $row['Category']['id']; ?>", "value": "<?= $row['Category']['name']; ?>" }<? if ($count != 0): ?>,<? $count--; ?><? endif; ?>
<? endforeach; ?>]<? endif; ?>