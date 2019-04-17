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
    public class GroupController : Controller
    {
        private IGroupRepository _groupRepository;
        private IAccountRepository _accountRepository;
        private IGroupMemberRepository _groupMemberRepository;
        private IExamRepository _examRepository;
        private IAccountExamRepository _accountExamRepository;
        private static string className = System.Reflection.MethodBase.GetCurrentMethod().DeclaringType.Name;

        public GroupController(IGroupRepository groupRepository, IAccountRepository accountRepository, IGroupMemberRepository groupMemberRepository, 
            IExamRepository examRepository, IAccountExamRepository accountExamRepository)
        {
            _groupRepository = groupRepository;
            _accountRepository = accountRepository;
            _groupMemberRepository = groupMemberRepository;
            _examRepository = examRepository;
            _accountExamRepository = accountExamRepository;
            Log4Net.InitLog();
        }

        /// <summary>
        /// Create group function
        /// </summary>
        /// <param name="group">The group information from body</param> 
        [HttpPost("group/create")]
        public JsonResult CreationGroup([FromBody] GroupForCreationDto group)
        {
            string functionName = System.Reflection.MethodBase.GetCurrentMethod().Name;

            try
            {
                AccountEntity account = _accountRepository.GetAccountById(group.accountId); //get account from AccountController stored data user logged in
                if (group == null)
                {
                    Log4Net.log.Error(className + "." + functionName + " - " + Log4Net.AddErrorLog(Constants.notInformationGroup));
                    return Json(MessageResult.GetMessage(MessageType.NOT_INFORMATION_GROUP));
                }

                //This is get current day
                group.CreatedDate = DateTime.Now;

                if (!ModelState.IsValid)
                {
                    Log4Net.log.Error(className + "." + functionName + " - " + Log4Net.AddErrorLog(Constants.notFound));
                    return Json(MessageResult.GetMessage(MessageType.NOT_FOUND));
                }

                var finalGroup = Mapper.Map<PPT.Database.Entities.GroupEntity>(group);

                //This is query insert account
                _groupRepository.CreationGroup(finalGroup, account);

                if (!_groupRepository.Save())
                {
                    Log4Net.log.Error(className + "." + functionName + " - " + Log4Net.AddErrorLog(Constants.badRequest));
                    return Json(MessageResult.GetMessage(MessageType.BAD_REQUEST));
                }

                GroupListResult groupListResult = new GroupListResult();
                groupListResult.groupId = finalGroup.GroupId;

                return Json(groupListResult);
            }
            catch (Exception ex)
            {
                Log4Net.log.Error(className + "." + functionName + " - " + Log4Net.AddErrorLog(ex.Message));
                return Json(MessageResult.ShowServerError(ex.Message));
            }            
        }

        /// <summary>
        /// Add members into group function
        /// </summary>
        /// <param name="account">The account information from body</param> 
        /// <param name="groupId">Get id group on the url</param> 
        [HttpPost("group/addmembers/{groupId}")]
        public JsonResult AddMember([FromBody] AccountGroup account, int groupId)
        {
            string functionName = System.Reflection.MethodBase.GetCurrentMethod().Name;

            try
            {
                if (account == null)
                {
                    Log4Net.log.Error(className + "." + functionName + " - " + Log4Net.AddErrorLog(Constants.notEnterEmail));
                    return Json(MessageResult.GetMessage(MessageType.NOT_ENTER_EMAIL));
                }

                if (!ModelState.IsValid)
                {
                    Log4Net.log.Error(className + "." + functionName + " - " + Log4Net.AddErrorLog(Constants.notFound));
                    return Json(MessageResult.GetMessage(MessageType.NOT_FOUND));
                }

                // get group by group Id in line 52
                GroupEntity groupEntity = _groupRepository.GetGroupById(groupId);
                if (groupEntity == null)
                {
                    Log4Net.log.Error(className + "." + functionName + " - " + Log4Net.AddErrorLog(Constants.groupNotFound));
                    return Json(MessageResult.GetMessage(MessageType.GROUP_NOT_FOUND));
                }

                // get account by email. Email was input from the form
                AccountEntity accountEntity = _accountRepository.GetAccountById(account.accountID);
                if (accountEntity == null)
                {
                    Log4Net.log.Error(className + "." + functionName + " - " + Log4Net.AddErrorLog(Constants.accountNotFound));
                    return Json(MessageResult.GetMessage(MessageType.ACCOUNT_NOT_FOUND));
                }

                //This is query add member into this group
                _groupRepository.AddMemberIntoGroup(groupEntity, accountEntity);

                if (!_groupRepository.Save())
                {
                    Log4Net.log.Error(className + "." + functionName + " - " + Log4Net.AddErrorLog(Constants.badRequest));
                    return Json(MessageResult.GetMessage(MessageType.BAD_REQUEST));
                }

                Log4Net.log.Error(className + "." + functionName + " - " + Log4Net.AddErrorLog(Constants.memberAdded));
                return Json(MessageResult.GetMessage(MessageType.MEMBER_ADDED));
            }
            catch (Exception ex)
            {
                Log4Net.log.Error(className + "." + functionName + " - " + Log4Net.AddErrorLog(ex.Message));
                return Json(MessageResult.ShowServerError(ex.Message));
            }
        }

        /// <summary>
        /// Get information group function
        /// </summary>
        /// <param name="groupId">Get id group on the url</param> 
        [HttpGet("getinformationgroup/{groupId}")]
        public JsonResult GetInformationGroup(int groupId)
        {
            string functionName = System.Reflection.MethodBase.GetCurrentMethod().Name;

            try
            {
                //Check id group exist in the database
                if (!_groupRepository.GroupExist(groupId))
                {
                    Log4Net.log.Error(className + "." + functionName + " - " + Log4Net.AddErrorLog(Constants.groupNotFound));
                    return Json(MessageResult.GetMessage(MessageType.GROUP_NOT_FOUND));
                }

                if (!ModelState.IsValid)
                {
                    Log4Net.log.Error(className + "." + functionName + " - " + Log4Net.AddErrorLog(Constants.notFound));
                    return Json(MessageResult.GetMessage(MessageType.NOT_FOUND));
                }

                //This is get all information of group by Id
                GroupEntity groupEntity = _groupRepository.GetGroupById(groupId);

                return Json(groupEntity);
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
        /// <param name="group">The group information from body</param> 
        [HttpPut("updateinformationgroup")]
        public JsonResult UpdateAccount( [FromBody] GroupForUpdateDto group)
        {
            string functionName = System.Reflection.MethodBase.GetCurrentMethod().Name;

            try
            {
                //Check id group exist in the database
                if (!_groupRepository.GroupExist(group.groupId))
                {
                    Log4Net.log.Error(className + "." + functionName + " - " + Log4Net.AddErrorLog(Constants.groupNotFound));
                    return Json(MessageResult.GetMessage(MessageType.GROUP_NOT_FOUND));
                }

                //Check value enter from the form 
                if (group == null)
                {
                    Log4Net.log.Error(className + "." + functionName + " - " + Log4Net.AddErrorLog(Constants.notInformationGroup));
                    return Json(MessageResult.GetMessage(MessageType.NOT_INFORMATION_GROUP));
                }

                if (!ModelState.IsValid)
                {
                    Log4Net.log.Error(className + "." + functionName + " - " + Log4Net.AddErrorLog(Constants.notFound));
                    return Json(MessageResult.GetMessage(MessageType.NOT_FOUND));
                }

                //This is get all information of group
                var groupEntity = _groupRepository.GetGroupById(group.groupId);

                if (groupEntity == null)
                {
                    Log4Net.log.Error(className + "." + functionName + " - " + Log4Net.AddErrorLog(Constants.groupNotFound));
                    return Json(MessageResult.GetMessage(MessageType.GROUP_NOT_FOUND));
                }

                //Map data enter from the form to group entity
                Mapper.Map(group, groupEntity);

                if (!_groupRepository.Save())
                {
                    Log4Net.log.Error(className + "." + functionName + " - " + Log4Net.AddErrorLog(Constants.badRequest));
                    return Json(MessageResult.GetMessage(MessageType.BAD_REQUEST));
                }

                Log4Net.log.Error(className + "." + functionName + " - " + Log4Net.AddErrorLog(Constants.groupUpdated));
                return Json(MessageResult.GetMessage(MessageType.GROUP_UPDATED));
            }
            catch (Exception ex)
            {
                Log4Net.log.Error(className + "." + functionName + " - " + Log4Net.AddErrorLog(ex.Message));
                return Json(MessageResult.ShowServerError(ex.Message));
            }
        }

        /// <summary>
        /// Delete group by owner function
        /// </summary>
        /// <param name="groupId">Get id group on the url</param> 
        [HttpDelete("deletegroup/{groupId}")]
        public JsonResult DeleteGroup(int groupId)
        {
            string functionName = System.Reflection.MethodBase.GetCurrentMethod().Name;

            try
            {
                //Check id group exist in the database
                if (!_groupRepository.GroupExist(groupId))
                {
                    Log4Net.log.Error(className + "." + functionName + " - " + Log4Net.AddErrorLog(Constants.groupNotFound));
                    return Json(MessageResult.GetMessage(MessageType.GROUP_NOT_FOUND));
                }

                //This is get all information of group by Id
                var groupEntity = _groupRepository.GetGroupById(groupId);

                if (groupEntity == null)
                {
                    Log4Net.log.Error(className + "." + functionName + " - " + Log4Net.AddErrorLog(Constants.groupNotFound));
                    return Json(MessageResult.GetMessage(MessageType.GROUP_NOT_FOUND));
                }

                //This is query to delete group
                _groupRepository.DeleteGroup(groupEntity);

                if (!_groupRepository.Save())
                {
                    Log4Net.log.Error(className + "." + functionName + " - " + Log4Net.AddErrorLog(Constants.badRequest));
                    return Json(MessageResult.GetMessage(MessageType.BAD_REQUEST));
                }

                Log4Net.log.Error(className + "." + functionName + " - " + Log4Net.AddErrorLog(Constants.groupDeleted));
                return Json(MessageResult.GetMessage(MessageType.GROUP_DELETED));
            }
            catch (Exception ex)
            {
                Log4Net.log.Error(className + "." + functionName + " - " + Log4Net.AddErrorLog(ex.Message));
                return Json(MessageResult.ShowServerError(ex.Message));
            }
        }

        /// <summary>
        /// Get list group function
        /// </summary>
        /// <param name="ownerId">Get id owner on the url</param> 
        [HttpGet("getlistgroup/{ownerId}")]
        public JsonResult GetGroupList(int ownerId)
        {
            string functionName = System.Reflection.MethodBase.GetCurrentMethod().Name;

            try
            {
                //Check value enter id account
                if (ownerId == 0)
                {
                    Log4Net.log.Error(className + "." + functionName + " - " + Log4Net.AddErrorLog(Constants.emailAndPasswordWrong));
                    return Json(MessageResult.GetMessage(MessageType.EMAIL_AND_PASSWORD_WRONG));
                }

                //get group list by owner Id
                List<GroupOwnerEntity> groupEntities = _groupRepository.GetGroupListByOwnerId(ownerId);

                if (groupEntities == null)
                {
                    Log4Net.log.Error(className + "." + functionName + " - " + Log4Net.AddErrorLog(Constants.groupNotFound));
                    return Json(MessageResult.GetMessage(MessageType.GROUP_NOT_FOUND));
                }

                // Create new list result to get data
                List<GroupListResult> groupListResult = new List<GroupListResult>();

                //
                foreach (var groupOwner in groupEntities)
                {
                    GroupListResult groupList = new GroupListResult();
                    groupList.groupId = groupOwner.GroupId;
                    groupList.groupOwnerId = groupOwner.GroupOwnerId;
                    groupList.ownerGroupId = groupOwner.AccountId;
                    GroupEntity group = _groupRepository.GetGroupById(groupOwner.GroupId);
                    groupList.groupName = group.Name;
                    groupList.description = group.Description;
                    groupListResult.Add(groupList);
                }

                return Json(groupListResult);
            }
            catch (Exception ex)
            {
                Log4Net.log.Error(className + "." + functionName + " - " + Log4Net.AddErrorLog(ex.Message));
                return Json(MessageResult.ShowServerError(ex.Message));
            }
        }

        [HttpDelete("{groupId}/outgroup/{accountId}")]
        public JsonResult DeleteGroup(int groupId, int accountId)
        {
            string functionName = System.Reflection.MethodBase.GetCurrentMethod().Name;

            try
            {
                if (groupId == 0 || accountId == 0)
                {
                    Log4Net.log.Error(className + "." + functionName + " - " + Log4Net.AddErrorLog(Constants.notFound));
                    return Json(MessageResult.GetMessage(MessageType.NOT_FOUND));
                }

                _groupRepository.OutGroup(groupId, accountId);

                if (!_groupRepository.Save())
                {
                    Log4Net.log.Error(className + "." + functionName + " - " + Log4Net.AddErrorLog(Constants.badRequest));
                    return Json(MessageResult.GetMessage(MessageType.BAD_REQUEST));
                }

                Log4Net.log.Error(className + "." + functionName + " - " + Log4Net.AddErrorLog(Constants.accountDeleted));
                return Json(MessageResult.GetMessage(MessageType.ACCOUNT_DELETED));
            }
            catch (Exception ex)
            {
                Log4Net.log.Error(className + "." + functionName + " - " + Log4Net.AddErrorLog(ex.Message));
                return Json(MessageResult.ShowServerError(ex.Message));
            }
        }

        /// <summary>
        /// Get list member of group function
        /// </summary>
        /// <param name="groupId">Get id group on the url</param> 
        [HttpGet("getlistmember/{groupId}")]
        public JsonResult GetMemberList(int groupId)
        {
            string functionName = System.Reflection.MethodBase.GetCurrentMethod().Name;

            try
            {
                //Check value enter id group
                if (groupId == 0)
                {
                    Log4Net.log.Error(className + "." + functionName + " - " + Log4Net.AddErrorLog(Constants.emailAndPasswordWrong));
                    return Json(MessageResult.GetMessage(MessageType.EMAIL_AND_PASSWORD_WRONG));
                }

                List<GroupMemberEntity> memberEntities = _groupRepository.GetMemberListByGroupId(groupId);

                if (memberEntities == null)
                {
                    Log4Net.log.Error(className + "." + functionName + " - " + Log4Net.AddErrorLog(Constants.notInformationAccount));
                    return Json(MessageResult.GetMessage(MessageType.NOT_INFORMATION_MEMBER));
                }

                List<MemberListResult> memberListResult = new List<MemberListResult>();

                foreach (var members in memberEntities)
                {
                    MemberListResult memberList = new MemberListResult();
                    memberList.groupMemberId = members.GroupMemberId;
                    memberList.groupId = members.GroupId;
                    memberList.accountId = members.AccountId;
                    AccountEntity accountEntity = _accountRepository.GetAccountById(members.AccountId);
                    memberList.email = accountEntity.Email;
                    memberList.fullName = accountEntity.FullName;
                    memberList.address = accountEntity.Address;
                    memberList.phoneNumber = accountEntity.Phone;
                    memberListResult.Add(memberList);
                }

                return Json(memberListResult);
            }
            catch (Exception ex)
            {
                Log4Net.log.Error(className + "." + functionName + " - " + Log4Net.AddErrorLog(ex.Message));
                return Json(MessageResult.ShowServerError(ex.Message));
            }
        }

        /// <summary>
        /// Delete member by owner function
        /// </summary>
        /// <param name="accountId">Get id account on the url</param> 
        [HttpDelete("deletemember/{accountId}")]
        public JsonResult DeleteMember(int accountId)
        {
            string functionName = System.Reflection.MethodBase.GetCurrentMethod().Name;

            try
            {
                //Check id group exist in the database
                if (!_accountRepository.AccountExists(accountId))
                {
                    Log4Net.log.Error(className + "." + functionName + " - " + Log4Net.AddErrorLog(Constants.accountNotFound));
                    return Json(MessageResult.GetMessage(MessageType.ACCOUNT_NOT_FOUND));
                }

                //This is get all member of group by id acount
                var memberEntity = _groupRepository.GetMemberByAccountId(accountId);

                if (memberEntity == null)
                {
                    Log4Net.log.Error(className + "." + functionName + " - " + Log4Net.AddErrorLog(Constants.notInformationMember));
                    return Json(MessageResult.GetMessage(MessageType.NOT_INFORMATION_MEMBER));
                }

                //This is query to delete member
                _groupRepository.DeleteMember(memberEntity);

                if (!_groupRepository.Save())
                {
                    Log4Net.log.Error(className + "." + functionName + " - " + Log4Net.AddErrorLog(Constants.badRequest));
                    return Json(MessageResult.GetMessage(MessageType.BAD_REQUEST));
                }

                Log4Net.log.Error(className + "." + functionName + " - " + Log4Net.AddErrorLog(Constants.memberDeleted));
                return Json(MessageResult.GetMessage(MessageType.MEMBER_DELETED));
            }
            catch (Exception ex)
            {
                Log4Net.log.Error(className + "." + functionName + " - " + Log4Net.AddErrorLog(ex.Message));
                return Json(MessageResult.ShowServerError(ex.Message));
            }
        }

        /// <summary>
        /// Search member by name function
        /// </summary>
        /// <param name="searchMember">The information of searching from body</param> 
        [HttpGet("searchmember")]
        public JsonResult SearchMemberInGroup([FromBody] SearchMemberDto searchMember)
        {
            //get method name
            string functionName = System.Reflection.MethodBase.GetCurrentMethod().Name;
            try
            {
                //Check value enter id group
                if (searchMember.groupId == 0 || searchMember.name == null)
                {
                    Log4Net.log.Error(className + "." + functionName + " - " + Log4Net.AddErrorLog(Constants.valueIsNull));
                    return Json(MessageResult.GetMessage(MessageType.VALUEISNULL));
                }
                
                List<SearchResult> listResult = new List<SearchResult>();
                //get all member with contain name from form body
                List<AccountEntity> memberEntities = _groupMemberRepository.SearchMemberByName(searchMember.name, searchMember.groupId);
                if (memberEntities != null)
                {
                    //add member into listResult
                    foreach (var groupMember in memberEntities)
                    {
                        AccountEntity account = _accountRepository.GetAccountById(groupMember.AccountId);
                        SearchResult result = new SearchResult();
                        result.accountId = account.AccountId;
                        result.fullName = account.FullName;
                        listResult.Add(result);
                    }
                }
                //list member with that name is null, it's will show message error
                if (memberEntities.Count() < 1)
                {
                    Log4Net.log.Error(className + "." + functionName + " - " + Log4Net.AddErrorLog(Constants.notInformationAccount));
                    return Json(MessageResult.GetMessage(MessageType.NOT_INFORMATION_MEMBER));
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
        /// Get list exam of group function
        /// </summary>
        /// <param name="accountId">Get id account on the url</param> 
        /// <param name="groupId">Get id group on the url</param> 
        [HttpGet("getlistexam/{accountId}/{groupId}")]
        public JsonResult GetListExam(int accountId, int groupId)
        {
            string functionName = System.Reflection.MethodBase.GetCurrentMethod().Name;

            try
            {
                //Check value enter id group
                if (accountId == 0 || groupId == 0)
                {
                    Log4Net.log.Error(className + "." + functionName + " - " + Log4Net.AddErrorLog(Constants.emailAndPasswordWrong));
                    return Json(MessageResult.GetMessage(MessageType.EMAIL_AND_PASSWORD_WRONG));
                }

                List<AccountExamEntity> listAccountExams = _accountExamRepository.GetAccountExamByAccountId(accountId);

                if (listAccountExams == null)
                {
                    Log4Net.log.Error(className + "." + functionName + " - " + Log4Net.AddErrorLog(Constants.notInformationAccount));
                    return Json(MessageResult.GetMessage(MessageType.ACCOUNT_NOT_FOUND));
                }

                List<ExamResult> examResults = new List<ExamResult>();

                foreach (var accountExam in listAccountExams)
                {
                    ExamEntity examEntity = _examRepository.GetExamById(accountExam.ExamId);
                    if (examEntity.GroupId == groupId)
                    {
                        ExamResult result = new ExamResult();
                        result.name = examEntity.Name;
                        result.status = accountExam.IsStatus;

                        examResults.Add(result);
                    }
                }

                return Json(examResults);
            }
            catch (Exception ex)
            {
                Log4Net.log.Error(className + "." + functionName + " - " + Log4Net.AddErrorLog(ex.Message));
                return Json(MessageResult.ShowServerError(ex.Message));
            }
        }
    }
}
