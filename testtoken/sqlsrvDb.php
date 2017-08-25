<?php
class SqlsrvDb{
	//private $host = '127.0.0.1';  
	private $host = '192.168.1.18,5555';  
	//private $host = 'localhost:3306';  
	private $user = 'root';           
	private $password = '';          
	private $database = 'test';         
	
	static private $_instance;
	static private $_connectSource;
	
	private $conninfo=array( "Database"=>"XJMIS", "UID"=>"sa", "PWD"=>"xjyd_2015");

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
			self::$_connectSource = sqlsrv_connect($this->host, $this->conninfo);	
			
			if(!self::$_connectSource) {
				throw new Exception('sqlsrv connect error ' . sqlsrv_errors());
				//die('sqlsrv connect error' . sqlsrv_errors());
			}
			
			//sqlsrv_query("set names UTF8", self::$_connectSource);
		}
		return self::$_connectSource;
	}
	
	// $fContents 字符串
	// $from 字符串的编码
	// $to 要转换的编码
	public function auto_charset($fContents,$from='gbk',$to='utf-8'){
		$from   =  strtoupper($from)=='UTF8'? 'utf-8':$from;
		$to       =  strtoupper($to)=='UTF8'? 'utf-8':$to;
		if( strtoupper($from) === strtoupper($to) || empty($fContents) || (is_scalar($fContents) && !is_string($fContents)) ){
			//如果编码相同或者非字符串标量则不转换
			return $fContents;
		}
		if(is_string($fContents) ) {
			if(function_exists('mb_convert_encoding')){
				return mb_convert_encoding ($fContents, $to, $from);
			}else{
				return $fContents;
			}
		}
		elseif(is_array($fContents)){
			foreach ( $fContents as $key => $val ) {
				$_key = self::auto_charset($key,$from,$to);
				$fContents[$_key] = self::auto_charset($val,$from,$to);
				if($key != $_key )
					unset($fContents[$key]);
			}
			return $fContents;
		}
		else{
			return $fContents;
		}
	}
}
/*
try {
	$conn = SqlsrvDb::getInstance()->connect();
	if($conn) {
		$sql="select * from t120Emergency";
		$db=sqlsrv_query($conn, $sql);
		//$stmt = sqlsrv_query($conn, $sql, null);  
		$arrays = array();
		while($row=sqlsrv_fetch_object($db)){
			//eval('return '.iconv("GBK//IGNORE", "UTF-8", var_export($row,true)).';');		
			$arrays[]=(array)$row;
		}
		$s = SqlsrvDb::getInstance()->auto_charset($arrays,'gbk','utf-8');
		//打印试试，在浏览器设置编码为UFT-8，看没有乱码
		//print_r($s);die();
		return Response::show(200, '数据获取成功', $s);
		//echo json_encode($s);
		//var_dump($s);
		
	}else{
		return Response::show(400, '数据库连接失败', $s);
	}
} catch(Exception $e) {
	// $e->getMessage();
	return Response::show(403, '数据库链接失败');
}
*/


?>