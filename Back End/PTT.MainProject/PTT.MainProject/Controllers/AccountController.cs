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
using Microsoft.AspNetCore.Http;
using PTT.MainProject.Log;

namespace PTT.MainProject.Controllers
{
    [Route("api/exam")]
    public class AccountController : Controller
    {
        private IAccountRepository _accountRepository;
        private static string className = System.Reflection.MethodBase.GetCurrentMethod().DeclaringType.Name;

        public AccountController(IAccountRepository accountRepository)
        {
            _accountRepository = accountRepository;
            Log4Net.InitLog();
        }

        /// <summary>
        /// Forgot password function
        /// </summary>
        /// <param name="email">Get email of the account on the url</param> 
        /// <response code="200">Your password have send on your email account.</response>
        [HttpGet("forgotpassword/{email}")]
        public JsonResult ForgotPassword(string email)
        {
            string functionName = System.Reflection.MethodBase.GetCurrentMethod().Name;

            try
            {
                //Check value enter from the form 
                if (email == null)
                {
                    Log4Net.log.Error(className + "." + functionName + " - " + Log4Net.AddErrorLog(Constants.notEnterEmail));
                    return Json(MessageResult.GetMessage(MessageType.NOT_ENTER_EMAIL));
                }

                //Check email enter from the form not exist in the database
                if (_accountRepository.EmailExist(email))
                {
                    Log4Net.log.Error(className + "." + functionName + " - " + Log4Net.AddErrorLog(Constants.emailNotExist));
                    return Json(MessageResult.GetMessage(MessageType.EMAIL_NOT_EXIST));
                }

                if (!ModelState.IsValid)
                {
                    Log4Net.log.Error(className + "." + functionName + " - " + Log4Net.AddErrorLog(Constants.notFound));
                    return Json(MessageResult.GetMessage(MessageType.NOT_FOUND));
                }

                //Check email enter from the form exist in the database
                if (!_accountRepository.EmailExist(email))
                {
                    //This is send new password through email
                    string code = SendGmail.ForgotPassword(email);

                    AccountEntity accountEntity = _accountRepository.GetAccountByEmail(email);
                    //This is update new password 
                    accountEntity.Password = PasswordUtil.CreateMD5(code);
                }

                if (!_accountRepository.Save())
                {
                    Log4Net.log.Error(className + "." + functionName + " - " + Log4Net.AddErrorLog(Constants.badRequest));
                    return Json(MessageResult.GetMessage(MessageType.BAD_REQUEST));
                }

                Log4Net.log.Error(className + "." + functionName + " - " + Log4Net.AddErrorLog(Constants.sendPassword));
                return Json(MessageResult.GetMessage(MessageType.SEND_PASSWORD));
            }
            catch (Exception ex)
            {
                Log4Net.log.Error(className + "." + functionName + " - " + Log4Net.AddErrorLog(ex.Message));
                return Json(MessageResult.ShowServerError(ex.Message));
            }

        }

        /// <summary>
        /// Get information account function
        /// </summary>
        /// <param name="id">Get id account on the url</param> 
        /// <response code="200">
        /// "accountId": 9,
        /// "email": "vuong113@gmail.com",
        /// "password": "FE9FC8835E5637C2812035D7623B843B",
        /// "fullName": "Nguyễn Văn Té",
        /// "phone": "03259689",
        /// "address": "Đà Nẵng"
        /// </response>
        [HttpGet("getinformationaccount/{id}")]
        public JsonResult GetInformationAccount(int id)
        {
            string functionName = System.Reflection.MethodBase.GetCurrentMethod().Name;

            try
            {
                //Check id account exist in the database
                if (!_accountRepository.AccountExists(id))
                {
                    Log4Net.log.Error(className + "." + functionName + " - " + Log4Net.AddErrorLog(Constants.accountNotFound));
                    return Json(MessageResult.GetMessage(MessageType.ACCOUNT_NOT_FOUND));
                }

                if (!ModelState.IsValid)
                {
                    Log4Net.log.Error(className + "." + functionName + " - " + Log4Net.AddErrorLog(Constants.notFound));
                    return Json(MessageResult.GetMessage(MessageType.NOT_FOUND));
                }

                //This is get all information of account
                AccountEntity account = _accountRepository.GetAccountById(id);

                return Json(account);
            }
            catch (Exception ex)
            {
                Log4Net.log.Error(className + "." + functionName + " - " + Log4Net.AddErrorLog(ex.Message));
                return Json(MessageResult.ShowServerError(ex.Message));
            }

        }

