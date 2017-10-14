<?php
include './engine/SeparateTemplate.php';
$x = SeparateTemplate::instance()->loadSourceFromFile('./tpl/sensors.htm');
$login = $_GET['l'];
$name = $_GET['d'];
$array_sensors=json_decode(file_get_contents("./users/$login/$name/in.json"), TRUE);
    foreach ($array_sensors as $keys => $vals) {
        //fetch column block from row block
        $columnBlock = $x->fetch('TableDevice');
        $columnBlock->assign('Sensor',  $vals);
        $columnBlock->assign('Sensor_name', $keys);
        $x->assign('TableDevice', $columnBlock);
    }

$x->display();
?>