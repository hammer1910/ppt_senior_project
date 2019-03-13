using PPT.Database.Entities;
using PPT.Database.Repositories;
using System;
using System.Collections.Generic;
using System.Text;

namespace PPT.Database.Services
{
    public class ExamService : IExamRepository
    {
        private ExamContext _context;

        public ExamService(ExamContext context)
        {
            _context = context;
        }

        public void CreateExam(ExamEntity examEntity)
        {
            _context.Exams.Add(examEntity);

        }

        public bool Save()
        {
            return  (_context.SaveChanges() >= 0);
        }
    }
}
