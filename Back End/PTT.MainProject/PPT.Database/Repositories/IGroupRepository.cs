using PPT.Database.Entities;
using System;
using System.Collections.Generic;
using System.Text;
using PPT.Database.Models;

namespace PPT.Database.Repositories
{
    public interface IGroupRepository
    {
        void CreationGroup(GroupEntity groupEntity, AccountEntity accountEntity); 
        bool Save();
        void AddMemberIntoGroup(GroupEntity groupEntity, AccountEntity accountEntity);
        GroupEntity GetGroupById(int id);
        List<GroupOwnerEntity> getGroupListByOwnerId(int ownerId);

    }
}
