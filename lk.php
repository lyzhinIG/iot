<?php
session_start();
include './engine/SeparateTemplate.php';
include './engine/Formatter/UrlFormatter.php';
$mysqli = new mysqli();
if (mysqli_connect_errno()) { 
    $w ="Подключение невозможно: " + mysqli_connect_error(); 
    exit();
}
$log = $_POST['login'];
$pass = $mysqli->query("SELECT `password` FROM `users` WHERE `login` = '$log'")->fetch_object()->password;
if(($pass <> md5(md5($_POST['password']+'const')+'e3')) and !(isset($_SESSION['id_user']))) {
        $t = SeparateTemplate::instance()->loadSourceFromFile('./tpl/err.htm');
        $t->assign('Title', 'Неверный логин или пароль');
        $t->assign('Text_mes', '120x');   
} else{
    if (!(isset($_SESSION['id_user']))){
        $login = $_POST['login'];
        $_SESSION['id_user'] = $mysqli->query("SELECT `id_user` FROM `users` WHERE `login` = '$login'")->fetch_object()->id_user;
        $id_user =  $_SESSION['id_user'];
        $_SESSION['key'] = $mysqli->query("SELECT `key_u` FROM `users` WHERE `id_user` = ' $id_user'")->fetch_object()->key_u;
        $_SESSION['login'] = $login; 
    }
    $t = SeparateTemplate::instance()->loadSourceFromFile('./tpl/lk.htm');
    $login = $_SESSION['login'];
    $t->assign('Title', 'Личный кабинет');
    include ('menu.php');
    $t->assign('key_u', $_SESSION['key']);
    
    $id_user =  $mysqli->query("SELECT `id_user` FROM `users` WHERE `login` = '$login'")->fetch_object()->id_user;
    //MySqli Select Query
$results = $mysqli->query("SELECT `id_device` FROM `devices` WHERE `id_user` = '$id_user'");
    $i=1;
while($row = $results->fetch_object()) {
    $D_res = $mysqli->query("SELECT * FROM `devices_info` WHERE `id_device` = '$row->id_device'");
    while($D = $D_res->fetch_object()){
        $D_id[$i] = $D->id_device;
        $D_name[$i] = $D->name_device;
        $D_ksen[$i] =$D->k_sensors;
        $D_isp[$i] = $D->k_isp;
        $i++;
    }   
}
    
    for($c = 1; $c < $i; $c++)
    {
        //fetch column block from row block
        $columnBlock = $t->fetch('TableDevice');
        $columnBlock->assign('ID',  $D_id[$c]);
        $columnBlock->assign('Name', $D_name[$c]);
        $columnBlock->assign('Sensors', $D_ksen[$c]);
        $columnBlock->assign('Isp', $D_isp[$c]);
        $columnBlock->assign('Editor', "editor.php?d=$D_name[$c]");
        $columnBlock->assign('Panel_sensor', "./panel.php?d=$D_name[$c]");
        //assign modified column block back to row block
        $t->assign('TableDevice', $columnBlock);
    }

}


    $t->display();
?>