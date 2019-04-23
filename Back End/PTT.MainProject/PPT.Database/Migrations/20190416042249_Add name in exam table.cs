using Microsoft.EntityFrameworkCore.Migrations;

namespace PPT.Database.Migrations
{
    public partial class Addnameinexamtable : Migration
    {
        protected override void Up(MigrationBuilder migrationBuilder)
        {
            migrationBuilder.AddColumn<string>(
                name: "Name",
                table: "Exams",
                maxLength: 255,
                nullable: true);
        }

        protected override void Down(MigrationBuilder migrationBuilder)
        {
            migrationBuilder.DropColumn(
                name: "Name",
                table: "Exams");
        }
    }
}
