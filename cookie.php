<?php


header("Access-Control-Allow-Headers: *");
$a = $_SERVER['HTTP_ORIGIN'];
header("Access-Control-Allow-Origin: $a");
header("Access-Control-Allow-Credentials: true");
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');

setCookie("test",json_encode(["admin"=>"gateau"]), time() + (86400));
var_dump($_SERVER);
 
//header('Location: http://www.localhost:5500/front/index.html');

?>