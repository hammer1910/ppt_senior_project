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
using PPT.Database.Common;

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
                return Json(MessageResult.GetMessage(MessageType.NOT_INFORMATION_EXAM));
            }
            if (groupId == 0)
            {
                return Json(MessageResult.GetMessage(MessageType.NOT_INFORMATION_EXAM));
            }

            if (!ModelState.IsValid)
            {
                return Json(MessageResult.GetMessage(MessageType.NOT_FOUND));
            }
            
            exam.GroupId = groupId;

            //Map data enter from the form to exam entity
            var finalExam = Mapper.Map<PPT.Database.Entities.ExamEntity>(exam);

            //This is query insert exam
            _examRepository.CreateExam(finalExam);

            if (!_examRepository.Save())
            {
                return Json(MessageResult.GetMessage(MessageType.BAD_REQUEST));
            }

            return Json(MessageResult.GetMessage(MessageType.CREATED_EXAM)); //For example here. It should be the list of MessageResult. More details. 1=You registered the account successfully!; 2=.... Understand?
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
                return Json(MessageResult.GetMessage(MessageType.EXAM_NOT_FOUND));
            }

            if (!ModelState.IsValid)
            {
                return Json(MessageResult.GetMessage(MessageType.NOT_FOUND));
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
        public JsonResult UpdateInformationExam(int examId, [FromBody] ExamForCreationDto exam)
        {
            //Check id group exist in the database
            if (!_examRepository.ExamExist(examId))
            {
                return Json(MessageResult.GetMessage(MessageType.EXAM_NOT_FOUND));
            }

            //Check value enter from the form 
            if (exam == null)
            {
                return Json(MessageResult.GetMessage(MessageType.NOT_INFORMATION_EXAM));
            }

            if (!ModelState.IsValid)
            {
                return Json(MessageResult.GetMessage(MessageType.BAD_REQUEST));
            }

            //This is get all information of group
            var examEntity = _examRepository.GetExamById(examId);

            if (examEntity == null)
            {
                return Json(MessageResult.GetMessage(MessageType.EXAM_NOT_FOUND));
            }

            //Map data enter from the form to group entity
            Mapper.Map(exam, examEntity);

            if (!_examRepository.Save())
            {
                return Json(MessageResult.GetMessage(MessageType.BAD_REQUEST));
            }

            return Json(MessageResult.GetMessage(MessageType.EXAM_UPDATED));
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
                return Json(MessageResult.GetMessage(MessageType.EXAM_NOT_FOUND));
            }

            //This is get all information of group by Id
            var examEntity = _examRepository.GetExamById(examId);

            if (examEntity == null)
            {
                return Json(MessageResult.GetMessage(MessageType.EXAM_NOT_FOUND));
            }

            //This is query to delete group
            _examRepository.DeleteExam(examEntity);

            if (!_examRepository.Save())
            {
                return Json(MessageResult.GetMessage(MessageType.BAD_REQUEST));
            }

            return Json(MessageResult.GetMessage(MessageType.EXAM_DELETED));
        }
    }
}
