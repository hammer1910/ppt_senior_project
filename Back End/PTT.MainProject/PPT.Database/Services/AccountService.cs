using System;
using System.Collections.Generic;
using System.Text;
using System.Linq;
using PPT.Database.Entities;

namespace PPT.Database.Services
{
    public class AccountService : IAccountRepository
    {
        private ExamContext _context;
        public AccountService(ExamContext context)
        {
            _context = context;
        }

        public AccountEntity LoginAccount(string email, string password)
        {
            
            AccountEntity acc = _context.Accounts.Where(c => c.Email.Equals(email) && c.Password.Equals(password)).FirstOrDefault();
            return acc;
        }

        public bool AccountExists(int accountId)
        {
            return _context.Accounts.Any(c => c.AccountId == accountId);
        }
    }
}
