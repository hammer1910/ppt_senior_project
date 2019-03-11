using System;
using System.Collections.Generic;
using System.Text;

namespace PPT.Database.ResultObject
{
    public class MessageResult
    {
        public int MessageId { get; set; }
        public String MessageReturn { get; set; }

        public static MessageResult GetMessage(int id)
        {
            List<MessageResult> list = new List<MessageResult>()
            {
                new MessageResult()
                {
                    MessageId = 1,
                    MessageReturn = "Register success!"
                },
                new MessageResult()
                {
                    MessageId = 2,
                    MessageReturn = "A problem happened while handling your request."
                },
                new MessageResult()
                {
                    MessageId = 3,
                    MessageReturn = "You haven't enter information for account."
                },
                new MessageResult()
                {
                    MessageId = 4,
                    MessageReturn = "Not found!"
                },
                new MessageResult()
                {
                    MessageId = 5,
                    MessageReturn = "Your email have exist. Please enter again!"
                },
                new MessageResult()
                {
                    MessageId = 6,
                    MessageReturn = "You haven't enter email."
                },
                new MessageResult()
                {
                    MessageId = 7,
                    MessageReturn = "Your password have send on your email account."
                },
                new MessageResult()
                {
                    MessageId = 8,
                    MessageReturn = "Your email haven't exist. Please enter again!"
                },
                new MessageResult()
                {
                    MessageId = 9,
                    MessageReturn = "Your account information was not found."
                },
                new MessageResult()
                {
                    MessageId = 10,
                    MessageReturn = "Your account information updated success."
                },
                new MessageResult()
                {
                    MessageId = 11,
                    MessageReturn = "You have enter wrong email or password. Please enter again!"
                },
                new MessageResult()
                {
                    MessageId = 12,
                    MessageReturn = "Your old password don't true. Please enter again!"
                },
                new MessageResult()
                {
                    MessageId = 13,
                    MessageReturn = "You deleted account success!"
                },
                new MessageResult()
                {
                    MessageId = 14,
                    MessageReturn = "You haven't owned any group right now!"
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
