﻿using System;
using System.Collections.Generic;
using System.IO;
using System.Linq;
using System.Reflection;
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
using Swashbuckle.AspNetCore.Swagger;

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

            //This line adds Swagger generation services to our container.
            services.AddSwaggerGen(c =>
            {
                //The generated Swagger JSON file will have these properties.
                c.SwaggerDoc("v1", new Info
                {
                    Title = "Pass Toeic Together Api",
                    Version = "v1",
                });
                
                //Locate the XML file being generated by ASP.NET...
                var xmlFile = $"{Assembly.GetExecutingAssembly().GetName().Name}.XML";
                var xmlPath = Path.Combine(AppContext.BaseDirectory, xmlFile);

                //... and tell Swagger to use those XML comments.
                c.IncludeXmlComments(xmlPath);
            });


            var connectionString = @"Data Source=CPU051;Initial Catalog=pass_toeic_together_ptt;Persist Security Info=True;User ID=admin;Password=admin";
            services.AddDbContext<ExamContext>(o => o.UseSqlServer(connectionString));
            services.AddScoped<IAccountRepository, AccountService>();
            services.AddScoped<IGroupRepository, GroupService>();
            services.AddScoped<IExamRepository, ExamService>();
            services.AddScoped<IQuestionRepository, QuestionService>();
            services.AddScoped<IExamQuestionRepository, ExamQuestionService>();
            services.AddDistributedMemoryCache();
            services.AddSession(options =>
            {
                // Set a short timeout for easy testing.
                options.IdleTimeout = TimeSpan.FromSeconds(10);
                options.Cookie.HttpOnly = true;
            });


        }

        // This method gets called by the runtime. Use this method to configure the HTTP request pipeline.
        public void Configure(IApplicationBuilder app, IHostingEnvironment env, ExamContext examContext)
        {            
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
                cfg.CreateMap<PPT.Database.Models.GroupForUpdateDto, PPT.Database.Entities.GroupEntity>();
                cfg.CreateMap<PPT.Database.Models.ExamForCreationDto, PPT.Database.Entities.ExamEntity>();
                cfg.CreateMap<PPT.Database.Models.QuestionPartOneDto, PPT.Database.Entities.QuestionEntity>();
                cfg.CreateMap<PPT.Database.Models.QuestionPartTwoDto, PPT.Database.Entities.QuestionEntity>();
                cfg.CreateMap<PPT.Database.Models.QuestionPartThreeAndFourDto, PPT.Database.Entities.QuestionEntity>();
                cfg.CreateMap<PPT.Database.Models.QuestionPartThreeAndFourDto, PPT.Database.Entities.QuestionEntity>();
                cfg.CreateMap<PPT.Database.Models.QuestionPartFiveDto, PPT.Database.Entities.QuestionEntity>();
                cfg.CreateMap<PPT.Database.Models.QuestionPartSixDto, PPT.Database.Entities.QuestionEntity>();
                cfg.CreateMap<PPT.Database.Models.QuestionPartSevenDto, PPT.Database.Entities.QuestionEntity>();
            });
           
            app.UseSession();

            app.UseHttpsRedirection();

            app.UseMvc();

            //This line enables the app to use Swagger, with the configuration in the ConfigureServices method.
            app.UseSwagger();

            //This line enables Swagger UI, which provides us with a nice, simple UI with which we can view our API calls.
            app.UseSwaggerUI(c =>
            {
                c.SwaggerEndpoint("/swagger/v1/swagger.json", "Pass Toeic Together Api");
            });

        }
    }
}
