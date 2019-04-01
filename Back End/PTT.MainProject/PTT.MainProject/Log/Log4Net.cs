using log4net;
using log4net.Config;
using log4net.Repository;
using PPT.Database.ResultObject;
using System;
using System.Collections.Generic;
using System.IO;
using System.Linq;
using System.Reflection;
using System.Threading.Tasks;

namespace PTT.MainProject.Log
{
    public class Log4Net
    {
        public static readonly log4net.ILog log = log4net.LogManager.GetLogger(System.Reflection.MethodBase.GetCurrentMethod().DeclaringType);

        public static void InitLog()
        {
            ILoggerRepository logRepository = LogManager.GetRepository(Assembly.GetEntryAssembly());
            XmlConfigurator.Configure(logRepository, new FileInfo("log4net.config"));
        }

        public static string AddInfoLog(string message)
        {
            return message;
        }

        public static string AddErrorLog(string message)
        {
            return message;
        }

        public static string AddWarnLog(string message)
        {
            return message;
        }
    }
}
