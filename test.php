<?php

//шаблонизатор
include './engine/SeparateTemplate.php';
//include './engine/Formatter/UrlFormatter.php';
$t = SeparateTemplate::instance()->loadSourceFromFile('./tpl/test.htm');
$t->display();
?>