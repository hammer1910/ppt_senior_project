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

        [HttpGet("login")]
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
