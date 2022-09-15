<?php
  include __DIR__."/authGuard/encrypt.php";
  include __DIR__."/authGuard/decrypt.php";

$s = "Hello world";
echo  $s." ".encrypt($s)." ".decrypt(encrypt($s));
echo "<pre>";
var_dump($_SERVER["REMOTE_ADDR"]);
echo "</pre>";
?>