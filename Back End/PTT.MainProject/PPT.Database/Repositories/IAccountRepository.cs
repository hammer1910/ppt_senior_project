using System;
using System.Collections.Generic;
using System.Text;

namespace PPT.Database.Services
{
    public interface IAccountRepository
    {
        bool AccountExists(int accountId);


    }
}
