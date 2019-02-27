using PPT.Database.Entities;
using System;
using System.Collections.Generic;
using System.Text;

namespace PPT.Database
{
    public static class Insert
    {
        public static void EnsureSeedDataForContext(this ExamContext context)
        {
            string a = "abc";
            var history = new List<AccountEntity>
            {
                new AccountEntity()
                {
                    Password = CreateMD5(a)               

                 }
                
            };
            context.Accounts.AddRange(history);
            context.SaveChanges();
        }
        public static string CreateMD5(string input)
        {
            // Use input string to calculate MD5 hash
            using (System.Security.Cryptography.MD5 md5 = System.Security.Cryptography.MD5.Create())
            {
                byte[] inputBytes = System.Text.Encoding.ASCII.GetBytes(input);
                byte[] hashBytes = md5.ComputeHash(inputBytes);
                // Convert the byte array to hexadecimal string
                StringBuilder sb = new StringBuilder();
                for (int i = 0; i < hashBytes.Length; i++)
                {
                    sb.Append(hashBytes[i].ToString("X2"));
                }
                return sb.ToString();
            }
        }
    }
}
