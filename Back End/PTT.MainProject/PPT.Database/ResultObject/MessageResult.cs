using Newtonsoft.Json.Linq;
using PPT.Database.Common;
using System;
using System.Collections.Generic;
using System.Text;

namespace PPT.Database.ResultObject
{
    public class MessageResult : Constants
    {
        public int MessageId { get; set; }
        public string MessageReturn { get; set; }  

        public static MessageResult GetMessage(MessageType message)
        {
            Constants constants = new Constants();
            MessageResult result = new MessageResult();
            result.MessageId = (int) message;
            result.MessageReturn = GetMessageConstant(constants);
            return result;
        }

        public static string GetMessageConstant(Constants constants)
        {

            return "";
        }
    }
}
