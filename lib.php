<?php
$site="http://iot.eduwork.cf";
function readSen($login, $name, $name_sen){
global $site;
$array_sensors=json_decode(file_get_contents("$site/users/$login/$name/in.json"), TRUE);
    foreach ($array_sensors as $keys => $vals) {
       if ($keys==$name_sen) { value=$vals}
    }
    return value;
}
function writeDev ($login, $key, $name, $numb, $flag){
    global $site;
    $array_out=json_decode(file_get_contents("$login/$name/$key.json"), TRUE);
    if(count($array_out)<$numb) {return 3;}
    if (!(file_exists("$site/users/$login/$name"))){return 2;}
    if (!(file_exists("$site/users/$login/$name/$key.json"))){return 1;}
    for($i=0; $i<$isp; $i++){
        if(($i+1)==$numb) $array_out[$i]=$flag;
    }    
    $json_out = json_encode($array_out);
    $fp = fopen("$site/users/$login/$name/$key.json", "w");
    fwrite($fp, $json_out);
    fclose($fp);
    return 0;
}
function writeDevArray ($login, $key, $name, $arr){
    global $site;
    $array_out=json_decode(file_get_contents("$site/users/$login/$name/$key.json"), TRUE);
    if(count($array_out)<>count($arr)) {return 3;}  
    if (!(file_exists("$site/users/$login/$name"))){return 2;}
    if (!(file_exists("$site/users/$login/$name/$key.json"))){return 1;}
    $json_out = json_encode($arr);
    $fp = fopen("$site/users/$login/$name/$key.json", "w");
    fwrite($fp, $json_out);
    fclose($fp);
    return 0;
}

?>