        /// <summary>
        /// Get all accounts of the database function
        /// </summary>
        /// <response code="200">
        /// [
        /// {
        ///  "accountId": 9,
        ///  "email": "vuong113@gmail.com",
        ///  "password": null,
        ///  "fullName": "Nguyễn Văn Té",
        ///  "address": "Đà Nẵng",
        ///  "phoneNumber": "03259689",
        /// },
        /// {
        ///  "accountId": 11,
        ///  "email": "canhtruong@gmail.com",
        ///  "password": null,
        ///  "fullName": "Trương Văn Cảnh",
        ///  "address": "Huế",
        /// "phoneNumber": "08996556322",
        /// }
        /// ]
        /// </response>
        [HttpGet("getallaccounts")]
        public JsonResult GetAllAccounts()
        {
            string functionName = System.Reflection.MethodBase.GetCurrentMethod().Name;

            try
            {
                if (!ModelState.IsValid)
                {
                    Log4Net.log.Error(className + "." + functionName + " - " + Log4Net.AddErrorLog(Constants.notFound));
                    return Json(MessageResult.GetMessage(MessageType.NOT_FOUND));
                }

                //This is get all information of account
                List<AccountEntity> listAccounts = _accountRepository.GetAllAccounts();

                List<LoginResult> listAccount = new List<LoginResult>();

                foreach (var item in listAccounts)
                {
                    IEnumerable<AccountRoleEntity> listRole = _accountRepository.GetAccountRoles(item.AccountId);
                    LoginResult account = new LoginResult();
                    account.accountId = item.AccountId;
                    account.email = item.Email;
                    account.fullName = item.FullName;
                    account.phoneNumber = item.Phone;
                    account.address = item.Address;
                    var listRoles = new List<string>();

                    List<RoleEntity> roles = new List<RoleEntity>();

                    //Browser the elements of list role
                    foreach (var poi in listRole)
                    {
                        RoleEntity roleEntity = _accountRepository.GetRole(poi.RoleId);
                        roles.Add(roleEntity);
                    }

                    foreach (var role in roles)
                    {
                        listRoles.Add(role.NameRole);
                    }

                    account.Roles = listRoles;

                    listAccount.Add(account);
                }

                return Json(listAccount);
            }
            catch (Exception ex)
            {
                Log4Net.log.Error(className + "." + functionName + " - " + Log4Net.AddErrorLog(ex.Message));
                return Json(MessageResult.ShowServerError(ex.Message));
            }

        }

