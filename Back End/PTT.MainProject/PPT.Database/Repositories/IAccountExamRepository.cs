using PPT.Database.Entities;
using System;
using System.Collections.Generic;
using System.Text;

namespace PPT.Database.Repositories
{
    public interface IAccountExamRepository
    {
        void CreateAccountExam(AccountExamEntity accountExamEntity);
        bool Save();
        List<AccountExamEntity> GetListAccountExamByExamId(int examId);
        AccountExamEntity GetByAccountIdAndExamId(int accountId, int examId);
        List<AccountExamEntity> GetAccountExamByAccountId(int accountId);
    }
}
