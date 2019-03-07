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
using PPT.Database.ResultObject;

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

        //This is login function
        [HttpPost("login")]
        public JsonResult Login([FromBody] AccountEntity account)
        {
            if (account == null)
            {
                return Json(MessageResult.GetMessage(6));
            }

            //This is hash password
            string hastPwd = PasswordUtil.CreateMD5(account.Password);

            //Query account following email and password
            AccountEntity accountEntity = _accountRepository.LoginAccount(account.Email, hastPwd);

            if (accountEntity == null)
            {
                return Json(MessageResult.GetMessage(11));
            }

            //This is get list role of account entity
            IEnumerable<AccountRoleEntity> listRole = _accountRepository.GetAccountRoles(accountEntity.AccountId);          

            //This is set data for login result
            LoginResult result = new LoginResult();
            result.accountId = accountEntity.AccountId;
            result.email = accountEntity.Email;
            result.password = accountEntity.Password;
            result.fullName = accountEntity.FirstName + " " + accountEntity.LastName;
            result.phoneNumber = accountEntity.Phone;
            result.address = accountEntity.Address;

            var listRoles = new List<string>();

            List<RoleEntity> roles = new List<RoleEntity>();

            //Browser the elements of list role
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

        //This is forgot password function
        [HttpGet("forgotpassword")]
        public JsonResult ForgotPassword([FromBody] AccountEntity account)
        {
            //Check value enter from the form 
            if (account == null)
            {
                return Json(MessageResult.GetMessage(6));
            }

            //Check email enter from the form not exist in the database
            if (_accountRepository.EmailExist(account.Email))
            {
                return Json(MessageResult.GetMessage(8));
            }

            if (!ModelState.IsValid)
            {
                return Json(MessageResult.GetMessage(4));
            }

            //Check email enter from the form exist in the database
            if (!_accountRepository.EmailExist(account.Email))
            {
                //This is send new password through email
                string code = SendGmail.ForgotPassword(account.Email);

                AccountEntity accountEntity = _accountRepository.GetAccountByEmail(account.Email);
                //This is update new password 
                accountEntity.Password = PasswordUtil.CreateMD5(code);
            }

            if (!_accountRepository.Save())
            {
                return Json(MessageResult.GetMessage(2));
            }

            return Json(MessageResult.GetMessage(7));
        }

        //This is register user function
        [HttpPost("register")]
        public JsonResult CreatePointOfInterest([FromBody] AccountForCreationDto account)
        {
            //Check value enter from the form 
            if (account == null)
            {
                return Json(MessageResult.GetMessage(3));
            }

            if (!ModelState.IsValid)
            {
                return Json(MessageResult.GetMessage(4));
            }

            //Check email enter from the form exist in the database
            if (!_accountRepository.EmailExist(account.Email))
            {
                return Json(MessageResult.GetMessage(5));
            }

            //This is send email to vertified account
            SendGmail.SendVertified(account.Email);

            //Hash new password 
            account.Password = PasswordUtil.CreateMD5(account.Password);

            //Map data enter from the form to account entity
            var finalAccount = Mapper.Map<PPT.Database.Entities.AccountEntity>(account);

            //This is query insert account
            _accountRepository.Register(finalAccount);

            if (!_accountRepository.Save())
            {
                return Json(MessageResult.GetMessage(2));
            }

            return Json(MessageResult.GetMessage(1));
        }

        //This is get information account function
        [HttpGet("getinformationaccount/{id}")]
        public JsonResult GetInformationAccount(int id)
        {
            //Check id account exist in the database
            if (!_accountRepository.AccountExists(id))
            {
                return Json(MessageResult.GetMessage(9));
            }

            if (!ModelState.IsValid)
            {
                return Json(MessageResult.GetMessage(4));
            }

            //This is get all information of account
            AccountEntity account = _accountRepository.GetAccountById(id);

            return Json(account);
        }

        //This is update information account function
        [HttpPut("updateinformationaccount/{id}")]
        public JsonResult UpdateAccount(int id, [FromBody] AccountForUpdateDto account)
        {
            //Check id account exist in the database
            if (!_accountRepository.AccountExists(id))
            {
                return Json(MessageResult.GetMessage(9));
            }

            //Check value enter from the form 
            if (account == null)
            {
                return Json(MessageResult.GetMessage(3));
            }

            if (!ModelState.IsValid)
            {
                return Json(MessageResult.GetMessage(4));
            }

            //This is get all information of account
            var accountEntity = _accountRepository.GetAccountById(id);

            if (accountEntity == null)
            {
                return Json(MessageResult.GetMessage(4));
            }

            //Map data enter from the form to account entity
            Mapper.Map(account, accountEntity);

            if (!_accountRepository.Save())
            {
                return Json(MessageResult.GetMessage(2));
            }

            return Json(MessageResult.GetMessage(10));
        }

        //This is change password account function
        [HttpPost("updatepasswordaccount/{id}")]
        public JsonResult UpdateAccountPatch(int id, [FromBody] ChangingPassword account)
        {
            //Check id account exist in the database
            if (!_accountRepository.AccountExists(id))
            {
                return Json(MessageResult.GetMessage(9));
            }

            //Check value enter from the form 
            if (account == null)
            {
                return Json(MessageResult.GetMessage(3));
            }

            if (!ModelState.IsValid)
            {
                return Json(MessageResult.GetMessage(4));
            }

            var oldPass = PasswordUtil.CreateMD5(account.oldPassword);

            //This is get all information of account
            var accountEntity = _accountRepository.GetAccountById(id);

            if (accountEntity == null)
            {
                return Json(MessageResult.GetMessage(11));
            }

            //This is check old password
            if (accountEntity.Password != oldPass)
            {
                return Json(MessageResult.GetMessage(12));
            }

            //This is update new password
            accountEntity.Password = PasswordUtil.CreateMD5(account.newPassword);

            if (!_accountRepository.Save())
            {
                return Json(MessageResult.GetMessage(2));
            }

            return Json(MessageResult.GetMessage(10));
        }

    }
}
