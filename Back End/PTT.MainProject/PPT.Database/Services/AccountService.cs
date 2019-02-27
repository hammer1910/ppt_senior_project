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

        public void Register(AccountEntity accountEntity)
        {
            _context.Accounts.Add(accountEntity);
            AccountRoleEntity role = new AccountRoleEntity();
            role.AccountId = accountEntity.AccountId;
            role.RoleId = 2;
            _context.AccountRoles.Add(role);
        }

        public bool Save()
        {
            return (_context.SaveChanges() >= 0);
        }

        public bool EmailExist(string email)
        {
            AccountEntity acc = _context.Accounts.FirstOrDefault(c => c.Email.Equals(email)); 
            if(acc == null)
            {
                return true;
            }
            return false;
        }
    }
}
