using PPT.Database.Entities;
using System;
using System.Collections.Generic;
using System.Text;

namespace PPT.Database.Repositories
{
    public interface IHistoryRepository
    {
        void CreateHistory(HistoryEntity historyEntity);
        bool Save();
        bool CheckAccount(int accountId, int examId);
        List<HistoryEntity> getHistoryByAccount(int accountId);
    }
}
