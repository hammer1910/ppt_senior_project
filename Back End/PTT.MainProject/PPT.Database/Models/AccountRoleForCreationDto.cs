using PPT.Database.Entities;
using System;
using System.Collections.Generic;
using System.ComponentModel.DataAnnotations.Schema;
using System.Text;

namespace PPT.Database.Models
{
    public class AccountRoleForCreationDto
    {
        [ForeignKey("AccountId")]
        public AccountEntity Account { set; get; }
        public int AccountId { get; set; }

        [ForeignKey("RoleId")]
        public RoleEntity Role { set; get; }
        public int RoleId { get; set; }
    }
}
