using PPT.Database.Entities;
using System;
using System.Collections.Generic;
using System.Text;
using PPT.Database.Services;

namespace PPT.Database.Common
{
    public class Pagging 
    {
        public static List<QuestionEntity> GetQuestions(int page, List<QuestionEntity> questionEntities)
        {
            List<QuestionEntity> questionsList = new List<QuestionEntity>();
            int start = (page - 1) * 3;
            for (int i = start; i < start + 3; i++)
            {
                questionsList.Add(questionEntities[i]);
            }
            return questionsList;
        }
    }
}
