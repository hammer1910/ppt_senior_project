using System;
using System.Collections.Generic;
using System.Net.Mail;
using System.Text;

namespace PPT.Database.Common
{
    public class SendGmail
    {
        public static void SendVertified(string email)
        {
            MailMessage mail = new MailMessage();
            SmtpClient SmtpServer = new SmtpClient("smtp.gmail.com");
            mail.From = new MailAddress("truongvancanhntt@gmail.com");
            mail.To.Add(email);
            mail.Subject = "Send gmail vertified!";
            mail.Body = "Hello";
            SmtpServer.Port = 587;
            SmtpServer.Credentials = new System.Net.NetworkCredential("truongvancanhntt@gmail.com", "vancanh123");
            SmtpServer.EnableSsl = true;
            SmtpServer.Send(mail);
        }

        public static string ForgotPassword(string email)
        {
            Random random = new Random();
            string activationcode = random.Next(1000000, 9999999).ToString();            
            MailMessage mail = new MailMessage();
            SmtpClient SmtpServer = new SmtpClient("smtp.gmail.com");
            mail.From = new MailAddress("truongvancanhntt@gmail.com");
            mail.To.Add(email);
            mail.Subject = "Your password is: ";
            mail.Body = activationcode;
            SmtpServer.Port = 587;
            SmtpServer.Credentials = new System.Net.NetworkCredential("truongvancanhntt@gmail.com", "vancanh123");
            SmtpServer.EnableSsl = true;
            SmtpServer.Send(mail);
            return activationcode;
        }
    }
}
