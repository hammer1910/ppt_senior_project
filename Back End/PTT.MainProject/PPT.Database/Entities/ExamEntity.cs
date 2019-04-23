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

        [MaxLength(255)]
        public string Name { get; set; }

        public DateTime StartDate { get; set; }

        public DateTime EndDate { get; set; }

        [ForeignKey("GroupId")]
        public GroupEntity Group { set; get; }
        public int GroupId { get; set; }

        public ICollection<ExamQuestionEntity> ExamQuestions { get; set; } = new List<ExamQuestionEntity>();
        public ICollection<HistoryEntity> Histories { get; set; } = new List<HistoryEntity>();
        public ICollection<CommentEntity> Comments { get; set; } = new List<CommentEntity>();
        public ICollection<AccountExamEntity> AccountExams { get; set; } = new List<AccountExamEntity>();
    }
}
