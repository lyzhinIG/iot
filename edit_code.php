<?php
//шаблонизатор
// Подключение к СУБД.
session_start();
$d_name = $_POST['Device_name'];
$code = $_POST['code'];
$login = $_SESSION['login'];
$key = $_SESSION['key'];
 $fp = fopen("./users/$login/$d_name/$key.php", "w");
        // записываем в файл текст
        fwrite($fp, $code);
        // закрываем
        fclose($fp);
echo '<head>
  <meta charset="utf-8">
  </head>';
echo '<a href="./editor.php?d=';
echo $d_name;
echo '" > Вернутся к редактированию </a>';
?>