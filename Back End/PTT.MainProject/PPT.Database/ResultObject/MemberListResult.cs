using System;
using System.Collections.Generic;
using System.Text;

namespace PPT.Database.ResultObject
{
    public class MemberListResult
    {
        public int groupMemberId { get; set; }
        public int groupId { get; set; }
        public int accountId { get; set; }
        public string email { get; set; }
        public string fullName { get; set; }
        public string address { get; set; }
        public string phoneNumber { get; set; }
    }
}
