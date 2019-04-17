using PPT.Database.Entities;
using PPT.Database.Repositories;
using System;
using System.Collections.Generic;
using System.Text;
using System.Linq;

namespace PPT.Database.Services
{
    public class CommentService : ICommentRepository
    {
        private ExamContext _context;

        public CommentService(ExamContext context)
        {
            _context = context;
        }

        public void CreateComment(CommentEntity commentEntity)
        {
            _context.Comments.Add(commentEntity);
        }

        public List<CommentEntity> GetCommentByExamId(int examId)
        {
            return _context.Comments.Where(c => c.ExamId == examId).OrderByDescending(c => c.DateTimeComment).ToList();
        }

        public bool Save()
        {
            return (_context.SaveChanges() >= 0);
        }
    }
}
