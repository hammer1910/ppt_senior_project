using System;
using System.Collections.Generic;
using System.Text;

namespace PPT.Database.ResultObject
{
    public class QuestionListResult
    {
        public int questionId { get; set; }
        public int questionNumber { get; set; }
        public string part { get; set; }
        public string image { get; set; }
        public string fileMp3 { get; set; }
        public string questionName { get; set; }
        public string A { get; set; }
        public string B { get; set; }
        public string C { get; set; }
        public string D { get; set; }
        public string correctAnswer { get; set; }
        public string team { get; set; }
        public string answerUser { get; set; }
    }
}
