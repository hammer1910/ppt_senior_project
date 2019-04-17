using System;
using System.Collections.Generic;
using System.Text;

namespace PPT.Database.Models
{
    public class CommentDto
    {
        public int accountId { get; set; }
        public int groupId { get; set; }
        public string content { get; set; }      
        public int examId { get; set; }
    }
}
