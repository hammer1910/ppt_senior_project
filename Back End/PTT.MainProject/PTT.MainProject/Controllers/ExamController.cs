using AutoMapper;
using Microsoft.AspNetCore.Mvc;
using PPT.Database.Entities;
using PPT.Database.Models;
using PPT.Database.Repositories;
using PPT.Database.ResultObject;
using System;
using System.Collections.Generic;
using System.Linq;
using System.Threading.Tasks;

namespace PTT.MainProject.Controllers
{
    [Route("api/exam")]
    public class ExamController : Controller
    {
        private IExamRepository _examRepository;

        public ExamController(IExamRepository examRepository)
        {
            _examRepository = examRepository;
        }
        //Create exam
        [HttpPost("{groupId}/createexam")]
        public JsonResult CreateExam([FromBody] ExamForCreationDto exam, int groupId)
        {
            //Check value enter from the form 
            if (exam == null)
            {
                return Json(MessageResult.GetMessage(3));
            }
            if (groupId == 0)
            {
                return Json(MessageResult.GetMessage(3));
            }

            if (!ModelState.IsValid)
            {
                return Json(MessageResult.GetMessage(4));
            }

            exam.GroupId = groupId;

            //Map data enter from the form to exam entity
            var finalExam = Mapper.Map<PPT.Database.Entities.ExamEntity>(exam);

            //This is query insert exam
            _examRepository.CreateExam(finalExam);

            if (!_examRepository.Save())
            {
                return Json(MessageResult.GetMessage(2));
            }

            return Json(MessageResult.GetMessage(22)); //For example here. It should be the list of MessageResult. More details. 1=You registered the account successfully!; 2=.... Understand?
        }
    }
}
