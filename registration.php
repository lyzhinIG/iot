<?php
include './engine/SeparateTemplate.php';
include './engine/Formatter/UrlFormatter.php';
$t = SeparateTemplate::instance()->loadSourceFromFile('./tpl/register.htm');

    $t->assign('Title', 'Регистрация');
   $t->assign('Regisrtation_action', '/reg_chek.php');
    $t->display();
?>