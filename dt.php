<?php
// Подключение к СУБД.
$mysqli = new mysqli();
if (mysqli_connect_errno()) { 
    $w ="Подключение невозможно: " + mysqli_connect_error(); 
    exit();
}
$key = $_GET['key'];
$id = $_GET['id'];
$name = $_GET['d'];
$key_db = $mysqli->query("SELECT `key_u` FROM `users` WHERE `id_user` = '$id'")->fetch_object()->key_u;
$login = $mysqli->query("SELECT `login` FROM `users` WHERE `id_user` = '$id'")->fetch_object()->login;
if( $key == $key_db){
    $id_d = $mysqli->query("SELECT `id_device` FROM `devices_info` WHERE `name_device` = '$name'")->fetch_object()->id_device;
    $isp = $mysqli->query("SELECT `k_isp` FROM `devices_info` WHERE `id_device` = '$id_d'")->fetch_object()->k_isp;
    $k_sen = $mysqli->query("SELECT `k_sensors` FROM `devices_info` WHERE `id_device` = '$id_d'")->fetch_object()->k_sensors;
    $result = $mysqli->query("SELECT * FROM `sensors` WHERE `id_device` = '$id_d'");
    
    //переписываем показания датчиков
    while($obj = $result->fetch_object()) {
    $array_sensor[$obj->name] = $_GET[$obj->name];  
    }
    /*foreach ($array_sensor as $keys => $vals) {
        echo $keys,'---]',$vals,"<br>";
    }*/
    $json_sensors = json_encode($array_sensor);
    $fp = fopen("./users/$login/$name/in.json", "w");
    fwrite($fp, $json_sensors);
    fclose($fp);
    
    //дергаем скрипт
    // инициализация сеанса
    $ch = curl_init();
 $command = "http://iot.eduwork.cf/users/$login/$name/$key.php";
    // установка URL и других необходимых параметров
    curl_setopt($ch, CURLOPT_URL, $command);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 0);
    // загрузка страницы и выдача её браузеру
    curl_exec($ch);
    // завершение сеанса и освобождение ресурсов
    curl_close($ch);
    //system($command);
    //выводим указания плате
    $array_out=json_decode(file_get_contents("./users/$login/$name/$key.json"), TRUE);
    for($i=0; $i<$isp; $i++){
        echo $array_out[$i];
        if($i<$isp-1) echo ":";
    }
    
}
?>