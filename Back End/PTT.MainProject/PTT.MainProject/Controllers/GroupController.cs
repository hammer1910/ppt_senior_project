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
    public class GroupController : Controller
    {
        private IGroupRepository _groupRepository;
        private IAccountRepository _accountRepository;
        public GroupController(IGroupRepository groupRepository, IAccountRepository accountRepository )
        {
            _groupRepository = groupRepository;
            _accountRepository = accountRepository;
        }

        /// <summary>
        /// Create group function
        /// </summary>
        /// <param name="group">The group information from body</param> 
        /// <param name="accountId">Get id account on the url</param> 
        [HttpPost("{accountId}/group/create")]
        public JsonResult CreationGroup([FromBody] GroupForCreationDto group, int accountId)
        {
            AccountEntity account = _accountRepository.GetAccountById(accountId); //get account from AccountController stored data user logged in
            if (group == null)
            {
                return Json(MessageResult.GetMessage(MessageType.NOT_INFORMATION_GROUP));
            }
            

            //This is get current day
            group.CreatedDate = DateTime.Now;

            if (!ModelState.IsValid)
            {
                return Json(MessageResult.GetMessage(MessageType.NOT_FOUND));
            }

            var finalGroup = Mapper.Map<PPT.Database.Entities.GroupEntity>(group);

            //This is query insert account
            _groupRepository.CreationGroup(finalGroup,account);

            if (!_groupRepository.Save())
            {
                return Json(MessageResult.GetMessage(MessageType.BAD_REQUEST));
            }

            GroupListResult groupListResult = new GroupListResult();
            groupListResult.groupId = finalGroup.GroupId;

            return Json(groupListResult);
        }

        /// <summary>
        /// Add members into group function
        /// </summary>
        /// <param name="account">The account information from body</param> 
        /// <param name="groupId">Get id group on the url</param> 
        [HttpPost("group/addmembers/{groupId}")]
        public JsonResult AddMember([FromBody] AccountEntity account, int groupId)
        {        
            if (account == null)
            {
                return Json(MessageResult.GetMessage(MessageType.NOT_ENTER_EMAIL));
            }
            
            if (!ModelState.IsValid)
            {
                return Json(MessageResult.GetMessage(MessageType.NOT_FOUND));
            }

            // get group by group Id in line 52
            GroupEntity groupEntity = _groupRepository.GetGroupById(groupId);
            if (groupEntity == null)
            {
                return Json(MessageResult.GetMessage(MessageType.GROUP_NOT_FOUND));
            }

            // get account by email. Email was input from the form
            AccountEntity accountEntity = _accountRepository.GetAccountByEmail(account.Email);
            if(accountEntity == null)
            {
                return Json(MessageResult.GetMessage(MessageType.ACCOUNT_NOT_FOUND));
            }

            //This is query add member into this group
            _groupRepository.AddMemberIntoGroup(groupEntity, accountEntity);

            if (!_groupRepository.Save())
            {
                return Json(MessageResult.GetMessage(MessageType.BAD_REQUEST));
            }

            return Json(MessageResult.GetMessage(MessageType.MEMBER_ADDED));
        }

        /// <summary>
        /// Get information group function
        /// </summary>
        /// <param name="groupId">Get id group on the url</param> 
        [HttpGet("getinformationgroup/{groupId}")]
        public JsonResult GetInformationGroup(int groupId)
        {
            //Check id group exist in the database
            if (!_groupRepository.GroupExist(groupId))
            {
                return Json(MessageResult.GetMessage(MessageType.GROUP_NOT_FOUND));
            }

            if (!ModelState.IsValid)
            {
                return Json(MessageResult.GetMessage(MessageType.NOT_FOUND));
            }

            //This is get all information of group by Id
            GroupEntity groupEntity = _groupRepository.GetGroupById(groupId);

            return Json(groupEntity);
        }

        /// <summary>
        /// Update information group function
        /// </summary>
        /// <param name="groupId">Get id group on the url</param> 
        /// <param name="group">The group information from body</param> 
        [HttpPut("updateinformationgroup/{groupId}")]
        public JsonResult UpdateAccount(int groupId, [FromBody] GroupForUpdateDto group)
        {
            //Check id group exist in the database
            if (!_groupRepository.GroupExist(groupId))
            {
                return Json(MessageResult.GetMessage(MessageType.GROUP_NOT_FOUND));
            }

            //Check value enter from the form 
            if (group == null)
            {
                return Json(MessageResult.GetMessage(MessageType.NOT_INFORMATION_GROUP));
            }

            if (!ModelState.IsValid)
            {
                return Json(MessageResult.GetMessage(MessageType.NOT_FOUND));
            }

            //This is get all information of group
            var groupEntity = _groupRepository.GetGroupById(groupId);

            if (groupEntity == null)
            {
                return Json(MessageResult.GetMessage(MessageType.GROUP_NOT_FOUND));
            }

            //Map data enter from the form to group entity
            Mapper.Map(group, groupEntity);

            if (!_groupRepository.Save())
            {
                return Json(MessageResult.GetMessage(MessageType.BAD_REQUEST));
            }

            return Json(MessageResult.GetMessage(MessageType.GROUP_UPDATED));
        }

        /// <summary>
        /// Delete group by owner function
        /// </summary>
        /// <param name="groupId">Get id group on the url</param> 
        [HttpDelete("deletegroup/{groupId}")]
        public JsonResult DeleteGroup(int groupId)
        {
            //Check id group exist in the database
            if (!_groupRepository.GroupExist(groupId))
            {
                return Json(MessageResult.GetMessage(MessageType.GROUP_NOT_FOUND));
            }

            //This is get all information of group by Id
            var groupEntity = _groupRepository.GetGroupById(groupId);

            if (groupEntity == null)
            {
                return Json(MessageResult.GetMessage(MessageType.GROUP_NOT_FOUND));
            }

            //This is query to delete group
            _groupRepository.DeleteGroup(groupEntity);

            if (!_groupRepository.Save())
            {
                return Json(MessageResult.GetMessage(MessageType.BAD_REQUEST));
            }

            return Json(MessageResult.GetMessage(MessageType.GROUP_DELETED));
        }

        /// <summary>
        /// Get list group function
        /// </summary>
        /// <param name="ownerId">Get id owner on the url</param> 
        [HttpGet("getlistgroup/{ownerId}")]
        public JsonResult GetGroupList(int ownerId)
        {
            //Check value enter id account
            if (ownerId == 0)
            {
                return Json(MessageResult.GetMessage(MessageType.EMAIL_AND_PASSWORD_WRONG));
            }
            
            //get group list by owner Id
            List<GroupOwnerEntity> groupEntities = _groupRepository.GetGroupListByOwnerId(ownerId);

            if (groupEntities == null)
            {
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

        [HttpDelete("{groupId}/outgroup/{accountId}")]
        public JsonResult DeleteGroup(int groupId, int accountId)
        {
            if (groupId == 0 || accountId == 0)
            {
                return Json(MessageResult.GetMessage(MessageType.NOT_FOUND));
            }
            _groupRepository.OutGroup(groupId, accountId);

            if (!_groupRepository.Save())
            {
                return Json(MessageResult.GetMessage(MessageType.BAD_REQUEST));
            }

            return Json(MessageResult.GetMessage(MessageType.ACCOUNT_DELETED));
        }

        /// <summary>
        /// Get list member of group function
        /// </summary>
        /// <param name="groupId">Get id group on the url</param> 
        [HttpGet("getlistmember/{groupId}")]
        public JsonResult GetMemberList(int groupId)
        {
            //Check value enter id group
            if (groupId == 0)
            {
                return Json(MessageResult.GetMessage(MessageType.EMAIL_AND_PASSWORD_WRONG));
            }

            List<GroupMemberEntity> memberEntities = _groupRepository.GetMemberListByGroupId(groupId);

            if (memberEntities == null)
            {
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
                memberList.fullName = accountEntity.FirstName + " " + accountEntity.LastName;
                memberList.address = accountEntity.Address;
                memberList.phoneNumber = accountEntity.Phone;
                memberListResult.Add(memberList);
            }

            return Json(memberListResult);
        }

        /// <summary>
        /// Delete member by owner function
        /// </summary>
        /// <param name="accountId">Get id account on the url</param> 
        [HttpDelete("deletemember/{accountId}")]
        public JsonResult DeleteMember(int accountId)
        {
            //Check id group exist in the database
            if (!_accountRepository.AccountExists(accountId))
            {
                return Json(MessageResult.GetMessage(MessageType.ACCOUNT_NOT_FOUND));
            }

            //This is get all member of group by id acount
            var memberEntity = _groupRepository.GetMemberByAccountId(accountId);

            if (memberEntity == null)
            {
                return Json(MessageResult.GetMessage(MessageType.NOT_INFORMATION_MEMBER));
            }

            //This is query to delete member
            _groupRepository.DeleteMember(memberEntity);

            if (!_groupRepository.Save())
            {
                return Json(MessageResult.GetMessage(MessageType.BAD_REQUEST));
            }

            return Json(MessageResult.GetMessage(MessageType.MEMBER_DELETED));
        }
    }
}
