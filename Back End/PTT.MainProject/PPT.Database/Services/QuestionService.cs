using PPT.Database.Entities;
using PPT.Database.Repositories;
using System;
using System.Collections.Generic;
using System.Text;

namespace PPT.Database.Services
{
    public class QuestionService : IQuestionRepository
    {
        private ExamContext _context;

        public QuestionService(ExamContext context)
        {
            _context = context;
        }

        public void CreatePart(QuestionEntity questionEntity, int examId)
        {
            _context.Questions.Add(questionEntity);
            if (Save())
            {
                ExamQuestionEntity examQuestion = new ExamQuestionEntity();
                examQuestion.ExamId = examId;
                examQuestion.QuestionId = questionEntity.QuestionId;
                _context.ExamQuestions.Add(examQuestion);
            }
        }

        public bool Save()
        {
            return (_context.SaveChanges() >= 0);
        }
    }
}
