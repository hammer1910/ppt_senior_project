using AutoMapper;
using Microsoft.AspNetCore.Mvc;
using PPT.Database.Entities;
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
    public class ExamController : Controller
    {
        private IExamRepository _examRepository;

        public ExamController(IExamRepository examRepository)
        {
            _examRepository = examRepository;
        }

        /// <summary>
        /// Create exam function
        /// </summary>
        /// <param name="exam">The account exam from body</param> 
        /// <param name="groupId">Get id group on the url</param>  
        [HttpPost("{groupId}/createexam")]
        public JsonResult CreateExam([FromBody] ExamForCreationDto exam, int groupId)
        {
            //Check value enter from the form 
            if (exam == null)
            {
                return Json(MessageResult.GetMessage(3));
            }
            if (groupId == 0)
            {
                return Json(MessageResult.GetMessage(3));
            }

            if (!ModelState.IsValid)
            {
                return Json(MessageResult.GetMessage(4));
            }
            
            exam.GroupId = groupId;

            //Map data enter from the form to exam entity
            var finalExam = Mapper.Map<PPT.Database.Entities.ExamEntity>(exam);

            //This is query insert exam
            _examRepository.CreateExam(finalExam);

            if (!_examRepository.Save())
            {
                return Json(MessageResult.GetMessage(2));
            }

            return Json(MessageResult.GetMessage(22)); //For example here. It should be the list of MessageResult. More details. 1=You registered the account successfully!; 2=.... Understand?
        }

        /// <summary>
        /// Get information exam function
        /// </summary>
        /// <param name="examId">Get id exam on the url</param> 
        [HttpGet("getinformationexam/{examId}")]
        public JsonResult GetInformationGroup(int examId)
        {
            //Check id exam exist in the database
            if (!_examRepository.ExamExist(examId))
            {
                return Json(MessageResult.GetMessage(16));
            }

            if (!ModelState.IsValid)
            {
                return Json(MessageResult.GetMessage(4));
            }

            //This is get all information of exam by Id
            ExamEntity examEntity = _examRepository.GetExamById(examId);

            return Json(examEntity);
        }

        /// <summary>
        /// Update information group function
        /// </summary>
        /// <param name="examId">Get id exam on the url</param> 
        /// <param name="exam">The exam information from body</param>
        [HttpPut("updateinformationexam/{examId}")]
        public JsonResult UpdateAccount(int examId, [FromBody] ExamForCreationDto exam)
        {
            //Check id group exist in the database
            if (!_examRepository.ExamExist(examId))
            {
                return Json(MessageResult.GetMessage(24));
            }

            //Check value enter from the form 
            if (exam == null)
            {
                return Json(MessageResult.GetMessage(25));
            }

            if (!ModelState.IsValid)
            {
                return Json(MessageResult.GetMessage(4));
            }

            //This is get all information of group
            var examEntity = _examRepository.GetExamById(examId);

            if (examEntity == null)
            {
                return Json(MessageResult.GetMessage(16));
            }

            //Map data enter from the form to group entity
            Mapper.Map(exam, examEntity);

            if (!_examRepository.Save())
            {
                return Json(MessageResult.GetMessage(2));
            }

            return Json(MessageResult.GetMessage(26));
        }

        /// <summary>
        /// Delete exam by owner function
        /// </summary>
        /// <param name="examId">Get id exam on the url</param> 
        [HttpDelete("deletexam/{examId}")]
        public JsonResult DeleteGroup(int examId)
        {
            //Check id group exist in the database
            if (!_examRepository.ExamExist(examId))
            {
                return Json(MessageResult.GetMessage(24));
            }

            //This is get all information of group by Id
            var examEntity = _examRepository.GetExamById(examId);

            if (examEntity == null)
            {
                return Json(MessageResult.GetMessage(24));
            }

            //This is query to delete group
            _examRepository.DeleteExam(examEntity);

            if (!_examRepository.Save())
            {
                return Json(MessageResult.GetMessage(2));
            }

            return Json(MessageResult.GetMessage(27));
        }
    }
}
