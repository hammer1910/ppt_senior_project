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
        private IAccountExamRepository _accountExamRepository;
        private IGroupMemberRepository _groupMemberRepository;
        private IGroupOwnerRepository _groupOwnerRepository;
        private IGroupRepository _groupRepository;
        private static string className = System.Reflection.MethodBase.GetCurrentMethod().DeclaringType.Name;

        public ExamController(IAccountExamRepository accountExamRepository,IExamRepository examRepository, IGroupMemberRepository groupMemberRepository, IGroupRepository groupRepository, IGroupOwnerRepository groupOwnerRepository)
        {
            _accountExamRepository = accountExamRepository;
            _groupRepository = groupRepository;
            _groupMemberRepository = groupMemberRepository;
            _examRepository = examRepository;
            _groupOwnerRepository = groupOwnerRepository;
            Log4Net.InitLog();
        }

        /// <summary>
        /// Get information exam function
        /// </summary>
        /// <param name="examId">Get id exam on the url</param> 
        /// <response code="200">
        /// "examId": 10,
        /// "name": "Exam 1",
        /// "startDate": "2019-04-18T03:59:30.586",
        /// "endDate": "2019-04-18T03:59:30.586",
        /// "groupId": 2
        /// </response>
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
            catch (Exception ex)
            {
                Log4Net.log.Error(className + "." + functionName + " - " + Log4Net.AddErrorLog(ex.Message));
                return Json(MessageResult.ShowServerError(ex.Message));
            }

        }

        /// <summary>
        /// Create exam function
        /// </summary>
        /// <param name="exam">The account exam from body</param>       
        /// <response code="200">You created exam successfully!</response>
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

                GroupOwnerEntity groupOwner = _groupOwnerRepository.GetGroupOwnerByGroupId(exam.GroupId);
                //Map data enter from the form to exam entity
                var finalExam = Mapper.Map<PPT.Database.Entities.ExamEntity>(exam);

                //This is query insert exam
                _examRepository.CreateExam(finalExam);

                if (!_examRepository.Save())
                {
                    Log4Net.log.Error(className + "." + functionName + " - " + Log4Net.AddErrorLog(Constants.badRequest));
                    
                    return Json(MessageResult.GetMessage(MessageType.BAD_REQUEST));
                }
                GroupEntity groupEntity = _groupRepository.GetGroupByExam(finalExam);             

                List<GroupMemberEntity> listGroupMembers = _groupMemberRepository.GetGroupMemberByGroupId(groupEntity.GroupId);
                if(listGroupMembers.Count() > 0)
                {
                    AccountExamEntity accountExamEntity1 = new AccountExamEntity();
                    accountExamEntity1.Exam = finalExam;
                    accountExamEntity1.AccountId = groupOwner.AccountId;
                    accountExamEntity1.ExamId = finalExam.ExamId;
                    accountExamEntity1.IsStatus = "Empty";
                    _accountExamRepository.CreateAccountExam(accountExamEntity1);
                    _accountExamRepository.Save();
                    foreach (var item in listGroupMembers)
                    {
                        AccountExamEntity accountExamEntity = new AccountExamEntity();
                        accountExamEntity.Exam = finalExam;
                        accountExamEntity.AccountId = item.AccountId;
                        accountExamEntity.Account = item.Account;
                        accountExamEntity.ExamId = finalExam.ExamId;
                        accountExamEntity.IsStatus = "Empty";
                        _accountExamRepository.CreateAccountExam(accountExamEntity);
                        _accountExamRepository.Save();
                    }
                }
                else
                {
                    AccountExamEntity accountExamEntity = new AccountExamEntity();
                    accountExamEntity.Exam = finalExam;
                    accountExamEntity.AccountId = groupOwner.AccountId;      
                    accountExamEntity.ExamId = finalExam.ExamId;
                    accountExamEntity.IsStatus = "Empty";
                    _accountExamRepository.CreateAccountExam(accountExamEntity);
                    _accountExamRepository.Save();
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
        /// Update information group function
        /// </summary>
        /// <param name="exam">The exam information from body</param>
        /// <response code="200">You updated the exam successfully!</response>
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
        /// <response code="200">You deleted the exam successfully!</response>
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
