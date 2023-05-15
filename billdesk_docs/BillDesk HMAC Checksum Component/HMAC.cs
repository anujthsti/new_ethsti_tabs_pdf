using System;
using System.Security.Cryptography;
using System.Text;
using System.Security.Cryptography;

namespace ConsoleApplication3
{
    public class SHASample
    {
        public SHASample() { }


        public string GetHMACSHA256(string text,string key)
        {
            UTF8Encoding encoder = new UTF8Encoding();

            byte[] hashValue;
            byte[] keybyt = encoder.GetBytes(key);
            byte[] message = encoder.GetBytes(text);

            HMACSHA256  hashString = new HMACSHA256(keybyt);
            string hex = "";

            hashValue = hashString.ComputeHash(message);
            foreach (byte x in hashValue)
            {
                hex += String.Format("{0:x2}", x);
            }
            return hex;
        }



        public static void Main(string[] args)
        {


            String data = "MERCHANT|1000000000|NA|12.00|XXX|NA|NA|INR|DIRECT|R|NA|NA|NA|F|111111111|NA|NA|NA|NA|NA|NA|NA";
			String commonkey="Your checksum key here";
            SHASample dataprg = new SHASample();
            String hash = String.Empty;
            hash = dataprg.GetHMACSHA256(data,commonkey);
            Console.Out.WriteLine("HMAC {0}", hash);
            Console.ReadKey();

        }


    }

}