using Microsoft.EntityFrameworkCore.Migrations;

namespace PPT.Database.Migrations
{
    public partial class Addcommentandaccounttable : Migration
    {
        protected override void Up(MigrationBuilder migrationBuilder)
        {
            migrationBuilder.AddColumn<int>(
                name: "AccountId",
                table: "Comments",
                nullable: false,
                defaultValue: 0);
        }

        protected override void Down(MigrationBuilder migrationBuilder)
        {

            migrationBuilder.DropIndex(
                name: "IX_Comments_AccountId",
                table: "Comments");

            migrationBuilder.DropColumn(
                name: "AccountId",
                table: "Comments");
        }
    }
}
