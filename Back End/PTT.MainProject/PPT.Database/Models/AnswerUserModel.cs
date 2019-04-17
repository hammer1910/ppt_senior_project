using System;
using System.Collections.Generic;
using System.Text;

namespace PPT.Database.Models
{
    public class AnswerUserModel
    {
        public string status;
        public int examId { get; set; }
        public int accountId { get; set; }
        public List<AnswerUserDto> listAnswerUser { get; set; } = new List<AnswerUserDto>();
    }
}
