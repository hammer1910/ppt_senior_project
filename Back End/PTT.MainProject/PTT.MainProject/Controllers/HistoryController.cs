using Microsoft.AspNetCore.Mvc;
using PPT.Database.Common;
using PPT.Database.Entities;
using PPT.Database.Repositories;
using PPT.Database.ResultObject;
using PPT.Database.Services;
using PTT.MainProject.Log;
using System;
using System.Collections.Generic;
using System.Linq;
using System.Threading.Tasks;

namespace PTT.MainProject.Controllers
{
    [Route("api/exam")]
    public class HistoryController : Controller
    {
        private IHistoryRepository _historyRepository;
        private IAccountRepository _accountRepository;
        private IExamRepository _examRepository;
        private IGroupRepository _groupRepository;

        private static string className = System.Reflection.MethodBase.GetCurrentMethod().DeclaringType.Name;

        public HistoryController(IHistoryRepository historyRepository, IAccountRepository accountRepository, 
            IExamRepository examRepository, IGroupRepository groupRepository)
        {
            _historyRepository = historyRepository;
            _accountRepository = accountRepository;
            _examRepository = examRepository;
            _groupRepository = groupRepository;
            Log4Net.InitLog();
        }

        /// <summary>
        /// Get information history function
        /// </summary>
        /// <param name="accountId">Get id account on the url</param> 
        /// <response code="200">
        /// [
        ///  {
        ///    "nameExam": "Exam 1",
        ///    "nameGroup": "English 2"
        ///  },
        ///  {
        ///    "nameExam": "Exam 1",
        ///    "nameGroup": "English 2"
        ///  }
        /// ]
        /// </response>
        [HttpGet("getinformationhistory/{accountId}")]
        public JsonResult GetInformationAccount(int accountId)
        {
            string functionName = System.Reflection.MethodBase.GetCurrentMethod().Name;

            try
            {
                //Check id account exist in the database
                if (!_accountRepository.AccountExists(accountId))
                {
                    Log4Net.log.Error(className + "." + functionName + " - " + Log4Net.AddErrorLog(Constants.accountNotFound));
                    return Json(MessageResult.GetMessage(MessageType.ACCOUNT_NOT_FOUND));
                }

                if (!ModelState.IsValid)
                {
                    Log4Net.log.Error(className + "." + functionName + " - " + Log4Net.AddErrorLog(Constants.notFound));
                    return Json(MessageResult.GetMessage(MessageType.NOT_FOUND));
                }

                //Get list all history by id account
                List<HistoryEntity> list = _historyRepository.getHistoryByAccount(accountId);

                List<HistoryResult> listResult = new List<HistoryResult>();

                foreach (var history in list)
                {
                    HistoryResult result = new HistoryResult();
                    ExamEntity exam = _examRepository.GetExamById(history.ExamId);
                    GroupEntity group = _groupRepository.GetGroupById(history.GroupId);
                    result.nameExam = exam.Name;
                    result.nameGroup = group.Name;

                    listResult.Add(result);
                }

                return Json(listResult);
            }
            catch (Exception ex)
            {
                Log4Net.log.Error(className + "." + functionName + " - " + Log4Net.AddErrorLog(ex.Message));
                return Json(MessageResult.ShowServerError(ex.Message));
            }

        }
    }
}
