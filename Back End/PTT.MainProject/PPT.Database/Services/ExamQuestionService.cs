using PPT.Database.Entities;
using PPT.Database.Repositories;
using System;
using System.Collections.Generic;
using System.Text;
using System.Linq;

namespace PPT.Database.Services
{
    public class ExamQuestionService : IExamQuestionRepository
    {
        private ExamContext _context;

        public ExamQuestionService(ExamContext context)
        {
            _context = context;
        }

        public List<ExamQuestionEntity> getListQuestions(int examId)
        {
            
            return _context.ExamQuestions.Where(c => c.ExamId == examId).ToList();
        }
    }
}
