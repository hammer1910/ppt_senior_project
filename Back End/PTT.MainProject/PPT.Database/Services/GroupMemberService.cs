using PPT.Database.Entities;
using PPT.Database.Repositories;
using System;
using System.Collections.Generic;
using System.Text;
using System.Linq;

namespace PPT.Database.Services
{
    public class GroupMemberService : IGroupMemberRepository
    {
        private ExamContext _context;

        public GroupMemberService(ExamContext context)
        {
            _context = context;
        }

        public GroupMemberEntity GetGroupMemberByGroupIdAndAccountId(int groupId, int accountId)
        {
            return _context.GroupMembers.FirstOrDefault(m => m.GroupId == groupId && m.AccountId == accountId);
        }

        public List<GroupMemberEntity> GetGroupMemberByGroupId(int groupId)
        {
            return _context.GroupMembers.Where(m => m.GroupId == groupId).ToList();
        }
    }
}
