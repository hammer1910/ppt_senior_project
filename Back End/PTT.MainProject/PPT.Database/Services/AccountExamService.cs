using PPT.Database.Entities;
using PPT.Database.Repositories;
using System;
using System.Collections.Generic;
using System.Text;
using System.Linq;

namespace PPT.Database.Services
{
    public class AccountExamService : IAccountExamRepository
    {
        private ExamContext _context;

        public AccountExamService(ExamContext context)
        {
            _context = context;
        }
        public void CreateAccountExam(AccountExamEntity accountExamEntity)
        {
            _context.AccountExams.Add(accountExamEntity);
        }

        public List<AccountExamEntity> GetAccountExamByAccountId(int accountId)
        {
            return _context.AccountExams.Where(c => c.AccountId == accountId).ToList();
        }

        public AccountExamEntity GetByAccountIdAndExamId(int accountId, int examId)
        {
            return _context.AccountExams.FirstOrDefault(c => c.AccountId == accountId && c.ExamId == examId);
        }

        public List<AccountExamEntity> GetListAccountExamByExamId(int examId)
        {
            return _context.AccountExams.Where(c => c.ExamId == examId).ToList();
        }

        public bool Save()
        {
            return (_context.SaveChanges() >= 0);
        }
    }
}
