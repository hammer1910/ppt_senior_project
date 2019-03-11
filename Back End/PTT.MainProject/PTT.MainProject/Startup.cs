using System;
using System.Collections.Generic;
using System.Linq;
using System.Threading.Tasks;
using Microsoft.AspNetCore.Builder;
using Microsoft.AspNetCore.Hosting;
using Microsoft.AspNetCore.Mvc;
using Microsoft.AspNetCore.Mvc.Formatters;
using Microsoft.EntityFrameworkCore;
using Microsoft.Extensions.Configuration;
using Microsoft.Extensions.DependencyInjection;
using Microsoft.Extensions.Logging;
using Microsoft.Extensions.Options;
using PPT.Database;
using PPT.Database.Entities;
using PPT.Database.Repositories;
using PPT.Database.Services;

namespace PTT.MainProject
{
    public class Startup
    {
        public Startup(IConfiguration configuration)
        {
            Configuration = configuration;
        }

        public IConfiguration Configuration { get; }

        // This method gets called by the runtime. Use this method to add services to the container.
        public void ConfigureServices(IServiceCollection services)
        {
            services.AddMvc()
               .AddMvcOptions(o => o.OutputFormatters.Add(
                   new XmlDataContractSerializerOutputFormatter()));

            var connectionString = @"Data Source=CPU051;Initial Catalog=pass_toeic_together_ptt;Persist Security Info=True;User ID=admin;Password=admin";
            services.AddDbContext<ExamContext>(o => o.UseSqlServer(connectionString));
            services.AddScoped<IAccountRepository, AccountService>();
            services.AddScoped<IGroupRepository, GroupService>();
        }

        // This method gets called by the runtime. Use this method to configure the HTTP request pipeline.
        public void Configure(IApplicationBuilder app, IHostingEnvironment env, ExamContext examContext)
        {
            //examContext.EnsureSeedDataForContext();
            if (env.IsDevelopment())
            {
                app.UseDeveloperExceptionPage();
            }
            else
            {
                // The default HSTS value is 30 days. You may want to change this for production scenarios, see https://aka.ms/aspnetcore-hsts.
                app.UseHsts();
            }

            AutoMapper.Mapper.Initialize( cfg =>
            {
                cfg.CreateMap<PPT.Database.Models.AccountForCreationDto, PPT.Database.Entities.AccountEntity>();
                cfg.CreateMap<PPT.Database.Models.AccountRoleForCreationDto, PPT.Database.Entities.AccountRoleEntity>();
                cfg.CreateMap<PPT.Database.Models.AccountForUpdateDto, PPT.Database.Entities.AccountEntity>();
                cfg.CreateMap<PPT.Database.Models.GroupForCreationDto, PPT.Database.Entities.GroupEntity>();
            });

            app.UseHttpsRedirection();

            app.UseMvc();
        }
    }
}
