<?php
include './engine/SeparateTemplate.php';
include './engine/Formatter/UrlFormatter.php';
$t = SeparateTemplate::instance()->loadSourceFromFile('./tpl/lk.htm');



for($column = 1; $column <= 3; $column++)
    {
        //fetch column block from row block
        $columnBlock = $t->fetch('TableDevice');
        $row = $column+2;
        $columnBlock->assign('ID', $row);
        $columnBlock->assign('Name', $column);
        $columnBlock->assign('Panel_sensor', 'ru.separatssse'+$row);
        $columnBlock->assign('Editor', 'ru.separate');
        //assign modified column block back to row block
        $t->assign('TableDevice', $columnBlock);
    }

    $t->assign('Username', 'Ivanov Иван');
   $t->assign('Book', 'https://mail.yandex.ru/');
$t->display();

echo "тест";
?>
echo '<a href="./editor.php?d='$d_name'" > Вернутся к редактированию </a>';