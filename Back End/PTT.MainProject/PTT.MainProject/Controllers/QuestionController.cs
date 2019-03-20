using AutoMapper;
using Microsoft.AspNetCore.Mvc;
using PPT.Database.Common;
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
    public class QuestionController : Controller
    {
        private IExamRepository _examRepository;
        private IQuestionRepository _questionRepository;
        private IExamQuestionRepository _examQuestionRepository;

        public QuestionController(IExamRepository examRepository, IQuestionRepository questionRepository, IExamQuestionRepository examQuestionRepository)
        {
            _examRepository = examRepository;
            _questionRepository = questionRepository;
            _examQuestionRepository = examQuestionRepository;
        }

        /// <summary>
        /// Create exam function
        /// </summary>
        /// <param name="part1">The information of question from body</param> 
        /// <param name="examId">Get id exam on the url</param>  
        [HttpPost("{examId}/createpartone")]
        public JsonResult CreatePartOne(int examId, [FromBody] QuestionPartOneDto part1)
        {
            //Check value enter from the form 
            if (part1 == null)
            {
                return Json(MessageResult.GetMessage(MessageType.NOT_INFORMATION_QUESTION));
            }

            if (!_examRepository.ExamExist(examId))
            {
                return Json(MessageResult.GetMessage(MessageType.EXAM_NOT_FOUND));
            }

            if (!ModelState.IsValid)
            {
                return Json(MessageResult.GetMessage(MessageType.NOT_FOUND));
            }

            //Map data enter from the form to question entity
            var partOneExam = Mapper.Map<PPT.Database.Entities.QuestionEntity>(part1);

            //This is query insert question
            _questionRepository.CreatePart(partOneExam,examId);

            if (!_questionRepository.Save())
            {
                return Json(MessageResult.GetMessage(MessageType.BAD_REQUEST));
            }

            return Json(MessageResult.GetMessage(MessageType.CREATED_QUESTION));
        }

        /// <summary>
        /// Create exam function
        /// </summary>
        /// <param name="part2">The information of question from body</param> 
        /// <param name="examId">Get id exam on the url</param>
        [HttpPost("{examId}/createparttwo")]
        public JsonResult CreatePartTwo(int examId, [FromBody] QuestionPartTwoDto part2)
        {
            //Check value enter from the form 
            if (part2 == null)
            {
                return Json(MessageResult.GetMessage(MessageType.NOT_INFORMATION_QUESTION));
            }

            if (!_examRepository.ExamExist(examId))
            {
                return Json(MessageResult.GetMessage(MessageType.EXAM_NOT_FOUND));
            }

            if (!ModelState.IsValid)
            {
                return Json(MessageResult.GetMessage(MessageType.NOT_FOUND));
            }

            //Map data enter from the form to question entity
            var partTwoExam = Mapper.Map<PPT.Database.Entities.QuestionEntity>(part2);

            //This is query insert question
            _questionRepository.CreatePart(partTwoExam, examId);

            if (!_questionRepository.Save())
            {
                return Json(MessageResult.GetMessage(MessageType.BAD_REQUEST));
            }

            return Json(MessageResult.GetMessage(MessageType.CREATED_QUESTION));
        }

        /// <summary>
        /// Create exam function
        /// </summary>
        /// <param name="part3">The information of question from body</param> 
        /// <param name="examId">Get id exam on the url</param>  
        [HttpPost("{examId}/createpartthree")]
        public JsonResult CreatePartThree(int examId, [FromBody] QuestionPartThreeAndFourDto part3)
        {
            //Check value enter from the form 
            if (part3 == null)
            {
                return Json(MessageResult.GetMessage(MessageType.NOT_INFORMATION_QUESTION));
            }

            if (!_examRepository.ExamExist(examId))
            {
                return Json(MessageResult.GetMessage(MessageType.EXAM_NOT_FOUND));
            }

            if (!ModelState.IsValid)
            {
                return Json(MessageResult.GetMessage(MessageType.NOT_FOUND));
            }

            //Map data enter from the form to question entity
            var partThreeExam = Mapper.Map<PPT.Database.Entities.QuestionEntity>(part3);

            //This is query insert question
            _questionRepository.CreatePart(partThreeExam, examId);

            if (!_questionRepository.Save())
            {
                return Json(MessageResult.GetMessage(MessageType.BAD_REQUEST));
            }

            return Json(MessageResult.GetMessage(MessageType.CREATED_QUESTION));
        }

        /// <summary>
        /// Create exam function
        /// </summary>
        /// <param name="part4">The information of question from body</param> 
        /// <param name="examId">Get id exam on the url</param>
        [HttpPost("{examId}/createpartfour")]
        public JsonResult CreatePartFour(int examId, [FromBody] QuestionPartThreeAndFourDto part4)
        {
            //Check value enter from the form 
            if (part4 == null)
            { 
                return Json(MessageResult.GetMessage(MessageType.NOT_INFORMATION_QUESTION));
            }

            if (!_examRepository.ExamExist(examId))                        
            {
                return Json(MessageResult.GetMessage(MessageType.EXAM_NOT_FOUND));
            }

            if (!ModelState.IsValid)
            {
                return Json(MessageResult.GetMessage(MessageType.NOT_FOUND));
            }

            //Map data enter from the form to question entity
            var partFourExam = Mapper.Map<PPT.Database.Entities.QuestionEntity>(part4);

            //This is query insert question
            _questionRepository.CreatePart(partFourExam, examId);

            if (!_questionRepository.Save())
            {
                return Json(MessageResult.GetMessage(MessageType.BAD_REQUEST));
            }

            return Json(MessageResult.GetMessage(MessageType.CREATED_QUESTION));
        }

        /// <summary>
        /// Create exam function
        /// </summary>
        /// <param name="part5">The information of question from body</param> 
        /// <param name="examId">Get id exam on the url</param> 
        [HttpPost("{examId}/createpartfive")]
        public JsonResult CreatePartFive(int examId, [FromBody] QuestionPartFiveDto part5)
        {
            //Check value enter from the form 
            if (part5 == null)
            {
                return Json(MessageResult.GetMessage(MessageType.NOT_INFORMATION_QUESTION));
            }

            if (!_examRepository.ExamExist(examId))
            {
                return Json(MessageResult.GetMessage(MessageType.EXAM_NOT_FOUND));
            }

            if (!ModelState.IsValid)
            {
                return Json(MessageResult.GetMessage(MessageType.NOT_FOUND));
            }

            //Map data enter from the form to question entity
            var partFiveExam = Mapper.Map<PPT.Database.Entities.QuestionEntity>(part5);

            //This is query insert question
            _questionRepository.CreatePart(partFiveExam, examId);

            if (!_questionRepository.Save())
            {
                return Json(MessageResult.GetMessage(MessageType.BAD_REQUEST));
            }

            return Json(MessageResult.GetMessage(MessageType.CREATED_QUESTION));
        }

        /// <summary>
        /// Create exam function
        /// </summary>
        /// <param name="part6">The information of question from body</param> 
        /// <param name="examId">Get id exam on the url</param> 
        [HttpPost("{examId}/createpartsix")]
        public JsonResult CreatePartSix(int examId, [FromBody] QuestionPartSixDto part6)
        {
            //Check value enter from the form 
            if (part6 == null)
            {
                return Json(MessageResult.GetMessage(MessageType.NOT_INFORMATION_QUESTION));
            }

            if (!_examRepository.ExamExist(examId))
            {
                return Json(MessageResult.GetMessage(MessageType.EXAM_NOT_FOUND));
            }

            if (!ModelState.IsValid)
            {
                return Json(MessageResult.GetMessage(MessageType.NOT_FOUND));
            }

            //Map data enter from the form to question entity
            var partSixExam = Mapper.Map<PPT.Database.Entities.QuestionEntity>(part6);

            //This is query insert question
            _questionRepository.CreatePart(partSixExam, examId);

            if (!_questionRepository.Save())
            {
                return Json(MessageResult.GetMessage(MessageType.BAD_REQUEST));
            }

            return Json(MessageResult.GetMessage(MessageType.CREATED_QUESTION));
        }

        /// <summary>
        /// Create exam function
        /// </summary>
        /// <param name="part7">The information of question from body</param> 
        /// <param name="examId">Get id exam on the url</param> 
        [HttpPost("{examId}/createpartseven")]
        public JsonResult CreatePartSeven(int examId, [FromBody] QuestionPartSevenDto part7)
        {
            //Check value enter from the form 
            if (part7 == null)
            {
                return Json(MessageResult.GetMessage(MessageType.NOT_INFORMATION_QUESTION));
            }

            if (!_examRepository.ExamExist(examId))
            {
                return Json(MessageResult.GetMessage(MessageType.EXAM_NOT_FOUND));
            }

            if (!ModelState.IsValid)
            {
                return Json(MessageResult.GetMessage(MessageType.NOT_FOUND));
            }

            //Map data enter from the form to question entity
            var partSevenExam = Mapper.Map<PPT.Database.Entities.QuestionEntity>(part7);

            //This is query insert question
            _questionRepository.CreatePart(partSevenExam, examId);

            if (!_questionRepository.Save())
            {
                return Json(MessageResult.GetMessage(MessageType.BAD_REQUEST));
            }

            return Json(MessageResult.GetMessage(MessageType.CREATED_QUESTION));
        }

        /// <summary>
        /// Get all questions of the exam function
        /// </summary>
        /// <param name="examId">Get id exam on the url</param> 
        [HttpGet("{examId}/getListQuestion")]
        public JsonResult GetListQuestion(int examId)
        {
            //Check id exam exist in the database
            if (!_examRepository.ExamExist(examId))
            {
                return Json(MessageResult.GetMessage(MessageType.GROUP_NOT_FOUND));
            }

            if (!ModelState.IsValid)
            {
                return Json(MessageResult.GetMessage(MessageType.NOT_FOUND));
            }

            //This is get all questions of the exam by id exam
            List<ExamQuestionEntity> examQuestionEntity = _examQuestionRepository.getListQuestions(examId);

            List<QuestionEntity> listQuestionEntities = new List<QuestionEntity>();
            foreach (var examQuestion in examQuestionEntity)
            {
                // Get all informations of the question by questionId and save it in the list
                QuestionEntity questionEntity = _questionRepository.getQuestionInformation(examQuestion.QuestionId);
                listQuestionEntities.Add(questionEntity);
            }

            List<QuestionListResult> questionLists = new List<QuestionListResult>();
            foreach (var item in listQuestionEntities)
            {
                QuestionListResult q = new QuestionListResult();
                q.questionId = item.QuestionId;
                q.part = item.Part;
                q.image = item.Image;
                q.fileMp3 = item.FileMp3;
                q.questionName = item.QuestionName;
                q.A = item.A;
                q.B = item.B;
                q.C = item.C;
                q.D = item.D;
                q.correctAnswer = item.CorrectAnswer;
                q.team = item.Team;
                questionLists.Add(q);
            }

            return Json(questionLists);
        }

        /// <summary>
        /// Get all questions of the exam function
        /// </summary>
        /// <param name="examId">Get id exam on the url</param> 
        /// <param name="part">Get part parameter on the url</param> 
        [HttpGet("{examId}/getListQuestionByPart/{part}")]
        public JsonResult GetListQuestionByPart(int examId, string part)
        {
            //Check id exam exist in the database
            if (!_examRepository.ExamExist(examId))
            {
                return Json(MessageResult.GetMessage(MessageType.GROUP_NOT_FOUND));
            }

            if (!ModelState.IsValid)
            {
                return Json(MessageResult.GetMessage(MessageType.NOT_FOUND));
            }

            //This is get all questions of the exam by id exam
            List<ExamQuestionEntity> examQuestionEntity = _examQuestionRepository.getListQuestions(examId);

            List<QuestionEntity> listQuestionEntities = new List<QuestionEntity>();
            foreach (var examQuestion in examQuestionEntity)
            {
                // Get all informations of the question by questionId and save it in the list
                QuestionEntity questionEntity = _questionRepository.getQuestionInformation(examQuestion.QuestionId);
                listQuestionEntities.Add(questionEntity);
            }

            List<QuestionListResult> questionLists = new List<QuestionListResult>();
            foreach (var item in listQuestionEntities)
            {
                QuestionListResult q = new QuestionListResult();
                if (item.Part.Equals(part))
                {
                    q.questionId = item.QuestionId;
                    q.part = item.Part;
                    q.image = item.Image;
                    q.fileMp3 = item.FileMp3;
                    q.questionName = item.QuestionName;
                    q.A = item.A;
                    q.B = item.B;
                    q.C = item.C;
                    q.D = item.D;
                    q.correctAnswer = item.CorrectAnswer;
                    q.team = item.Team;
                    questionLists.Add(q);
                }
                
            }

            return Json(questionLists);
        }

        /// <summary>
        /// Get all informations of the question function
        /// </summary>
        /// <param name="examId">Get id exam on the url</param> 
        /// <param name="questionId">Get id question on the url</param>
        [HttpGet("{examId}/getQuestionInformation/{questionId}")]
        public JsonResult GetInformationGroup(int examId,int questionId)
        {
            //Check id exam exist in the database
            if (!_examRepository.ExamExist(examId))
            {
                return Json(MessageResult.GetMessage(MessageType.GROUP_NOT_FOUND));
            }

            if (!ModelState.IsValid)
            {
                return Json(MessageResult.GetMessage(MessageType.NOT_FOUND));
            }
            QuestionEntity question = null;
            //This is get all information of the exam by examId
            List<ExamQuestionEntity> examQuestionEntity = _examQuestionRepository.getListQuestions(examId);

            QuestionListResult questionListResult = new QuestionListResult();
            foreach (var examQuestion in examQuestionEntity)
            {
                if(examQuestion.QuestionId == questionId)
                {
                    question = _questionRepository.getQuestionInformation(questionId);
                    break;
                }
            }

            questionListResult.questionId = question.QuestionId;
            questionListResult.part = question.Part;
            questionListResult.image = question.Image;
            questionListResult.fileMp3 = question.FileMp3;
            questionListResult.questionName = question.QuestionName;
            questionListResult.A = question.A;
            questionListResult.B = question.B;
            questionListResult.C = question.C;
            questionListResult.D = question.D;
            questionListResult.correctAnswer = question.CorrectAnswer;
            questionListResult.team = question.Team;

            return Json(questionListResult);
        }

        /// <summary>
        /// Update information group function
        /// </summary>
        /// <param name="examId">Get id exam on the url</param> 
        /// <param name="questionId">Get id question on the url</param>
        /// <param name="part1">The question information from body</param>
        [HttpPut("{examId}/updatepartone/{questionId}")]
        public JsonResult UpdateInformationQuestion(int examId, int questionId, [FromBody] QuestionPartOneDto part1)
        {
            //Check id exam exist in the database
            if (!_examRepository.ExamExist(examId))
            {
                return Json(MessageResult.GetMessage(MessageType.EXAM_NOT_FOUND));
            }

            //Check value enter from the form 
            if (part1 == null)
            {
                return Json(MessageResult.GetMessage(MessageType.NOT_INFORMATION_QUESTION));
            }

            if (!ModelState.IsValid)
            {
                return Json(MessageResult.GetMessage(MessageType.BAD_REQUEST));
            }

            QuestionEntity question = null;
            //This is get all information of the exam by examId
            List<ExamQuestionEntity> examQuestionEntity = _examQuestionRepository.getListQuestions(examId);

            foreach (var examQuestion in examQuestionEntity)
            {
                if (examQuestion.QuestionId == questionId)
                {
                    question = _questionRepository.getQuestionInformation(questionId);
                }
            }

            if (question == null)
            {
                return Json(MessageResult.GetMessage(MessageType.EXAM_NOT_FOUND));
            }

            //Map data enter from the form to question entity
            Mapper.Map(part1, question);

            if (!_questionRepository.Save())
            {
                return Json(MessageResult.GetMessage(MessageType.BAD_REQUEST));
            }

            return Json(MessageResult.GetMessage(MessageType.QUESTION_UPDATED));
        }

        /// <summary>
        /// Update information group function
        /// </summary>
        /// <param name="examId">Get id exam on the url</param> 
        /// <param name="questionId">Get id question on the url</param>
        /// <param name="part2">The question information from body</param>
        [HttpPut("{examId}/updateparttwo/{questionId}")]
        public JsonResult UpdateInformationQuestion(int examId, int questionId, [FromBody] QuestionPartTwoDto part2)
        {
            //Check id exam exist in the database
            if (!_examRepository.ExamExist(examId))
            {
                return Json(MessageResult.GetMessage(MessageType.EXAM_NOT_FOUND));
            }

            //Check value enter from the form 
            if (part2 == null)
            {
                return Json(MessageResult.GetMessage(MessageType.NOT_INFORMATION_QUESTION));
            }

            if (!ModelState.IsValid)
            {
                return Json(MessageResult.GetMessage(MessageType.BAD_REQUEST));
            }

            QuestionEntity question = null;
            //This is get all information of the exam by examId
            List<ExamQuestionEntity> examQuestionEntity = _examQuestionRepository.getListQuestions(examId);

            foreach (var examQuestion in examQuestionEntity)
            {
                if (examQuestion.QuestionId == questionId)
                {
                    question = _questionRepository.getQuestionInformation(questionId);
                }
            }

            if (question == null)
            {
                return Json(MessageResult.GetMessage(MessageType.EXAM_NOT_FOUND));
            }

            //Map data enter from the form to question entity
            Mapper.Map(part2, question);

            if (!_questionRepository.Save())
            {
                return Json(MessageResult.GetMessage(MessageType.BAD_REQUEST));
            }

            return Json(MessageResult.GetMessage(MessageType.QUESTION_UPDATED));
        }

        /// <summary>
        /// Update information group function
        /// </summary>
        /// <param name="examId">Get id exam on the url</param> 
        /// <param name="questionId">Get id question on the url</param>
        /// <param name="part3">The question information from body</param>
        [HttpPut("{examId}/updatepartthree/{questionId}")]
        public JsonResult UpdateInformationQuestion(int examId, int questionId, [FromBody] QuestionPartThreeAndFourDto part3)
        {
            //Check id exam exist in the database
            if (!_examRepository.ExamExist(examId))
            {
                return Json(MessageResult.GetMessage(MessageType.EXAM_NOT_FOUND));
            }

            //Check value enter from the form 
            if (part3 == null)
            {
                return Json(MessageResult.GetMessage(MessageType.NOT_INFORMATION_QUESTION));
            }

            if (!ModelState.IsValid)
            {
                return Json(MessageResult.GetMessage(MessageType.BAD_REQUEST));
            }

            QuestionEntity question = null;
            //This is get all information of the exam by examId
            List<ExamQuestionEntity> examQuestionEntity = _examQuestionRepository.getListQuestions(examId);

            foreach (var examQuestion in examQuestionEntity)
            {
                if (examQuestion.QuestionId == questionId)
                {
                    question = _questionRepository.getQuestionInformation(questionId);
                }
            }

            if (question == null)
            {
                return Json(MessageResult.GetMessage(MessageType.EXAM_NOT_FOUND));
            }

            //Map data enter from the form to question entity
            Mapper.Map(part3, question);

            if (!_questionRepository.Save())
            {
                return Json(MessageResult.GetMessage(MessageType.BAD_REQUEST));
            }

            return Json(MessageResult.GetMessage(MessageType.QUESTION_UPDATED));
        }


        /// <summary>
        /// Update information group function
        /// </summary>
        /// <param name="examId">Get id exam on the url</param> 
        /// <param name="questionId">Get id question on the url</param>
        /// <param name="part4">The question information from body</param>
        [HttpPut("{examId}/updatepartfour/{questionId}")]
        public JsonResult UpdateInformationQuestionFour(int examId, int questionId, [FromBody] QuestionPartThreeAndFourDto part4)
        {
            //Check id exam exist in the database
            if (!_examRepository.ExamExist(examId))
            {
                return Json(MessageResult.GetMessage(MessageType.EXAM_NOT_FOUND));
            }

            //Check value enter from the form 
            if (part4 == null)
            {
                return Json(MessageResult.GetMessage(MessageType.NOT_INFORMATION_QUESTION));
            }

            if (!ModelState.IsValid)
            {
                return Json(MessageResult.GetMessage(MessageType.BAD_REQUEST));
            }

            QuestionEntity question = null;
            //This is get all information of the exam by examId
            List<ExamQuestionEntity> examQuestionEntity = _examQuestionRepository.getListQuestions(examId);

            foreach (var examQuestion in examQuestionEntity)
            {
                if (examQuestion.QuestionId == questionId)
                {
                    question = _questionRepository.getQuestionInformation(questionId);
                }
            }

            if (question == null)
            {
                return Json(MessageResult.GetMessage(MessageType.EXAM_NOT_FOUND));
            }

            //Map data enter from the form to question entity
            Mapper.Map(part4, question);

            if (!_questionRepository.Save())
            {
                return Json(MessageResult.GetMessage(MessageType.BAD_REQUEST));
            }

            return Json(MessageResult.GetMessage(MessageType.QUESTION_UPDATED));
        }

        /// <summary>
        /// Update information group function
        /// </summary>
        /// <param name="examId">Get id exam on the url</param> 
        /// <param name="questionId">Get id question on the url</param>
        /// <param name="part5">The question information from body</param>
        [HttpPut("{examId}/updatepartfive/{questionId}")]
        public JsonResult UpdateInformationQuestion(int examId, int questionId, [FromBody] QuestionPartFiveDto part5)
        {
            //Check id exam exist in the database
            if (!_examRepository.ExamExist(examId))
            {
                return Json(MessageResult.GetMessage(MessageType.EXAM_NOT_FOUND));
            }

            //Check value enter from the form 
            if (part5 == null)
            {
                return Json(MessageResult.GetMessage(MessageType.NOT_INFORMATION_QUESTION));
            }

            if (!ModelState.IsValid)
            {
                return Json(MessageResult.GetMessage(MessageType.BAD_REQUEST));
            }

            QuestionEntity question = null;
            //This is get all information of the exam by examId
            List<ExamQuestionEntity> examQuestionEntity = _examQuestionRepository.getListQuestions(examId);

            foreach (var examQuestion in examQuestionEntity)
            {
                if (examQuestion.QuestionId == questionId)
                {
                    question = _questionRepository.getQuestionInformation(questionId);
                }
            }

            if (question == null)
            {
                return Json(MessageResult.GetMessage(MessageType.EXAM_NOT_FOUND));
            }

            //Map data enter from the form to question entity
            Mapper.Map(part5, question);

            if (!_questionRepository.Save())
            {
                return Json(MessageResult.GetMessage(MessageType.BAD_REQUEST));
            }

            return Json(MessageResult.GetMessage(MessageType.QUESTION_UPDATED));
        }


        /// <summary>
        /// Update information group function
        /// </summary>
        /// <param name="examId">Get id exam on the url</param> 
        /// <param name="questionId">Get id question on the url</param>
        /// <param name="part6">The question information from body</param>
        [HttpPut("{examId}/updatepartsix/{questionId}")]
        public JsonResult UpdateInformationQuestion(int examId, int questionId, [FromBody] QuestionPartSixDto part6)
        {
            //Check id exam exist in the database
            if (!_examRepository.ExamExist(examId))
            {
                return Json(MessageResult.GetMessage(MessageType.EXAM_NOT_FOUND));
            }

            //Check value enter from the form 
            if (part6 == null)
            {
                return Json(MessageResult.GetMessage(MessageType.NOT_INFORMATION_QUESTION));
            }

            if (!ModelState.IsValid)
            {
                return Json(MessageResult.GetMessage(MessageType.BAD_REQUEST));
            }

            QuestionEntity question = null;
            //This is get all information of the exam by examId
            List<ExamQuestionEntity> examQuestionEntity = _examQuestionRepository.getListQuestions(examId);

            foreach (var examQuestion in examQuestionEntity)
            {
                if (examQuestion.QuestionId == questionId)
                {
                    question = _questionRepository.getQuestionInformation(questionId);
                }
            }

            if (question == null)
            {
                return Json(MessageResult.GetMessage(MessageType.EXAM_NOT_FOUND));
            }

            //Map data enter from the form to question entity
            Mapper.Map(part6, question);

            if (!_questionRepository.Save())
            {
                return Json(MessageResult.GetMessage(MessageType.BAD_REQUEST));
            }

            return Json(MessageResult.GetMessage(MessageType.QUESTION_UPDATED));
        }

        /// <summary>
        /// Update information group function
        /// </summary>
        /// <param name="examId">Get id exam on the url</param> 
        /// <param name="questionId">Get id question on the url</param>
        /// <param name="part7">The question information from body</param>
        [HttpPut("{examId}/updatepartseven/{questionId}")]
        public JsonResult UpdateInformationQuestion(int examId, int questionId, [FromBody] QuestionPartSevenDto part7)
        {
            //Check id exam exist in the database
            if (!_examRepository.ExamExist(examId))
            {
                return Json(MessageResult.GetMessage(MessageType.EXAM_NOT_FOUND));
            }

            //Check value enter from the form 
            if (part7 == null)
            {
                return Json(MessageResult.GetMessage(MessageType.NOT_INFORMATION_QUESTION));
            }

            if (!ModelState.IsValid)
            {
                return Json(MessageResult.GetMessage(MessageType.BAD_REQUEST));
            }

            QuestionEntity question = null;
            //This is get all information of the exam by examId
            List<ExamQuestionEntity> examQuestionEntity = _examQuestionRepository.getListQuestions(examId);

            foreach (var examQuestion in examQuestionEntity)
            {
                if (examQuestion.QuestionId == questionId)
                {
                    question = _questionRepository.getQuestionInformation(questionId);
                }
            }

            if (question == null)
            {
                return Json(MessageResult.GetMessage(MessageType.QUESTION_NOT_FOUND));
            }

            //Map data enter from the form to question entity
            Mapper.Map(part7, question); 

            if (!_questionRepository.Save())
            {
                return Json(MessageResult.GetMessage(MessageType.BAD_REQUEST));
            }

            return Json(MessageResult.GetMessage(MessageType.QUESTION_UPDATED));
        }
        [HttpDelete("{examId}/deletequestion/{questionId}")]
        public JsonResult DeleteQuestion(int examId, int questionId)
        {
            //Check id exam exist in the database
            if (!_examRepository.ExamExist(examId))
            {
                return Json(MessageResult.GetMessage(MessageType.EXAM_NOT_FOUND));
            }

            

            if (!ModelState.IsValid)
            {
                return Json(MessageResult.GetMessage(MessageType.BAD_REQUEST));
            }

            QuestionEntity question = null;
            //This is get all information of the exam by examId
            List<ExamQuestionEntity> examQuestionEntity = _examQuestionRepository.getListQuestions(examId);

            foreach (var examQuestion in examQuestionEntity)
            {
                if (examQuestion.QuestionId == questionId)
                {
                    question = _questionRepository.getQuestionInformation(questionId);
                }
            }

            if (question == null)
            {
                return Json(MessageResult.GetMessage(MessageType.QUESTION_NOT_FOUND));
            }

            _questionRepository.DeleteQuestion(question.QuestionId);

            if (!_questionRepository.Save())
            {
                return Json(MessageResult.GetMessage(MessageType.BAD_REQUEST));
            }

            return Json(MessageResult.GetMessage(MessageType.QUESTION_DELETED));
        }


    }
}
