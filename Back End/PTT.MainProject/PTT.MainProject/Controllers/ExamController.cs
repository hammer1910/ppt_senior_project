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
using PTT.MainProject.Log;

namespace PTT.MainProject.Controllers
{
    [Route("api/exam")]
    public class ExamController : Controller
    {
        private IExamRepository _examRepository;
        private static string className = System.Reflection.MethodBase.GetCurrentMethod().DeclaringType.Name;

        public ExamController(IExamRepository examRepository)
        {
            _examRepository = examRepository;
            Log4Net.InitLog();
        }

        /// <summary>
        /// Create exam function
        /// </summary>
        /// <param name="exam">The account exam from body</param>        
        [HttpPost("createexam")]
        public JsonResult CreateExam([FromBody] ExamForCreationDto exam)
        {
            string functionName = System.Reflection.MethodBase.GetCurrentMethod().Name;

            try
            {
                //Check value enter from the form 
                if (exam == null)
                {
                    Log4Net.log.Error(className + "." + functionName + " - " + Log4Net.AddErrorLog(Constants.notInformationExam));
                    return Json(MessageResult.GetMessage(MessageType.NOT_INFORMATION_EXAM));
                }

                if (!ModelState.IsValid)
                {
                    Log4Net.log.Error(className + "." + functionName + " - " + Log4Net.AddErrorLog(Constants.notFound));
                    return Json(MessageResult.GetMessage(MessageType.NOT_FOUND));
                }


                //Map data enter from the form to exam entity
                var finalExam = Mapper.Map<PPT.Database.Entities.ExamEntity>(exam);

                //This is query insert exam
                _examRepository.CreateExam(finalExam);

                if (!_examRepository.Save())
                {
                    Log4Net.log.Error(className + "." + functionName + " - " + Log4Net.AddErrorLog(Constants.badRequest));
                    return Json(MessageResult.GetMessage(MessageType.BAD_REQUEST));
                }

                Log4Net.log.Error(className + "." + functionName + " - " + Log4Net.AddErrorLog(Constants.createdExam));
                return Json(MessageResult.GetMessage(MessageType.CREATED_EXAM));
            }
            catch(Exception ex)
            {
                Log4Net.log.Error(className + "." + functionName + " - " + Log4Net.AddErrorLog(ex.Message));
                return Json(MessageResult.ShowServerError(ex.Message));
            }
            
        }

        /// <summary>
        /// Get information exam function
        /// </summary>
        /// <param name="examId">Get id exam on the url</param> 
        [HttpGet("getinformationexam/{examId}")]
        public JsonResult GetInformationGroup(int examId)
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
                    Log4Net.log.Error(className + "." + functionName + " - " + Log4Net.AddErrorLog(Constants.notFound));
                    return Json(MessageResult.GetMessage(MessageType.NOT_FOUND));
                }

                //This is get all information of exam by Id
                ExamEntity examEntity = _examRepository.GetExamById(examId);

                return Json(examEntity);
            }
            catch(Exception ex)
            {
                Log4Net.log.Error(className + "." + functionName + " - " + Log4Net.AddErrorLog(ex.Message));
                return Json(MessageResult.ShowServerError(ex.Message));
            }
            
        }

        /// <summary>
        /// Update information group function
        /// </summary>
        /// <param name="exam">The exam information from body</param>
        [HttpPut("updateinformationexam")]
        public JsonResult UpdateInformationExam([FromBody] ExamForCreationDto exam)
        {
            string functionName = System.Reflection.MethodBase.GetCurrentMethod().Name;

            try
            {
                //Check id group exist in the database
                if (!_examRepository.ExamExist(exam.ExamId))
                {
                    Log4Net.log.Error(className + "." + functionName + " - " + Log4Net.AddErrorLog(Constants.examNotFound));
                    return Json(MessageResult.GetMessage(MessageType.EXAM_NOT_FOUND));
                }

                //Check value enter from the form 
                if (exam == null)
                {
                    Log4Net.log.Error(className + "." + functionName + " - " + Log4Net.AddErrorLog(Constants.notInformationExam));
                    return Json(MessageResult.GetMessage(MessageType.NOT_INFORMATION_EXAM));
                }

                if (!ModelState.IsValid)
                {
                    Log4Net.log.Error(className + "." + functionName + " - " + Log4Net.AddErrorLog(Constants.badRequest));
                    return Json(MessageResult.GetMessage(MessageType.BAD_REQUEST));
                }

                //This is get all information of group
                var examEntity = _examRepository.GetExamById(exam.ExamId);

                if (examEntity == null)
                {
                    Log4Net.log.Error(className + "." + functionName + " - " + Log4Net.AddErrorLog(Constants.examNotFound));
                    return Json(MessageResult.GetMessage(MessageType.EXAM_NOT_FOUND));
                }

                //Map data enter from the form to group entity
                Mapper.Map(exam, examEntity);

                if (!_examRepository.Save())
                {
                    Log4Net.log.Error(className + "." + functionName + " - " + Log4Net.AddErrorLog(Constants.badRequest));
                    return Json(MessageResult.GetMessage(MessageType.BAD_REQUEST));
                }

                Log4Net.log.Error(className + "." + functionName + " - " + Log4Net.AddErrorLog(Constants.examUpdated));
                return Json(MessageResult.GetMessage(MessageType.EXAM_UPDATED));
            }
            catch(Exception ex)
            {
                Log4Net.log.Error(className + "." + functionName + " - " + Log4Net.AddErrorLog(ex.Message));
                return Json(MessageResult.ShowServerError(ex.Message));
            }
            
        }

        /// <summary>
        /// Delete exam by owner function
        /// </summary>
        /// <param name="examId">Get id exam on the url</param> 
        [HttpDelete("deletexam/{examId}")]
        public JsonResult DeleteGroup(int examId)
        {
            string functionName = System.Reflection.MethodBase.GetCurrentMethod().Name;

            try
            {
                //Check id group exist in the database
                if (!_examRepository.ExamExist(examId))
                {
                    Log4Net.log.Error(className + "." + functionName + " - " + Log4Net.AddErrorLog(Constants.examNotFound));
                    return Json(MessageResult.GetMessage(MessageType.EXAM_NOT_FOUND));
                }

                //This is get all information of group by Id
                var examEntity = _examRepository.GetExamById(examId);

                if (examEntity == null)
                {
                    Log4Net.log.Error(className + "." + functionName + " - " + Log4Net.AddErrorLog(Constants.examNotFound));
                    return Json(MessageResult.GetMessage(MessageType.EXAM_NOT_FOUND));
                }

                //This is query to delete group
                _examRepository.DeleteExam(examEntity);

                if (!_examRepository.Save())
                {
                    Log4Net.log.Error(className + "." + functionName + " - " + Log4Net.AddErrorLog(Constants.badRequest));
                    return Json(MessageResult.GetMessage(MessageType.BAD_REQUEST));
                }

                Log4Net.log.Error(className + "." + functionName + " - " + Log4Net.AddErrorLog(Constants.examDeleted));
                return Json(MessageResult.GetMessage(MessageType.EXAM_DELETED));
            }
            catch(Exception ex)
            {
                Log4Net.log.Error(className + "." + functionName + " - " + Log4Net.AddErrorLog(ex.Message));
                return Json(MessageResult.ShowServerError(ex.Message));
            }
            
        }
    }
}
