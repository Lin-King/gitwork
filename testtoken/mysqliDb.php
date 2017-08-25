<?php

class MysqliDb {
	private $host = '127.0.0.1';  // mysql服务器主机地址
	//private $host = 'localhost:3306';  // mysql服务器主机地址
	private $user = 'root';            // mysql用户名
	private $password = '';          // mysql用户名密码
	private $database = 'test';          // mysql用户名密码
	
	static private $_instance;
	static private $_connectSource;

	private function __construct() {
	}

	static public function getInstance() {
		if(!(self::$_instance instanceof self)) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	public function connect() {
		if(!self::$_connectSource) {
			self::$_connectSource = mysqli_connect($this->host, $this->user, $this->password);	

			if(!self::$_connectSource) {
				throw new Exception('mysql connect error ' . mysqli_connect_error());
				//die('mysql connect error' . mysql_error());
				//die("连接失败: " . $conn->connect_error);
			}
			
			mysqli_select_db(self::$_connectSource,$this->database);
			mysqli_query(self::$_connectSource,"set names UTF8");
		}
		return self::$_connectSource;
	}
	
}
/*
$connect = MysqliDb::getInstance()->connect();

$sql = "select * from user";
$result = mysqli_query($connect,$sql);
echo mysqli_num_rows($result);
var_dump($result);
while($video = mysqli_fetch_assoc($result)) {
	$videos[] = $video;
	var_dump($video);
}
*/