using AutoMapper;
using Microsoft.AspNetCore.Mvc;
using PPT.Database.Models;
using PPT.Database.Repositories;
using PPT.Database.ResultObject;
using System;
using System.Collections.Generic;
using System.Linq;
using System.Threading.Tasks;

namespace PTT.MainProject.Controllers
{
    [Route("api/exam")]
    public class QuestionController : Controller
    {
        private IExamRepository _examRepository;
        private IQuestionRepository _questionRepository;

        public QuestionController(IExamRepository examRepository, IQuestionRepository questionRepository)
        {
            _examRepository = examRepository;
            _questionRepository = questionRepository;
        }

        /// <summary>
        /// Create exam function
        /// </summary>
        /// <param name="exam">The account exam from body</param> 
        /// <param name="groupId">Get id group on the url</param>  
        [HttpPost("{examId}/createpartone")]
        public JsonResult CreatePartOne(int examId, [FromBody] PartOneForCreationDto part1)
        {
            //Check value enter from the form 
            if (part1 == null)
            {
                return Json(MessageResult.GetMessage(3));
            }
            if (examId == 0)
            {
                return Json(MessageResult.GetMessage(3));
            }

            if (!_examRepository.ExamExist(examId))
            {
                return Json(MessageResult.GetMessage(3));
            }

            if (!ModelState.IsValid)
            {
                return Json(MessageResult.GetMessage(4));
            }

            //Map data enter from the form to exam entity
            var partOneExam = Mapper.Map<PPT.Database.Entities.QuestionEntity>(part1);

            //This is query insert exam
            _questionRepository.CreatePart(partOneExam,examId);

            if (!_questionRepository.Save())
            {
                return Json(MessageResult.GetMessage(2));
            }


            return Json(MessageResult.GetMessage(22)); //For example here. It should be the list of MessageResult. More details. 1=You registered the account successfully!; 2=.... Understand?
        }

        /// <summary>
        /// Create exam function
        /// </summary>
        /// <param name="exam">The account exam from body</param> 
        /// <param name="groupId">Get id group on the url</param>  
        [HttpPost("{examId}/createparttwo")]
        public JsonResult CreateParttwo(int examId, [FromBody] PartTwoForCreationDto part2)
        {
            //Check value enter from the form 
            if (part2 == null)
            {
                return Json(MessageResult.GetMessage(3));
            }
            if (examId == 0)
            {
                return Json(MessageResult.GetMessage(3));
            }

            if (!_examRepository.ExamExist(examId))
            {
                return Json(MessageResult.GetMessage(3));
            }

            if (!ModelState.IsValid)
            {
                return Json(MessageResult.GetMessage(4));
            }

            //Map data enter from the form to exam entity
            var partTwoExam = Mapper.Map<PPT.Database.Entities.QuestionEntity>(part2);

            //This is query insert exam
            _questionRepository.CreatePart(partTwoExam, examId);

            if (!_questionRepository.Save())
            {
                return Json(MessageResult.GetMessage(2));
            }


            return Json(MessageResult.GetMessage(22)); //For example here. It should be the list of MessageResult. More details. 1=You registered the account successfully!; 2=.... Understand?
        }
    }
}
