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
        System.out.println("�ͻ�������...");    
        System.out.println("�����յ����������ַ�Ϊ \"OK\" ��ʱ��, �ͻ��˽���ֹ\n");   
        Socket mSocket = null ;  
        while (true) {   
			Scanner sc = new Scanner(System.in);
			String next = sc.next();
            try {  
				if(mSocket == null)
					mSocket = new Socket(IP_ADDR, PORT);
				OutputStream mOs = mSocket.getOutputStream();
				PrintWriter pw = new PrintWriter(mOs);//���������װ�ɴ�ӡ��
				pw.write(next);
				pw.flush();
//                    mSocket.shutdownOutput();
				//3����ȡ������������ȡ�������˵���Ӧ��Ϣ
				InputStream is = mSocket.getInputStream();
				BufferedReader br = new BufferedReader(new InputStreamReader(is));
				String info;
				while ((info = br.readLine()) != null) {
					System.out.println("�ͻ���:" + info);   
				}
				//4���ر���Դ
				br.close();
				is.close();
				pw.close();
				
            } catch (Exception e) {  
                System.out.println("�ͻ����쳣:" + e.getMessage());   
            } 
        }    
    }    
}





