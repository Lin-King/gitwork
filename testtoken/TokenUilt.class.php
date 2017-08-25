<?php
Class TokenUilt{
	//下面是生成token方法代码
	public static function settoken()
	{
		$token = md5(uniqid(md5(microtime(true)),true));  //生成一个不会重复的字符串
		$token = sha1($token);  //加密
		return $token;
	}
}