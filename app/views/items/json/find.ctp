[<? if (!empty($result)): ?><? $count = count($result) - 1; ?><? foreach ($result as $row): ?>
{ "id": "<?= $row['Item']['id']; ?>", "value": "<?= $row['Item']['name']; ?>" }<? if ($count != 0): ?>,<? $count--; ?><? endif; ?>
<? endforeach; ?><? endif; ?>]