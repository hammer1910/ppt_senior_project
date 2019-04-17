using PPT.Database.Entities;
using PPT.Database.Repositories;
using System;
using System.Collections.Generic;
using System.Text;
using System.Linq;
using System.Data.Linq.SqlClient;

namespace PPT.Database.Services
{
    public class GroupMemberService : IGroupMemberRepository
    {
        private ExamContext _context;
        private IAccountRepository _accountRepository;
        public GroupMemberService(ExamContext context, IAccountRepository accountRepository)
        {
            _context = context;
            _accountRepository = accountRepository;
        }

        public GroupMemberEntity GetGroupMemberByGroupIdAndAccountId(int groupId, int accountId)
        {
            return _context.GroupMembers.FirstOrDefault(m => m.GroupId == groupId && m.AccountId == accountId);
        }

        public List<GroupMemberEntity> GetGroupMemberByGroupId(int groupId)
        {
            return _context.GroupMembers.Where(m => m.GroupId == groupId).ToList();
        }

        public List<AccountEntity> SearchMemberByName(string name, int groupId)
        {
            List<GroupMemberEntity> listMember = _context.GroupMembers.Where(m => m.GroupId == groupId).ToList();
            List<AccountEntity> listAccount = new List<AccountEntity>();
            foreach (var item in listMember)
            {
                AccountEntity account = _accountRepository.GetAccountById(item.AccountId);
                listAccount.Add(account);
                
            }

            return listAccount.Where(c => c.FullName.Contains(name)).ToList();
        }
    }
}
