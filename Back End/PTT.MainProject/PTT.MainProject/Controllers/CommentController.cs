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
    public class CommentController : Controller
    {
        private ICommentRepository _commentRepository;
        private IGroupMemberRepository _groupMemberRepository;
        private IGroupRepository _groupRepository;
        private IExamRepository _examRepository;
        private IAccountRepository _accountRepository;
        private static string className = System.Reflection.MethodBase.GetCurrentMethod().DeclaringType.Name;

        public CommentController(ICommentRepository commentRepository, IGroupMemberRepository groupMemberRepository,
            IExamRepository examRepository, IGroupRepository groupRepository, IAccountRepository accountRepository)
        {
            _commentRepository = commentRepository;
            _groupMemberRepository = groupMemberRepository;
            _examRepository = examRepository;
            _groupRepository = groupRepository;
            _accountRepository = accountRepository;
            Log4Net.InitLog();
        }

        /// <summary>
        /// Get information comment function
        /// </summary>
        /// <param name="examId">Get id exam on the url</param>       
        /// <response code="200">
        /// [
        ///  {
        ///    "name": "Trương Văn Cảnh",
        ///    "content": "Exam is very good",
        ///    "dateTime": "2019-04-22T16:26:37.3356622"
        ///  },
        ///  {
        ///    "name": "Nguyễn Văn Té",
        ///    "content": "Exam is very useful",
        ///    "dateTime": "2019-04-22T16:24:41.556793"
        ///  }
        /// ]
        /// </response>
        [HttpGet("getcomment/{examId}")]
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

                List<CommentEntity> listComment = _commentRepository.GetCommentByExamId(examId);

                List<CommentResult> listResult = new List<CommentResult>();

                foreach (var comment in listComment)
                {
                    CommentResult result = new CommentResult();
                    AccountEntity account = _accountRepository.GetAccountById(comment.AccountId);
                    result.name = account.FullName;
                    result.dateTime = comment.DateTimeComment;
                    result.content = comment.Content;

                    listResult.Add(result);
                }

                return Json(listResult);
            }
            catch (Exception ex)
            {
                Log4Net.log.Error(className + "." + functionName + " - " + Log4Net.AddErrorLog(ex.Message));
                return Json(MessageResult.ShowServerError(ex.Message));
            }

        }

        /// <summary>
        /// Create comment function
        /// </summary>
        /// <param name="comment">The comment information from body</param> 
        /// <response code="200">You commented successfully!</response>
        [HttpPost("createcomment")]
        public JsonResult CreatePointOfInterest([FromBody] CommentDto comment)
        {
            string functionName = System.Reflection.MethodBase.GetCurrentMethod().Name;

            try
            {
                //Check value enter from the form 
                if (comment == null)
                {
                    Log4Net.log.Error(className + "." + functionName + " - " + Log4Net.AddErrorLog(Constants.notInformationAccount));
                    return Json(MessageResult.GetMessage(MessageType.NOT_INFORMATION_ACCOUNT));
                }

                if (!ModelState.IsValid)
                {
                    Log4Net.log.Error(className + "." + functionName + " - " + Log4Net.AddErrorLog(Constants.notFound));
                    return Json(MessageResult.GetMessage(MessageType.NOT_FOUND));
                }

                GroupMemberEntity groupMemberEntity = _groupMemberRepository.GetGroupMemberByGroupIdAndAccountId(comment.groupId, comment.accountId);

                //Map data enter from the form to comment entity
                var comments = Mapper.Map<PPT.Database.Entities.CommentEntity>(comment);
                comments.GroupMemberId = groupMemberEntity.GroupMemberId;
                comments.DateTimeComment = DateTime.Now;
                comments.AccountId = comment.accountId;

                _commentRepository.CreateComment(comments);

                if (!_commentRepository.Save())
                {
                    Log4Net.log.Error(className + "." + functionName + " - " + Log4Net.AddErrorLog(Constants.badRequest));
                    return Json(MessageResult.GetMessage(MessageType.BAD_REQUEST));
                }

                Log4Net.log.Error(className + "." + functionName + " - " + Log4Net.AddErrorLog(Constants.commentSuccess));
                return Json(MessageResult.GetMessage(MessageType.COMMENTSUCCESS));
            }
            catch (Exception ex)
            {
                Log4Net.log.Error(className + "." + functionName + " - " + Log4Net.AddErrorLog(ex.Message));
                return Json(MessageResult.ShowServerError(ex.Message));
            }
        }        
    }
}
