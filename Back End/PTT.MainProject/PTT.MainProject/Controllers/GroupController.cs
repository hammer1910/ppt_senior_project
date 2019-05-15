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
        private IGroupOwnerRepository _groupOwnerRepository;
        private IAccountRepository _accountRepository;
        private IGroupMemberRepository _groupMemberRepository;
        private IExamRepository _examRepository;
        private IAccountExamRepository _accountExamRepository;
        private static string className = System.Reflection.MethodBase.GetCurrentMethod().DeclaringType.Name;

        public GroupController(IGroupOwnerRepository groupOwnerRepository,IGroupRepository groupRepository, IAccountRepository accountRepository, IGroupMemberRepository groupMemberRepository, 
            IExamRepository examRepository, IAccountExamRepository accountExamRepository)
        {
            _groupRepository = groupRepository;
            _accountRepository = accountRepository;
            _groupMemberRepository = groupMemberRepository;
            _examRepository = examRepository;
            _accountExamRepository = accountExamRepository;
            _groupOwnerRepository = groupOwnerRepository;
            Log4Net.InitLog();
        }

        /// <summary>
        /// Get information group function
        /// </summary>
        /// <param name="groupId">Get id group on the url</param> 
        /// <response code="200">
        /// {
        ///  "groupId": 11,
        ///  "name": "Philip English",
        ///  "description": "Examination 1",
        ///  "createdDate": "2019-04-21T16:44:17.965718",
        ///  }
        /// </response>
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
        /// Get list group function
        /// </summary>
        /// <param name="accountId">Get id owner on the url</param> 
        /// <response code="200">
        /// [
        /// {
        ///   "groupOwnerId": 18,
        ///   "ownerGroupId": 11,
        ///   "groupId": 14,
        ///   "groupName": "Canh",
        ///   "description": "123"
        /// },
        /// {
        ///  "groupOwnerId": 19,
        ///  "ownerGroupId": 11,
        ///  "groupId": 15,
        ///  "groupName": "Canh",
        ///  "description": "123"
        /// }
        /// ]
        /// </response>
        [HttpGet("getlistgroup/{accountId}")]
        public JsonResult GetGroupList(int accountId)
        {
            string functionName = System.Reflection.MethodBase.GetCurrentMethod().Name;

            try
            {
                //Check value enter id account
                if (accountId == 0)
                {
                    Log4Net.log.Error(className + "." + functionName + " - " + Log4Net.AddErrorLog(Constants.emailAndPasswordWrong));
                    return Json(MessageResult.GetMessage(MessageType.EMAIL_AND_PASSWORD_WRONG));
                }

                //get group list by owner Id
                List<GroupOwnerEntity> groupEntities = _groupRepository.GetGroupListByOwnerId(accountId);

                List<GroupMemberEntity> groupMembers = _groupMemberRepository.GetGroupMemberByAccountId(accountId);

                if (groupEntities == null)
                {
                    Log4Net.log.Error(className + "." + functionName + " - " + Log4Net.AddErrorLog(Constants.groupNotFound));
                    return Json(MessageResult.GetMessage(MessageType.GROUP_NOT_FOUND));
                }

                // Create new list result to get data
                List<GroupListResult> groupListResult = new List<GroupListResult>();

                foreach (var groupOwner in groupEntities)
                {
                    GroupEntity group = _groupRepository.GetGroupById(groupOwner.GroupId);
                    GroupListResult groupList = new GroupListResult();
                    groupList.groupId = groupOwner.GroupId.ToString("0000");
                    groupList.groupOwnerId = groupOwner.GroupOwnerId;
                    groupList.ownerGroupId = groupOwner.AccountId;
                    groupList.groupName = group.Name;
                    groupList.description = group.Description;
                    groupListResult.Add(groupList);
                }

                foreach (var groupMember in groupMembers)
                {
                    GroupEntity group = _groupRepository.GetGroupById(groupMember.GroupId);
                    GroupListResult groupList = new GroupListResult();
                    groupList.groupId = groupMember.GroupId.ToString("0000");
                    groupList.groupOwnerId = groupMember.GroupMemberId;
                    groupList.ownerGroupId = groupMember.AccountId;
                    groupList.groupName = group.Name;
                    groupList.description = group.Description;
                    groupListResult.Add(groupList);
                }

                return Json(groupListResult.OrderByDescending(a => a.groupId));
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
        /// <param name="accountId">Get id owner on the url</param> 
        /// <response code="200">
        /// [
        ///   {
        ///    "groupOwnerId": 1016,
        ///    "ownerGroupId": 42,
        ///    "groupId": "1012",
        ///    "groupName": "ABC",
        ///    "description": "ABC"
        ///   },
        ///   {
        ///    "groupOwnerId": 1013,
        ///    "ownerGroupId": 42,
        ///    "groupId": "1009",
        ///    "groupName": "Delete Group",
        ///    "description": "Delete Group"
        ///   }
        /// ]
        /// </response>
        [HttpGet("getlistgroupowner/{accountId}")]
        public JsonResult GetGroupOwnerList(int accountId)
        {
            string functionName = System.Reflection.MethodBase.GetCurrentMethod().Name;

            try
            {
                //Check value enter id account
                if (accountId == 0)
                {
                    Log4Net.log.Error(className + "." + functionName + " - " + Log4Net.AddErrorLog(Constants.emailAndPasswordWrong));
                    return Json(MessageResult.GetMessage(MessageType.EMAIL_AND_PASSWORD_WRONG));
                }

                //get group list by owner Id
                List<GroupOwnerEntity> groupEntities = _groupRepository.GetGroupListByOwnerId(accountId);

                if (groupEntities == null)
                {
                    Log4Net.log.Error(className + "." + functionName + " - " + Log4Net.AddErrorLog(Constants.groupNotFound));
                    return Json(MessageResult.GetMessage(MessageType.GROUP_NOT_FOUND));
                }

                // Create new list result to get data
                List<GroupListResult> groupListResult = new List<GroupListResult>();

                foreach (var groupOwner in groupEntities)
                {
                    GroupEntity group = _groupRepository.GetGroupById(groupOwner.GroupId);
                    GroupListResult groupList = new GroupListResult();
                    groupList.groupId = groupOwner.GroupId.ToString("0000");
                    groupList.groupOwnerId = groupOwner.GroupOwnerId;
                    groupList.ownerGroupId = groupOwner.AccountId;
                    groupList.groupName = group.Name;
                    groupList.description = group.Description;
                    groupListResult.Add(groupList);
                }

                return Json(groupListResult.OrderByDescending(a => a.groupId));
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
        /// <response code="200">
        /// [
        ///  {
        ///    "groupMemberId": 9,
        ///    "groupId": 2,
        ///    "accountId": 9,
        ///    "email": "vuong113@gmail.com",
        ///    "fullName": "Nguyễn Văn Té",
        ///    "address": "Đà Nẵng",
        ///    "phoneNumber": "03259689"
        ///  },
        ///  {
        ///    "groupMemberId": 1032,
        ///    "groupId": 2,
        ///    "accountId": 11,
        ///    "email": "canhtruong@gmail.com",
        ///    "fullName": "Trương Văn Cảnh",
        ///    "address": "Huế",
        ///    "phoneNumber": "08996556322"
        ///  }
        /// ]
        /// </response>
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
        /// Search member by name function
        /// </summary>
        /// <param name="groupId">Get id group on the url</param> 
        /// <param name="name">Get account name on the url</param>
        /// <response code="200">
        /// [
        ///  {
        ///    "accountId": 9,
        ///    "fullName": "Nguyễn Văn Hòa"
        ///  }
        /// ]
        /// </response>
        [HttpGet("searchmember/{name}")]
        public JsonResult SearchMemberInGroup(string name)
        {
            //get method name
            string functionName = System.Reflection.MethodBase.GetCurrentMethod().Name;
            try
            {
                //Check value enter id group
                if (name == null)
                {
                    Log4Net.log.Error(className + "." + functionName + " - " + Log4Net.AddErrorLog(Constants.valueIsNull));
                    return Json(MessageResult.GetMessage(MessageType.VALUEISNULL));
                }

                List<SearchResult> listResult = new List<SearchResult>();
                //get all member with contain name from form body
                List<AccountEntity> memberEntities = _accountRepository.SearchMemberByName(name);
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
                else
                {
                    Log4Net.log.Error(className + "." + functionName + " - " + Log4Net.AddErrorLog(Constants.notInformationAccount));
                    return Json(MessageResult.GetMessage(MessageType.NOT_INFORMATION_MEMBER));
                }

                return Json(listResult.Take(10));
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
        /// <response code="200">
        /// {
        ///  "ownerId": 9,
        ///  "examResults": [
        ///   {
        ///    "ownerId": 9,
        ///    "examId": 11,
        ///    "name": "Exam 1",
        ///    "status": "Finish"
        ///   },
        ///   {
        ///    "ownerId": 9,
        ///    "examId": 25,
        ///    "name": "vuong 123123",
        ///    "status": "Do Exam"
        ///   }
        ///   ]
        ///  }
        /// </response>
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
                GroupOwnerEntity ownerEntity = _groupOwnerRepository.GetGroupOwnerByGroupId(groupId);
                foreach (var accountExam in listAccountExams)
                {
                    ExamEntity examEntity = _examRepository.GetExamById(accountExam.ExamId);
                    if (examEntity.GroupId == groupId)
                    {
                        ExamResult result = new ExamResult();
                        result.examId = accountExam.ExamId;
                        result.name = examEntity.Name;
                        result.status = accountExam.IsStatus;
                        examResults.Add(result);
                    }
                }

                ExamResultHasOwner examResultHasOwner = new ExamResultHasOwner();
                examResultHasOwner.ownerId = ownerEntity.AccountId;
                examResultHasOwner.examResults = examResults;
                return Json(examResultHasOwner);
            }
            catch (Exception ex)
            {
                Log4Net.log.Error(className + "." + functionName + " - " + Log4Net.AddErrorLog(ex.Message));
                return Json(MessageResult.ShowServerError(ex.Message));
            }
        }

        /// <summary>
        /// Create group function
        /// </summary>
        /// <param name="group">The group information from body</param> 
        /// <response code="200">You created the group successfully!</response>
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

                Log4Net.log.Error(className + "." + functionName + " - " + Log4Net.AddErrorLog(Constants.groupCreated));
                return Json(MessageResult.GetMessage(MessageType.GROUP_CREATED));
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
        /// <response code="200">You add member into the group successfully!</response>
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

                GroupMemberEntity groupMemberEntity = _groupMemberRepository.GetGroupMemberByGroupIdAndAccountId(groupId, account.accountID);

                if (groupMemberEntity != null)
                {
                    Log4Net.log.Error(className + "." + functionName + " - " + Log4Net.AddErrorLog(Constants.groupMemberExist));
                    return Json(MessageResult.GetMessage(MessageType.GROUP_MEMBER_EXIST));
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

                List<ExamEntity> listExamEntity = _examRepository.GetListExamByGroupId(groupId);

                foreach (var item in listExamEntity)
                {
                    AccountExamEntity accountExamEntity = new AccountExamEntity();
                    accountExamEntity.AccountId = accountEntity.AccountId;
                    accountExamEntity.ExamId = item.ExamId;
                    accountExamEntity.IsStatus = "Do Exam";
                    _accountExamRepository.CreateAccountExam(accountExamEntity);
                }

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
        /// Update information group function
        /// </summary>
        /// <param name="group">The group information from body</param> 
        /// <response code="200">You updated the group successfully!</response>
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
        /// <response code="200">You deleted the group successfully!</response>
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
        /// Delete member by owner function
        /// </summary>
        /// <param name="groupId">Get id group on the url</param> 
        /// <param name="accountId">Get id account on the url</param> 
        /// <response code="200">You deleted the member successfully!</response>
        [HttpDelete("deletemember/{groupId}/{accountId}")]
        public JsonResult DeleteMember(int groupId, int accountId)
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
                var memberEntity = _groupMemberRepository.GetGroupMemberByGroupIdAndAccountId(groupId ,accountId);

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
    }
}
