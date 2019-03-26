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
        /// <param name="answers">The information answer of user from body</param> 
        /// <param name="accountId">Get id account on the url</param>
        /// <param name="examId">Get id exam on the url</param> 
        [HttpPost("{accountId}/{examId}/createansweruser")]
        public JsonResult CreateAnswerUser(int accountId, int examId, [FromBody] List<AnswerUserDto> answers)
        {
            //Check value enter from the form 
            if (answers == null)
            {
                return Json(MessageResult.GetMessage(MessageType.NOT_INFORMATION_QUESTION));
            }

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

            foreach (var examQuestion in examQuestionEntity)
            {
                foreach (var answer in answers)
                {
                    if (examQuestion.QuestionId == answer.questionId)
                    {
                        answer.accountId = accountId;
                        //Map data enter from the form to question entity
                        var answerUser = Mapper.Map<PPT.Database.Entities.AnswerUserEntity>(answer);
                        //This is query insert question
                        _answerUserRepository.CreateAnswerUser(answerUser);
                    }
                }
            }

            if (!_answerUserRepository.Save())
            {
                return Json(MessageResult.GetMessage(MessageType.BAD_REQUEST));
            }

            return Json(MessageResult.GetMessage(MessageType.CREATED_ANSWER_USER));
        }
        
    }
}
