import java.io.IOException;
import java.io.InputStreamReader;
import java.io.OutputStreamWriter;
import java.io.Reader;
import java.io.Writer;
import java.net.ServerSocket;
import java.net.Socket;
import java.io.BufferedReader;

public class Server {
 
   public static void main(String args[]) throws IOException {
      //Ϊ�˼���������е��쳣��Ϣ��������
     int port = 8899;
      //����һ��ServerSocket�����ڶ˿�8899��
     ServerSocket server = new ServerSocket(port);
      while (true) {
         //server���Խ�������Socket����������server��accept����������ʽ��
         Socket socket = server.accept();
         //ÿ���յ�һ��Socket�ͽ���һ���µ��߳���������
         new Thread(new Task(socket)).start();
      }
   }
   
   /**
    * ��������Socket�����
   */
   static class Task implements Runnable {
 
      private Socket socket;
      
      public Task(Socket socket) {
         this.socket = socket;
      }
      
      public void run() {
         try {
            handleSocket();
         } catch (Exception e) {
            e.printStackTrace();
         }
      }
      
      /**
       * ���ͻ���Socket����ͨ��
      * @throws Exception
       */
      private void handleSocket() throws Exception {
         BufferedReader br = new BufferedReader(new InputStreamReader(socket.getInputStream()));
         StringBuilder sb = new StringBuilder();
         String temp;
         int index;
         while ((temp=br.readLine()) != null) {
            System.out.println(temp);
            if ((index = temp.indexOf("eof")) != -1) {//����eofʱ�ͽ�������
             sb.append(temp.substring(0, index));
                break;
            }
            sb.append(temp);
         }
         System.out.println("from client: " + sb);
         //�����дһ��
       Writer writer = new OutputStreamWriter(socket.getOutputStream());
         writer.write("Hello Client.");
         writer.write("eof\n");
         writer.flush();
         writer.close();
         br.close();
         socket.close();
      }
   }
}




