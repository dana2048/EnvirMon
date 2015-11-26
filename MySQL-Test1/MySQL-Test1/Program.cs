
using System;
using System.IO.Ports;
using MySql.Data.MySqlClient;

namespace MySQL_Test1
{
    class Program
    {

        static void Main(string[] args)
        {
            Application a = new Application();

            Console.WriteLine("Hello World!");

            a.App();
        }
    }

    class Application
    {
        MySqlConnection connect;

        public void App()
        {

            SerialPort myPort = new SerialPort();

            myPort.DataBits = 8;
            myPort.BaudRate = 9600;
            myPort.DtrEnable = true;
            myPort.PortName = "COM6";
            myPort.Parity = Parity.None;
            myPort.StopBits = StopBits.One;
            myPort.DataReceived += MyPortDataReceived;

            myPort.Open();

            connect = new MySqlConnection
                (
                "user id=root;" +
                "server=localhost;" +
                "port=3306;" +
                "database=monitor; " + 
                "connection timeout=30"
                );

            try
            {
                connect.Open();

                Console.WriteLine("press return to quit");
                Console.ReadLine();

/*                
                string sql = "INSERT INTO data (sensor, pressure, humidity, temperature) VALUES (4, 30.33, 55.55, 66.6)";
                Console.WriteLine(sql);
                
                var cmd = new MySqlCommand(sql, connect);

                if (cmd == null) Console.WriteLine("new MySqlCommand returned null");

                int affected = cmd.ExecuteNonQuery();
                Console.WriteLine("Lines affected= {0}", affected);

                connect.Close();

                Console.ReadKey();
*/
            }

            catch (Exception ex)
            {
                Console.WriteLine("caught exception " + ex.Message);
                Console.ReadKey();
                //throw;
            }
        }

        void MyPortDataReceived(object sender, SerialDataReceivedEventArgs e)
        {
            try
            {
                var myPort = sender as SerialPort;
                string line = myPort.ReadLine();

                Console.WriteLine(line);
                line = line.Trim();

                string[] item;

                item = line.Split( new Char[]{','}, 4 );

                string sql="";
                string values;
                values = item[1] + ", " + item[2] + ", " + item[3];

                if (item[0] == "H")
                {
                    sql = "INSERT INTO data (sensor, humidity, temperature) VALUES (" + values + ");";
                }

                else if (item[0] == "P")
                {
                    sql = "INSERT INTO data (sensor, pressure, temperature) VALUES (" + values + ");";
                }

                else
                {
                    Console.WriteLine(">>>>>>>>>>" + line);
                }

                if (sql.Length > 0)
                {
                    Console.WriteLine(sql);

                    var cmd = new MySqlCommand(sql, connect);

                    if (cmd == null) Console.WriteLine("new MySqlCommand returned null");

                    int affected = cmd.ExecuteNonQuery();
                    Console.WriteLine("Lines affected= {0}", affected);
                }
            }

            catch (Exception ex)
            {
                Console.WriteLine("caught exception " + ex.Message);
                //Console.ReadKey();
            }
        }

    }
}
