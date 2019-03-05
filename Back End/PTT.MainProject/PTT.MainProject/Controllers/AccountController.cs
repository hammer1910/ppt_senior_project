using Microsoft.AspNetCore.Mvc;
using System;
using System.Collections.Generic;
using System.Linq;
using System.Threading.Tasks;
using PPT.Database.Services;
using PPT.Database.Entities;
using Microsoft.AspNetCore.JsonPatch;
using System.Text;
using PPT.Database.Common;
using PPT.Database.Models;
using AutoMapper;

namespace PTT.MainProject.Controllers
{
    [Route("api/exam")]
    public class AccountController : Controller
    {
        private IAccountRepository _accountRepository;

        public AccountController(IAccountRepository accountRepository)
        {
            _accountRepository = accountRepository;
        }

        [HttpPost("login")]
        public JsonResult Login([FromBody] AccountEntity account)
        {
            if (account == null)
            {
                return null;
            }
            string hastPwd = PasswordUtil.CreateMD5(account.Password);
            AccountEntity accountEntity = _accountRepository.LoginAccount(account.Email, hastPwd);
            if (accountEntity == null)
            {
                return null;
            }
            IEnumerable<AccountRoleEntity> listRole = _accountRepository.GetAccountRoles(accountEntity.AccountId);          
            LoginResult result = new LoginResult();
            result.accountId = accountEntity.AccountId;
            result.email = accountEntity.Email;
            result.password = accountEntity.Password;
            result.phoneNumber = accountEntity.Phone;
            result.address = accountEntity.Address;
            var listRoles = new List<string>();
            List<RoleEntity> roles = new List<RoleEntity>();
            foreach (var poi in listRole )
            {
                RoleEntity roleEntity = _accountRepository.GetRole(poi.RoleId);
                roles.Add(roleEntity);
            }
            foreach (var item in roles)
            {
                listRoles.Add(item.NameRole);
            }
            result.Roles = listRoles;
            return Json(result);           

        }
        
        [HttpGet("forgotpassword/{email}")]
        public IActionResult ForgotPassword(string email)
        {
            if (email == null || _accountRepository.EmailExist(email))
            {
                return BadRequest();
            }
            if (!ModelState.IsValid)
            {
                return BadRequest(ModelState);
            }

            if (!_accountRepository.EmailExist(email))
            {
                string code = SendGmail.ForgotPassword(email);
                AccountEntity account = _accountRepository.GetAccountByEmail(email);
                account.Password = PasswordUtil.CreateMD5(code);
            }

            if (!_accountRepository.Save())
            {
                return StatusCode(500, "A problem happened while handling your request.");
            }

            return Ok(201);
        }

        [HttpPost("register")]
        public IActionResult CreatePointOfInterest([FromBody] AccountForCreationDto account)
        {
            if (account == null)
            {
                return BadRequest();
            }

            if (!ModelState.IsValid)
            {
                return BadRequest(ModelState);
            }

            if (!_accountRepository.EmailExist(account.Email))
            {
                return NotFound();
            }

            SendGmail.SendVertified(account.Email);

            account.Password = PasswordUtil.CreateMD5(account.Password);
            var finalAccount = Mapper.Map<PPT.Database.Entities.AccountEntity>(account);

            _accountRepository.Register(finalAccount);         

            if (!_accountRepository.Save())
            {
                return StatusCode(500, "A problem happened while handling your request.");
            }

            return Ok(201);
        }
    }
}
