using Microsoft.EntityFrameworkCore.Migrations;

namespace PPT.Database.Migrations
{
    public partial class CreaterelationshipbetweenQuestionandAnswerUsertable : Migration
    {
        protected override void Up(MigrationBuilder migrationBuilder)
        {
            migrationBuilder.DropForeignKey(
                name: "FK_AnswerUsers_ExamQuestions_ExamQuestionId",
                table: "AnswerUsers");

            migrationBuilder.RenameColumn(
                name: "ExamQuestionId",
                table: "AnswerUsers",
                newName: "QuestionId");

            migrationBuilder.RenameIndex(
                name: "IX_AnswerUsers_ExamQuestionId",
                table: "AnswerUsers",
                newName: "IX_AnswerUsers_QuestionId");

            migrationBuilder.AddForeignKey(
                name: "FK_AnswerUsers_Questions_QuestionId",
                table: "AnswerUsers",
                column: "QuestionId",
                principalTable: "Questions",
                principalColumn: "QuestionId",
                onDelete: ReferentialAction.Cascade);
        }

        protected override void Down(MigrationBuilder migrationBuilder)
        {
            migrationBuilder.DropForeignKey(
                name: "FK_AnswerUsers_Questions_QuestionId",
                table: "AnswerUsers");

            migrationBuilder.RenameColumn(
                name: "QuestionId",
                table: "AnswerUsers",
                newName: "ExamQuestionId");

            migrationBuilder.RenameIndex(
                name: "IX_AnswerUsers_QuestionId",
                table: "AnswerUsers",
                newName: "IX_AnswerUsers_ExamQuestionId");

            migrationBuilder.AddForeignKey(
                name: "FK_AnswerUsers_ExamQuestions_ExamQuestionId",
                table: "AnswerUsers",
                column: "ExamQuestionId",
                principalTable: "ExamQuestions",
                principalColumn: "ExamQuestionId",
                onDelete: ReferentialAction.Cascade);
        }
    }
}
