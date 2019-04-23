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

        public List<GroupMemberEntity> GetGroupMemberByAccountId(int memberId)
        {
            return _context.GroupMembers.Where(m => m.AccountId == memberId).ToList();
        }
    }
}
