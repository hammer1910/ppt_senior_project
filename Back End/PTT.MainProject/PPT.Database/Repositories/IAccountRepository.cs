using PPT.Database.Entities;
using System;
using System.Collections.Generic;
using System.Text;

namespace PPT.Database.Services
{
    public interface IAccountRepository
    {
        bool AccountExists(int accountId);
        AccountEntity LoginAccount(string email, string password);
        
    }
}
