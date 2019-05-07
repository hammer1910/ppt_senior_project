using Newtonsoft.Json.Linq;
using PPT.Database.Common;
using System;
using System.Collections.Generic;
using System.Text;

namespace PPT.Database.ResultObject
{
    public class MessageResult 
    {
        public int MessageId { get; set; }
        public string MessageReturnTrue { get; set; }
        public string MessageReturnFalse { get; set; }
        public bool IsSuccessful { get; set; }

        public MessageResult()
        {
            this.MessageReturnTrue = "";
            this.MessageReturnFalse = "";
            this.IsSuccessful = false;
        }

        public static MessageResult ShowServerError(string message)
        {
            MessageResult messageResult = new MessageResult();
            messageResult.MessageReturnFalse = message;
            messageResult.IsSuccessful = false;
            return messageResult;
        }

        public static MessageResult GetMessage(MessageType messageType)
        {
            MessageResult messageResult = new MessageResult();

            List<MessageResult> listMessageResult = InitMessages();

            foreach (var item in listMessageResult)
            {
                if (item.MessageId == (int)messageType)
                {
                    messageResult.MessageId = item.MessageId;
                    messageResult.MessageReturnTrue = item.MessageReturnTrue;
                    messageResult.MessageReturnFalse = item.MessageReturnFalse;
                    messageResult.IsSuccessful = item.IsSuccessful;
                }
            }

            return messageResult;
        }

        public static List<MessageResult> InitMessages()
        {
            List<MessageResult> messages = new List<MessageResult>
            {
                new MessageResult()
                {
                    MessageId = 1,
                    MessageReturnTrue = Constants.registerSuccess,
                    IsSuccessful = true
                },
                new MessageResult()
                {
                    MessageId = 2,
                    MessageReturnFalse = Constants.badRequest,
                    IsSuccessful = false
                },
                new MessageResult()
                {
                    MessageId = 3,
                    MessageReturnFalse = Constants.notInformationAccount,
                    IsSuccessful = false
                },
                new MessageResult()
                {
                    MessageId = 4,
                    MessageReturnFalse = Constants.notFound,
                    IsSuccessful = false
                },
                new MessageResult()
                {
                    MessageId = 5,
                    MessageReturnFalse = Constants.emailExist,
                    IsSuccessful = false
                },
                new MessageResult()
                {
                    MessageId = 6,
                    MessageReturnFalse = Constants.notEnterEmail,
                    IsSuccessful = false
                },
                new MessageResult()
                {
                    MessageId = 7,
                    MessageReturnTrue = Constants.sendPassword,
                    IsSuccessful = true
                },                
                new MessageResult()
                {
                    MessageId = 8,
                    MessageReturnFalse = Constants.emailNotExist,
                    IsSuccessful = false
                },
                new MessageResult()
                {
                    MessageId = 9,
                    MessageReturnFalse = Constants.accountNotFound,
                    IsSuccessful = false
                },
                new MessageResult()
                {
                    MessageId = 10,
                    MessageReturnTrue = Constants.accountUpdated,
                    IsSuccessful = false
                },
                new MessageResult()
                {
                    MessageId = 11,
                    MessageReturnFalse = Constants.emailAndPasswordWrong,
                    IsSuccessful = false
                },
                new MessageResult()
                {
                    MessageId = 12,
                    MessageReturnFalse = Constants.oldPasswordNotTrue,
                    IsSuccessful = false
                },
                new MessageResult()
                {
                    MessageId = 13,
                    MessageReturnTrue = Constants.accountDeleted,
                    IsSuccessful = true
                },
                new MessageResult()
                {
                    MessageId = 14,
                    MessageReturnFalse = Constants.notInformationGroup,
                    IsSuccessful = false
                },
                new MessageResult()
                {
                    MessageId = 15,
                    MessageReturnTrue = Constants.groupCreated,
                    IsSuccessful = true
                },
                new MessageResult()
                {
                    MessageId = 16,
                    MessageReturnFalse = Constants.groupNotFound,
                    IsSuccessful = false
                },
                new MessageResult()
                {
                    MessageId = 17,
                    MessageReturnTrue = Constants.memberAdded,
                    IsSuccessful = true
                },
                new MessageResult()
                {
                    MessageId = 18,
                    MessageReturnTrue = Constants.groupUpdated,
                    IsSuccessful = true
                },
                new MessageResult()
                {
                    MessageId = 19,
                    MessageReturnTrue = Constants.groupDeleted,
                    IsSuccessful = true
                },
                new MessageResult()
                {
                    MessageId = 20,
                    MessageReturnFalse = Constants.notInformationMember,
                    IsSuccessful = false
                },
                new MessageResult()
                {
                    MessageId = 21,
                    MessageReturnTrue = Constants.memberDeleted,
                    IsSuccessful = true
                },
                new MessageResult()
                {
                    MessageId = 22,
                    MessageReturnTrue = Constants.createdExam,
                    IsSuccessful = true
                },
                new MessageResult()
                {
                    MessageId = 23,
                    MessageReturnFalse = Constants.failCreatedExam,
                    IsSuccessful = false
                },
                new MessageResult()
                {
                    MessageId = 24,
                    MessageReturnFalse = Constants.examNotFound,
                    IsSuccessful = false
                },
                new MessageResult()
                {
                    MessageId = 25,
                    MessageReturnFalse = Constants.notInformationExam,
                    IsSuccessful = false
                },
                new MessageResult()
                {
                    MessageId = 26,
                    MessageReturnTrue = Constants.examUpdated,
                    IsSuccessful = true
                },
                new MessageResult()
                {
                    MessageId = 27,
                    MessageReturnTrue = Constants.examDeleted,
                    IsSuccessful = true
                },
                new MessageResult()
                {
                    MessageId = 28,
                    MessageReturnFalse = Constants.notInformationQuestion,
                    IsSuccessful = false
                },
                new MessageResult()
                {
                    MessageId = 29,
                    MessageReturnTrue = Constants.createdQuestion,
                    IsSuccessful = true
                },
                new MessageResult()
                {
                    MessageId = 30,
                    MessageReturnTrue = Constants.questionUpdated,
                    IsSuccessful = true
                },
                new MessageResult()
                {
                    MessageId = 31,
                    MessageReturnTrue = Constants.questionDeleted,
                    IsSuccessful = true
                },
                new MessageResult()
                {
                    MessageId = 32,
                    MessageReturnFalse = Constants.questionNotFound,
                    IsSuccessful = false
                },
                new MessageResult()
                {
                    MessageId = 33,
                    MessageReturnTrue = Constants.createdAnswerUser,
                    IsSuccessful = true
                },
                new MessageResult()
                {
                    MessageId = 34,
                    MessageReturnFalse = Constants.questionIdWrong,
                    IsSuccessful = false
                },
                new MessageResult()
                {
                    MessageId = 35,
                    MessageReturnFalse = Constants.commentSuccess,
                    IsSuccessful = false
                },
                new MessageResult()
                {
                    MessageId = 36,
                    MessageReturnTrue = Constants.valueIsNull,
                    IsSuccessful = false
                },
                new MessageResult()
                {
                    MessageId = 37,
                    MessageReturnTrue = Constants.groupMemberExist,
                    IsSuccessful = false
                }
            };

            return messages;
        }
    }
}
