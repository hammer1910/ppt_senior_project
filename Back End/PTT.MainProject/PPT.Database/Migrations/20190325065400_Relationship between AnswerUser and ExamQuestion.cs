using Microsoft.EntityFrameworkCore.Migrations;

namespace PPT.Database.Migrations
{
    public partial class RelationshipbetweenAnswerUserandExamQuestion : Migration
    {
        protected override void Up(MigrationBuilder migrationBuilder)
        {
            migrationBuilder.AddColumn<int>(
                name: "ExamQuestionId",
                table: "AnswerUsers",
                nullable: false,
                defaultValue: 0);

            migrationBuilder.CreateIndex(
                name: "IX_AnswerUsers_ExamQuestionId",
                table: "AnswerUsers",
                column: "ExamQuestionId",
                unique: true);

            migrationBuilder.AddForeignKey(
                name: "FK_AnswerUsers_ExamQuestions_ExamQuestionId",
                table: "AnswerUsers",
                column: "ExamQuestionId",
                principalTable: "ExamQuestions",
                principalColumn: "ExamQuestionId",
                onDelete: ReferentialAction.Cascade);
        }

        protected override void Down(MigrationBuilder migrationBuilder)
        {
            migrationBuilder.DropForeignKey(
                name: "FK_AnswerUsers_ExamQuestions_ExamQuestionId",
                table: "AnswerUsers");

            migrationBuilder.DropIndex(
                name: "IX_AnswerUsers_ExamQuestionId",
                table: "AnswerUsers");

            migrationBuilder.DropColumn(
                name: "ExamQuestionId",
                table: "AnswerUsers");
        }
    }
}
