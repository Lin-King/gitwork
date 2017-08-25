<?php
use \GatewayWorker\Gateway;
require_once './Workerman/Autoloader.php';

// 指定websocket协议
$gateway = new Gateway("websocket://0.0.0.0:8585");