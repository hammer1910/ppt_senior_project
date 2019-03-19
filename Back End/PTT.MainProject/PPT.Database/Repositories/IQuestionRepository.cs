using PPT.Database.Entities;
using System;
using System.Collections.Generic;
using System.Text;

namespace PPT.Database.Repositories
{
    public interface IQuestionRepository
    {
        void CreatePart(QuestionEntity questionEntity, int examId);
        bool Save();
        QuestionEntity getQuestionInformation(int questionId);
        void DeleteQuestion(int questionId);
    }
}
