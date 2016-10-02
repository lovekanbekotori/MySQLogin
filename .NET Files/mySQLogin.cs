using System;
using System.Collections.Generic;
using System.Collections.Specialized;
using System.IO;
using System.Linq;
using System.Net;
using System.Security.Cryptography;
using System.Text;
using System.Threading.Tasks;

class mySQLogin
{
    #region config
    private static string create_userURL = "http://.../create_user.php";
    private static string check_userURL = "http://.../check_user.php";
    #endregion
    public static int register(string username, string password)
    {
        try
        {
            using (var client = new WebClient())
            {
                var values = new NameValueCollection();
                values["username"] = username;
                values["password"] = enc.obfuscate(password);
                var response = client.UploadValues(create_userURL, values);
                var responseString = Encoding.Default.GetString(response);
                if (responseString.Contains("New record created successfully"))
                {
                    return 1;
                }
                if (responseString.Contains("Username already taken"))
                {
                    return 2;
                }
            }
        } catch (Exception)
        {
            return 0;
        }
        return 0;
    }
    public static int login(string username, string password)
    {
        try
        {
            using (var client = new WebClient())
            {
                var values = new NameValueCollection();
                values["username"] = username;
                values["password"] = enc.obfuscate(password);
                var response = client.UploadValues(check_userURL, values);
                var responseString = Encoding.Default.GetString(response);
                if (responseString.Contains("true->" + username.ToLower()))
                {
                    return 1;
                }
                else if (responseString.Contains("false->" + username.ToLower()))
                {
                    return 2;
                }
                return 0;
            }
        } catch (Exception)
        {
            return 0;
        }
    }
}
class enc
{
    public static string obfuscate(string s)
    {
        string ogS = s;
        int run = s.Length; int insX = 3;
        for (int i = 0; i < run + Math.Pow(insX, insX); i++)
        {
            int indX = i + (i * insX);
            string toEnc = s.Substring(indX - i, insX);
            string nData = encode(toEnc);
            s = s.Insert(indX, nData);
        } return s.Replace(ogS, null).Replace(s.Substring(0, run), null);
    }
    private static string encode(string s)
    {
        var pBytes = System.Text.Encoding.ASCII.GetBytes(s);
        return System.Convert.ToBase64String(pBytes);
    }
}