using PPT.Database.Entities;
using System;
using System.Collections.Generic;
using System.Text;

namespace PPT.Database.Models
{
    public class ExamForCreationDto
    {
        public int ExamId { get; set; }
        public string Name { get; set; }
        public DateTime StartDate { get; set; }
        public DateTime EndDate { get; set; }            
        public int GroupId { get; set; }
    }
}
