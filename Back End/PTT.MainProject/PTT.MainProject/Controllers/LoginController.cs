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

namespace PTT.MainProject.Controllers
{
    [Route("api/account")]
    public class LoginController : Controller
    {
        private IAccountRepository _accountRepository;

        public LoginController(IAccountRepository accountRepository)
        {
            _accountRepository = accountRepository;
        }
        [HttpGet]
        public IActionResult Login([FromBody] AccountEntity account)
        {
            if (account == null)
            {
                return BadRequest();
            }
            if (!ModelState.IsValid)
            {
                return BadRequest(ModelState);
            }
            string hastPwd = PasswordUtil.CreateMD5(account.Password);
            AccountEntity accountEntity = _accountRepository.LoginAccount(account.Email, hastPwd);       
            if(accountEntity == null)
            {
                return NotFound();
            }
            return Ok(accountEntity);
        }
        
    }
}
