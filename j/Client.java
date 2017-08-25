import java.io.BufferedReader;
import java.io.DataInputStream;
import java.io.DataOutputStream;
import java.io.IOException;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.io.OutputStream;
import java.io.PrintWriter;
import java.net.Socket;
import java.util.Scanner;

public class Client {
	public static final String IP_ADDR = "192.168.1.70";//��������ַ   
    public static final int PORT = 8899;//�������˿ں�    
      
    public static void main(String[] args) {    
        
		new Thread(new Runnable() {
            @Override
            public void run() {
                try {
                    Socket socket = new Socket(IP_ADDR, PORT);
                   // 2����ȡ���������������˷�����Ϣ
                    OutputStream os = socket.getOutputStream();//�ֽ������
                    PrintWriter pw = new PrintWriter(os);//���������װ�ɴ�ӡ��
                    pw.write("11111111111111111");
                    pw.flush();
                    //socket.shutdownOutput();
                    //3����ȡ������������ȡ�������˵���Ӧ��Ϣ
                    InputStream is = socket.getInputStream();
                    BufferedReader br = new BufferedReader(new InputStreamReader(is));
                    String info = null;
                    while ((info = br.readLine()) != null) {
                        System.out.println("���ǿͻ��ˣ�������˵��" + info);
                    }
                    //4���ر���Դ
                    br.close();
                    is.close();
                    pw.close();
                } catch (IOException e) {
                    e.printStackTrace();
                }
            }
        }).start();

    }    
}





