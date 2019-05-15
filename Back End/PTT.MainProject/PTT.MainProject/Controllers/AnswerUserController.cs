using AutoMapper;
using Microsoft.AspNetCore.Mvc;
using PPT.Database.Common;
using PPT.Database.Entities;
using PPT.Database.Models;
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
    public class AnswerUserController : Controller
    {
        private IAccountExamRepository _accountExamRepository;
        private IExamRepository _examRepository;
        private IQuestionRepository _questionRepository;
        private IExamQuestionRepository _examQuestionRepository;
        private IAnswerUserRepository _answerUserRepository;
        private IAccountRepository _accountRepository;
        private IHistoryRepository _historyRepository;
        private IGroupRepository _groupRepository;
        private static string className = System.Reflection.MethodBase.GetCurrentMethod().DeclaringType.Name;

        public AnswerUserController(IAccountExamRepository accountExamRepository, IExamRepository examRepository, IQuestionRepository questionRepository, IHistoryRepository historyRepository,
            IExamQuestionRepository examQuestionRepository, IAnswerUserRepository answerUserRepository, IAccountRepository accountRepository, IGroupRepository groupRepository)
        {
            _accountExamRepository = accountExamRepository;
            _examRepository = examRepository;
            _questionRepository = questionRepository;
            _examQuestionRepository = examQuestionRepository;
            _answerUserRepository = answerUserRepository;
            _accountRepository = accountRepository;
            _historyRepository = historyRepository;
            _groupRepository = groupRepository;
            Log4Net.InitLog();
        }              

        /// <summary>
        /// The compare function
        /// </summary>
        /// <param name="examId">Get id exam on the url</param> 
        /// <param name="accountId">Get id account on the url</param>
        /// <param name="anotherAccountId">Get another id account on the url</param>
        /// <response code="200">
        /// [
        ///  {
        ///   "quetionNumber": 1,
        ///   "answerUser": "a",
        ///   "finalAnswer": "A",
        ///   "answerAnother": "b"
        ///  },
        ///  {
        ///   "quetionNumber": 2,
        ///   "answerUser": "a",
        ///   "finalAnswer": "B",
        ///   "answerAnother": "a"
        ///  },
        ///  {
        ///   "quetionNumber": 3,
        ///   "answerUser": "a",
        ///   "finalAnswer": "C",
        ///   "answerAnother": "b"
        ///  }
        /// ]
        /// </response>
        [HttpGet("{accountId}/{examId}/getanswerkeyandcorrectanswer/{anotherAccountId}")]
        public JsonResult GetAnswerKeyAndCorrectAnswer(int examId, int accountId, int anotherAccountId)
        {
            string functionName = System.Reflection.MethodBase.GetCurrentMethod().Name;

            try
            {
                if (!_accountRepository.AccountExists(accountId))
                {
                    Log4Net.log.Error(className + "." + functionName + " - " + Log4Net.AddErrorLog(Constants.accountNotFound));
                    return Json(MessageResult.GetMessage(MessageType.ACCOUNT_NOT_FOUND));
                }

                if (!_examRepository.ExamExist(examId))
                {
                    Log4Net.log.Error(className + "." + functionName + " - " + Log4Net.AddErrorLog(Constants.examNotFound));
                    return Json(MessageResult.GetMessage(MessageType.EXAM_NOT_FOUND));
                }

                if (!ModelState.IsValid)
                {
                    Log4Net.log.Error(className + "." + functionName + " - " + Log4Net.AddErrorLog(Constants.notFound));
                    return Json(MessageResult.GetMessage(MessageType.NOT_FOUND));
                }

                List<ExamQuestionEntity> examQuestionEntity = _examQuestionRepository.getListQuestions(examId);

                List<QuestionEntity> listQuestionEntities = new List<QuestionEntity>();
                foreach (var examQuestion in examQuestionEntity)
                {
                    // Get all informations of the question by questionId and save it in the list
                    QuestionEntity questionEntity = _questionRepository.getQuestionInformation(examQuestion.QuestionId);
                    listQuestionEntities.Add(questionEntity);
                }

                List<AnswerUserEntity> answerUserEntities = _answerUserRepository.GetAnswerUserEntities(accountId);

                List<AnswerUserResult> answerUserResults = new List<AnswerUserResult>();

                if (anotherAccountId <= 0)
                {
                    foreach (var examQuestion in listQuestionEntities)
                    {
                        foreach (var item in answerUserEntities)
                        {
                            if (item.QuestionId == examQuestion.QuestionId)
                            {
                                AnswerUserResult answerUser = new AnswerUserResult();
                                answerUser.part = examQuestion.Part;
                                answerUser.quetionNumber = examQuestion.QuestionNumber;
                                answerUser.answerUser = item.AnswerKey.ToUpper();
                                answerUser.finalAnswer = examQuestion.CorrectAnswer.ToUpper();
                                
                                answerUserResults.Add(answerUser);
                            }
                        }
                    }
                }
                else if (anotherAccountId > 0)
                {
                    List<AnswerUserEntity> anotherAccount = _answerUserRepository.GetAnswerUserEntities(anotherAccountId);
                    AccountEntity nameAnother = _accountRepository.GetAccountById(anotherAccountId);
                    foreach (var examQuestion in listQuestionEntities)
                    {
                        foreach (var item in answerUserEntities)
                        {
                            foreach (var another in anotherAccount)
                            {
                                if (item.QuestionId == examQuestion.QuestionId && another.QuestionId == examQuestion.QuestionId)
                                {
                                    AnswerUserResult answerUser = new AnswerUserResult();
                                    answerUser.part = examQuestion.Part;
                                    answerUser.nameAnother = nameAnother.FullName;
                                    answerUser.quetionNumber = examQuestion.QuestionNumber;
                                    answerUser.answerUser = item.AnswerKey.ToUpper();
                                    answerUser.finalAnswer = examQuestion.CorrectAnswer.ToUpper();
                                    answerUser.answerAnother = another.AnswerKey.ToUpper();
                                    
                                    if (!item.AnswerKey.Equals(another.AnswerKey))
                                    {
                                        answerUser.status = "uncorrect";
                                    }
                                    
                                    answerUserResults.Add(answerUser);
                                }
                            }
                        }

                    }
                }                                             

                return Json(answerUserResults.OrderBy(a => a.quetionNumber));
            }
            catch (Exception ex)
            {
                Log4Net.log.Error(className + "." + functionName + " - " + Log4Net.AddErrorLog(ex.Message));
                return Json(MessageResult.ShowServerError(ex.Message));
            }

        }

        /// <summary>
        /// Get list account finished exam function
        /// </summary>
        /// <param name="accountId">Get id account on the url</param> 
        /// <param name="examId">Get id exam on the url</param> 
        /// <response code="200">  
        /// [
        ///  {
        ///   "accountId": 42,
        ///   "name": "Nguyễn Văn Dũng"
        ///  }
        /// ]
        /// </response>
        [HttpGet("getListAccountFinishExam/{accountId}/{examId}")]
        public JsonResult GetListQuestionByPart(int examId, int accountId)
        {
            string functionName = System.Reflection.MethodBase.GetCurrentMethod().Name;

            try
            {
                if (!_examRepository.ExamExist(examId))
                {
                    Log4Net.log.Error(className + "." + functionName + " - " + Log4Net.AddErrorLog(Constants.groupNotFound));
                    return Json(MessageResult.GetMessage(MessageType.GROUP_NOT_FOUND));
                }

                if (!ModelState.IsValid)
                {
                    Log4Net.log.Error(className + "." + functionName + " - " + Log4Net.AddErrorLog(Constants.notFound));
                    return Json(MessageResult.GetMessage(MessageType.NOT_FOUND));
                }

                //This is get all account exam of the exam by id exam
                List<AccountExamEntity> listAccountExamEntity = _accountExamRepository.GetListAccountExamByExamId(examId);

                List<AccountFinishExam> accountFinishExams = new List<AccountFinishExam>();

                foreach (var item in listAccountExamEntity)
                {
                    if (item.IsStatus.Equals("Finish"))
                    {
                        AccountEntity accountEntity = _accountRepository.GetAccountById(item.AccountId);
                        AccountFinishExam accountFinishExam = new AccountFinishExam();
                        accountFinishExam.accountId = accountEntity.AccountId;
                        accountFinishExam.name = accountEntity.FullName;
                        accountFinishExams.Add(accountFinishExam);
                    }
                }

                accountFinishExams = accountFinishExams.Where(a => a.accountId != accountId).ToList();

                return Json(accountFinishExams);
            }
            catch (Exception ex)
            {
                Log4Net.log.Error(className + "." + functionName + " - " + Log4Net.AddErrorLog(ex.Message));
                return Json(MessageResult.ShowServerError(ex.Message));
            }
        }

        /// <summary>
        /// Add answer of the user function
        /// </summary>
        /// <param name="answerUserModel">The information answer of user from body</param> 
        /// <response code="200">You added answer of user successfully!</response>
        [HttpPost("createansweruser")]
        public JsonResult CreateAnswerUser([FromBody] AnswerUserModel answerUserModel)
        {
            string functionName = System.Reflection.MethodBase.GetCurrentMethod().Name;

            try
            {
                //Check value enter from the form 
                if (answerUserModel == null)
                {
                    Log4Net.log.Error(className + "." + functionName + " - " + Log4Net.AddErrorLog(Constants.notInformationQuestion));
                    return Json(MessageResult.GetMessage(MessageType.NOT_INFORMATION_QUESTION));
                }

                if (!_accountRepository.AccountExists(answerUserModel.accountId))
                {
                    Log4Net.log.Error(className + "." + functionName + " - " + Log4Net.AddErrorLog(Constants.accountNotFound));
                    return Json(MessageResult.GetMessage(MessageType.ACCOUNT_NOT_FOUND));
                }

                if (!_examRepository.ExamExist(answerUserModel.examId))
                {
                    Log4Net.log.Error(className + "." + functionName + " - " + Log4Net.AddErrorLog(Constants.examNotFound));
                    return Json(MessageResult.GetMessage(MessageType.EXAM_NOT_FOUND));
                }

                if (!ModelState.IsValid)
                {
                    Log4Net.log.Error(className + "." + functionName + " - " + Log4Net.AddErrorLog(Constants.notFound));
                    return Json(MessageResult.GetMessage(MessageType.NOT_FOUND));
                }
                //get list answer user from form
                List<AnswerUserDto> answersFromForm = answerUserModel.listAnswerUser;
                //get all list question from the examId
                List<ExamQuestionEntity> examQuestionEntity = _examQuestionRepository.getListQuestions(answerUserModel.examId);
                //get all answer user of this account
                List<AnswerUserEntity> answerUsersFromDB = _answerUserRepository.GetAnswerUserEntities(answerUserModel.accountId);

                //if this account haven't ever do the exam. newAccountAnswer will store it
                List<AnswerUserDto> newAccountAnswer = new List<AnswerUserDto>();
                //list answer of this account from DB
                List<AnswerUserDto> oldAccountUser = new List<AnswerUserDto>();


                // divide between old and new answer
                foreach (var answer in answersFromForm)
                {
                    foreach (var item in answerUsersFromDB)
                    {
                        if (answer.questionId == item.QuestionId)
                        {
                            oldAccountUser.Add(answer);
                        }
                    }
                }
                newAccountAnswer = answersFromForm;

                if (oldAccountUser.Count() > 0)
                {
                    // remove old answer
                    for (int i = 0; i < answersFromForm.Count; i++)
                    {
                        foreach (var item in oldAccountUser)
                        {
                            if (item == answersFromForm[i])
                            {
                                answersFromForm.Remove(answersFromForm[i]);
                            }
                        }
                    }

                    foreach (var examQuestion in examQuestionEntity)
                    {
                        foreach (var answer in newAccountAnswer)
                        {
                            if (examQuestion.QuestionId == answer.questionId)
                            {
                                //Map data enter from the form to question entity
                                var answerUser = Mapper.Map<PPT.Database.Entities.AnswerUserEntity>(answer);
                                answerUser.AccountId = answerUserModel.accountId;
                                //This is query insert question
                                _answerUserRepository.CreateAnswerUser(answerUser);

                            }

                        }
                    }

                    foreach (var answer in oldAccountUser)
                    {
                        foreach (var answerU in answerUsersFromDB)
                        {
                            if (answerU.QuestionId == answer.questionId)
                            {
                                answerU.AnswerKey = answer.answerKey;
                            }
                        }
                    }
                }
                //this function shows that user haven't ever done this exam. This is the first time they do it.

                else
                {
                    //1 -> 14
                    foreach (var examQuestion in examQuestionEntity)
                    {
                        //1 -> 2
                        foreach (var answer in newAccountAnswer)
                        {
                            if (examQuestion.QuestionId == answer.questionId)
                            {
                                //Map data enter from the form to question entity
                                var answerUser = Mapper.Map<PPT.Database.Entities.AnswerUserEntity>(answer);
                                answerUser.AccountId = answerUserModel.accountId;
                                //This is query insert question
                                _answerUserRepository.CreateAnswerUser(answerUser);
                                AccountExamEntity accountExamEntity = _accountExamRepository.GetByAccountIdAndExamId(answerUser.AccountId, examQuestion.ExamId);

                                accountExamEntity.IsStatus = "Continue Do Exam";
                                _accountExamRepository.Save();
                            }

                        }
                    }
                }
                AccountExamEntity finishExam = _accountExamRepository.GetByAccountIdAndExamId(answerUserModel.accountId, answerUserModel.examId);
                if (answerUserModel.status != null)
                {
                    finishExam.IsStatus = "Finish";
                    _accountExamRepository.Save();
                }

                //get account by Id
                AccountEntity account = _accountRepository.GetAccountById(answerUserModel.accountId);
                //get exam by Id
                ExamEntity exam = _examRepository.GetExamById(answerUserModel.examId);
                int groupId = exam.GroupId;
                //get group by Id
                GroupEntity group = _groupRepository.GetGroupById(groupId);

                if (_historyRepository.CheckAccount(account.AccountId, exam.ExamId))
                {
                    HistoryEntity history = new HistoryEntity();
                    history.AccountId = account.AccountId;
                    history.ExamId = exam.ExamId;
                    history.Group = group;
                    _historyRepository.CreateHistory(history);
                    _historyRepository.Save();
                }

                if (!_answerUserRepository.Save())
                {
                    Log4Net.log.Error(className + "." + functionName + " - " + Log4Net.AddErrorLog(Constants.badRequest));
                    return Json(MessageResult.GetMessage(MessageType.BAD_REQUEST));
                }

                Log4Net.log.Error(className + "." + functionName + " - " + Log4Net.AddErrorLog(Constants.createdAnswerUser));
                return Json(MessageResult.GetMessage(MessageType.CREATED_ANSWER_USER));
            }
            catch (Exception ex)
            {
                Log4Net.log.Error(className + "." + functionName + " - " + Log4Net.AddErrorLog(ex.Message));
                return Json(MessageResult.ShowServerError(ex.Message));
            }

        }
    }
}
