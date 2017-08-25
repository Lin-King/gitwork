<?php
header ( "Content-type: text/html; charset=UTF-8" ); 						//设置文件编码格式

require_once('./db.php');
require_once('./response.php');
require_once('./TokenUilt.class.php');

$username = isset($_POST['username']) ? $_POST['username'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';

if(!$username || !$password){
	return Response::show(403, '账号或密码不能有空');
}
if(strpos($username," ")!==false || strpos($password," ")!==false){
	return Response::show(403, '账号或密码不能空格');
}

try {
	$connect = Db::getInstance()->connect();
} catch(Exception $e) {
	// $e->getMessage();
	return Response::show(403, '数据库链接失败');
}

$sql = "select * from user where user_id = '$username' and user_pass='$password'";
$result = mysql_query($sql,$connect); 
if(mysql_num_rows($result) == 0){
	return Response::show(403, '账号或密码错误！');
}else{
	session_start();
	$sessionID = session_id(); 
	$lifeTime = 30*24*60*60;
	setcookie(session_name(), session_id(), time() + $lifeTime, "/");  
	$update = "UPDATE user SET user_session='$sessionID' WHERE user_id ='$username'";
	mysql_query($update,$connect);
	$result = mysql_query($sql,$connect); 
	$user = mysql_fetch_assoc($result);
	return Response::show(200, '登录成功！',$user);
	
/*
	if($user_session == $sessionID || $user_session==''){
		$update = "UPDATE user SET user_session='$sessionID' WHERE user_id ='$username'";
		mysql_query($update,$connect);
		return Response::show(200, '登录成功！',$user);
	}
	if($user_session != $sessionID){
		return Response::show(403, '重复登录！');
	}
*/
}
?>