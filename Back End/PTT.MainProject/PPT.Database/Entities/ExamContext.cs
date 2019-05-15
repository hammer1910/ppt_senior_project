using Microsoft.EntityFrameworkCore;
using System;
using System.Collections.Generic;
using System.Text;

namespace PPT.Database.Entities
{
    public class ExamContext : DbContext
    {
        public ExamContext(DbContextOptions<ExamContext> options) : base(options)
        {
            Database.Migrate();
        }

        public DbSet<AccountEntity> Accounts { get; set; }
        public DbSet<AccountRoleEntity> AccountRoles { get; set; }
        public DbSet<AnswerUserEntity> AnswerUsers { get; set; }
        public DbSet<ExamEntity> Exams { get; set; }
        public DbSet<ExamQuestionEntity> ExamQuestions { get; set; }
        public DbSet<GroupEntity> Groups { get; set; }
        public DbSet<GroupMemberEntity> GroupMembers { get; set; }
        public DbSet<GroupOwnerEntity> GroupOwners { get; set; }
        public DbSet<HistoryEntity> Histories { get; set; }
        public DbSet<NotificationEntity> Notifications { get; set; }
        public DbSet<QuestionEntity> Questions { get; set; }
        public DbSet<RoleEntity> Roles { get; set; }
        public DbSet<CommentEntity> Comments { get; set; }
        public DbSet<AccountExamEntity> AccountExams { get; set; }
    }
}
