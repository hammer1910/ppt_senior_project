﻿using System;
using System.Collections.Generic;
using System.ComponentModel.DataAnnotations;
using System.ComponentModel.DataAnnotations.Schema;
using System.Text;

namespace PPT.Database.Entities
{
    public class AnswerUserEntity
    {
        [Key]
        [DatabaseGenerated(DatabaseGeneratedOption.Identity)]
        public int AnswerUserId { get; set; }

        [MaxLength(10)]
        public string AnswerKey { get; set; }

        [ForeignKey("AccountId")]
        public AccountEntity Account { set; get; }
        public int AccountId { get; set; }

        [ForeignKey("ExamId")]
        public ExamEntity Exam { set; get; }
        public int ExamId { get; set; }
    }
}