<?php
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

$token =  TokenUilt::settoken();

try {
	$connect = Db::getInstance()->connect();
} catch(Exception $e) {
	// $e->getMessage();
	return Response::show(403, '数据库链接失败');
}

$sql = "select * from user where user_id = '".$username."'";
//$result = mysql_query($sql, $connect); 
$result = mysql_query($sql,$connect); 

if(mysql_num_rows($result) != 0){
	return Response::show(200, '账号已存在！');
}else{
	$ins = "INSERT INTO user (user_id, user_pass, user_token) VALUES ('$username', '$password', '$token')";
	//echo $ins;
	$res = mysql_query($ins,$connect); 
	if($res){
		return Response::show(200, '账号创建成功！');
	}else{
		return Response::show(403, '账号创建失败！');
	}
}

/*if($result!=null){
	$videos = array();
	while($video = mysql_fetch_assoc($result)) {
		$videos[] = $video;
		//echo $video["user_id"]."</br>";
	}
	//echo json_encode($videos,JSON_UNESCAPED_UNICODE);
	return Response::show(200, '数据获取成功', $videos);
}*/
?>