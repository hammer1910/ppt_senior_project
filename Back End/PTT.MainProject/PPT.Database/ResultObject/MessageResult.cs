using PPT.Database.Common;
using System;
using System.Collections.Generic;
using System.Text;

namespace PPT.Database.ResultObject
{
    public class MessageResult
    {
        public int MessageId { get; set; }
        public string MessageReturn { get; set; }

        public static MessageResult GetMessage(int id)
        {
            List<MessageResult> list = new List<MessageResult>()
            {
                new MessageResult()
                {
                    MessageId = 1,
                    MessageReturn = Constants.registerSuccess
                },
                new MessageResult()
                {
                    MessageId = 2,
                    MessageReturn = Constants.badRequest
                },
                new MessageResult()
                {
                    MessageId = 3,
                    MessageReturn = Constants.notInformationAccount
                },
                new MessageResult()
                {
                    MessageId = 4,
                    MessageReturn = Constants.notFound
                },
                new MessageResult()
                {
                    MessageId = 5,
                    MessageReturn = Constants.emailExist
                },
                new MessageResult()
                {
                    MessageId = 6,
                    MessageReturn = Constants.notEnterEmail
                },
                new MessageResult()
                {
                    MessageId = 7,
                    MessageReturn = Constants.sendPassword
                },
                new MessageResult()
                {
                    MessageId = 8,
                    MessageReturn = Constants.emailNotExist
                },
                new MessageResult()
                {
                    MessageId = 9,
                    MessageReturn = Constants.accountNotFound
                },
                new MessageResult()
                {
                    MessageId = 10,
                    MessageReturn = Constants.accountUpdated
                },
                new MessageResult()
                {
                    MessageId = 11,
                    MessageReturn = Constants.emailAndPasswordWrong
                },
                new MessageResult()
                {
                    MessageId = 12,
                    MessageReturn = Constants.oldPasswordNotTrue
                },
                new MessageResult()
                {
                    MessageId = 13,
                    MessageReturn = Constants.accountDeleted
                },
                new MessageResult()
                {
                    MessageId = 14,
                    MessageReturn = Constants.notInformationGroup
                },
                new MessageResult()
                {
                    MessageId = 15,
                    MessageReturn = Constants.groupCreated
                },
                new MessageResult()
                {
                    MessageId = 16,
                    MessageReturn = Constants.groupNotFound
                },
                new MessageResult()
                {
                    MessageId = 17,
                    MessageReturn = Constants.memberAdded
                },
                new MessageResult()
                {
                    MessageId = 18,
                    MessageReturn = Constants.groupUpdated
                },
                new MessageResult()
                {
                    MessageId = 19,
                    MessageReturn = Constants.groupDeleted
                },
                new MessageResult()
                {
                    MessageId = 20,
                    MessageReturn = Constants.notInformationMember
                },
                new MessageResult()
                {
                    MessageId = 21,
                    MessageReturn = Constants.memberDeleted
                }
            };
            MessageResult result = new MessageResult();
            foreach (var item in list)
            {
                if(item.MessageId == id)
                {
                    result.MessageId = item.MessageId;
                    result.MessageReturn = item.MessageReturn;
                }
            }
            return result;
        }
    }
}
