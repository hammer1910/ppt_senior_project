using PPT.Database.Entities;
using PPT.Database.Repositories;
using System;
using System.Collections.Generic;
using System.Text;
using System.Linq;

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

        public void DeleteQuestion(int questionId)
        {
            _context.ExamQuestions.Remove(_context.ExamQuestions.FirstOrDefault(c => c.QuestionId == questionId));
            _context.Questions.Remove(_context.Questions.FirstOrDefault(c => c.QuestionId == questionId));
        }

        public QuestionEntity getQuestionInformation(int questionId)
        {
            return _context.Questions.FirstOrDefault(q => q.QuestionId == questionId);
        }

        public bool Save()
        {
            return (_context.SaveChanges() >= 0);
        }
    }
}
