<?php
use Workerman\Worker;
use Workerman\Lib\Timer;
require_once __DIR__ . '/Workerman/Autoloader.php';
/*
$ws_worker = new Worker('tcp://192.168.1.70:8989');
$ws_worker->onConnect = function($connection){
	echo $connection->id ."\r\n";
};
// 进程启动时设置一个定时器，定时向所有客户端连接发送数据
$ws_worker->onWorkerStart = function($ws_worker){
	// 定时，每10秒一次
	Timer::add(10, function()use($ws_worker){
	// 遍历当前进程所有的客户端连接，发送当前服务器的时间
		foreach($ws_worker->connections as $connection){
			// 向客户端发送hello $data
			echo "worker->id={$connection->id}\r\n";
			$connection->send(time()." $connection->id ");
		}
	});
};
// 当收到客户端发来的数据后返回hello $data给客户端
$ws_worker->onMessage = function($connection, $data){
	echo "$connection->id said $data \r\n";
	$connection->send('hello ' . $data .'eof');
};
// 运行worker
Worker::runAll();
*/


// 创建一个Worker监听2346端口，使用websocket协议通讯
$ws_worker = new Worker("websocket://192.168.1.70:8989");
//$ws_worker = new Worker("http://192.168.1.70:8989");
// 启动4个进程对外提供服务
$ws_worker->count = 4;
// 进程启动时设置一个定时器，定时向所有客户端连接发送数据
$ws_worker->onWorkerStart = function($ws_worker){
	// 定时，每10秒一次
	Timer::add(5, function()use($ws_worker){
	// 遍历当前进程所有的客户端连接，发送当前服务器的时间
		foreach($ws_worker->connections as $connection){
			// 向客户端发送hello $data
			echo "worker->id={$connection->id}\r\n";
			$connection->send(time()." $connection->id ");
		}
	});
};
// 当收到客户端发来的数据后返回hello $data给客户端
$ws_worker->onMessage = function($connection, $data){
	echo "$connection->id said $data \r\n";
	$connection->send('hello ' . $data);
};
// 运行worker
Worker::runAll();
