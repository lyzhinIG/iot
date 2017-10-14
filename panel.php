<?php
session_start();
include './engine/SeparateTemplate.php';
include './engine/Formatter/UrlFormatter.php';

if(isset($_SESSION['id_user'])){
    $name_device= $_GET['d'];
    $login = $_SESSION['login'];
    
    $t = SeparateTemplate::instance()->loadSourceFromFile('./tpl/panel.htm');
    $t->assign('Title', 'Показания датчиков');
    include('menu.php');
    $t->assign ('Device_name', $name_device );
    $Ajax_action = "./display_sensors.php?l=$login&d=$name_device";
    $t->assign ('Ajax_action', $Ajax_action);
    //$t->assign ('Ajax_action', "./display_sensors.php?l=$login&d=$name_device");
    //$t->assign ('Device_name', $name_device );*/
}
    $t->display();
?>