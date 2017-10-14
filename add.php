<?php
session_start();
//шаблонизатор
include './engine/SeparateTemplate.php';
//include './engine/Formatter/UrlFormatter.php';
$t = SeparateTemplate::instance()->loadSourceFromFile('./tpl/code.htm');
// Подключение к СУБД.
$mysqli = new mysqli();
if (mysqli_connect_errno()) { 
    $w ="Подключение невозможно: " + mysqli_connect_error(); 
    exit();
}
//проверка авторизации
if(isset($_SESSION['id_user'])){
    //данные
    $id_user = $_SESSION['id_user'];
    $login = $_SESSION['login'];
    $key = $_SESSION['key'];
    $name_d=$_POST['name_device'];
    $pl=$_POST['name_device'];
    $tf=$_POST['type_file'];
    $isp=$_POST['isp'];
    $pl=$_POST['name_device'];
    $k_sen = count($_POST['name_sensor']);
    //проверка свободности имени
   $result = $mysqli->query("SELECT * FROM `devices_info` WHERE `name_device` = '$name_d'"); 
    
    if($result->num_rows <> 0) 
    {
       /*  $t = SeparateTemplate::instance()->loadSourceFromFile('./tpl/err.htm');
        $t->assign('Title', 'Вы уже создали устройство с таким  именем');
        $t->assign('Text_mes', '');   */
    }
    else{
        $stmt = $mysqli->prepare("INSERT INTO `devices_info`  ( `pl`, `type_file`, `k_sensors`, `k_isp`, `name_device`)VALUES (?, ?, ?, ?, ?)"); 
        $stmt->bind_param('iiiis', $pl, $tf, $k_sen, $isp, $name_d);
        $stmt->execute(); 
        $id_device = $mysqli->query("SELECT `id_device` FROM `devices_info` WHERE `name_device` = '$name_d'")->fetch_object()->id_device;
       $stmt = $mysqli->prepare("INSERT INTO `devices`  ( `id_user`, `id_device`) VALUES (?, ?)"); 
        $stmt->bind_param('ii', $id_user, $id_device);
        $stmt->execute(); 
               //создание директории файлов для устройства и исполняемого файла
        mkdir("./users/$login/$name_d");
        $text = "//первый скрипт
//все готово, можете начинать программировать";
        $fp = fopen("./users/$login/$name_d/$key.php", "w");
        // записываем в файл текст
        fwrite($fp, $text);
        // закрываем
        fclose($fp); 
        foreach ($_POST['name_sensor'] as $keyi=>$valuei){
            $ArrName[] = $valuei;
            }
        foreach ($_POST['type_sensor'] as $keyi=>$valuei){
            $ArrSen[] = $valuei;
        }
        //отправка в базу информации о датчиках
        for ($i=0; $i<$k_sen; $i++){
            $name_s = $ArrName[$i];
            $type_s = $ArrSen[$i];
           // echo $name_s,' >> ';
           // echo $type_s;
            $stmt = $mysqli->prepare("INSERT INTO `sensors`  ( `id_device`, `name`, `type`)VALUES (?, ?, ?)"); 
            $stmt->bind_param('isi', $id_device, $name_s, $type_s);
            $stmt->execute(); 
           // echo 'q<hr>';
            $array_s[$name_s]=-1;
        }
        //JSON на показатели

       $json_sensors = json_encode($array_s);
        $fp = fopen("./users/$login/$name_d/in.json", "w");
        fwrite($fp, $json_sensors);
        fclose($fp);
        //JSON на вывод
        for ($i=0; $i<$isp; $i++){
            //$j = 'isp'+$i;
            $array_isp[$i] = '0';
        }
       $json_out = json_encode($array_isp);
        $fp = fopen("./users/$login/$name_d/$key.json", "w");
        fwrite($fp, $json_out);
        fclose($fp);
  
         
    }
    
}

    $t->assign('Title', 'Код к ESP');
include('menu.php');
  $t->assign ('Device_name', $name_d );
   $t->assign ('user_id', $id_user );
 $t->assign ('user_key', $key );
$t->display();
?>