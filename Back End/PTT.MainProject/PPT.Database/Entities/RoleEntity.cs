using System;
using System.Collections.Generic;
using System.ComponentModel.DataAnnotations;
using System.ComponentModel.DataAnnotations.Schema;
using System.Text;

namespace PPT.Database.Entities
{
    public class RoleEntity
    {
        [Key]
        [DatabaseGenerated(DatabaseGeneratedOption.Identity)]
        public int RoleId { get; set; }

        [MaxLength(20)]
        public string NameRole { get; set; }

        public ICollection<AccountRoleEntity> AccountRoles { get; set; } = new List<AccountRoleEntity>();
    }
}
