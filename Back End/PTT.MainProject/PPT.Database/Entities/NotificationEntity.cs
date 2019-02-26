using System;
using System.Collections.Generic;
using System.ComponentModel.DataAnnotations;
using System.ComponentModel.DataAnnotations.Schema;
using System.Text;

namespace PPT.Database.Entities
{
    public class NotificationEntity
    {
        [Key]
        [DatabaseGenerated(DatabaseGeneratedOption.Identity)]
        public int NotificationId { get; set; }

        [MaxLength(1000)]
        public string Message { get; set; }

        public DateTime CreatedDate { get; set; }

        [ForeignKey("GroupId")]
        public GroupEntity Group { set; get; }
        public int GroupId { get; set; }

        [ForeignKey("AccountId")]
        public AccountEntity Account { set; get; }
        public int AccountId { get; set; }
    }
}
