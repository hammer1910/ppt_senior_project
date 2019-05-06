using PPT.Database.Entities;
using PPT.Database.Models;
using PPT.Database.Repositories;
using System;
using System.Collections.Generic;
using System.Text;
using System.Linq;
using PPT.Database.ResultObject;

namespace PPT.Database.Services
{
    public class GroupService : IGroupRepository
    {
        private ExamContext _context;

        public GroupService(ExamContext context)
        {
            _context = context;
        }

        public void AddMemberIntoGroup(GroupEntity groupEntity, AccountEntity accountEntity)
        {
            GroupMemberEntity groupMemberEntity = new GroupMemberEntity();
            groupMemberEntity.AccountId = accountEntity.AccountId;
            groupMemberEntity.GroupId = groupEntity.GroupId;
            _context.GroupMembers.Add(groupMemberEntity);
        }

        public void CreationGroup(GroupEntity groupEntity,AccountEntity accountEntity)
        {
            _context.Groups.Add(groupEntity);

            GroupOwnerEntity groupOwner = new GroupOwnerEntity();
            groupOwner.AccountId = accountEntity.AccountId;
            groupOwner.GroupId = groupEntity.GroupId;

            _context.GroupOwners.Add(groupOwner);       
        }

        public bool Save()
        {
            return (_context.SaveChanges() >= 0);
        }

        public GroupEntity GetGroupById(int id)
        {
            return _context.Groups.Where(a => a.GroupId == id).OrderByDescending(a => a.CreatedDate).FirstOrDefault();
        }

        public bool GroupExist(int groupId)
        {
            return _context.Groups.Any(g => g.GroupId == groupId);
        }

        public void DeleteGroup(GroupEntity group)
        {
            _context.Groups.Remove(group);
        }

        public List<GroupOwnerEntity> GetGroupListByOwnerId(int ownerId)
        {
            return _context.GroupOwners.Where(c => c.AccountId == ownerId).ToList();
        }

        public void OutGroup(int groupId, int accountId)
        {

            _context.GroupMembers.Remove(GetGroupMemberByGroupIdAndMemberId(groupId, accountId));
        }

        public GroupMemberEntity GetGroupMemberByGroupIdAndMemberId(int groupId, int memberId)
        {
            return _context.GroupMembers.FirstOrDefault(c => c.GroupId == groupId && c.AccountId == memberId);
        }

        public List<GroupMemberEntity> GetMemberListByGroupId(int groupId)
        {
            return _context.GroupMembers.Where(m => m.GroupId == groupId).ToList();
        }

        public GroupMemberEntity GetMemberByAccountId(int accountId)
        {
            return _context.GroupMembers.FirstOrDefault(a => a.AccountId == accountId);
        }

        public void DeleteMember(GroupMemberEntity member)
        {
            _context.GroupMembers.Remove(member);
        }

        public GroupEntity GetGroupByExam(ExamEntity examEntity)
        {
            int groupId = examEntity.GroupId;
            return GetGroupById(groupId);
        }
    }
}
