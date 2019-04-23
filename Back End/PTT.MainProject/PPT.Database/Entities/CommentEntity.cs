using System;
using System.Collections.Generic;
using System.ComponentModel.DataAnnotations;
using System.ComponentModel.DataAnnotations.Schema;
using System.Text;

namespace PPT.Database.Entities
{
    public class CommentEntity
    {
        [Key]
        [DatabaseGenerated(DatabaseGeneratedOption.Identity)]
        public int CommentId { get; set; }

        [MaxLength(255)]
        public string Content { get; set; }

        public DateTime DateTimeComment { get; set; }

        [ForeignKey("GroupMemberId")]
        public GroupMemberEntity GroupMember { set; get; }
        public int GroupMemberId { get; set; }

        [ForeignKey("ExamId")]
        public ExamEntity Exam { set; get; }
        public int ExamId { get; set; }

        [ForeignKey("AccountId")]
        public AccountEntity Account { set; get; }
        public int AccountId { get; set; }
    }
}
