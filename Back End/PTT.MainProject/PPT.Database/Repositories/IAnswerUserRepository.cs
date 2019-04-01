using PPT.Database.Entities;
using System;
using System.Collections.Generic;
using System.Text;

namespace PPT.Database.Repositories
{
    public interface IAnswerUserRepository
    {
        void CreateAnswerUser(AnswerUserEntity answerUserEntity);
        bool Save();
        List<AnswerUserEntity> GetAnswerUserEntities(int accountId);
        AnswerUserEntity GetAnswerUserByQuestionId(int questionId);
        List<AnswerUserEntity> GetAnswerUsers();
    }
}
