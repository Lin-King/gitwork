<?php
session_start();
//$lifeTime = 24 * 3600;
//$lifeTime = 5;
//setcookie(session_name(), session_id(), time() + $lifeTime, "/");

$sessionName = session_name();   //取得当前 Session 名，默认为 PHPSESSID
//$sessionID = $_GET[$sessionName];   //取得 Session ID
$sessionID = session_id();   
//session_id($sessionID);      //使用 session_id() 设置获得的 Session ID
print($sessionID); 
?>