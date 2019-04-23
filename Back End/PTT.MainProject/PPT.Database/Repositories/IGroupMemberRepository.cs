using PPT.Database.Entities;
using System;
using System.Collections.Generic;
using System.Text;

namespace PPT.Database.Repositories
{
    public interface IGroupMemberRepository
    {
        GroupMemberEntity GetGroupMemberByGroupIdAndAccountId(int groupId, int accountId);
        List<GroupMemberEntity> GetGroupMemberByGroupId(int groupId);        
        List<GroupMemberEntity> GetGroupMemberByAccountId(int memberId);
    }
}
