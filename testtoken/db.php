<?php

class Db {
	private $host = '127.0.0.1';  // mysql服务器主机地址
	//private $host = 'localhost:3306';  // mysql服务器主机地址
	private $user = 'root';            // mysql用户名
	private $password = '';          // mysql用户名密码
	private $database = 'test';          // mysql用户名密码
	
	static private $_instance;
	static private $_connectSource;
	/*private $_dbConfig = array(
		'host' => '127.0.0.1',
		'user' => 'root',
		'password' => '',
		'database' => 'test',
	);*/

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
			self::$_connectSource = @mysql_connect($this->host, $this->user, $this->password);	

			if(!self::$_connectSource) {
				throw new Exception('mysql connect error ' . mysql_error());
				//die('mysql connect error' . mysql_error());
			}
			
			mysql_select_db($this->database, self::$_connectSource);
			mysql_query("set names UTF8", self::$_connectSource);
		}
		return self::$_connectSource;
	}
	
}
/*$connect = Db::getInstance()->connect();

$sql = "select * from video";
$result = mysql_query($sql, $connect);
echo mysql_num_rows($result);
var_dump($result);*/