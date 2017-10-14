<?php
session_start();
include './engine/SeparateTemplate.php';


if(isset($_SESSION['id_user'])){
    $name_device= $_GET['d'];
    $login = $_SESSION['login'];
   $key_u = $_SESSION['key'];
 $t = SeparateTemplate::instance()->loadSourceFromFile('./tpl/editor.htm');
    $t->assign('Title', 'Редактор');
include('menu.php');
    
    
  $t->assign ('Device_name', $name_device );
    $code  = file_get_contents("./users/$login/$name_device/$key_u.php");
  $t->assign('Code', $code);
    //echo $code;
    $t->assign ('Editor_action', './edit_code.php');
}
   $t->display();
?>