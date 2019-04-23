using PPT.Database.Entities;
using PPT.Database.Repositories;
using System;
using System.Collections.Generic;
using System.Text;
using System.Linq;

namespace PPT.Database.Services
{
    public class HistoryService : IHistoryRepository
    {
        private ExamContext _context;

        public HistoryService(ExamContext context)
        {
            _context = context;
        }

        public bool CheckAccount(int accountId, int examId)
        {
            HistoryEntity history = _context.Histories.FirstOrDefault(c => c.AccountId == accountId  && c.ExamId == examId);
            if (history == null)
            {
                return true;
            }

            return false;
        }

        public void CreateHistory(HistoryEntity historyEntity)
        {
            _context.Histories.Add(historyEntity);
        }

        public List<HistoryEntity> getHistoryByAccount(int accountId)
        {
            return _context.Histories.ToList();
        }

        public bool Save()
        {
            return (_context.SaveChanges() >= 0);
        }
    }
}
