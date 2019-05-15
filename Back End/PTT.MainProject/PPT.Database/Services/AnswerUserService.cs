using PPT.Database.Entities;
using PPT.Database.Repositories;
using System;
using System.Collections.Generic;
using System.Text;
using System.Linq;

namespace PPT.Database.Services
{
    public class AnswerUserService : IAnswerUserRepository
    {
        private ExamContext _context;

        public AnswerUserService(ExamContext context)
        {
            _context = context;
        }

        public void CreateAnswerUser(AnswerUserEntity answerUserEntity)
        {
            AnswerUserEntity answer = _context.AnswerUsers.FirstOrDefault(c => c.AccountId == answerUserEntity.AccountId && c.QuestionId == answerUserEntity.QuestionId);
            if(answer == null)
            {
                _context.AnswerUsers.Add(answerUserEntity);
            }            
        }

        public AnswerUserEntity GetAnswerUserByQuestionId(int questionId)
        {
            return _context.AnswerUsers.Where(a => a.QuestionId == questionId).FirstOrDefault();
        }

        public List<AnswerUserEntity> GetAnswerUserEntities(int accountId)
        {
            return _context.AnswerUsers.Where(c => c.AccountId == accountId).ToList();
        }

        public List<AnswerUserEntity> GetAnswerUsers()
        {
            return _context.AnswerUsers.ToList();
        }

        public bool Save()
        {
            return (_context.SaveChanges() >= 0);
        }
    }
}
