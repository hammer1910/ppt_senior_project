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
    }
}
