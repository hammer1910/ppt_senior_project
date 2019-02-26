using System;
using System.Collections.Generic;
using System.ComponentModel.DataAnnotations;
using System.ComponentModel.DataAnnotations.Schema;
using System.Text;

namespace PPT.Database.Entities
{
    public class AccountRoleEntity
    {
        [Key]
        [DatabaseGenerated(DatabaseGeneratedOption.Identity)]
        public int AccountRoleId { get; set; }

        [ForeignKey("AccountId")]
        public AccountEntity Account { set; get; }
        public int AccountId { get; set; }

        [ForeignKey("RoleId")]
        public RoleEntity Role { set; get; }
        public int RoleId { get; set; }
    }
}
