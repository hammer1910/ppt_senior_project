using System;
using System.Collections.Generic;
using System.Text;

namespace PPT.Database.Models
{
    public class QuestionDto
    {        
        public int examId;
        public int questionNumber;
        public string part { get; set; }
        public string image { get; set; }
        public string fileMp3 { get; set; }
        public string questionName { get; set; }
        public string a { get; set; }
        public string b { get; set; }
        public string c { get; set; }
        public string d { get; set; }
        public string correctAnswer { get; set; }
        public string team { get; set; }
    }
}
