using AutoMapper;
using Microsoft.AspNetCore.Mvc;
using PPT.Database.Common;
using PPT.Database.Entities;
using PPT.Database.Models;
using PPT.Database.Repositories;
using PPT.Database.ResultObject;
using PPT.Database.Services;
using System;
using System.Collections.Generic;
using System.Linq;
using System.Threading.Tasks;

namespace PTT.MainProject.Controllers
{
    [Route("api/exam")]
    public class AnswerUserController : Controller
    {
        private IExamRepository _examRepository;
        private IQuestionRepository _questionRepository;
        private IExamQuestionRepository _examQuestionRepository;
        private IAnswerUserRepository _answerUserRepository;
        private IAccountRepository _accountRepository;

        public AnswerUserController(IExamRepository examRepository, IQuestionRepository questionRepository, 
            IExamQuestionRepository examQuestionRepository, IAnswerUserRepository answerUserRepository, IAccountRepository accountRepository)
        {
            _examRepository = examRepository;
            _questionRepository = questionRepository;
            _examQuestionRepository = examQuestionRepository;
            _answerUserRepository = answerUserRepository;
            _accountRepository = accountRepository;
        }

        /// <summary>
        /// Add answer of the user function
        /// </summary>
        /// <param name="answerUserModel">The information answer of user from body</param> 
        [HttpPost("createansweruser")]
        public JsonResult CreateAnswerUser( [FromBody] AnswerUserModel answerUserModel)
        {
            try
            {
                //Check value enter from the form 
                if (answerUserModel == null)
                {
                    return Json(MessageResult.GetMessage(MessageType.NOT_INFORMATION_QUESTION));
                }

                if (!_accountRepository.AccountExists(answerUserModel.accountId))
                {
                    return Json(MessageResult.GetMessage(MessageType.ACCOUNT_NOT_FOUND));
                }

                if (!_examRepository.ExamExist(answerUserModel.examId))
                {
                    return Json(MessageResult.GetMessage(MessageType.EXAM_NOT_FOUND));
                }

                if (!ModelState.IsValid)
                {
                    return Json(MessageResult.GetMessage(MessageType.NOT_FOUND));
                }
                List<AnswerUserDto> answersFromForm = answerUserModel.listAnswerUser;

                List<ExamQuestionEntity> examQuestionEntity = _examQuestionRepository.getListQuestions(answerUserModel.examId);

                List<AnswerUserEntity> answerUsersFromDB = _answerUserRepository.GetAnswerUserEntities(answerUserModel.accountId);

                List<AnswerUserDto> newAccountAnswer = new List<AnswerUserDto>();

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

                if (oldAccountUser != null)
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
                    newAccountAnswer = answersFromForm;
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
                else
                {
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
                }

                if (!_answerUserRepository.Save())
                {
                    return Json(MessageResult.GetMessage(MessageType.BAD_REQUEST));
                }

                return Json(MessageResult.GetMessage(MessageType.CREATED_ANSWER_USER));
            }
            catch(Exception ex)
            {
                return Json(ex.Message);
            }
            
        }

        /// <summary>
        /// Get all informations of the question function
        /// </summary>
        /// <param name="examId">Get id exam on the url</param> 
        /// <param name="accountId">Get id account on the url</param>
        [HttpGet("{accountId}/{examId}/getanswerkeyandcorrectanswer")]
        public JsonResult GetAnswerKeyAndCorrectAnswer(int examId, int accountId)
        {
            try
            {
                if (!_accountRepository.AccountExists(accountId))
                {
                    return Json(MessageResult.GetMessage(MessageType.ACCOUNT_NOT_FOUND));
                }

                if (!_examRepository.ExamExist(examId))
                {
                    return Json(MessageResult.GetMessage(MessageType.EXAM_NOT_FOUND));
                }

                if (!ModelState.IsValid)
                {
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
                foreach (var examQuestion in listQuestionEntities)
                {
                    foreach (var item in answerUserEntities)
                    {
                        if (item.QuestionId == examQuestion.QuestionId)
                        {
                            AnswerUserResult answerUser = new AnswerUserResult();
                            answerUser.answerKey = item.AnswerKey;
                            answerUser.correctAnswer = examQuestion.CorrectAnswer;
                            answerUserResults.Add(answerUser);
                        }
                    }
                }

                return Json(answerUserResults);
            }
            catch(Exception ex)
            {
                return Json(ex.Message);
            }
           
        }
    }
}
