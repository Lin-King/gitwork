<?php 
use Workerman\Worker;
require_once __DIR__ . '/Workerman/Autoloader.php';

// ����һ��Worker����2346�˿ڣ�ʹ��websocketЭ��ͨѶ
$ws_worker = new Worker("websocket://127.0.0.1:8899");

// ����4�����̶����ṩ����
$ws_worker->count = 4;

// ���յ��ͻ��˷��������ݺ󷵻�hello $data���ͻ���
$ws_worker->onMessage = function($connection, $data)
{
    // ��ͻ��˷���hello $data
    $connection->send('hello ' . $data);
};

// ����worker
Worker::runAll();
?>  