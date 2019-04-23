using System;
using System.Collections.Generic;
using System.ComponentModel.DataAnnotations;
using System.Text;

namespace PPT.Database.Models
{
    public class GroupForCreationDto
    {
        public int accountId;
        [MaxLength(200)]
        public string Name { get; set; }

        [MaxLength(200)]
        public string Description { get; set; }

        public DateTime CreatedDate { get; set; }
    }
}
