﻿using Microsoft.AspNetCore.Mvc;
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
using Microsoft.AspNetCore.Http;

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

        /// <summary>
        /// Login function
        /// </summary>
        /// <param name="account">The account information from body</param>        
        [HttpPost("login")]
        public JsonResult Login([FromBody] AccountEntity account)
        {
            try
            {
                if (account == null)
                {
                    return Json(MessageResult.GetMessage(MessageType.NOT_ENTER_EMAIL));
                }

                //This is hash password
                string hastPwd = PasswordUtil.CreateMD5(account.Password);

                //Query account following email and password
                AccountEntity accountEntity = _accountRepository.LoginAccount(account.Email, hastPwd);

                if (accountEntity == null)
                {
                    return Json(MessageResult.GetMessage(MessageType.EMAIL_AND_PASSWORD_WRONG));
                }

                //This is get list role of account entity
                IEnumerable<AccountRoleEntity> listRole = _accountRepository.GetAccountRoles(accountEntity.AccountId);

                //This is set data for login result            
                LoginResult result = new LoginResult();


                HttpContext.Session.SetInt32("accountId", account.AccountId);
                result.accountId = accountEntity.AccountId;
                result.email = accountEntity.Email;
                result.password = accountEntity.Password;
                result.firstName = accountEntity.FirstName;
                result.lastName = accountEntity.LastName;
                result.phoneNumber = accountEntity.Phone;
                result.address = accountEntity.Address;
                var a = HttpContext.Session.Get("accountId");
                result.Session = a;
                var listRoles = new List<string>();

                List<RoleEntity> roles = new List<RoleEntity>();

                //Browser the elements of list role
                foreach (var poi in listRole)
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
            catch(Exception ex)
            {
                return Json(ex.Message);
            }
                   

        }

        /// <summary>
        /// Forgot password function
        /// </summary>
        /// <param name="account">The account information from body</param> 
        [HttpGet("forgotpassword")]
        public JsonResult ForgotPassword([FromBody] AccountEntity account)
        {
            try
            {
                //Check value enter from the form 
                if (account == null)
                {
                    return Json(MessageResult.GetMessage(MessageType.NOT_ENTER_EMAIL));
                }

                //Check email enter from the form not exist in the database
                if (_accountRepository.EmailExist(account.Email))
                {
                    return Json(MessageResult.GetMessage(MessageType.EMAIL_NOT_EXIST));
                }

                if (!ModelState.IsValid)
                {
                    return Json(MessageResult.GetMessage(MessageType.NOT_FOUND));
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
                    return Json(MessageResult.GetMessage(MessageType.BAD_REQUEST));
                }

                return Json(MessageResult.GetMessage(MessageType.SEND_PASSWORD));
            }
            catch(Exception ex)
            {
                return Json(ex.Message);
            }
            
        }

        /// <summary>
        /// Register user function
        /// </summary>
        /// <param name="account">The account information from body</param> 
        [HttpPost("register")]
        public JsonResult CreatePointOfInterest([FromBody] AccountForCreationDto account)
        {
            try
            {
                //Check value enter from the form 
                if (account == null)
                {
                    return Json(MessageResult.GetMessage(MessageType.NOT_INFORMATION_ACCOUNT));
                }

                if (!ModelState.IsValid)
                {
                    return Json(MessageResult.GetMessage(MessageType.NOT_FOUND));
                }

                //Check email enter from the form exist in the database
                if (!_accountRepository.EmailExist(account.Email))
                {
                    return Json(MessageResult.GetMessage(MessageType.EMAIL_EXIST));
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
                    return Json(MessageResult.GetMessage(MessageType.BAD_REQUEST));
                }

                return Json(MessageResult.GetMessage(MessageType.REGISTER_SUCCESS)); //For example here. It should be the list of MessageResult. More details. 1=You registered the account successfully!; 2=.... Understand?

            }
            catch (Exception ex)
            {
                return Json(ex.Message);
            }
        }

        /// <summary>
        /// Get information account function
        /// </summary>
        /// <param name="id">Get id account on the url</param> 
        [HttpGet("getinformationaccount/{id}")]
        public JsonResult GetInformationAccount(int id)
        {
            try
            {
                //Check id account exist in the database
                if (!_accountRepository.AccountExists(id))
                {
                    return Json(MessageResult.GetMessage(MessageType.ACCOUNT_NOT_FOUND));
                }

                if (!ModelState.IsValid)
                {
                    return Json(MessageResult.GetMessage(MessageType.NOT_FOUND));
                }

                //This is get all information of account
                AccountEntity account = _accountRepository.GetAccountById(id);

                return Json(account);
            }
            catch(Exception ex)
            {
                return Json(ex.Message);
            }
           
        }

        /// <summary>
        /// Update information account function
        /// </summary>
        /// <param name="id">Get id account on the url</param>
        /// <param name="account">The account information from body</param>
        [HttpPut("updateinformationaccount")]
        public JsonResult UpdateAccount( [FromBody] AccountForUpdateDto account)
        {
            try
            {
                //Check id account exist in the database
                if (!_accountRepository.AccountExists(account.accountId))
                {
                    return Json(MessageResult.GetMessage(MessageType.ACCOUNT_NOT_FOUND));
                }

                //Check value enter from the form 
                if (account == null)
                {
                    return Json(MessageResult.GetMessage(MessageType.NOT_INFORMATION_ACCOUNT));
                }

                if (!ModelState.IsValid)
                {
                    return Json(MessageResult.GetMessage(MessageType.NOT_FOUND));
                }

                //This is get all information of account
                var accountEntity = _accountRepository.GetAccountById(account.accountId);

                if (accountEntity == null)
                {
                    return Json(MessageResult.GetMessage(MessageType.NOT_FOUND));
                }

                //Map data enter from the form to account entity
                Mapper.Map(account, accountEntity);

                if (!_accountRepository.Save())
                {
                    return Json(MessageResult.GetMessage(MessageType.BAD_REQUEST));
                }

                return Json(MessageResult.GetMessage(MessageType.ACCOUNT_UPDATED));
            }
            catch(Exception ex)
            {
                return Json(ex.Message);
            }
            
        }

        /// <summary>
        /// Change password account function
        /// </summary>
        /// <param name="id">Get id account on the url</param>
        /// <param name="account">The account information from body</param>
        [HttpPost("updatepasswordaccount")]
        public JsonResult UpdateAccountPatch([FromBody] ChangingPassword account)
        {
            try
            {
                //Check id account exist in the database
                if (!_accountRepository.AccountExists(account.accountId))
                {
                    return Json(MessageResult.GetMessage(MessageType.ACCOUNT_NOT_FOUND));
                }

                //Check value enter from the form 
                if (account == null)
                {
                    return Json(MessageResult.GetMessage(MessageType.NOT_INFORMATION_ACCOUNT));
                }

                if (!ModelState.IsValid)
                {
                    return Json(MessageResult.GetMessage(MessageType.NOT_FOUND));
                }

                var oldPass = PasswordUtil.CreateMD5(account.oldPassword);

                //This is get all information of account
                var accountEntity = _accountRepository.GetAccountById(account.accountId);

                if (accountEntity == null)
                {
                    return Json(MessageResult.GetMessage(MessageType.EMAIL_AND_PASSWORD_WRONG));
                }

                //This is check old password
                if (accountEntity.Password != oldPass)
                {
                    return Json(MessageResult.GetMessage(MessageType.OLD_PASSWORD_NOT_TRUE));
                }

                //This is update new password
                accountEntity.Password = PasswordUtil.CreateMD5(account.newPassword);

                if (!_accountRepository.Save())
                {
                    return Json(MessageResult.GetMessage(MessageType.BAD_REQUEST));
                }

                return Json(MessageResult.GetMessage(MessageType.ACCOUNT_UPDATED));
            }
            catch(Exception ex)
            {
                return Json(ex.Message);
            }
            
        }

        /// <summary>
        /// Delete account function
        /// </summary>
        /// <param name="id">Get id account on the url</param>
        [HttpDelete("deleteaccount/{id}")]
        public JsonResult DeleteAccount(int id)
        {
            try
            {
                //Check id account exist in the database
                if (!_accountRepository.AccountExists(id))
                {
                    return Json(MessageResult.GetMessage(MessageType.ACCOUNT_NOT_FOUND));
                }

                //This is get all information of account
                var accountEntity = _accountRepository.GetAccountById(id);

                if (accountEntity == null)
                {
                    return Json(MessageResult.GetMessage(MessageType.EMAIL_AND_PASSWORD_WRONG));
                }

                //This is query to delete account
                _accountRepository.DeleteAccount(accountEntity);

                if (!_accountRepository.Save())
                {
                    return Json(MessageResult.GetMessage(MessageType.BAD_REQUEST));
                }

                return Json(MessageResult.GetMessage(MessageType.ACCOUNT_DELETED));
            }
            catch(Exception ex)
            {
                return Json(ex.Message);
            }
            
        }

        /// <summary>
        /// Get all accounts of the database function
        /// </summary>
        [HttpGet("getallaccounts")]
        public JsonResult GetAllAccounts()
        {
            try
            {
                if (!ModelState.IsValid)
                {
                    return Json(MessageResult.GetMessage(MessageType.NOT_FOUND));
                }

                //This is get all information of account
                List<AccountEntity> listAccounts = _accountRepository.GetAllAccounts();

                List<LoginResult> listAccount = new List<LoginResult>();

                foreach (var item in listAccounts)
                {
                    LoginResult account = new LoginResult();
                    account.email = item.Email;
                    account.firstName = item.FirstName;
                    account.lastName = item.LastName;
                    account.phoneNumber = item.Phone;
                    account.address = item.Address;

                    listAccount.Add(account);
                }

                return Json(listAccount);
            }
            catch(Exception ex)
            {
                return Json(ex.Message);
            }
            
        }
    }
}