        /// <summary>
        /// Login function
        /// </summary>
        /// <param name="account">The account information from body</param>  
        /// <response code="200">
        /// "accountId": 9,
        /// "email": "vuong113@gmail.com",
        /// "password": "E10ADC3949BA59ABBE56E057F20F883E",
        /// "fullName": "Nguyễn Văn Té",
        /// "address": "Đà Nẵng",
        /// "phoneNumber": "03259689",
        /// "roles": [
        /// "user"
        /// ],
        /// "session": "AAAAAA=="
        /// </response>
        [HttpPost("login")]
        public JsonResult Login([FromBody] AccountDto account)
        {
            string functionName = System.Reflection.MethodBase.GetCurrentMethod().Name;

            try
            {
                if (account == null)
                {
                    Log4Net.log.Error(className + "." + functionName + " - " + Log4Net.AddErrorLog(Constants.notEnterEmail));
                    return Json(MessageResult.GetMessage(MessageType.NOT_ENTER_EMAIL));
                }

                //This is hash password
                string hastPwd = PasswordUtil.CreateMD5(account.password);

                //Query account following email and password
                AccountEntity accountEntity = _accountRepository.LoginAccount(account.email, hastPwd);

                if (accountEntity == null)
                {
                    Log4Net.log.Error(className + "." + functionName + " - " + Log4Net.AddErrorLog(Constants.emailAndPasswordWrong));
                    return Json(MessageResult.GetMessage(MessageType.EMAIL_AND_PASSWORD_WRONG));
                }

                //This is get list role of account entity
                IEnumerable<AccountRoleEntity> listRole = _accountRepository.GetAccountRoles(accountEntity.AccountId);

                //This is set data for login result            
                LoginResult result = new LoginResult();


                HttpContext.Session.SetInt32("accountId", account.accountId);
                result.accountId = accountEntity.AccountId;
                result.email = accountEntity.Email;
                result.password = accountEntity.Password;
                result.fullName = accountEntity.FullName;
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
            catch (Exception ex)
            {
                Log4Net.log.Error(className + "." + functionName + " - " + Log4Net.AddErrorLog(ex.Message));
                return Json(MessageResult.ShowServerError(ex.Message));
            }


        }        

        /// <summary>
        /// Register user function
        /// </summary>
        /// <param name="account">The account information from body</param> 
        /// <response code="200">You registered the account successfully!</response>
        [HttpPost("register")]
        public JsonResult CreatePointOfInterest([FromBody] AccountForCreationDto account)
        {
            string functionName = System.Reflection.MethodBase.GetCurrentMethod().Name;

            try
            {
                //Check value enter from the form 
                if (account == null)
                {
                    Log4Net.log.Error(className + "." + functionName + " - " + Log4Net.AddErrorLog(Constants.notInformationAccount));
                    return Json(MessageResult.GetMessage(MessageType.NOT_INFORMATION_ACCOUNT));
                }

                if (!ModelState.IsValid)
                {
                    Log4Net.log.Error(className + "." + functionName + " - " + Log4Net.AddErrorLog(Constants.notFound));
                    return Json(MessageResult.GetMessage(MessageType.NOT_FOUND));
                }

                //Check email enter from the form exist in the database
                if (!_accountRepository.EmailExist(account.Email))
                {
                    Log4Net.log.Error(className + "." + functionName + " - " + Log4Net.AddErrorLog(Constants.emailExist));
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
                    Log4Net.log.Error(className + "." + functionName + " - " + Log4Net.AddErrorLog(Constants.badRequest));
                    return Json(MessageResult.GetMessage(MessageType.BAD_REQUEST));
                }

                Log4Net.log.Error(className + "." + functionName + " - " + Log4Net.AddErrorLog(Constants.registerSuccess));
                return Json(MessageResult.GetMessage(MessageType.REGISTER_SUCCESS));
            }
            catch (Exception ex)
            {
                Log4Net.log.Error(className + "." + functionName + " - " + Log4Net.AddErrorLog(ex.Message));
                return Json(MessageResult.ShowServerError(ex.Message));
            }
        }                

        /// <summary>
        /// Change password account function
        /// </summary>
        /// <param name="account">The account information from body</param>
        /// <response code="200">Your account information updated successfully.</response>
        [HttpPost("updatepasswordaccount")]
        public JsonResult UpdateAccountPatch([FromBody] ChangingPassword account)
        {
            string functionName = System.Reflection.MethodBase.GetCurrentMethod().Name;

            try
            {
                //Check id account exist in the database
                if (!_accountRepository.AccountExists(account.accountId))
                {
                    Log4Net.log.Error(className + "." + functionName + " - " + Log4Net.AddErrorLog(Constants.accountNotFound));
                    return Json(MessageResult.GetMessage(MessageType.ACCOUNT_NOT_FOUND));
                }

                //Check value enter from the form 
                if (account == null)
                {
                    Log4Net.log.Error(className + "." + functionName + " - " + Log4Net.AddErrorLog(Constants.notInformationAccount));
                    return Json(MessageResult.GetMessage(MessageType.NOT_INFORMATION_ACCOUNT));
                }

                if (!ModelState.IsValid)
                {
                    Log4Net.log.Error(className + "." + functionName + " - " + Log4Net.AddErrorLog(Constants.notFound));
                    return Json(MessageResult.GetMessage(MessageType.NOT_FOUND));
                }

                var oldPass = PasswordUtil.CreateMD5(account.oldPassword);

                //This is get all information of account
                var accountEntity = _accountRepository.GetAccountById(account.accountId);

                if (accountEntity == null)
                {
                    Log4Net.log.Error(className + "." + functionName + " - " + Log4Net.AddErrorLog(Constants.emailAndPasswordWrong));
                    return Json(MessageResult.GetMessage(MessageType.EMAIL_AND_PASSWORD_WRONG));
                }

                //This is check old password
                if (accountEntity.Password != oldPass)
                {
                    Log4Net.log.Error(className + "." + functionName + " - " + Log4Net.AddErrorLog(Constants.oldPasswordNotTrue));
                    return Json(MessageResult.GetMessage(MessageType.OLD_PASSWORD_NOT_TRUE));
                }

                //This is update new password
                accountEntity.Password = PasswordUtil.CreateMD5(account.newPassword);

                if (!_accountRepository.Save())
                {
                    Log4Net.log.Error(className + "." + functionName + " - " + Log4Net.AddErrorLog(Constants.badRequest));
                    return Json(MessageResult.GetMessage(MessageType.BAD_REQUEST));
                }

                Log4Net.log.Error(className + "." + functionName + " - " + Log4Net.AddErrorLog(Constants.accountUpdated));
                return Json(MessageResult.GetMessage(MessageType.ACCOUNT_UPDATED));
            }
            catch (Exception ex)
            {
                Log4Net.log.Error(className + "." + functionName + " - " + Log4Net.AddErrorLog(ex.Message));
                return Json(MessageResult.ShowServerError(ex.Message));
            }

        }

        /// <summary>
        /// Update information account function
        /// </summary>
        /// <param name="account">The account information from body</param>
        /// <response code="200">Your account information updated successfully.</response>
        [HttpPut("updateinformationaccount")]
        public JsonResult UpdateAccount([FromBody] AccountForUpdateDto account)
        {
            string functionName = System.Reflection.MethodBase.GetCurrentMethod().Name;

            try
            {
                //Check id account exist in the database
                if (!_accountRepository.AccountExists(account.accountId))
                {
                    Log4Net.log.Error(className + "." + functionName + " - " + Log4Net.AddErrorLog(Constants.accountNotFound));
                    return Json(MessageResult.GetMessage(MessageType.ACCOUNT_NOT_FOUND));
                }

                //Check value enter from the form 
                if (account == null)
                {
                    Log4Net.log.Error(className + "." + functionName + " - " + Log4Net.AddErrorLog(Constants.notInformationAccount));
                    return Json(MessageResult.GetMessage(MessageType.NOT_INFORMATION_ACCOUNT));
                }

                if (!ModelState.IsValid)
                {
                    Log4Net.log.Error(className + "." + functionName + " - " + Log4Net.AddErrorLog(Constants.notFound));
                    return Json(MessageResult.GetMessage(MessageType.NOT_FOUND));
                }

                //This is get all information of account
                var accountEntity = _accountRepository.GetAccountById(account.accountId);

                if (accountEntity == null)
                {
                    Log4Net.log.Error(className + "." + functionName + " - " + Log4Net.AddErrorLog(Constants.accountNotFound));
                    return Json(MessageResult.GetMessage(MessageType.ACCOUNT_NOT_FOUND));
                }

                //Map data enter from the form to account entity
                Mapper.Map(account, accountEntity);

                if (!_accountRepository.Save())
                {
                    Log4Net.log.Error(className + "." + functionName + " - " + Log4Net.AddErrorLog(Constants.badRequest));
                    return Json(MessageResult.GetMessage(MessageType.BAD_REQUEST));
                }

                Log4Net.log.Error(className + "." + functionName + " - " + Log4Net.AddErrorLog(Constants.accountUpdated));
                return Json(MessageResult.GetMessage(MessageType.ACCOUNT_UPDATED));
            }
            catch (Exception ex)
            {
                Log4Net.log.Error(className + "." + functionName + " - " + Log4Net.AddErrorLog(ex.Message));
                return Json(MessageResult.ShowServerError(ex.Message));
            }

        }

        /// <summary>
        /// Delete account function
        /// </summary>
        /// <param name="id">Get id account on the url</param>
        /// <response code="200">You deleted the account successfully!</response>
        [HttpDelete("deleteaccount/{id}")]
        public JsonResult DeleteAccount(int id)
        {
            string functionName = System.Reflection.MethodBase.GetCurrentMethod().Name;

            try
            {
                //Check id account exist in the database
                if (!_accountRepository.AccountExists(id))
                {
                    Log4Net.log.Error(className + "." + functionName + " - " + Log4Net.AddErrorLog(Constants.accountNotFound));
                    return Json(MessageResult.GetMessage(MessageType.ACCOUNT_NOT_FOUND));
                }

                //This is get all information of account
                var accountEntity = _accountRepository.GetAccountById(id);

                if (accountEntity == null)
                {
                    Log4Net.log.Error(className + "." + functionName + " - " + Log4Net.AddErrorLog(Constants.emailAndPasswordWrong));
                    return Json(MessageResult.GetMessage(MessageType.EMAIL_AND_PASSWORD_WRONG));
                }

                //This is query to delete account
                _accountRepository.DeleteAccount(accountEntity);

                if (!_accountRepository.Save())
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

    }
}
