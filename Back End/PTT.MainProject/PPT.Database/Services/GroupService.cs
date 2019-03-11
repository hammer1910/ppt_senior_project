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
            return _context.Groups.Where(a => a.GroupId == id).FirstOrDefault();
        }

        public List<GroupOwnerEntity> getGroupListByOwnerId(int ownerId)
        {
            return _context.GroupOwners.Where(c => c.AccountId == ownerId).ToList();
        }
    }
}
