using PPT.Database.Entities;
using PPT.Database.Repositories;
using System;
using System.Collections.Generic;
using System.Text;
using System.Linq;
namespace PPT.Database.Services
{
    public class GroupOwnerService : IGroupOwnerRepository
    {
        public ExamContext _context;
        public GroupOwnerService(ExamContext context)
        {
            _context = context;
        }
        public GroupOwnerEntity GetGroupOwnerByGroupId(int groupId)
        {
            return _context.GroupOwners.FirstOrDefault(c => c.GroupId == groupId);
        }
    }
}
