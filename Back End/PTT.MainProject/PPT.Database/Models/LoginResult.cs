using System;
using System.Collections.Generic;
using System.Text;

namespace PPT.Database.Models
{
    public class LoginResult
    {
        public int accountId { get; set; }
        public string email { get; set; }
        public string password { get; set; }
        public string address { get; set; }
        public string phoneNumber { get; set; }
        public List<string> Roles { get; set; }
    }
}
