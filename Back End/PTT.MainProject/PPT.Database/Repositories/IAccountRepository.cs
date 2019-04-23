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
        IEnumerable<AccountRoleEntity> GetAccountRoles(int accountId);
        RoleEntity GetRole(int id);
        void Register(AccountEntity accountEntity);
        bool Save();
        bool EmailExist(string email);
        AccountEntity GetAccountByEmail(string email);
        AccountEntity GetAccountById(int id);
        void DeleteAccount(AccountEntity account);
        List<AccountEntity> GetAllAccounts();
        List<AccountEntity> SearchMemberByName(string name);
    }
}
