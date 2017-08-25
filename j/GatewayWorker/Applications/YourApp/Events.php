<?php
/**
 * This file is part of workerman.
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the MIT-LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @author walkor<walkor@workerman.net>
 * @copyright walkor<walkor@workerman.net>
 * @link http://www.workerman.net/
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 */

/**
 * ���ڼ��ҵ�������ѭ�����߳�ʱ������������
 * �������ҵ���������Խ�����declare�򿪣�ȥ��//ע�ͣ�����ִ��php start.php reload
 * Ȼ��۲�һ��ʱ��workerman.log���Ƿ���process_timeout�쳣
 */
//declare(ticks=1);

use \GatewayWorker\Lib\Gateway;

/**
 * ���߼�
 * ��Ҫ�Ǵ��� onConnect onMessage onClose ��������
 * onConnect �� onClose �������Ҫ���Բ���ʵ�ֲ�ɾ��
 */
class Events
{
	
    public static function onWorkerStart($businessWorker)
    {
       echo "WorkerStart\n";
    }
	
    public static function onWorkerStop($businessWorker)
    {
       echo "WorkerStop\n";
    }
	
    /**
     * ���ͻ�������ʱ����
     * ���ҵ����˻ص�����ɾ��onConnect
     * 
     * @param int $client_id ����id
     */
    public static function onConnect($client_id)
    {
        // ��ǰclient_id�������� 
        Gateway::sendToClient($client_id, "Hello $client_id\r\n");
        // �������˷���
        Gateway::sendToAll("$client_id login\r\n");
    }
    
   /**
    * ���ͻ��˷�����Ϣʱ����
    * @param int $client_id ����id
    * @param mixed $message ������Ϣ
    */
   public static function onMessage($client_id, $message)
   {
        // �������˷��� 
        Gateway::sendToAll("$client_id said $message\r\n");
   }
   
   /**
    * ���û��Ͽ�����ʱ����
    * @param int $client_id ����id
    */
   public static function onClose($client_id)
   {
       // �������˷��� 
       GateWay::sendToAll("$client_id logout\r\n");
   }
}
