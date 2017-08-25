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
        
		new Thread(new Runnable() {
            @Override
            public void run() {
                try {
                    Socket socket = new Socket(IP_ADDR, PORT);
                   // 2、获取输出流，向服务器端发送信息
                    OutputStream os = socket.getOutputStream();//字节输出流
                    PrintWriter pw = new PrintWriter(os);//将输出流包装成打印流
                    pw.write("11111111111111111");
                    pw.flush();
                    //socket.shutdownOutput();
                    //3、获取输入流，并读取服务器端的响应信息
                    InputStream is = socket.getInputStream();
                    BufferedReader br = new BufferedReader(new InputStreamReader(is));
                    String info = null;
                    while ((info = br.readLine()) != null) {
                        System.out.println("我是客户端，服务器说：" + info);
                    }
                    //4、关闭资源
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





