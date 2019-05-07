using PPT.Database.Entities;
using PPT.Database.Repositories;
using System;
using System.Linq;
using System.Collections.Generic;
using System.Text;

namespace PPT.Database.Services
{
    public class ExamService : IExamRepository
    {
        private ExamContext _context;

        public ExamService(ExamContext context)
        {
            _context = context;
        }

        public void CreateExam(ExamEntity examEntity)
        {
            _context.Exams.Add(examEntity);
        }

        public void DeleteExam(ExamEntity exam)
        {
            _context.Exams.Remove(exam);
        }

        public bool ExamExist(int examId)
        {
            return _context.Exams.Any(e => e.ExamId == examId);
        }

        public ExamEntity GetExamById(int examId)
        {
            return _context.Exams.Where(e => e.ExamId == examId).FirstOrDefault();
        }

        public List<ExamEntity> GetListExamByGroupId(int groupId)
        {
            return _context.Exams.Where(e => e.GroupId == groupId).ToList();
        }

        public bool Save()
        {
            return  (_context.SaveChanges() >= 0);
        }
    }
}
