using System;
using System.Collections.Generic;
using System.Text;

namespace PPT.Database.ResultObject
{
    public class ExamResultHasOwner
    {
        public int ownerId { get; set; }
        public List<ExamResult> examResults { get; set; }
    }
}
