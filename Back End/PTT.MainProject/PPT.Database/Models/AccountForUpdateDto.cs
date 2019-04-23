using System;
using System.Collections.Generic;
using System.ComponentModel.DataAnnotations;
using System.Text;

namespace PPT.Database.Models
{
    public class AccountForUpdateDto
    {
        public int accountId;
        [MaxLength(255)]
        public string Email { get; set; }

        [MaxLength(30)]
        public string FullName { get; set; }

        [MaxLength(20)]
        public string Phone { get; set; }

        [MaxLength(150)]
        public string Address { get; set; }
    }
}
