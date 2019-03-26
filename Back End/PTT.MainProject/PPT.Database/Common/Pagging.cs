using PPT.Database.Entities;
using System;
using System.Collections.Generic;
using System.Text;
using PPT.Database.Services;
using PPT.Database.ResultObject;

namespace PPT.Database.Common
{
    public class Pagging 
    {
        public static List<QuestionListResult> GetQuestions(int page, List<QuestionListResult> questionEntities)
        {
            List<QuestionListResult> questionsList = new List<QuestionListResult>();
            int start = (page - 1) * 5;
            int total = start + 5;
            int s = total - questionEntities.Count;
            int d = total - s;
            if (total > questionEntities.Count)
            {
                for(int i = start; i < d; i++)
                {
                    questionsList.Add(questionEntities[i]);
                }
            }
            else
            {
                for (int i = start; i < start + 5; i++)
                {
                    questionsList.Add(questionEntities[i]);
                }

            }
            
            return questionsList;
        }
    }
}
