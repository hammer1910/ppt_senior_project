﻿using System;
using System.Collections.Generic;
using System.Text;

namespace PPT.Database.Models
{
    public class QuestionDto
    {
        public int questionId { get; set; }
        public string part { get; set; }      
        public string A { get; set; }
        public string B { get; set; }
        public string C { get; set; }        
        public string correctAnswer { get; set; }
    }
}