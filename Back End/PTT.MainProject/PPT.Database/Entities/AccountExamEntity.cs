using System;
using System.Collections.Generic;
using System.ComponentModel.DataAnnotations;
using System.ComponentModel.DataAnnotations.Schema;
using System.Text;

namespace PPT.Database.Entities
{
    public class AccountExamEntity
    {
        [Key]
        [DatabaseGenerated(DatabaseGeneratedOption.Identity)]
        public int AccountExamId { get; set; }

        [MaxLength(30)]
        public string IsStatus { get; set; }

        [ForeignKey("ExamId")]
        public ExamEntity Exam { set; get; }
        public int ExamId { get; set; }

        [ForeignKey("AccountId")]
        public AccountEntity Account { set; get; }
        public int AccountId { get; set; }
    }
}
