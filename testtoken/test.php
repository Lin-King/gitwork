<?php
session_start();
//$lifeTime = 24 * 3600;
$lifeTime = 5;
setcookie(session_name(), session_id(), time() + $lifeTime, "/");

$sessionID = session_id();   
print($sessionID); 
$token = settoken();
echo '</br>';
echo $token;

//下面是生成token方法代码
function settoken()
{
	$token = md5(uniqid(md5(microtime(true)),true));  //生成一个不会重复的字符串
	$token = sha1($token);  //加密
	return $token;
}
?>