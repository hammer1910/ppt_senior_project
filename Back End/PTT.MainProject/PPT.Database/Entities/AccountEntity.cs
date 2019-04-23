using System;
using System.Collections.Generic;
using System.ComponentModel.DataAnnotations;
using System.ComponentModel.DataAnnotations.Schema;
using System.Text;

namespace PPT.Database.Entities
{
    public class AccountEntity
    {
        [Key]
        [DatabaseGenerated(DatabaseGeneratedOption.Identity)]
        public int AccountId { get; set; }

        [MaxLength(255)]
        public string Email { get; set; }

        [MaxLength(255)]
        public string Password { get; set; }

        [MaxLength(30)]
        public string FullName { get; set; }

        [MaxLength(20)]
        public string Phone { get; set; }

        [MaxLength(150)]
        public string Address { get; set; }

        public ICollection<GroupMemberEntity> GroupMembers { get; set; } = new List<GroupMemberEntity>();
        public ICollection<HistoryEntity> Histories { get; set; } = new List<HistoryEntity>();
        public ICollection<NotificationEntity> Notifications { get; set; } = new List<NotificationEntity>();
        public ICollection<AccountRoleEntity> AccountRoles { get; set; } = new List<AccountRoleEntity>();
        public ICollection<GroupOwnerEntity> GroupOwners { get; set; } = new List<GroupOwnerEntity>();
        public ICollection<AnswerUserEntity> AnswerUsers { get; set; } = new List<AnswerUserEntity>();
        public ICollection<CommentEntity> Comments { get; set; } = new List<CommentEntity>();
        public ICollection<AccountExamEntity> AccountExams { get; set; } = new List<AccountExamEntity>();
    }
}
