<?php
use Workerman\Worker;
use Workerman\Lib\Timer;
require_once __DIR__ . '/Workerman/Autoloader.php';
/*
$ws_worker = new Worker('tcp://192.168.1.70:8989');
$ws_worker->onConnect = function($connection){
	echo $connection->id ."\r\n";
};
// ��������ʱ����һ����ʱ������ʱ�����пͻ������ӷ�������
$ws_worker->onWorkerStart = function($ws_worker){
	// ��ʱ��ÿ10��һ��
	Timer::add(10, function()use($ws_worker){
	// ������ǰ�������еĿͻ������ӣ����͵�ǰ��������ʱ��
		foreach($ws_worker->connections as $connection){
			// ��ͻ��˷���hello $data
			echo "worker->id={$connection->id}\r\n";
			$connection->send(time()." $connection->id ");
		}
	});
};
// ���յ��ͻ��˷��������ݺ󷵻�hello $data���ͻ���
$ws_worker->onMessage = function($connection, $data){
	echo "$connection->id said $data \r\n";
	$connection->send('hello ' . $data .'eof');
};
// ����worker
Worker::runAll();
*/


// ����һ��Worker����2346�˿ڣ�ʹ��websocketЭ��ͨѶ
$ws_worker = new Worker("websocket://192.168.1.70:8989");
//$ws_worker = new Worker("http://192.168.1.70:8989");
// ����4�����̶����ṩ����
$ws_worker->count = 4;
// ��������ʱ����һ����ʱ������ʱ�����пͻ������ӷ�������
$ws_worker->onWorkerStart = function($ws_worker){
	// ��ʱ��ÿ10��һ��
	Timer::add(5, function()use($ws_worker){
	// ������ǰ�������еĿͻ������ӣ����͵�ǰ��������ʱ��
		foreach($ws_worker->connections as $connection){
			// ��ͻ��˷���hello $data
			echo "worker->id={$connection->id}\r\n";
			$connection->send(time()." $connection->id ");
		}
	});
};
// ���յ��ͻ��˷��������ݺ󷵻�hello $data���ͻ���
$ws_worker->onMessage = function($connection, $data){
	echo "$connection->id said $data \r\n";
	$connection->send('hello ' . $data);
};
// ����worker
Worker::runAll();
