using System;
using System.Collections.Generic;
using System.Text;

namespace PPT.Database.Models
{
    public class ChangingPassword
    {
        public int accountId;
        public string oldPassword { get; set; }
        public string newPassword { get; set; }
    }
}
