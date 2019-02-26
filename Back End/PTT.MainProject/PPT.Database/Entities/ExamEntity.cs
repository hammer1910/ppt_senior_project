using System;
using System.Collections.Generic;
using System.ComponentModel.DataAnnotations;
using System.ComponentModel.DataAnnotations.Schema;
using System.Text;

namespace PPT.Database.Entities
{
    public class ExamEntity
    {
        [Key]
        [DatabaseGenerated(DatabaseGeneratedOption.Identity)]
        public int ExamId { get; set; }

        public DateTime StartDate { get; set; }

        public DateTime EndDate { get; set; }

        [ForeignKey("GroupId")]
        public GroupEntity Group { set; get; }
        public int GroupId { get; set; }

        public ICollection<AnswerUserEntity> AnswerUsers { get; set; } = new List<AnswerUserEntity>();
        public ICollection<ExamQuestionEntity> ExamQuestions { get; set; } = new List<ExamQuestionEntity>();
        public ICollection<HistoryEntity> Histories { get; set; } = new List<HistoryEntity>();
    }
}
