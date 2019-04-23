using System;
using System.Collections.Generic;
using System.ComponentModel.DataAnnotations;
using System.ComponentModel.DataAnnotations.Schema;
using System.Text;

namespace PPT.Database.Entities
{
    public class HistoryEntity
    {
        [Key]
        [DatabaseGenerated(DatabaseGeneratedOption.Identity)]
        public int HistoryId { get; set; }

        [ForeignKey("GroupId")]
        public GroupEntity Group { set; get; }
        public int GroupId { get; set; }

        [ForeignKey("AccountId")]
        public AccountEntity Account { set; get; }
        public int AccountId { get; set; }

        [ForeignKey("ExamId")]
        public ExamEntity Exam { set; get; }
        public int ExamId { get; set; }
    }
}
