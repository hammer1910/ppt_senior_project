using PPT.Database.Entities;
using System;
using System.Collections.Generic;
using System.Text;

namespace PPT.Database.Repositories
{
    public interface IExamRepository
    {
        void CreateExam(ExamEntity examEntity);
        bool Save();
    }
}
