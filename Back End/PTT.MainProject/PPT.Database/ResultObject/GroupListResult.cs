using System;
using System.Collections.Generic;
using System.Text;

namespace PPT.Database.ResultObject
{
    public class GroupListResult
    {
        public int groupOwnerId { get; set; }
        public int ownerGroupId { get; set; }
        public int groupId { get; set; }
        public string groupName { get; set; }
    }
}
