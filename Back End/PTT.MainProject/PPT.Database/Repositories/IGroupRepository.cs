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
        bool GroupExist(int groupId);
        void DeleteGroup(GroupEntity group);
        List<GroupOwnerEntity> GetGroupListByOwnerId(int ownerId);
        void OutGroup(int groupId, int accountId);
        GroupMemberEntity GetGroupMemberByGroupIdAndMemberId(int groupId, int memberId);
        List<GroupMemberEntity> GetMemberListByGroupId(int groupId);
        GroupMemberEntity GetMemberByAccountId(int accountId);
        void DeleteMember(GroupMemberEntity member);
        GroupEntity GetGroupByExam(ExamEntity examEntity);
        
    }
}
