using PPT.Database.Entities;
using System;
using System.Collections.Generic;
using System.Text;

namespace PPT.Database.Repositories
{
    public interface ICommentRepository
    {
        void CreateComment(CommentEntity commentEntity);
        bool Save();
        List<CommentEntity> GetCommentByExamId(int examId);
    }
}
