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
    public class QuestionController : Controller
    {
        private IAccountRepository _accountRepository;
        private IAnswerUserRepository _answerUserRepository;
        private IExamRepository _examRepository;
        private IQuestionRepository _questionRepository;
        private IExamQuestionRepository _examQuestionRepository;
        private static string className = System.Reflection.MethodBase.GetCurrentMethod().DeclaringType.Name;

        public QuestionController(IAccountRepository accountRepository,IAnswerUserRepository answerUserRepository,IExamRepository examRepository, IQuestionRepository questionRepository, IExamQuestionRepository examQuestionRepository)
        {
            _accountRepository = accountRepository;
            _examRepository = examRepository;
            _questionRepository = questionRepository;
            _examQuestionRepository = examQuestionRepository;
            _answerUserRepository = answerUserRepository;
            Log4Net.InitLog();
        }

        /// <summary>
        /// Create exam function
        /// </summary>
        /// <param name="question">The information of question from body</param>  
        [HttpPost("createquestion")]
        public JsonResult CreateQuestion([FromBody] QuestionDto question)
        {
            string functionName = System.Reflection.MethodBase.GetCurrentMethod().Name;

            try
            {
                if (question == null)
                {
                    Log4Net.log.Error(className + "." + functionName + " - " + Log4Net.AddErrorLog(Constants.notInformationQuestion));
                    return Json(MessageResult.GetMessage(MessageType.NOT_INFORMATION_QUESTION));
                }

                if (!_examRepository.ExamExist(question.examId))
                {
                    Log4Net.log.Error(className + "." + functionName + " - " + Log4Net.AddErrorLog(Constants.examNotFound));
                    return Json(MessageResult.GetMessage(MessageType.EXAM_NOT_FOUND));
                }

                if (!ModelState.IsValid)
                {
                    Log4Net.log.Error(className + "." + functionName + " - " + Log4Net.AddErrorLog(Constants.notFound));
                    return Json(MessageResult.GetMessage(MessageType.NOT_FOUND));
                }

                //Map data enter from the form to question entity
                var partOneExam = Mapper.Map<PPT.Database.Entities.QuestionEntity>(question);

                //This is query insert question
                _questionRepository.CreatePart(partOneExam, question.examId);

                if (!_questionRepository.Save())
                {
                    Log4Net.log.Error(className + "." + functionName + " - " + Log4Net.AddErrorLog(Constants.badRequest));
                    return Json(MessageResult.GetMessage(MessageType.BAD_REQUEST));
                }

                Log4Net.log.Error(className + "." + functionName + " - " + Log4Net.AddErrorLog(Constants.createdQuestion));
                return Json(MessageResult.GetMessage(MessageType.CREATED_QUESTION));
            }
            catch(Exception ex)
            {
                Log4Net.log.Error(className + "." + functionName + " - " + Log4Net.AddErrorLog(ex.Message));
                return Json(MessageResult.ShowServerError(ex.Message));
            }            
        }

        /// <summary>
        /// Get all questions of the exam function
        /// </summary>
        /// <param name="accountId">Get id account on the url</param>
        /// <param name="examId">Get id exam on the url</param> 
        /// <param name="page">Get page parameter on the url</param> 
        [HttpGet("{accountId}/{examId}/getListQuestion/{page}")]
        public JsonResult GetListQuestion(int accountId, int examId, int page)
        {
            string functionName = System.Reflection.MethodBase.GetCurrentMethod().Name;

            try
            {
                if (!_accountRepository.AccountExists(accountId))
                {
                    Log4Net.log.Error(className + "." + functionName + " - " + Log4Net.AddErrorLog(Constants.accountNotFound));
                    return Json(MessageResult.GetMessage(MessageType.ACCOUNT_NOT_FOUND));
                }

                //Check id exam exist in the database
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

                //This is get all questions of the exam by id exam
                List<ExamQuestionEntity> examQuestionEntity = _examQuestionRepository.getListQuestions(examId);
                List<AnswerUserEntity> answerUsers = _answerUserRepository.GetAnswerUserEntities(accountId);

                List<QuestionEntity> listQuestionEntities = new List<QuestionEntity>();
                foreach (var examQuestion in examQuestionEntity)
                {
                    // Get all informations of the question by questionId and save it in the list
                    QuestionEntity questionEntity = _questionRepository.getQuestionInformation(examQuestion.QuestionId);
                    listQuestionEntities.Add(questionEntity);
                }

                List<QuestionListResult> questionLists = new List<QuestionListResult>();
                foreach (var item in listQuestionEntities)
                {
                    QuestionListResult q = new QuestionListResult();
                    q.questionId = item.QuestionId;
                    q.part = item.Part;
                    q.image = item.Image;
                    q.fileMp3 = item.FileMp3;
                    q.questionName = item.QuestionName;
                    q.A = item.A;
                    q.B = item.B;
                    q.C = item.C;
                    q.D = item.D;
                    q.correctAnswer = item.CorrectAnswer;
                    q.team = item.Team;
                    foreach (var answer in answerUsers)
                    {
                        if (q.questionId == answer.QuestionId)
                        {
                            q.answerUser = answer.AnswerKey;
                        }
                    }
                    questionLists.Add(q);
                }

                List<QuestionListResult> pagging = Pagging.GetQuestions(page, questionLists);

                return Json(pagging);
            }
            catch(Exception ex)
            {
                Log4Net.log.Error(className + "." + functionName + " - " + Log4Net.AddErrorLog(ex.Message));
                return Json(MessageResult.ShowServerError(ex.Message));
            }
            
        }

        /// <summary>
        /// Get all questions by part of the exam function
        /// </summary>
        /// <param name="examId">Get id exam on the url</param> 
        /// <param name="part">Get part parameter on the url</param> 
        [HttpGet("{examId}/getListQuestionByPart/{part}")]
        public JsonResult GetListQuestionByPart(int examId, string part)
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

                //This is get all questions of the exam by id exam
                List<ExamQuestionEntity> examQuestionEntity = _examQuestionRepository.getListQuestions(examId);

                List<QuestionEntity> listQuestionEntities = new List<QuestionEntity>();
                foreach (var examQuestion in examQuestionEntity)
                {
                    // Get all informations of the question by questionId and save it in the list
                    QuestionEntity questionEntity = _questionRepository.getQuestionInformation(examQuestion.QuestionId);
                    listQuestionEntities.Add(questionEntity);
                }

                List<QuestionListResult> questionLists = new List<QuestionListResult>();
                foreach (var item in listQuestionEntities)
                {
                    QuestionListResult q = new QuestionListResult();
                    if (item.Part.Equals(part))
                    {
                        q.questionId = item.QuestionId;
                        q.part = item.Part;
                        q.image = item.Image;
                        q.fileMp3 = item.FileMp3;
                        q.questionName = item.QuestionName;
                        q.A = item.A;
                        q.B = item.B;
                        q.C = item.C;
                        q.D = item.D;
                        q.correctAnswer = item.CorrectAnswer;
                        q.team = item.Team;
                        questionLists.Add(q);
                    }

                }

                return Json(questionLists);
            }
            catch(Exception ex)
            {
                Log4Net.log.Error(className + "." + functionName + " - " + Log4Net.AddErrorLog(ex.Message));
                return Json(MessageResult.ShowServerError(ex.Message));
            }            
        }

        /// <summary>
        /// Get all informations of the question function
        /// </summary>
        /// <param name="examId">Get id exam on the url</param> 
        /// <param name="questionId">Get id question on the url</param>
        [HttpGet("{examId}/getQuestionInformation/{questionId}")]
        public JsonResult GetInformationGroup(int examId,int questionId)
        {
            string functionName = System.Reflection.MethodBase.GetCurrentMethod().Name;

            try
            {
                //Check id exam exist in the database
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
                QuestionEntity question = null;
                //This is get all information of the exam by examId
                List<ExamQuestionEntity> examQuestionEntity = _examQuestionRepository.getListQuestions(examId);

                QuestionListResult questionListResult = new QuestionListResult();
                foreach (var examQuestion in examQuestionEntity)
                {
                    if (examQuestion.QuestionId == questionId)
                    {
                        question = _questionRepository.getQuestionInformation(questionId);
                        break;
                    }
                }

                questionListResult.questionId = question.QuestionId;
                questionListResult.part = question.Part;
                questionListResult.image = question.Image;
                questionListResult.fileMp3 = question.FileMp3;
                questionListResult.questionName = question.QuestionName;
                questionListResult.A = question.A;
                questionListResult.B = question.B;
                questionListResult.C = question.C;
                questionListResult.D = question.D;
                questionListResult.correctAnswer = question.CorrectAnswer;
                questionListResult.team = question.Team;

                return Json(questionListResult);
            }
            catch (Exception ex)
            {
                Log4Net.log.Error(className + "." + functionName + " - " + Log4Net.AddErrorLog(ex.Message));
                return Json(MessageResult.ShowServerError(ex.Message));
            }
            
        }

        /// <summary>
        /// Update information group function
        /// </summary>
        /// <param name="question">The question information from body</param>
        [HttpPut("updatequestion")]
        public JsonResult UpdateInformationQuestion([FromBody] QuestionDto question)
        {
            string functionName = System.Reflection.MethodBase.GetCurrentMethod().Name;

            try
            {
                //Check id exam exist in the database
                if (!_examRepository.ExamExist(question.examId))
                {
                    Log4Net.log.Error(className + "." + functionName + " - " + Log4Net.AddErrorLog(Constants.examNotFound));
                    return Json(MessageResult.GetMessage(MessageType.EXAM_NOT_FOUND));
                }

                //Check value enter from the form 
                if (question == null)
                {
                    Log4Net.log.Error(className + "." + functionName + " - " + Log4Net.AddErrorLog(Constants.notInformationQuestion));
                    return Json(MessageResult.GetMessage(MessageType.NOT_INFORMATION_QUESTION));
                }

                if (!ModelState.IsValid)
                {
                    Log4Net.log.Error(className + "." + functionName + " - " + Log4Net.AddErrorLog(Constants.badRequest));
                    return Json(MessageResult.GetMessage(MessageType.BAD_REQUEST));
                }

                QuestionEntity questionEntity = null;
                //This is get all information of the exam by examId
                List<ExamQuestionEntity> examQuestionEntity = _examQuestionRepository.getListQuestions(question.examId);

                foreach (var examQuestion in examQuestionEntity)
                {
                    if (examQuestion.QuestionId == question.questionId)
                    {
                        questionEntity = _questionRepository.getQuestionInformation(question.questionId);
                    }
                }

                if (questionEntity == null)
                {
                    Log4Net.log.Error(className + "." + functionName + " - " + Log4Net.AddErrorLog(Constants.examNotFound));
                    return Json(MessageResult.GetMessage(MessageType.EXAM_NOT_FOUND));
                }

                //Map data enter from the form to question entity
                Mapper.Map(question, questionEntity);

                if (!_questionRepository.Save())
                {
                    Log4Net.log.Error(className + "." + functionName + " - " + Log4Net.AddErrorLog(Constants.badRequest));
                    return Json(MessageResult.GetMessage(MessageType.BAD_REQUEST));
                }

                Log4Net.log.Error(className + "." + functionName + " - " + Log4Net.AddErrorLog(Constants.questionUpdated));
                return Json(MessageResult.GetMessage(MessageType.QUESTION_UPDATED));
            }
            catch(Exception ex)
            {
                Log4Net.log.Error(className + "." + functionName + " - " + Log4Net.AddErrorLog(ex.Message));
                return Json(MessageResult.ShowServerError(ex.Message));
            }
            
        }

        /// <summary>
        /// Delete question by owner function
        /// </summary>
        /// <param name="examId">Get id exam on the url</param> 
        /// <param name="questionId">Get id question on the url</param>
        [HttpDelete("{examId}/deletequestion/{questionId}")]
        public JsonResult DeleteQuestion(int examId, int questionId)
        {
            string functionName = System.Reflection.MethodBase.GetCurrentMethod().Name;

            try
            {
                //Check id exam exist in the database
                if (!_examRepository.ExamExist(examId))
                {
                    Log4Net.log.Error(className + "." + functionName + " - " + Log4Net.AddErrorLog(Constants.examNotFound));
                    return Json(MessageResult.GetMessage(MessageType.EXAM_NOT_FOUND));
                }

                if (!ModelState.IsValid)
                {
                    Log4Net.log.Error(className + "." + functionName + " - " + Log4Net.AddErrorLog(Constants.badRequest));
                    return Json(MessageResult.GetMessage(MessageType.BAD_REQUEST));
                }

                QuestionEntity question = null;
                //This is get all information of the exam by examId
                List<ExamQuestionEntity> examQuestionEntity = _examQuestionRepository.getListQuestions(examId);

                foreach (var examQuestion in examQuestionEntity)
                {
                    if (examQuestion.QuestionId == questionId)
                    {
                        question = _questionRepository.getQuestionInformation(questionId);
                    }
                }

                if (question == null)
                {
                    Log4Net.log.Error(className + "." + functionName + " - " + Log4Net.AddErrorLog(Constants.questionNotFound));
                    return Json(MessageResult.GetMessage(MessageType.QUESTION_NOT_FOUND));
                }

                _questionRepository.DeleteQuestion(question.QuestionId);

                if (!_questionRepository.Save())
                {
                    Log4Net.log.Error(className + "." + functionName + " - " + Log4Net.AddErrorLog(Constants.badRequest));
                    return Json(MessageResult.GetMessage(MessageType.BAD_REQUEST));
                }

                Log4Net.log.Error(className + "." + functionName + " - " + Log4Net.AddErrorLog(Constants.questionDeleted));
                return Json(MessageResult.GetMessage(MessageType.QUESTION_DELETED));
            }
            catch(Exception ex)
            {
                Log4Net.log.Error(className + "." + functionName + " - " + Log4Net.AddErrorLog(ex.Message));
                return Json(MessageResult.ShowServerError(ex.Message));
            }
           
        }
    }
}
