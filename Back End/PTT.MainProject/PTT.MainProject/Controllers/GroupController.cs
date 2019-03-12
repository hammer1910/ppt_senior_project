using AutoMapper;
using Microsoft.AspNetCore.Mvc;
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

        [HttpPost("group/create")]
        public JsonResult CreationGroup([FromBody] GroupForCreationDto group)
        {
            AccountEntity account = AccountController._account; //get account from AccountController stored data user logged in
            if (group == null)
            {
                return Json(MessageResult.GetMessage(3));
            }

            group.CreatedDate = DateTime.Now;

            if (!ModelState.IsValid)
            {
                return Json(MessageResult.GetMessage(4));
            }

            var finalGroup = Mapper.Map<PPT.Database.Entities.GroupEntity>(group);

            //This is query insert account
            _groupRepository.CreationGroup(finalGroup,account);

            if (!_groupRepository.Save())
            {
                return Json(MessageResult.GetMessage(2));
            }

            return Json(MessageResult.GetMessage(1));
        }
        //Add members into group with group ID
        [HttpPost("group/addmembers/{groupId}")]
        public JsonResult AddMember([FromBody] AccountEntity account, int groupId)
        {        
            if (account == null)
            {
                return Json(MessageResult.GetMessage(3));
            }
            
            if (!ModelState.IsValid)
            {
                return Json(MessageResult.GetMessage(4));
            }

            // get group by group Id in line 52
            GroupEntity groupEntity = _groupRepository.GetGroupById(groupId);
            if (groupEntity == null)
            {
                return Json(MessageResult.GetMessage(3));
            }

            // get account by email. Email was input from the form
            AccountEntity accountEntity = _accountRepository.GetAccountByEmail(account.Email);
            if(accountEntity == null)
            {
                return Json(MessageResult.GetMessage(4));
            }

            //This is query add member into this group
            _groupRepository.AddMemberIntoGroup(groupEntity, accountEntity);

            if (!_groupRepository.Save())
            {
                return Json(MessageResult.GetMessage(2));
            }
            return Json(MessageResult.GetMessage(1));
        }

        //This is get information group function
        [HttpGet("getinformationgroup/{groupId}")]
        public JsonResult GetInformationGroup(int groupId)
        {
            //Check id group exist in the database
            if (!_groupRepository.GroupExist(groupId))
            {
                return Json(MessageResult.GetMessage(9));
            }

            if (!ModelState.IsValid)
            {
                return Json(MessageResult.GetMessage(4));
            }

            //This is get all information of group by Id
            GroupEntity groupEntity = _groupRepository.GetGroupById(groupId);

            return Json(groupEntity);
        }

        //This is update information group function
        [HttpPut("updateinformationgroup/{groupId}")]
        public JsonResult UpdateAccount(int groupId, [FromBody] GroupForUpdateDto group)
        {
            //Check id group exist in the database
            if (!_groupRepository.GroupExist(groupId))
            {
                return Json(MessageResult.GetMessage(9));
            }

            //Check value enter from the form 
            if (group == null)
            {
                return Json(MessageResult.GetMessage(3));
            }

            if (!ModelState.IsValid)
            {
                return Json(MessageResult.GetMessage(4));
            }

            //This is get all information of group
            var groupEntity = _groupRepository.GetGroupById(groupId);

            if (groupEntity == null)
            {
                return Json(MessageResult.GetMessage(4));
            }

            //Map data enter from the form to group entity
            Mapper.Map(group, groupEntity);

            if (!_groupRepository.Save())
            {
                return Json(MessageResult.GetMessage(2));
            }

            return Json(MessageResult.GetMessage(10));
        }

        //This is delete group function
        [HttpDelete("deletegroup/{groupId}")]
        public JsonResult DeleteGroup(int groupId)
        {
            //Check id group exist in the database
            if (!_groupRepository.GroupExist(groupId))
            {
                return Json(MessageResult.GetMessage(9));
            }

            //This is get all information of group by Id
            var groupEntity = _groupRepository.GetGroupById(groupId);

            if (groupEntity == null)
            {
                return Json(MessageResult.GetMessage(11));
            }

            //This is query to delete group
            _groupRepository.DeleteGroup(groupEntity);

            if (!_groupRepository.Save())
            {
                return Json(MessageResult.GetMessage(2));
            }

            return Json(MessageResult.GetMessage(13));
        }

        //This is get list group function
        [HttpGet("getlistgroup/{ownerId}")]
        public JsonResult GetGroupList(int ownerId)
        {
            //Check value enter id account
            if (ownerId == 0)
            {
                return Json(MessageResult.GetMessage(11));
            }

            List<GroupOwnerEntity> groupEntities = _groupRepository.GetGroupListByOwnerId(ownerId);

            if (groupEntities == null)
            {
                return Json(MessageResult.GetMessage(14));
            }

            List<GroupListResult> groupListResult = new List<GroupListResult>();

            foreach (var groupOwner in groupEntities)
            {
                GroupListResult groupList = new GroupListResult();
                groupList.groupId = groupOwner.GroupId;
                groupList.groupOwnerId = groupOwner.GroupOwnerId;
                groupList.ownerGroupId = groupOwner.AccountId;
                GroupEntity group = _groupRepository.GetGroupById(groupOwner.GroupId);
                groupList.groupName = group.Name;
                groupListResult.Add(groupList);
            }

            return Json(groupListResult);
        }

        [HttpDelete("{groupId}/outgroup/{accountId}")]
        public JsonResult DeleteGroup(int groupId, int accountId)
        {
            if(groupId == 0 || accountId == 0)
            {
                return Json(ResultMessage.NOTFOUND);
            }
            _groupRepository.OutGroup(groupId, accountId);
            if (!_groupRepository.Save())
            {
                return Json(MessageResult.GetMessage(2));
            }

            return Json(MessageResult.GetMessage(13));
        }
    }
}
