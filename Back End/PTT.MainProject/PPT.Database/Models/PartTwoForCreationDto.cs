using System;
using System.Collections.Generic;
using System.Text;

namespace PPT.Database.Models
{
    public class PartTwoForCreationDto
    {
        public int questionId { get; set; }
        public string part { get; set; }        
        public string fileMp3 { get; set; }
        public string A { get; set; }
        public string B { get; set; }
        public string C { get; set; }       
        public string correctAnswer { get; set; }
        public string team { get; set; }
    }
}
