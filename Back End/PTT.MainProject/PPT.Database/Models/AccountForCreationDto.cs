using System;
using System.Collections.Generic;
using System.ComponentModel.DataAnnotations;
using System.Text;

namespace PPT.Database.Models
{
    public class AccountForCreationDto
    {
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
    }
}
