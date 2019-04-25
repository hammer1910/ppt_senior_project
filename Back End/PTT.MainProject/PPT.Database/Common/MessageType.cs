using System;
using System.Collections.Generic;
using System.Text;

namespace PPT.Database.Common
{
    public enum MessageType
    {
        REGISTER_SUCCESS = 1,
        BAD_REQUEST = 2,
        NOT_INFORMATION_ACCOUNT = 3,
        NOT_FOUND = 4,
        EMAIL_EXIST = 5,
        NOT_ENTER_EMAIL = 6,
        SEND_PASSWORD = 7,
        EMAIL_NOT_EXIST = 8,
        ACCOUNT_NOT_FOUND = 9,
        ACCOUNT_UPDATED = 10,
        EMAIL_AND_PASSWORD_WRONG = 11,
        OLD_PASSWORD_NOT_TRUE = 12,
        ACCOUNT_DELETED = 13,
        NOT_INFORMATION_GROUP = 14,
        GROUP_CREATED = 15,
        GROUP_NOT_FOUND = 16,
        MEMBER_ADDED = 17,
        GROUP_UPDATED = 18,
        GROUP_DELETED = 19,
        NOT_INFORMATION_MEMBER = 20,
        MEMBER_DELETED = 21,
        CREATED_EXAM = 22,
        FAIL_CREATED_EXAM = 23,
        EXAM_NOT_FOUND = 24,    
        NOT_INFORMATION_EXAM = 25,
        EXAM_UPDATED = 26,
        EXAM_DELETED = 27,
        NOT_INFORMATION_QUESTION = 28,
        CREATED_QUESTION = 29,
        QUESTION_UPDATED = 30,
        QUESTION_DELETED = 31,
        QUESTION_NOT_FOUND = 32,
        CREATED_ANSWER_USER = 33,
        QUESTION_ID_WRONG = 34,
        COMMENTSUCCESS = 35,
        VALUEISNULL = 36,
        GROUP_MEMBER_EXIST = 37
    }
}
