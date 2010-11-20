<?= $html->link(
	'Low Item Stock',
	array('action' => 'low_stock'),
	array('class' => 'button')
); ?>
<?= $html->link(
	'Low Item Stock',
	array('action' => 'low_stock'),
	array('class' => 'button')
); ?>

<?php
    echo $flashChart->begin();    
    $flashChart->setTitle('Steppometer','{color:#880a88;font-size:35px;padding-bottom:20px;}');
    $flashChart->setData($data, '{n}.Day.count', 'Default.{n}.Day.date' );
    $flashChart->setLegend('x','Date');
    $flashChart->setLegend('y','Steps', '{color:#AA0aFF;font-size:40px;}' );
    $flashChart->axis('x',array('tick_height' => 10,'3d' => -10));
    $flashChart->axis('y',array('range' => array(0,10000,1000)));
    echo $flashChart->pie();
    echo $flashChart->render(500,500);
?>