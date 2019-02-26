using System;
using System.Collections.Generic;
using System.ComponentModel.DataAnnotations;
using System.ComponentModel.DataAnnotations.Schema;
using System.Text;

namespace PPT.Database.Entities
{
    public class ExamQuestionEntity
    {
        [Key]
        [DatabaseGenerated(DatabaseGeneratedOption.Identity)]
        public int ExamQuestionId { get; set; }

        [MaxLength(10)]
        public string CorrectAnswer { get; set; }

        [ForeignKey("QuestionId")]
        public QuestionEntity Question { set; get; }
        public int QuestionId { get; set; }

        [ForeignKey("ExamId")]
        public ExamEntity Exam { set; get; }
        public int ExamId { get; set; }
    }
}
