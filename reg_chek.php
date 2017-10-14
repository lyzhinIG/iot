<?php
//шаблонизатор
include './engine/SeparateTemplate.php';
include './engine/Formatter/UrlFormatter.php';
// Подключение к СУБД.
$mysqli = new mysqli();
if (mysqli_connect_errno()) { 
    $w ="Подключение невозможно: " + mysqli_connect_error(); 
    exit();
}

$login = $_POST['login'];
$fio = $_POST['fio'];
$password = md5(md5($_POST['password']+'const')+'e3');
$result = $mysqli->query("SELECT * FROM `users` WHERE `login` = '$login'");
$key = base_convert(rand(0,65535),10,16);


if($result->num_rows == 0) 
{
    if ($_POST['password']==$_POST['password2']){
        $t = SeparateTemplate::instance()->loadSourceFromFile('./tpl/success.htm');
        $stmt = $mysqli->prepare("INSERT INTO `users`  ( `login`, `key_u`, `password`)VALUES (?, ?, ?)"); 
        $stmt->bind_param('sss', $login, $key, $password); 
        $stmt->execute(); 
        $id = $mysqli->query("SELECT `id_user` FROM `users` WHERE `login` = '$login'")->fetch_object()->id_user;
        
        $mysqli->query("INSERT INTO `users_info` (`fio`, `id_user`) VALUES('$fio','$id')"); 
        $t->assign('Title', 'Успех');
        $t->assign('Text_mes', $key);   
        
        //создание директории файлов и исполняемого файла
        mkdir("./users/$login");
        /*// строка, которую будем записывать
        $text = "   //первый скрипт
        //все готово, можете начинать программировать";
        // открываем файл, если файл не существует,
        //делается попытка создать его
        $fp = fopen("./users/$login/$key.php", "w");
        // записываем в файл текст
        fwrite($fp, $text);
        // закрываем
        fclose($fp);  */   
        
    }
    else{
        $t = SeparateTemplate::instance()->loadSourceFromFile('./tpl/err.htm');
        $t->assign('Title', 'Пароли не совпадают');
        $t->assign('Text_mes', '');   
    }

}
else{
    $t = SeparateTemplate::instance()->loadSourceFromFile('./tpl/err.htm');
    $t->assign('Title', 'Логин занят');
    $t->assign('Text_mes', '');
    
}
   $t->display(); 
?>