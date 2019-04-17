using Microsoft.EntityFrameworkCore.Migrations;

namespace PPT.Database.Migrations
{
    public partial class Fixansweruserandquestiontable : Migration
    {
        protected override void Up(MigrationBuilder migrationBuilder)
        {
            migrationBuilder.DropIndex(
                name: "IX_AnswerUsers_QuestionId",
                table: "AnswerUsers");

            migrationBuilder.CreateIndex(
                name: "IX_AnswerUsers_QuestionId",
                table: "AnswerUsers",
                column: "QuestionId");
        }

        protected override void Down(MigrationBuilder migrationBuilder)
        {
            migrationBuilder.DropIndex(
                name: "IX_AnswerUsers_QuestionId",
                table: "AnswerUsers");

            migrationBuilder.CreateIndex(
                name: "IX_AnswerUsers_QuestionId",
                table: "AnswerUsers",
                column: "QuestionId",
                unique: true);
        }
    }
}
