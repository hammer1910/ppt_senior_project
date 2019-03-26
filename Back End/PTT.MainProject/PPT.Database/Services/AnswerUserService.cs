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
            _context.AnswerUsers.Add(answerUserEntity);
        }

        public bool Save()
        {
            return (_context.SaveChanges() >= 0);
        }
    }
}
