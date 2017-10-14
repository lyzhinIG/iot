<?php
session_start();
include './engine/SeparateTemplate.php';
include './engine/Formatter/UrlFormatter.php';

if(isset($_SESSION['id_user'])){
$t = SeparateTemplate::instance()->loadSourceFromFile('./tpl/add_device.htm');

    $t->assign('Title', 'Добавление устройства');
    $t->assign('Add_action', './add.php');
    include('menu.php');
}
    $t->display();
?>