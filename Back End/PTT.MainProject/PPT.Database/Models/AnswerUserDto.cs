﻿using System;
using System.Collections.Generic;
using System.Text;

namespace PPT.Database.Models
{
    public class AnswerUserDto
    {
        public int answerUserId { get; set; }

        public string answerKey { get; set; }

        public int accountId { get; set; }

        public int questionId { get; set; }
    }
}
