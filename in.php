<?php
include './engine/SeparateTemplate.php';
include './engine/Formatter/UrlFormatter.php';
$t = SeparateTemplate::instance()->loadSourceFromFile('./tpl/login.htm');

    $t->assign('Title', 'Вход');
    $t->assign('Lk_action', './lk.php');
    $t->assign('Regisrtation', './registration.php');
    $t->assign('Index_promo', './index.php');
    $t->display();
?>