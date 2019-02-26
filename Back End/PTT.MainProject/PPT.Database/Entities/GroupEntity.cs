using System;
using System.Collections.Generic;
using System.ComponentModel.DataAnnotations;
using System.ComponentModel.DataAnnotations.Schema;
using System.Text;

namespace PPT.Database.Entities
{
    public class GroupEntity
    {
        [Key]
        [DatabaseGenerated(DatabaseGeneratedOption.Identity)]
        public int GroupId { get; set; }

        [MaxLength(200)]
        public string Name { get; set; }

        [MaxLength(200)]
        public string Description { get; set; }

        public DateTime CreatedDate { get; set; }

        public ICollection<GroupMemberEntity> GroupMembers { get; set; } = new List<GroupMemberEntity>();
        public ICollection<GroupOwnerEntity> GroupOwners { get; set; } = new List<GroupOwnerEntity>();
        public ICollection<HistoryEntity> HistoryEntity { get; set; } = new List<HistoryEntity>();
        public ICollection<NotificationEntity> Notifications { get; set; } = new List<NotificationEntity>();
        public ICollection<ExamEntity> Exams { get; set; } = new List<ExamEntity>();
    }
}
