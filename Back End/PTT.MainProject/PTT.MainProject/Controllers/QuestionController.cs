using AutoMapper;
using Microsoft.AspNetCore.Mvc;
using PPT.Database.Common;
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
        /// <param name="part1">The information of question from body</param> 
        /// <param name="examId">Get id exam on the url</param>  
        [HttpPost("{examId}/createpartone")]
        public JsonResult CreatePartOne(int examId, [FromBody] PartOneForCreationDto part1)
        {
            //Check value enter from the form 
            if (part1 == null)
            {
                return Json(MessageResult.GetMessage(MessageType.NOT_INFORMATION_GROUP));
            }
            if (examId == 0)
            {
                return Json(MessageResult.GetMessage(MessageType.NOT_INFORMATION_GROUP));
            }

            if (!_examRepository.ExamExist(examId))
            {
                return Json(MessageResult.GetMessage(MessageType.NOT_INFORMATION_GROUP));
            }

            if (!ModelState.IsValid)
            {
                return Json(MessageResult.GetMessage(MessageType.NOT_INFORMATION_GROUP));
            }

            //Map data enter from the form to exam entity
            var partOneExam = Mapper.Map<PPT.Database.Entities.QuestionEntity>(part1);

            //This is query insert exam
            _questionRepository.CreatePart(partOneExam,examId);

            if (!_questionRepository.Save())
            {
                return Json(MessageResult.GetMessage(MessageType.NOT_INFORMATION_GROUP));
            }


            return Json(MessageResult.GetMessage(MessageType.NOT_INFORMATION_GROUP));
        }

        /// <summary>
        /// Create exam function
        /// </summary>
        /// <param name="part2">The information of question from body</param> 
        /// <param name="examId">Get id exam on the url</param>
        [HttpPost("{examId}/createparttwo")]
        public JsonResult CreateParttwo(int examId, [FromBody] PartTwoForCreationDto part2)
        {
            //Check value enter from the form 
            if (part2 == null)
            {
                return Json(MessageResult.GetMessage(MessageType.NOT_INFORMATION_GROUP));
            }
            if (examId == 0)
            {
                return Json(MessageResult.GetMessage(MessageType.NOT_INFORMATION_GROUP));
            }

            if (!_examRepository.ExamExist(examId))
            {
                return Json(MessageResult.GetMessage(MessageType.NOT_INFORMATION_GROUP));
            }

            if (!ModelState.IsValid)
            {
                return Json(MessageResult.GetMessage(MessageType.NOT_INFORMATION_GROUP));
            }

            //Map data enter from the form to exam entity
            var partTwoExam = Mapper.Map<PPT.Database.Entities.QuestionEntity>(part2);

            //This is query insert exam
            _questionRepository.CreatePart(partTwoExam, examId);

            if (!_questionRepository.Save())
            {
                return Json(MessageResult.GetMessage(MessageType.NOT_INFORMATION_GROUP));
            }


            return Json(MessageResult.GetMessage(MessageType.NOT_INFORMATION_GROUP));
        }

        /// <summary>
        /// Create exam function
        /// </summary>
        /// <param name="part5">The information of question from body</param> 
        /// <param name="examId">Get id exam on the url</param> 
        [HttpPost("{examId}/createpartfive")]
        public JsonResult CreatePartFive(int examId, [FromBody] PartFiveForCreationDto part5)
        {
            //Check value enter from the form 
            if (part5 == null)
            {
                return Json(MessageResult.GetMessage(MessageType.NOT_INFORMATION_GROUP));
            }
            if (examId == 0)
            {
                return Json(MessageResult.GetMessage(MessageType.NOT_INFORMATION_GROUP));
            }

            if (!_examRepository.ExamExist(examId))
            {
                return Json(MessageResult.GetMessage(MessageType.NOT_INFORMATION_GROUP));
            }

            if (!ModelState.IsValid)
            {
                return Json(MessageResult.GetMessage(MessageType.NOT_INFORMATION_GROUP));
            }

            //Map data enter from the form to exam entity
            var partFiveExam = Mapper.Map<PPT.Database.Entities.QuestionEntity>(part5);

            //This is query insert exam
            _questionRepository.CreatePart(partFiveExam, examId);

            if (!_questionRepository.Save())
            {
                return Json(MessageResult.GetMessage(MessageType.NOT_INFORMATION_GROUP));
            }


            return Json(MessageResult.GetMessage(MessageType.NOT_INFORMATION_GROUP));
        }

        /// <summary>
        /// Create exam function
        /// </summary>
        /// <param name="part6">The information of question from body</param> 
        /// <param name="examId">Get id exam on the url</param> 
        [HttpPost("{examId}/createpartsix")]
        public JsonResult CreatePartSix(int examId, [FromBody] PartSixForCreationDto part6)
        {
            //Check value enter from the form 
            if (part6 == null)
            {
                return Json(MessageResult.GetMessage(MessageType.NOT_INFORMATION_GROUP));
            }
            if (examId == 0)
            {
                return Json(MessageResult.GetMessage(MessageType.NOT_INFORMATION_GROUP));
            }

            if (!_examRepository.ExamExist(examId))
            {
                return Json(MessageResult.GetMessage(MessageType.NOT_INFORMATION_GROUP));
            }

            if (!ModelState.IsValid)
            {
                return Json(MessageResult.GetMessage(MessageType.NOT_INFORMATION_GROUP));
            }

            //Map data enter from the form to exam entity
            var partSixExam = Mapper.Map<PPT.Database.Entities.QuestionEntity>(part6);

            //This is query insert exam
            _questionRepository.CreatePart(partSixExam, examId);

            if (!_questionRepository.Save())
            {
                return Json(MessageResult.GetMessage(MessageType.NOT_INFORMATION_GROUP));
            }


            return Json(MessageResult.GetMessage(MessageType.NOT_INFORMATION_GROUP));
        }

        /// <summary>
        /// Create exam function
        /// </summary>
        /// <param name="part7">The information of question from body</param> 
        /// <param name="examId">Get id exam on the url</param> 
        [HttpPost("{examId}/createpartseven")]
        public JsonResult CreatePartSeven(int examId, [FromBody] PartSevenForCreationDto part7)
        {
            //Check value enter from the form 
            if (part7 == null)
            {
                return Json(MessageResult.GetMessage(MessageType.NOT_INFORMATION_GROUP));
            }
            if (examId == 0)
            {
                return Json(MessageResult.GetMessage(MessageType.NOT_INFORMATION_GROUP));
            }

            if (!_examRepository.ExamExist(examId))
            {
                return Json(MessageResult.GetMessage(MessageType.NOT_INFORMATION_GROUP));
            }

            if (!ModelState.IsValid)
            {
                return Json(MessageResult.GetMessage(MessageType.NOT_INFORMATION_GROUP));
            }

            //Map data enter from the form to exam entity
            var partSevenExam = Mapper.Map<PPT.Database.Entities.QuestionEntity>(part7);

            //This is query insert exam
            _questionRepository.CreatePart(partSevenExam, examId);

            if (!_questionRepository.Save())
            {
                return Json(MessageResult.GetMessage(MessageType.NOT_INFORMATION_GROUP));
            }


            return Json(MessageResult.GetMessage(MessageType.NOT_INFORMATION_GROUP));
        }
    }
}
