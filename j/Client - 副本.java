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
	public static final String IP_ADDR = "192.168.1.70";//服务器地址   
    public static final int PORT = 8899;//服务器端口号    
      
    public static void main(String[] args) {    
        System.out.println("客户端启动...");    
        System.out.println("当接收到服务器端字符为 \"OK\" 的时候, 客户端将终止\n");   
        Socket mSocket = null ;  
        while (true) {   
			Scanner sc = new Scanner(System.in);
			String next = sc.next();
            try {  
				if(mSocket == null)
					mSocket = new Socket(IP_ADDR, PORT);
				OutputStream mOs = mSocket.getOutputStream();
				PrintWriter pw = new PrintWriter(mOs);//将输出流包装成打印流
				pw.write(next);
				pw.flush();
//                    mSocket.shutdownOutput();
				//3、获取输入流，并读取服务器端的响应信息
				InputStream is = mSocket.getInputStream();
				BufferedReader br = new BufferedReader(new InputStreamReader(is));
				String info;
				while ((info = br.readLine()) != null) {
					System.out.println("客户端:" + info);   
				}
				//4、关闭资源
				br.close();
				is.close();
				pw.close();
				
            } catch (Exception e) {  
                System.out.println("客户端异常:" + e.getMessage());   
            } 
        }    
    }    
}





