@extends('Home_Master')
@section('content')

    @if (session('message'))
        <div class="alert alert-success" style="text-align: center; font-size: large">
            <strong>{{session('message')}}</strong>
        </div>
    @endif


    <div style="margin-left: 20px">
        <ul class="nav nav-tabs" id="myTab1">
            <li class="active"><a data-toggle="tab" href="#part1" class="part" id="1">Part 1</a></li>
            <li ><a data-toggle="tab" href="#part2" class="part" id="2">Part 2</a></li>
            <li ><a data-toggle="tab" href="#part3" class="part" id="3">Part 3</a></li>
            <li ><a data-toggle="tab" href="#part4" class="part" id="4">Part 4</a></li>
            <li ><a data-toggle="tab" href="#part5" class="part" id="5">Part 5</a></li>
            <li ><a data-toggle="tab" href="#part6" class="part" id="6">Part 6</a></li>
            <li ><a data-toggle="tab" href="#part7" class="part" id="7">Part 7</a></li>
            {{--@if (session('user_id')== $listExams['ownerId'])--}}
                {{--<li><a data-toggle="tab" href="#menu1">Member</a></li>--}}
            {{--@endif--}}

        </ul>
    </div>
<script type="text/javascript">
    $(document).ready(function(){

        $('a[data-toggle="tab"]').on('show.bs.tab', function(e) {
            localStorage.setItem('activeTab', $(e.target).attr('href'));
        });
        var activeTab1 = localStorage.getItem('activeTab');

        if(activeTab1) {
            $('#myTab1 a[href="' + activeTab1 + '"]').tab('show');
        }

    });

</script>
<style>
    .checkbox{
        height: 25px;  width: 25px; text-align: center;
        margin-top: -3px;
    }
    .checkbox1{
        height: 25px;  width: 25px; text-align: center;
        margin-top: -3px;
    }
    .answerSelect{
        width: 100%;
        height: 34px;
        border-radius: .25em;
    }

</style>
    <div class="tab-content" style="margin-left: 20px">
        <div id="part1" class="tab-pane fade in active">

            <div id="table-part-1" class="hidden">
                <h3 style="text-align: center">List Question</h3>
                <table data-has-data="false" class="table table-striped table-bordered table-hover" id="dataTables-example">
                    <thead>
                        <tr align="center">
                            <th style="text-align: center">Question</th>
                            <th style="text-align: center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>

            </div>
            <script>


            </script>
            <form id="add" action="{{route('upload.part1')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div>
                    <h3 class="text-center" style="color: black;margin-top: 10px; font-size: xx-large">Upload</h3>


                    <button type="submit" id="finish" class="btn btn-outline-primary"
                            style="display: block; margin: auto; float: right; font-size: large">Upload <i class="fa fa-upload"></i>
                    </button>

                    {{--<input type="button" id="btn2" class="btn" value="Add Question">--}}
                    <button type="button" id="addQuestionPart1" class="btn btn-outline-primary" style="font-size: large">Add Question
                        <i class="fa fa-plus-square"></i>
                    </button>
                </div>

                <input name="count" id="count" hidden>
                <div class="col-lg-4 ">
                    <h3 class="text-center" style="color: black;margin-top: 10px" id="question_order"></h3>
                    <div class="panel-body" style="margin-top: 1px">
                        <div class="form-group" style="margin-top: 1px;margin-bottom: 5px">
                            <label>MP3</label>
                            <input type="file" class="form-control" name="mp3[]" id="mp3"/>
                            <div type="hidden" class="alert-warning">{{$errors->first('mp3')}}</div>
                            <div type="hidden" class="alert-warning">{{$errors->first('mp3.*')}}</div>
                        </div>
                        <div class="form-group" style="margin-top: 1px;margin-bottom: 5px">
                            <label>Image</label>
                            <input type="file" class="form-control" name="images[]" />
                            <div type="hidden" class="alert-warning">{{$errors->first('images')}}</div>
                            <div type="hidden" class="alert-warning">{{$errors->first('images.*')}}</div>
                        </div>

                        <div class="form-group" style="margin-top: 15px;margin-bottom: 5px" >
                            <div style="width: 100%" class="checkbox-group">
                            <label style="margin-right: 10px;">Correct Answer </label>
                                <select class="answerSelect" name="answer[]">
                                    <option value="A" selected>A</option>
                                    <option value="B">B</option>
                                    <option value="C">C</option>
                                    <option value="D" >D</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <script>
                        var i = 0;
                        var count = 1;
                        $("#addQuestionPart1").click(function () {
                            var d =$("#question_order").text();
                            count++;
                            var s = parseInt(d) + i;
                            s+=1;

                            $("#add").append(" <div class=\"col-lg-4 \">\n" +
                                "                    <h3 class=\"text-center\" style=\"color: black;margin-top: 10px\" id=\"question_order1"+i+"\"></h3>\n" +
                                "                    <div class=\"panel-body\" style=\"margin-top: 1px\">\n" +
                                "                        <div class=\"form-group\" style=\"margin-top: 1px;margin-bottom: 5px\">\n" +
                                "                            <label>MP3</label>\n" +
                                "                            <input type=\"file\" class=\"form-control\" name=\"mp3[]\" id=\"mp3\"/>\n" +
                                "                            <div type=\"hidden\" class=\"alert-warning\">{{$errors->first('mp3')}}</div>\n" +
                                "                            <div type=\"hidden\" class=\"alert-warning\">{{$errors->first('mp3.*')}}</div>\n" +
                                "                        </div>\n" +
                                "                        <div class=\"form-group\" style=\"margin-top: 1px;margin-bottom: 5px\">\n" +
                                "                            <label>Image</label>\n" +
                                "                            <input type=\"file\" class=\"form-control\" name=\"images[]\" />\n" +
                                "                            <div type=\"hidden\" class=\"alert-warning\">{{$errors->first('images')}}</div>\n" +
                                "                            <div type=\"hidden\" class=\"alert-warning\">{{$errors->first('images.*')}}</div>\n" +
                                "                        </div>\n" +
                                "\n" +
                                "                        <div class=\"form-group\" style=\"margin-top: 15px;margin-bottom: 5px\" >\n" +
                                "                            <label style=\"margin-right: 10px;\">Correct Answer </label>\n" +
                                "                            <select  class=\"answerSelect\" name=\"answer[]\">\n" +
                                "                                    <option value=\"A\" selected>A</option>\n" +
                                "                                    <option value=\"B\">B</option>\n" +
                                "                                    <option value=\"C\">C</option>\n" +
                                "                                    <option value=\"D\" >D</option>\n" +
                                "                                </select>" +
                                "                            </div>\n" +
                                "                    </div>\n" +
                                "                </div>");
                            var d = "#question_order1"+i;
                            $(d).text(s);
                            i++;


                        });

                </script>


            </form>
        </div>
        <div id="part2" class="tab-pane fade">
            <div id="table-part-2" class="hidden">
                <h3 style="text-align: center">List Question</h3>
                <table data-has-data="false" class="table table-striped table-bordered table-hover" id="dataTables-example">
                    <thead>
                    <tr align="center">
                        <th style="text-align: center">Question</th>
                        <th style="text-align: center">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
            <form id="add2" action="{{route('upload.part2')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div>
                    <button type="submit" id="finish" class="btn btn-outline-primary"
                            style="display: block; margin: auto; float: right; font-size: large">Upload <i class="fa fa-upload"></i>
                    </button>
                    <button type="button" id="addQuestionPart2" class="btn btn-outline-primary" style="font-size: large">Add Question
                        <i class="fa fa-plus-square"></i>
                    </button>
                </div>
                <input name="countPart2" id="countPart2"  hidden >
                <input name="countQuestion" id="countQuestion" hidden  >
                <input name="countTeamPart2" id="countTeamPart2" hidden  >
                <div class="col-lg-4 ">
                    <h3 class="text-center" style="color: black;margin-top: 10px" id="question_order2"></h3>
                    <div class="panel-body" style="margin-top: 1px">
                        <div class="form-group" style="margin-top: 1px;margin-bottom: 5px">
                            <label>MP3</label>
                            <input type="file" class="form-control" name="mp3[]"/>
                            <div type="hidden" class="alert-warning">{{$errors->first('mp3')}}</div>
                            <div type="hidden" class="alert-warning">{{$errors->first('mp3.*')}}</div>
                        </div>

                        <div class="form-group" style="margin-top: 1px;margin-bottom: 5px" id="answer">

                            <h5 id="questionOder1" style="font-size: initial"></h5>
                            <input id="questionOder_1" name="questionNumber_1[]" hidden>
                            <div style="width: 100%" class="checkbox-group">
                                <label style="margin-right: 10px;">Correct Answer </label>
                                <select class="answerSelect" name="answer2_1[]">
                                    <option value="A" selected>A</option>
                                    <option value="B">B</option>
                                    <option value="C">C</option>
                                    <option value="D" >D</option>
                                </select>

                            </div>
                        </div>
                        <div class="form-group" style="margin-top: 1px;margin-bottom: 5px" id="answer">

                            <h6 id="questionOder2" style="font-size: initial"></h6>
                            <input id="questionOder_2" name="questionNumber_2[]" hidden>
                            <div style="width: 100%" class="checkbox-group">
                                <label style="margin-right: 10px;">Correct Answer </label>
                                <select class="answerSelect" name="answer2_2[]">
                                    <option value="A" selected>A</option>
                                    <option value="B">B</option>
                                    <option value="C">C</option>
                                    <option value="D" >D</option>
                                </select>

                            </div>
                        </div>
                        <div class="form-group" style="margin-top: 1px;margin-bottom: 5px" id="answer">

                            <h6 id="questionOder3" style="font-size: initial"></h6>
                            <input id="questionOder_3" name="questionNumber_3[]" hidden>
                            <div style="width: 100%" class="checkbox-group">
                                <label style="margin-right: 10px;">Correct Answer </label>
                                <select class="answerSelect" name="answer2_3[]">
                                    <option value="A" selected>A</option>
                                    <option value="B">B</option>
                                    <option value="C">C</option>
                                    <option value="D" >D</option>
                                </select>

                            </div>
                        </div>
                    </div>
                </div>

                <script>
                    var  i1= 0,j1=1,k1=2;
                    var s1 = 0;
                    var count = 1;
                        $("#addQuestionPart2").click(function () {
                            var d =$("#countPart2").val();
                            count++;
                            s1 = parseInt(d);
                            s1++;
                            $("#add2").append("<div class=\"col-lg-4 \">\n" +
                                "\n" +
                                "            <h3 class=\"text-center\" style=\"color: black;margin-top: 10px\" id=\"question_order3\" ></h3>\n" +
                                "            <div class=\"panel-body\" style=\"margin-top: 1px\">\n" +
                                "                <div class=\"form-group\" style=\"margin-top: 1px;margin-bottom: 5px\">\n" +
                                "                    <label>MP3</label>\n" +
                                "                    <input type=\"file\" class=\"form-control\" name=\"mp3[]\" required=\"mp3\"/>\n" +
                                "                            <div type=\"hidden\" class=\"alert-warning\">{{$errors->first('mp3')}}</div>\n" +
                                "                            <div type=\"hidden\" class=\"alert-warning\">{{$errors->first('mp3.*')}}</div>\n" +
                                "                </div>\n" +
                                "\n" +
                                "                <div class=\"form-group\" style=\"margin-top: 1px;margin-bottom: 5px\" id=\"answer\">\n" +
                                "\n" +
                                "                    <H6 id=\"question_Part2"+i1+"\" style=\"font-size: initial\"> </H6 >\n" +
                                "                    <input type=\"hidden\" id=\"questionPart2_1" +i1+"\" class=\"form-control\" name=\"questionNumber_1[]\"  />\n" +
                                "                    <div style=\"width: 100%\" class=\"checkbox-group\">\n" +
                                "                                <label style=\"margin-right: 10px;\">Correct Answer </label>\n" +
                                "                               <select class=\"answerSelect\" name=\"answer2_1[]\">\n" +
                                "                                    <option value=\"A\" selected>A</option>\n" +
                                "                                    <option value=\"B\">B</option>\n" +
                                "                                    <option value=\"C\">C</option>\n" +
                                "                                    <option value=\"D\" >D</option>\n" +
                                "                                </select>\n "+
                                "                            </div>\n"+
                                "                </div>\n" +
                                "                <div class=\"form-group\" style=\"margin-top: 1px;margin-bottom: 5px\" id=\"answer\">\n" +
                                "\n" +
                                "                    <H6 id=\"question_Part2"+j1+"\" style=\"font-size: initial\" > </H6 >\n" +
                                "                    <input type=\"hidden\" id=\"questionPart2_2"+j1+"\" class=\"form-control\" name=\"questionNumber_2[]\" />\n" +
                                "                     <div style=\"width: 100%\" class=\"checkbox-group\">\n" +
                                "                                <label style=\"margin-right: 10px;\">Correct Answer </label>\n" +
                                "                                <select class=\"answerSelect\" name=\"answer2_2[]\">\n" +
                                "                                    <option value=\"A\" selected>A</option>\n" +
                                "                                    <option value=\"B\">B</option>\n" +
                                "                                    <option value=\"C\">C</option>\n" +
                                "                                    <option value=\"D\" >D</option>\n" +
                                "                                </select>"+
                                "                            </div>\n"+
                                "                </div>\n" +
                                "                <div class=\"form-group\" style=\"margin-top: 1px;margin-bottom: 5px\" id=\"answer\">\n" +
                                "\n" +
                                "                    <H6 id=\"question_Part2"+k1+"\"  style=\"font-size: initial\"></H6  >\n" +
                                "                    <input type=\"hidden\" id=\"questionPart2_3"+k1+"\" class=\"form-control\" name=\"questionNumber_3[]\" />\n" +
                                "                     <div style=\"width: 100%\" class=\"checkbox-group\">\n" +
                                "                                <label style=\"margin-right: 10px;\">Correct Answer </label>\n" +
                                "                                <select class=\"answerSelect\" name=\"answer2_3[]\">\n" +
                                "                                    <option value=\"A\" selected>A</option>\n" +
                                "                                    <option value=\"B\">B</option>\n" +
                                "                                    <option value=\"C\">C</option>\n" +
                                "                                    <option value=\"D\" >D</option>\n" +
                                "                                </select>"+
                                "                            </div>\n"+
                                "                </div>\n" +
                                "               \n" +
                                "            </div>\n" +
                                "\n" +
                                "\n" +
                                "        </div> ");
                            var d1 = "#question_Part2"+i1;
                            var a1 = "#questionPart2_1"+i1;
                            i1+=4;
                            $(d1).text(s1);
                            $(a1).val(s1);
                            var d2 = "#question_Part2"+j1;
                            var a2 = "#questionPart2_2"+j1;
                            j1+=4;
                            s1++;
                            $(d2).text(s1);
                            $(a2).val(s1);
                            var d3 = "#question_Part2"+k1;
                            var a3 = "#questionPart2_3"+k1;
                            k1+=4;
                            s1++;
                            $(d3).text(s1);
                            $(a3).val(s1);
                            $("#countPart2").val(s1);

                        });
                </script>

            </form>
        </div>
        <div id="part3" class="tab-pane fade">
            <div id="table-part-3" class="hidden">
                <h3 style="text-align: center">List Question</h3>
                <table data-has-data="false" class="table table-striped table-bordered table-hover" id="dataTables-example">
                    <thead>
                    <tr align="center">
                        <th style="text-align: center">Question</th>
                        <th style="text-align: center">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
            <form id="add3" action="{{route('upload.part3')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div>
                    <button type="submit" id="finish" class="btn btn-outline-primary"
                            style="display: block; margin: auto; float: right; font-size: large">Upload <i class="fa fa-upload"></i>
                    </button>
                    <button type="button" id="addQuestionPart3" class="btn btn-outline-primary" style="font-size: large">Add Question
                        <i class="fa fa-plus-square"></i>
                    </button>
                </div>
                <input name="countPart3" id="countPart3"  hidden >
                <input name="countQuestion" id="countQuestion"  hidden>
                <input name="countTeamPart3" id="countTeamPart3" hidden  >
                <div class="col-lg-6 ">

                    <h3 class="text-center" style="color: black;margin-top: 10px" id="question_order3"></h3>
                    <div class="panel-body" style="margin-top: 1px">
                        <div class="form-group" style="margin-top: 1px;margin-bottom: 5px">
                            <label>MP3</label>
                            <input type="file" class="form-control" name="mp3[]" required="mp3"/>
                            <div type="hidden" class="alert-warning">{{$errors->first('mp3')}}</div>
                            <div type="hidden" class="alert-warning">{{$errors->first('mp3.*')}}</div>
                        </div>
                        <div class="col-lg-4 ">
                            <div class="form-group" style="margin-top: 1px;margin-bottom: 5px">
                                <h6 id="questionOder4" style="font-size: initial"></h6>
                                <input id="questionOder_4"name="questionNumber_4[]" hidden>
                                <textarea class="form-control" name="question_1[]" placeholder="Please Enter question" required="text" ></textarea>

                            </div>
                            <div class="form-group" style="margin-top: 1px;margin-bottom: 5px">
                                <label>Answer A</label>
                                <input class="form-control" name="answer_1_A[]" placeholder="Please Enter Answer" required="text" />

                            </div>
                            <div class="form-group" style="margin-top: 1px;margin-bottom: 5px">
                                <label>Answer B</label>
                                <input class="form-control" name="answer_1_B[]" placeholder="Please Enter Answer" required="text"/>

                            </div>
                            <div class="form-group" style="margin-top: 1px;margin-bottom: 5px">
                                <label>Answer C</label>
                                <input class="form-control" name="answer_1_C[]" placeholder="Please Enter Answer" required="text"/>

                            </div>
                            <div class="form-group" style="margin-top: 1px;margin-bottom: 5px">
                                <label>Answer D</label>
                                <input class="form-control" name="answer_1_D[]" placeholder="Please Enter Answer"required="text" />

                            </div>
                            <div class="form-group"  >

                                    <label style="margin-right: 10px;">Correct Answer </label>
                                    <select class="answerSelect" name="answer3_1[]">
                                        <option value="A" selected>A</option>
                                        <option value="B">B</option>
                                        <option value="C">C</option>
                                        <option value="D" >D</option>
                                    </select>
                            </div>
                        </div>
                        <div class="col-lg-4 ">
                            <div class="form-group" style="margin-top: 1px;margin-bottom: 5px">
                                <h6 id="questionOder5" style="font-size: initial"></h6>
                                <input id="questionOder_5" name="questionNumber_5[]"hidden >
                                <textarea class="form-control" name="question_2[]" placeholder="Please Enter question" required="text"></textarea>

                            </div>
                            <div class="form-group" style="margin-top: 1px;margin-bottom: 5px">
                                <label>Answer A</label>
                                <input class="form-control" name="answer_2_A[]" placeholder="Please Enter Answer"required="text" />

                            </div>
                            <div class="form-group" style="margin-top: 1px;margin-bottom: 5px">
                                <label>Answer B</label>
                                <input class="form-control" name="answer_2_B[]" placeholder="Please Enter Answer" required="text"/>

                            </div>
                            <div class="form-group" style="margin-top: 1px;margin-bottom: 5px">
                                <label>Answer C</label>
                                <input class="form-control" name="answer_2_C[]" placeholder="Please Enter Answer" required="text"/>

                            </div>
                            <div class="form-group" style="margin-top: 1px;margin-bottom: 5px">
                                <label>Answer D</label>
                                <input class="form-control" name="answer_2_D[]" placeholder="Please Enter Answer" required="text"/>

                            </div>
                            <div class="form-group"  >

                                    <label style="margin-right: 10px;">Correct Answer </label>
                                    <select class="answerSelect" name="answer3_2[]">
                                        <option value="A" selected>A</option>
                                        <option value="B">B</option>
                                        <option value="C">C</option>
                                        <option value="D" >D</option>
                                    </select>
                            </div>
                        </div>
                        <div class="col-lg-4 ">
                            <div class="form-group" style="margin-top: 1px;margin-bottom: 5px">
                                <h6 id="questionOder6" style="font-size: initial"></h6>
                                <input id="questionOder_6" name="questionNumber_6[]" hidden >
                                <textarea class="form-control" name="question_3[]" placeholder="Please Enter question" required="text"></textarea>

                            </div>
                            <div class="form-group" style="margin-top: 1px;margin-bottom: 5px">
                                <label>Answer A</label>
                                <input class="form-control" name="answer_3_A[]" placeholder="Please Enter Answer" required="text"/>

                            </div>
                            <div class="form-group" style="margin-top: 1px;margin-bottom: 5px">
                                <label>Answer B</label>
                                <input class="form-control" name="answer_3_B[]" placeholder="Please Enter Answer" required="text"/>

                            </div>
                            <div class="form-group" style="margin-top: 1px;margin-bottom: 5px">
                                <label>Answer C</label>
                                <input class="form-control" name="answer_3_C[]" placeholder="Please Enter Answer" required="text" />

                            </div>
                            <div class="form-group" style="margin-top: 1px;margin-bottom: 5px">
                                <label>Answer D</label>
                                <input class="form-control" name="answer_3_D[]" placeholder="Please Enter Answer" required="text"/>

                            </div>
                            <div class="form-group" >
                                    <label style="margin-right: 10px;">Correct Answer </label>
                                    <select class="answerSelect" name="answer3_3[]">
                                        <option value="A" selected>A</option>
                                        <option value="B">B</option>
                                        <option value="C">C</option>
                                        <option value="D" >D</option>
                                    </select>
                            </div>
                        </div>
                </div>
                <script>
                    $(function(){
                        var requiredCheckboxes = $('.form-group :checkbox[required]');
                        requiredCheckboxes.change(function(){
                            if(requiredCheckboxes.is(':checked')) {
                                requiredCheckboxes.removeAttr('required');
                            } else {
                                requiredCheckboxes.attr('required', 'required');
                            }
                        });
                    });
                    $("input:checkbox").on('click', function() {
                        // in the handler, 'this' refers to the box clicked on
                        var $box = $(this);
                        if ($box.is(":checked")) {
                            var group = "input:checkbox[name='" + $box.attr("name") + "']";
                            $(group).prop("checked", false);
                            $box.prop("checked", true);
                        } else {
                            $box.prop("checked", false);
                        }
                    });
                    var i2 = 0,j2=1,k2=2;
                    var s2 = 0;
                    var count = 1;
                    $("#addQuestionPart3").click(function () {
                        var d =$("#countPart3").val();
                        count++;
                        s2 = parseInt(d);
                        s2++;
                        $("#add3").append(" <div class=\"col-lg-6 \">\n" +
                            "\n" +
                            "                    <h3 class=\"text-center\" style=\"color: black;margin-top: 10px\" id=\"question_order4\"></h3>\n" +
                            "                    <div class=\"panel-body\" style=\"margin-top: 1px\">\n" +
                            "                        <div class=\"form-group\" style=\"margin-top: 1px;margin-bottom: 5px\">\n" +
                            "                            <label>MP3</label>\n" +
                            "                            <input type=\"file\" class=\"form-control\" name=\"mp3[]\" />\n" +
                            "                            <div type=\"hidden\" class=\"alert-warning\">{{$errors->first('mp3')}}</div>\n" +
                            "                            <div type=\"hidden\" class=\"alert-warning\">{{$errors->first('mp3.*')}}</div>\n" +
                            "                        </div>\n" +
                            "                        <div class=\"col-lg-4 \">\n" +
                            "                            <div class=\"form-group\" style=\"margin-top: 1px;margin-bottom: 5px\">\n" +
                            "                                <h6 id=\"question_Part3"+i2+"\"  style=\"font-size: initial\"></h6>\n" +
                            "                                <input id=\"questionPart3_1" +i2+"\" name=\"questionNumber_4[]\" hidden>\n" +
                            "                                <textarea class=\"form-control\" name=\"question_1[]\" placeholder=\"Please Enter question\" required=\"text\" ></textarea>\n" +
                            "\n" +
                            "                            </div>\n" +
                            "                            <div class=\"form-group\" style=\"margin-top: 1px;margin-bottom: 5px\">\n" +
                            "                                <label>Answer A</label>\n" +
                            "                                <input class=\"form-control\" name=\"answer_1_A[]\" placeholder=\"Please Enter Answer\" required=\"text\" />\n" +
                            "\n" +
                            "                            </div>\n" +
                            "                            <div class=\"form-group\" style=\"margin-top: 1px;margin-bottom: 5px\">\n" +
                            "                                <label>Answer B</label>\n" +
                            "                                <input class=\"form-control\" name=\"answer_1_B[]\" placeholder=\"Please Enter Answer\" required=\"text\"/>\n" +
                            "\n" +
                            "                            </div>\n" +
                            "                            <div class=\"form-group\" style=\"margin-top: 1px;margin-bottom: 5px\">\n" +
                            "                                <label>Answer C</label>\n" +
                            "                                <input class=\"form-control\" name=\"answer_1_C[]\" placeholder=\"Please Enter Answer\" required=\"text\"/>\n" +
                            "\n" +
                            "                            </div>\n" +
                            "                            <div class=\"form-group\" style=\"margin-top: 1px;margin-bottom: 5px\">\n" +
                            "                                <label>Answer D</label>\n" +
                            "                                <input class=\"form-control\" name=\"answer_1_D[]\" placeholder=\"Please Enter Answer\"required=\"text\" />\n" +
                            "\n" +
                            "                            </div>\n" +
                            "                             <div class=\"form-group\" style=\"margin-top: 15px;margin-bottom: 5px\" >\n" +
                            "                                <label style=\"margin-right: 10px;\">Correct Answer </label>\n" +
                            "                                <select class=\"answerSelect\" name=\"answer3_1[]\">\n" +
                            "                                        <option value=\"A\" selected>A</option>\n" +
                            "                                        <option value=\"B\">B</option>\n" +
                            "                                        <option value=\"C\">C</option>\n" +
                            "                                        <option value=\"D\" >D</option>\n" +
                            "                                    </select>\n "+
                            "                            </div>\n"+
                            "\n" +
                            "\n" +
                            "                        </div>\n" +
                            "                        <div class=\"col-lg-4 \">\n" +
                            "                            <div class=\"form-group\" style=\"margin-top: 1px;margin-bottom: 5px\">\n" +
                            "                                <h6 id=\"question_Part3"+j2+"\" style=\"font-size: initial\"></h6>\n" +
                            "                                <input id=\"questionPart3_2"+j2+"\" name=\"questionNumber_5[]\" hidden>\n" +
                            "                                <textarea class=\"form-control\" name=\"question_2[]\" placeholder=\"Please Enter question\" required=\"text\"></textarea>\n" +
                            "\n" +
                            "                            </div>\n" +
                            "                            <div class=\"form-group\" style=\"margin-top: 1px;margin-bottom: 5px\">\n" +
                            "                                <label>Answer A</label>\n" +
                            "                                <input class=\"form-control\" name=\"answer_2_A[]\" placeholder=\"Please Enter Answer\"required=\"text\" />\n" +
                            "\n" +
                            "                            </div>\n" +
                            "                            <div class=\"form-group\" style=\"margin-top: 1px;margin-bottom: 5px\">\n" +
                            "                                <label>Answer B</label>\n" +
                            "                                <input class=\"form-control\" name=\"answer_2_B[]\" placeholder=\"Please Enter Answer\" required=\"text\"/>\n" +
                            "\n" +
                            "                            </div>\n" +
                            "                            <div class=\"form-group\" style=\"margin-top: 1px;margin-bottom: 5px\">\n" +
                            "                                <label>Answer C</label>\n" +
                            "                                <input class=\"form-control\" name=\"answer_2_C[]\" placeholder=\"Please Enter Answer\" required=\"text\"/>\n" +
                            "\n" +
                            "                            </div>\n" +
                            "                            <div class=\"form-group\" style=\"margin-top: 1px;margin-bottom: 5px\">\n" +
                            "                                <label>Answer D</label>\n" +
                            "                                <input class=\"form-control\" name=\"answer_2_D[]\" placeholder=\"Please Enter Answer\" required=\"text\"/>\n" +
                            "\n" +
                            "                            </div>\n" +
                            "                            <div class=\"form-group\" style=\"margin-top: 15px;margin-bottom: 5px\" >\n" +

                            "                                 <label style=\"margin-right: 10px;\">Correct Answer </label>\n" +
                            "                                <select class=\"answerSelect\" name=\"answer3_2[]\">\n" +
                            "                                        <option value=\"A\" selected>A</option>\n" +
                            "                                        <option value=\"B\">B</option>\n" +
                            "                                        <option value=\"C\">C</option>\n" +
                            "                                        <option value=\"D\" >D</option>\n" +
                            "                                    </select>"+
                            "                            </div>\n"+
                            "\n" +
                            "\n" +
                            "                        </div>\n" +
                            "                        <div class=\"col-lg-4 \">\n" +
                            "                            <div class=\"form-group\" style=\"margin-top: 1px;margin-bottom: 5px\">\n" +
                            "                                <h6 id=\"question_Part3"+k2+"\"style=\"font-size: initial\"></h6>\n" +
                            "                                <input id=\"questionPart3_3"+k2+"\" name=\"questionNumber_6[]\" hidden>\n" +
                            "                                <textarea class=\"form-control\" name=\"question_3[]\" placeholder=\"Please Enter question\" required=\"text\"></textarea>\n" +
                            "\n" +
                            "                            </div>\n" +
                            "                            <div class=\"form-group\" style=\"margin-top: 1px;margin-bottom: 5px\">\n" +
                            "                                <label>Answer A</label>\n" +
                            "                                <input class=\"form-control\" name=\"answer_3_A[]\" placeholder=\"Please Enter Answer\" required=\"text\"/>\n" +
                            "\n" +
                            "                            </div>\n" +
                            "                            <div class=\"form-group\" style=\"margin-top: 1px;margin-bottom: 5px\">\n" +
                            "                                <label>Answer B</label>\n" +
                            "                                <input class=\"form-control\" name=\"answer_3_B[]\" placeholder=\"Please Enter Answer\" required=\"text\"/>\n" +
                            "\n" +
                            "                            </div>\n" +
                            "                            <div class=\"form-group\" style=\"margin-top: 1px;margin-bottom: 5px\">\n" +
                            "                                <label>Answer C</label>\n" +
                            "                                <input class=\"form-control\" name=\"answer_3_C[]\" placeholder=\"Please Enter Answer\" required=\"text\" />\n" +
                            "\n" +
                            "                            </div>\n" +
                            "                            <div class=\"form-group\" style=\"margin-top: 1px;margin-bottom: 5px\">\n" +
                            "                                <label>Answer D</label>\n" +
                            "                                <input class=\"form-control\" name=\"answer_3_D[]\" placeholder=\"Please Enter Answer\" required=\"text\"/>\n" +
                            "\n" +
                            "                            </div>\n" +
                            "                            <div class=\"form-group\" style=\"margin-top: 15px;margin-bottom: 5px\" >\n" +
                            "                                \n" +
                            "                                    <label style=\"margin-right: 10px;\">Correct Answer </label>\n" +
                            "                                 <select class=\"answerSelect\" name=\"answer3_3[]\">\n" +
                            "                                        <option value=\"A\" selected>A</option>\n" +
                            "                                        <option value=\"B\">B</option>\n" +
                            "                                        <option value=\"C\">C</option>\n" +
                            "                                        <option value=\"D\" >D</option>\n" +
                            "                                    </select>"+
                            "                            </div>\n"+
                            "\n" +
                            "                            </div>\n" +
                            "\n" +
                            "\n" +
                            "\n" +
                            "                </div>");
                        var d1 = "#question_Part3"+i2;
                        var a1 = "#questionPart3_1"+i2;
                        i2+=4;
                        $(d1).text(s2);
                        $(a1).val(s2);
                        var d2 = "#question_Part3"+j2;
                        var a2 = "#questionPart3_2"+j2;
                        j2+=4;
                        s2++;
                        $(d2).text(s2);
                        $(a2).val(s2);
                        var d3 = "#question_Part3"+k2;
                        var a3 = "#questionPart3_3"+k2;
                        k2+=4;
                        s2++;
                        $(d3).text(s2);
                        $(a3).val(s2);
                        $("#countPart3").val(s2);

                    });
                </script>

                </div>
            </form>
        </div>
        <div id="part4" class="tab-pane fade">
            <div id="table-part-4" class="hidden">
                <h3 style="text-align: center">List Question</h3>
                <table data-has-data="false" class="table table-striped table-bordered table-hover" id="dataTables-example">
                    <thead>
                    <tr align="center">
                        <th style="text-align: center">Question</th>
                        <th style="text-align: center">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
            <form id="add4" action="{{route('upload.part4')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div>
                    <button type="submit" id="finish" class="btn btn-outline-primary"
                            style="display: block; margin: auto; float: right; font-size: large">Upload <i class="fa fa-upload"></i>
                    </button>
                    <button type="button" id="addQuestionPart4" class="btn btn-outline-primary" style="font-size: large">Add Question
                        <i class="fa fa-plus-square"></i>
                    </button>
                </div>
                <input name="countPart4" id="countPart4"   hidden>
                <input name="countQuestion" id="countQuestion"  hidden >
                <input name="countTeamPart4" id="countTeamPart4"  hidden >

                <div class="col-lg-6 ">

                    <h3 class="text-center" style="color: black;margin-top: 10px" id="question_order3"></h3>
                    <div class="panel-body" style="margin-top: 1px">
                        <div class="form-group" style="margin-top: 1px;margin-bottom: 5px">
                            <label>MP3</label>
                            <input type="file" class="form-control" name="mp3[]" required="mp3"/>
                            <div type="hidden" class="alert-warning">{{$errors->first('mp3')}}</div>
                            <div type="hidden" class="alert-warning">{{$errors->first('mp3.*')}}</div>
                        </div>
                        <div class="col-lg-4 ">
                            <div class="form-group" style="margin-top: 1px;margin-bottom: 5px">
                                <h6 id="questionOder7" style="font-size: initial"></h6>
                                <input id="questionOder_7" name="questionNumber_7[]" hidden>
                                <textarea class="form-control" name="question_1[]" placeholder="Please Enter question" required="text" ></textarea>

                            </div>
                            <div class="form-group" style="margin-top: 1px;margin-bottom: 5px">
                                <label>Answer A</label>
                                <input class="form-control" name="answer_1_A[]" placeholder="Please Enter Answer" required="text" />

                            </div>
                            <div class="form-group" style="margin-top: 1px;margin-bottom: 5px">
                                <label>Answer B</label>
                                <input class="form-control" name="answer_1_B[]" placeholder="Please Enter Answer" required="text"/>

                            </div>
                            <div class="form-group" style="margin-top: 1px;margin-bottom: 5px">
                                <label>Answer C</label>
                                <input class="form-control" name="answer_1_C[]" placeholder="Please Enter Answer" required="text"/>

                            </div>
                            <div class="form-group" style="margin-top: 1px;margin-bottom: 5px">
                                <label>Answer D</label>
                                <input class="form-control" name="answer_1_D[]" placeholder="Please Enter Answer"required="text" />

                            </div>
                            <div class="form-group" style="margin-top: 1px;margin-bottom: 5px">
                                <label>Correct Answer</label>
                                <select class="answerSelect" name="answer4_1[]">
                                    <option value="A" selected>A</option>
                                    <option value="B">B</option>
                                    <option value="C">C</option>
                                    <option value="D" >D</option>
                                </select>

                            </div>

                        </div>
                        <div class="col-lg-4 ">
                            <div class="form-group" style="margin-top: 1px;margin-bottom: 5px">
                                <h6 id="questionOder8" style="font-size: initial"></h6>
                                <input id="questionOder_8" name="questionNumber_8[]" hidden >
                                <textarea class="form-control" name="question_2[]" placeholder="Please Enter question" required="text"></textarea>

                            </div>
                            <div class="form-group" style="margin-top: 1px;margin-bottom: 5px">
                                <label>Answer A</label>
                                <input class="form-control" name="answer_2_A[]" placeholder="Please Enter Answer"required="text" />

                            </div>
                            <div class="form-group" style="margin-top: 1px;margin-bottom: 5px">
                                <label>Answer B</label>
                                <input class="form-control" name="answer_2_B[]" placeholder="Please Enter Answer" required="text"/>

                            </div>
                            <div class="form-group" style="margin-top: 1px;margin-bottom: 5px">
                                <label>Answer C</label>
                                <input class="form-control" name="answer_2_C[]" placeholder="Please Enter Answer" required="text"/>

                            </div>
                            <div class="form-group" style="margin-top: 1px;margin-bottom: 5px">
                                <label>Answer D</label>
                                <input class="form-control" name="answer_2_D[]" placeholder="Please Enter Answer" required="text"/>

                            </div>
                            <div class="form-group" style="margin-top: 1px;margin-bottom: 5px">
                                <label>Correct Answer</label>
                                <select class="answerSelect" name="answer4_2[]">
                                    <option value="A" selected>A</option>
                                    <option value="B">B</option>
                                    <option value="C">C</option>
                                    <option value="D" >D</option>
                                </select>

                            </div>

                        </div>
                        <div class="col-lg-4 ">
                            <div class="form-group" style="margin-top: 1px;margin-bottom: 5px">
                                <h6 id="questionOder9" style="font-size: initial"></h6>
                                <input id="questionOder_9" name="questionNumber_9[]" hidden >
                                <textarea class="form-control" name="question_3[]" placeholder="Please Enter question" required="text"></textarea>

                            </div>
                            <div class="form-group" style="margin-top: 1px;margin-bottom: 5px">
                                <label>Answer A</label>
                                <input class="form-control" name="answer_3_A[]" placeholder="Please Enter Answer" required="text"/>

                            </div>
                            <div class="form-group" style="margin-top: 1px;margin-bottom: 5px">
                                <label>Answer B</label>
                                <input class="form-control" name="answer_3_B[]" placeholder="Please Enter Answer" required="text"/>

                            </div>
                            <div class="form-group" style="margin-top: 1px;margin-bottom: 5px">
                                <label>Answer C</label>
                                <input class="form-control" name="answer_3_C[]" placeholder="Please Enter Answer" required="text" />

                            </div>
                            <div class="form-group" style="margin-top: 1px;margin-bottom: 5px">
                                <label>Answer D</label>
                                <input class="form-control" name="answer_3_D[]" placeholder="Please Enter Answer" required="text"/>

                            </div>
                            <div class="form-group" style="margin-top: 1px;margin-bottom: 5px">
                                <label>Correct Answer</label>
                                <select class="answerSelect" name="answer4_3[]">
                                    <option value="A" selected>A</option>
                                    <option value="B">B</option>
                                    <option value="C">C</option>
                                    <option value="D" >D</option>
                                </select>

                            </div>

                        </div>
                    </div>


                </div>
                <script>

                    var i3 = 0,j3=1,k3=2;
                    var  s3= 0;
                    var count = 1;
                    $("#addQuestionPart4").click(function () {
                        var d =$("#countPart4").val();
                        count++;
                        s3 = parseInt(d);
                        s3++;
                        $("#add4").append(" <div class=\"col-lg-6 \">\n" +
                            "\n" +
                            "                    <h3 class=\"text-center\" style=\"color: black;margin-top: 10px\" id=\"question_order4\"></h3>\n" +
                            "                    <div class=\"panel-body\" style=\"margin-top: 1px\">\n" +
                            "                        <div class=\"form-group\" style=\"margin-top: 1px;margin-bottom: 5px\">\n" +
                            "                            <label>MP3</label>\n" +
                            "                            <input type=\"file\" class=\"form-control\" name=\"mp3[]\" />\n" +
                            "                            <div type=\"hidden\" class=\"alert-warning\">{{$errors->first('mp3')}}</div>\n" +
                            "                            <div type=\"hidden\" class=\"alert-warning\">{{$errors->first('mp3.*')}}</div>\n" +
                            "                        </div>\n" +
                            "                        <div class=\"col-lg-4 \">\n" +
                            "                            <div class=\"form-group\" style=\"margin-top: 1px;margin-bottom: 5px\">\n" +
                            "                                <h6 id=\"question_Part4"+i3+"\"  style=\"font-size: initial\"></h6>\n" +
                            "                                <input id=\"questionPart4_1" +i3+"\" name=\"questionNumber_7[]\" hidden>\n" +
                            "                                <textarea class=\"form-control\" name=\"question_1[]\" placeholder=\"Please Enter question\" required=\"text\" ></textarea>\n" +
                            "\n" +
                            "                            </div>\n" +
                            "                            <div class=\"form-group\" style=\"margin-top: 1px;margin-bottom: 5px\">\n" +
                            "                                <label>Answer A</label>\n" +
                            "                                <input class=\"form-control\" name=\"answer_1_A[]\" placeholder=\"Please Enter Answer\" required=\"text\" />\n" +
                            "\n" +
                            "                            </div>\n" +
                            "                            <div class=\"form-group\" style=\"margin-top: 1px;margin-bottom: 5px\">\n" +
                            "                                <label>Answer B</label>\n" +
                            "                                <input class=\"form-control\" name=\"answer_1_B[]\" placeholder=\"Please Enter Answer\" required=\"text\"/>\n" +
                            "\n" +
                            "                            </div>\n" +
                            "                            <div class=\"form-group\" style=\"margin-top: 1px;margin-bottom: 5px\">\n" +
                            "                                <label>Answer C</label>\n" +
                            "                                <input class=\"form-control\" name=\"answer_1_C[]\" placeholder=\"Please Enter Answer\" required=\"text\"/>\n" +
                            "\n" +
                            "                            </div>\n" +
                            "                            <div class=\"form-group\" style=\"margin-top: 1px;margin-bottom: 5px\">\n" +
                            "                                <label>Answer D</label>\n" +
                            "                                <input class=\"form-control\" name=\"answer_1_D[]\" placeholder=\"Please Enter Answer\"required=\"text\" />\n" +
                            "\n" +
                            "                            </div>\n" +
                            "                            <div class=\"form-group\" style=\"margin-top: 1px;margin-bottom: 5px\">\n" +
                            "                                <label>Correct Answer</label>\n" +
                            "                               <select class=\"answerSelect\" name=\"answer4_1[]\">\n" +
                            "                                    <option value=\"A\" selected>A</option>\n" +
                            "                                    <option value=\"B\">B</option>\n" +
                            "                                    <option value=\"C\">C</option>\n" +
                            "                                    <option value=\"D\" >D</option>\n" +
                            "                                </select>"+
                            "\n" +
                            "                            </div>\n" +
                            "\n" +
                            "                        </div>\n" +
                            "                        <div class=\"col-lg-4 \">\n" +
                            "                            <div class=\"form-group\" style=\"margin-top: 1px;margin-bottom: 5px\">\n" +
                            "                                <h6 id=\"question_Part4"+j3+"\" style=\"font-size: initial\"></h6>\n" +
                            "                                <input id=\"questionPart4_2"+j3+"\" name=\"questionNumber_8[]\" hidden>\n" +
                            "                                <textarea class=\"form-control\" name=\"question_2[]\" placeholder=\"Please Enter question\" required=\"text\"></textarea>\n" +
                            "\n" +
                            "                            </div>\n" +
                            "                            <div class=\"form-group\" style=\"margin-top: 1px;margin-bottom: 5px\">\n" +
                            "                                <label>Answer A</label>\n" +
                            "                                <input class=\"form-control\" name=\"answer_2_A[]\" placeholder=\"Please Enter Answer\"required=\"text\" />\n" +
                            "\n" +
                            "                            </div>\n" +
                            "                            <div class=\"form-group\" style=\"margin-top: 1px;margin-bottom: 5px\">\n" +
                            "                                <label>Answer B</label>\n" +
                            "                                <input class=\"form-control\" name=\"answer_2_B[]\" placeholder=\"Please Enter Answer\" required=\"text\"/>\n" +
                            "\n" +
                            "                            </div>\n" +
                            "                            <div class=\"form-group\" style=\"margin-top: 1px;margin-bottom: 5px\">\n" +
                            "                                <label>Answer C</label>\n" +
                            "                                <input class=\"form-control\" name=\"answer_2_C[]\" placeholder=\"Please Enter Answer\" required=\"text\"/>\n" +
                            "\n" +
                            "                            </div>\n" +
                            "                            <div class=\"form-group\" style=\"margin-top: 1px;margin-bottom: 5px\">\n" +
                            "                                <label>Answer D</label>\n" +
                            "                                <input class=\"form-control\" name=\"answer_2_D[]\" placeholder=\"Please Enter Answer\" required=\"text\"/>\n" +
                            "\n" +
                            "                            </div>\n" +
                            "                            <div class=\"form-group\" style=\"margin-top: 1px;margin-bottom: 5px\">\n" +
                            "                                <label>Correct Answer</label>\n" +
                            "                                <select class=\"answerSelect\" name=\"answer4_2[]\">\n" +
                            "                                    <option value=\"A\" selected>A</option>\n" +
                            "                                    <option value=\"B\">B</option>\n" +
                            "                                    <option value=\"C\">C</option>\n" +
                            "                                    <option value=\"D\" >D</option>\n" +
                            "                                </select>"+
                            "\n" +
                            "                            </div>\n" +
                            "\n" +
                            "                        </div>\n" +
                            "                        <div class=\"col-lg-4 \">\n" +
                            "                            <div class=\"form-group\" style=\"margin-top: 1px;margin-bottom: 5px\">\n" +
                            "                                <h6 id=\"question_Part4"+k3+"\"style=\"font-size: initial\"></h6>\n" +
                            "                                <input id=\"questionPart4_3"+k3+"\" name=\"questionNumber_9[]\" hidden>\n" +
                            "                                <textarea class=\"form-control\" name=\"question_3[]\" placeholder=\"Please Enter question\" required=\"text\"></textarea>\n" +
                            "\n" +
                            "                            </div>\n" +
                            "                            <div class=\"form-group\" style=\"margin-top: 1px;margin-bottom: 5px\">\n" +
                            "                                <label>Answer A</label>\n" +
                            "                                <input class=\"form-control\" name=\"answer_3_A[]\" placeholder=\"Please Enter Answer\" required=\"text\"/>\n" +
                            "\n" +
                            "                            </div>\n" +
                            "                            <div class=\"form-group\" style=\"margin-top: 1px;margin-bottom: 5px\">\n" +
                            "                                <label>Answer B</label>\n" +
                            "                                <input class=\"form-control\" name=\"answer_3_B[]\" placeholder=\"Please Enter Answer\" required=\"text\"/>\n" +
                            "\n" +
                            "                            </div>\n" +
                            "                            <div class=\"form-group\" style=\"margin-top: 1px;margin-bottom: 5px\">\n" +
                            "                                <label>Answer C</label>\n" +
                            "                                <input class=\"form-control\" name=\"answer_3_C[]\" placeholder=\"Please Enter Answer\" required=\"text\" />\n" +
                            "\n" +
                            "                            </div>\n" +
                            "                            <div class=\"form-group\" style=\"margin-top: 1px;margin-bottom: 5px\">\n" +
                            "                                <label>Answer D</label>\n" +
                            "                                <input class=\"form-control\" name=\"answer_3_D[]\" placeholder=\"Please Enter Answer\" required=\"text\"/>\n" +
                            "\n" +
                            "                            </div>\n" +
                            "                            <div class=\"form-group\" style=\"margin-top: 1px;margin-bottom: 5px\">\n" +
                            "                                <label>Correct Answer</label>\n" +
                            "                               <select class=\"answerSelect\" name=\"answer4_3[]\">\n" +
                            "                                    <option value=\"A\" selected>A</option>\n" +
                            "                                    <option value=\"B\">B</option>\n" +
                            "                                    <option value=\"C\">C</option>\n" +
                            "                                    <option value=\"D\" >D</option>\n" +
                            "                                </select>"+
                            "\n" +
                            "                            </div>\n" +
                            "\n" +
                            "                        </div>\n" +
                            "                    </div>\n" +
                            "\n" +
                            "\n" +
                            "                </div>");
                        var d1 = "#question_Part4"+i3;
                        var a1 = "#questionPart4_1"+i3;
                        i3+=4;
                        $(d1).text(s3);
                        $(a1).val(s3);
                        var d2 = "#question_Part4"+j3;
                        var a2 = "#questionPart4_2"+j3;
                        j3+=4;
                        s3++;
                        $(d2).text(s3);
                        $(a2).val(s3);
                        var d3 = "#question_Part4"+k3;
                        var a3 = "#questionPart4_3"+k3;
                        k3+=4;
                        s3++;
                        $(d3).text(s3);
                        $(a3).val(s3);
                        $("#countPart4").val(s3);


                    });
                </script>

            </form>
        </div>
        <div id="part5" class="tab-pane fade">
            <div id="table-part-5" class="hidden">
                <h3 style="text-align: center">List Question</h3>
                <table data-has-data="false" class="table table-striped table-bordered table-hover" id="dataTables-example">
                    <thead>
                    <tr align="center">
                        <th style="text-align: center">Question</th>
                        <th style="text-align: center">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
            <form id="add5" action="{{route('upload.part5')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div>
                    <h3 class="text-center" style="color: black;margin-top: 10px; font-size: xx-large">Upload</h3>


                    <button type="submit" id="finish" class="btn btn-outline-primary"
                            style="display: block; margin: auto; float: right; font-size: large">Upload <i class="fa fa-upload"></i>
                    </button>

                    {{--<input type="button" id="btn2" class="btn" value="Add Question">--}}
                    <button type="button" id="addQuestionPart5" class="btn btn-outline-primary" style="font-size: large">Add Question
                        <i class="fa fa-plus-square"></i>
                    </button>
                </div>

                <input name="count5" id="count5"  hidden>
                <div class="col-lg-4 ">
                    <h3 class="text-center" style="color: black;margin-top: 10px" id="question_order5"></h3>
                    <div class="panel-body" style="margin-top: 1px">
                        <div class="form-group" style="margin-top: 1px;margin-bottom: 5px">
                            <label>Question</label>
                            <textarea class="form-control" name="question[]" placeholder="Please Enter question" required="text"></textarea>
                        </div>
                        <div class="form-group" style="margin-top: 1px;margin-bottom: 5px">
                            <label>Answer A</label>
                            <input class="form-control" name="answer_A[]" placeholder="Please Enter Answer" required="text"/>

                        </div>
                        <div class="form-group" style="margin-top: 1px;margin-bottom: 5px">
                            <label>Answer B</label>
                            <input class="form-control" name="answer_B[]" placeholder="Please Enter Answer" required="text"/>

                        </div>
                        <div class="form-group" style="margin-top: 1px;margin-bottom: 5px">
                            <label>Answer C</label>
                            <input class="form-control" name="answer_C[]" placeholder="Please Enter Answer" required="text"/>

                        </div>
                        <div class="form-group" style="margin-top: 1px;margin-bottom: 5px">
                            <label>Answer D</label>
                            <input class="form-control" name="answer_D[]" placeholder="Please Enter Answer"required="text"/>

                        </div>
                        <div class="form-group" style="margin-top: 1px;margin-bottom: 5px">
                            <label>Correct Answer</label>
                            <select class="answerSelect" name="answer5[]">
                                <option value="A" selected>A</option>
                                <option value="B">B</option>
                                <option value="C">C</option>
                                <option value="D" >D</option>
                            </select>

                        </div>
                    </div>


                </div>
                <script>
                    var z = 0;
                    var count = 1;
                    $("#addQuestionPart5").click(function () {
                        var d =$("#question_order5").text();
                        count++;
                        var r = parseInt(d) + z;
                        r+=1;
                        $("#add5").append("<div class=\"col-lg-4 \">\n" +
                            "                    <h3 class=\"text-center\" style=\"color: black;margin-top: 10px\" id=\"question_order55"+z+"\"></h3>\n" +
                            "                    <div class=\"panel-body\" style=\"margin-top: 1px\">\n" +
                            "                        <div class=\"form-group\" style=\"margin-top: 1px;margin-bottom: 5px\">\n" +
                            "                            <label>Question</label>\n" +
                            "                            <textarea class=\"form-control\" name=\"question[]\" placeholder=\"Please Enter question\" required=\"text\"></textarea>\n" +
                            "                        </div>\n" +
                            "                        <div class=\"form-group\" style=\"margin-top: 1px;margin-bottom: 5px\">\n" +
                            "                            <label>Answer A</label>\n" +
                            "                            <input class=\"form-control\" name=\"answer_A[]\" placeholder=\"Please Enter Answer\" required=\"text\"/>\n" +
                            "\n" +
                            "                        </div>\n" +
                            "                        <div class=\"form-group\" style=\"margin-top: 1px;margin-bottom: 5px\">\n" +
                            "                            <label>Answer B</label>\n" +
                            "                            <input class=\"form-control\" name=\"answer_B[]\" placeholder=\"Please Enter Answer\" required=\"text\"/>\n" +
                            "\n" +
                            "                        </div>\n" +
                            "                        <div class=\"form-group\" style=\"margin-top: 1px;margin-bottom: 5px\">\n" +
                            "                            <label>Answer C</label>\n" +
                            "                            <input class=\"form-control\" name=\"answer_C[]\" placeholder=\"Please Enter Answer\" required=\"text\"/>\n" +
                            "\n" +
                            "                        </div>\n" +
                            "                        <div class=\"form-group\" style=\"margin-top: 1px;margin-bottom: 5px\">\n" +
                            "                            <label>Answer D</label>\n" +
                            "                            <input class=\"form-control\" name=\"answer_D[]\" placeholder=\"Please Enter Answer\"required=\"text\"/>\n" +
                            "\n" +
                            "                        </div>\n" +
                            "                        <div class=\"form-group\" style=\"margin-top: 1px;margin-bottom: 5px\">\n" +
                            "                            <label>Correct Answer</label>\n" +
                            "                           <select class=\"answerSelect\" name=\"answer5[]\">\n" +
                            "                                <option value=\"A\" selected>A</option>\n" +
                            "                                <option value=\"B\">B</option>\n" +
                            "                                <option value=\"C\">C</option>\n" +
                            "                                <option value=\"D\" >D</option>\n" +
                            "                            </select>" +
                            "\n" +
                            "                        </div>\n" +
                            "                    </div>\n" +
                            "\n" +
                            "\n" +
                            "                </div>");
                        var d = "#question_order55"+z;
                        $(d).text(r);
                        z++;
                    });

                </script>

            </form>
        </div>
        <div id="part6" class="tab-pane fade">
            <div id="table-part-6" class="hidden">
                <h3 style="text-align: center">List Question</h3>
                <table data-has-data="false" class="table table-striped table-bordered table-hover" id="dataTables-example">
                    <thead>
                    <tr align="center">
                        <th style="text-align: center">Question</th>
                        <th style="text-align: center">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
            <form id="add6" action="{{route('upload.part6')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div>
                    <button type="submit" id="finish" class="btn btn-outline-primary"
                            style="display: block; margin: auto; float: right; font-size: large">Upload <i class="fa fa-upload"></i>
                    </button>
                    <button type="button" id="addQuestionPart6" class="btn btn-outline-primary" style="font-size: large">Add Question
                        <i class="fa fa-plus-square"></i>
                    </button>
                </div>
                <input name="countPart6" id="countPart6" hidden >
                <input name="countQuestion" id="countQuestion" hidden >
                <input name="countTeamPart6" id="countTeamPart6" hidden  >
                <div class="col-lg-6 ">

                    <h3 class="text-center" style="color: black;margin-top: 10px" id="question_order6"></h3>
                    <div class="panel-body" style="margin-top: 1px">
                        <div class="form-group" style="margin-top: 1px;margin-bottom: 5px">
                            <label>Image</label>
                            <input type="file" class="form-control" name="images[]" />
                            <div type="hidden" class="alert-warning">{{$errors->first('images')}}</div>
                            <div type="hidden" class="alert-warning">{{$errors->first('images.*')}}</div>
                        </div>
                        <div class="col-lg-4 ">
                            <div class="form-group" style="margin-top: 1px;margin-bottom: 5px">
                                <h6 id="questionOder10" style="font-size: initial"></h6>
                                <input id="questionOder_10" name="questionNumber_10[]" hidden>
                                <textarea class="form-control" name="question_1[]" placeholder="Please Enter question" required="text" ></textarea>

                            </div>
                            <div class="form-group" style="margin-top: 1px;margin-bottom: 5px">
                                <label>Answer A</label>
                                <input class="form-control" name="answer_1_A[]" placeholder="Please Enter Answer" required="text" />

                            </div>
                            <div class="form-group" style="margin-top: 1px;margin-bottom: 5px">
                                <label>Answer B</label>
                                <input class="form-control" name="answer_1_B[]" placeholder="Please Enter Answer" required="text"/>

                            </div>
                            <div class="form-group" style="margin-top: 1px;margin-bottom: 5px">
                                <label>Answer C</label>
                                <input class="form-control" name="answer_1_C[]" placeholder="Please Enter Answer" required="text"/>

                            </div>
                            <div class="form-group" style="margin-top: 1px;margin-bottom: 5px">
                                <label>Answer D</label>
                                <input class="form-control" name="answer_1_D[]" placeholder="Please Enter Answer"required="text" />

                            </div>
                            <div class="form-group" style="margin-top: 1px;margin-bottom: 5px">
                                <label>Correct Answer</label>
                                <select class="answerSelect" name="answer6_1[]">
                                    <option value="A" selected>A</option>
                                    <option value="B">B</option>
                                    <option value="C">C</option>
                                    <option value="D" >D</option>
                                </select>

                            </div>

                        </div>
                        <div class="col-lg-4 ">
                            <div class="form-group" style="margin-top: 1px;margin-bottom: 5px">
                                <h6 id="questionOder11" style="font-size: initial"></h6>
                                <input id="questionOder_11" name="questionNumber_11[]"  hidden>
                                <textarea class="form-control" name="question_2[]" placeholder="Please Enter question" required="text"></textarea>

                            </div>
                            <div class="form-group" style="margin-top: 1px;margin-bottom: 5px">
                                <label>Answer A</label>
                                <input class="form-control" name="answer_2_A[]" placeholder="Please Enter Answer"required="text" />

                            </div>
                            <div class="form-group" style="margin-top: 1px;margin-bottom: 5px">
                                <label>Answer B</label>
                                <input class="form-control" name="answer_2_B[]" placeholder="Please Enter Answer" required="text"/>

                            </div>
                            <div class="form-group" style="margin-top: 1px;margin-bottom: 5px">
                                <label>Answer C</label>
                                <input class="form-control" name="answer_2_C[]" placeholder="Please Enter Answer" required="text"/>

                            </div>
                            <div class="form-group" style="margin-top: 1px;margin-bottom: 5px">
                                <label>Answer D</label>
                                <input class="form-control" name="answer_2_D[]" placeholder="Please Enter Answer" required="text"/>

                            </div>
                            <div class="form-group" style="margin-top: 1px;margin-bottom: 5px">
                                <label>Correct Answer</label>
                                <select class="answerSelect" name="answer6_2[]">
                                    <option value="A" selected>A</option>
                                    <option value="B">B</option>
                                    <option value="C">C</option>
                                    <option value="D" >D</option>
                                </select>

                            </div>

                        </div>
                        <div class="col-lg-4 ">
                            <div class="form-group" style="margin-top: 1px;margin-bottom: 5px">
                                <h6 id="questionOder12" style="font-size: initial"></h6>
                                <input id="questionOder_12" name="questionNumber_12[]" hidden>
                                <textarea class="form-control" name="question_3[]" placeholder="Please Enter question" required="text"></textarea>

                            </div>
                            <div class="form-group" style="margin-top: 1px;margin-bottom: 5px">
                                <label>Answer A</label>
                                <input class="form-control" name="answer_3_A[]" placeholder="Please Enter Answer" required="text"/>

                            </div>
                            <div class="form-group" style="margin-top: 1px;margin-bottom: 5px">
                                <label>Answer B</label>
                                <input class="form-control" name="answer_3_B[]" placeholder="Please Enter Answer" required="text"/>

                            </div>
                            <div class="form-group" style="margin-top: 1px;margin-bottom: 5px">
                                <label>Answer C</label>
                                <input class="form-control" name="answer_3_C[]" placeholder="Please Enter Answer" required="text" />

                            </div>
                            <div class="form-group" style="margin-top: 1px;margin-bottom: 5px">
                                <label>Answer D</label>
                                <input class="form-control" name="answer_3_D[]" placeholder="Please Enter Answer" required="text"/>

                            </div>
                            <div class="form-group" style="margin-top: 1px;margin-bottom: 5px">
                                <label>Correct Answer</label>
                                <select class="answerSelect" name="answer6_3[]">
                                    <option value="A" selected>A</option>
                                    <option value="B">B</option>
                                    <option value="C">C</option>
                                    <option value="D" >D</option>
                                </select>

                            </div>

                        </div>
                    </div>


                </div>
                <script>
                    var i4 = 0,j4=1,k4=2;
                    var s4 = 0;
                    var count = 1;
                    $("#addQuestionPart6").click(function () {
                        var d =$("#countPart6").val();
                        count++;
                        s4 = parseInt(d);
                        s4++;
                        $("#add6").append(" <div class=\"col-lg-6 \">\n" +
                            "\n" +
                            "                    <h3 class=\"text-center\" style=\"color: black;margin-top: 10px\" id=\"question_order6\"></h3>\n" +
                            "                    <div class=\"panel-body\" style=\"margin-top: 1px\">\n" +
                            "                        <div class=\"form-group\" style=\"margin-top: 1px;margin-bottom: 5px\">\n" +
                            "                            <label>Image</label>\n" +
                            "                            <input type=\"file\" class=\"form-control\" name=\"images[]\" />\n" +
                            "                            <div type=\"hidden\" class=\"alert-warning\">{{$errors->first('images')}}</div>\n" +
                            "                            <div type=\"hidden\" class=\"alert-warning\">{{$errors->first('images.*')}}</div>\n" +
                            "                        </div>\n" +
                            "                        <div class=\"col-lg-4 \">\n" +
                            "                            <div class=\"form-group\" style=\"margin-top: 1px;margin-bottom: 5px\">\n" +
                            "                                <h6 id=\"question_Part6"+i4+"\" style=\"font-size: initial\"></h6>\n" +
                            "                                <input id=\"questionPart6_1" +i4+"\" name=\"questionNumber_10[]\"  hidden>\n" +
                            "                                <textarea class=\"form-control\" name=\"question_1[]\" placeholder=\"Please Enter question\" required=\"text\" ></textarea>\n" +
                            "\n" +
                            "                            </div>\n" +
                            "                            <div class=\"form-group\" style=\"margin-top: 1px;margin-bottom: 5px\">\n" +
                            "                                <label>Answer A</label>\n" +
                            "                                <input class=\"form-control\" name=\"answer_1_A[]\" placeholder=\"Please Enter Answer\" required=\"text\" />\n" +
                            "\n" +
                            "                            </div>\n" +
                            "                            <div class=\"form-group\" style=\"margin-top: 1px;margin-bottom: 5px\">\n" +
                            "                                <label>Answer B</label>\n" +
                            "                                <input class=\"form-control\" name=\"answer_1_B[]\" placeholder=\"Please Enter Answer\" required=\"text\"/>\n" +
                            "\n" +
                            "                            </div>\n" +
                            "                            <div class=\"form-group\" style=\"margin-top: 1px;margin-bottom: 5px\">\n" +
                            "                                <label>Answer C</label>\n" +
                            "                                <input class=\"form-control\" name=\"answer_1_C[]\" placeholder=\"Please Enter Answer\" required=\"text\"/>\n" +
                            "\n" +
                            "                            </div>\n" +
                            "                            <div class=\"form-group\" style=\"margin-top: 1px;margin-bottom: 5px\">\n" +
                            "                                <label>Answer D</label>\n" +
                            "                                <input class=\"form-control\" name=\"answer_1_D[]\" placeholder=\"Please Enter Answer\"required=\"text\" />\n" +
                            "\n" +
                            "                            </div>\n" +
                            "                            <div class=\"form-group\" style=\"margin-top: 1px;margin-bottom: 5px\">\n" +
                            "                                <label>Correct Answer</label>\n" +
                            "                                <select class=\"answerSelect\" name=\"answer6_1[]\">\n" +
                            "                                    <option value=\"A\" selected>A</option>\n" +
                            "                                    <option value=\"B\">B</option>\n" +
                            "                                    <option value=\"C\">C</option>\n" +
                            "                                    <option value=\"D\" >D</option>\n" +
                            "                                </select>" +
                            "\n" +
                            "                            </div>\n" +
                            "\n" +
                            "                        </div>\n" +
                            "                        <div class=\"col-lg-4 \">\n" +
                            "                            <div class=\"form-group\" style=\"margin-top: 1px;margin-bottom: 5px\">\n" +
                            "                                <h6 id=\"question_Part6"+j4+"\" style=\"font-size: initial\"></h6>\n" +
                            "                                <input id=\"questionPart6_2" +j4+"\" name=\"questionNumber_11[]\" hidden>\n" +
                            "                                <textarea class=\"form-control\" name=\"question_2[]\" placeholder=\"Please Enter question\" required=\"text\"></textarea>\n" +
                            "\n" +
                            "                            </div>\n" +
                            "                            <div class=\"form-group\" style=\"margin-top: 1px;margin-bottom: 5px\">\n" +
                            "                                <label>Answer A</label>\n" +
                            "                                <input class=\"form-control\" name=\"answer_2_A[]\" placeholder=\"Please Enter Answer\"required=\"text\" />\n" +
                            "\n" +
                            "                            </div>\n" +
                            "                            <div class=\"form-group\" style=\"margin-top: 1px;margin-bottom: 5px\">\n" +
                            "                                <label>Answer B</label>\n" +
                            "                                <input class=\"form-control\" name=\"answer_2_B[]\" placeholder=\"Please Enter Answer\" required=\"text\"/>\n" +
                            "\n" +
                            "                            </div>\n" +
                            "                            <div class=\"form-group\" style=\"margin-top: 1px;margin-bottom: 5px\">\n" +
                            "                                <label>Answer C</label>\n" +
                            "                                <input class=\"form-control\" name=\"answer_2_C[]\" placeholder=\"Please Enter Answer\" required=\"text\"/>\n" +
                            "\n" +
                            "                            </div>\n" +
                            "                            <div class=\"form-group\" style=\"margin-top: 1px;margin-bottom: 5px\">\n" +
                            "                                <label>Answer D</label>\n" +
                            "                                <input class=\"form-control\" name=\"answer_2_D[]\" placeholder=\"Please Enter Answer\" required=\"text\"/>\n" +
                            "\n" +
                            "                            </div>\n" +
                            "                            <div class=\"form-group\" style=\"margin-top: 1px;margin-bottom: 5px\">\n" +
                            "                                <label>Correct Answer</label>\n" +
                            "                                <select class=\"answerSelect\" name=\"answer6_2[]\">\n" +
                            "                                    <option value=\"A\" selected>A</option>\n" +
                            "                                    <option value=\"B\">B</option>\n" +
                            "                                    <option value=\"C\">C</option>\n" +
                            "                                    <option value=\"D\" >D</option>\n" +
                            "                                </select>" +
                            "\n" +
                            "                            </div>\n" +
                            "\n" +
                            "                        </div>\n" +
                            "                        <div class=\"col-lg-4 \">\n" +
                            "                            <div class=\"form-group\" style=\"margin-top: 1px;margin-bottom: 5px\">\n" +
                            "                                <h6 id=\"question_Part6"+k4+"\"style=\"font-size: initial\"></h6>\n" +
                            "                                <input id=\"questionPart6_3" +k4+"\"  name=\"questionNumber_12[]\" hidden>\n" +
                            "                                <textarea class=\"form-control\" name=\"question_3[]\" placeholder=\"Please Enter question\" required=\"text\"></textarea>\n" +
                            "\n" +
                            "                            </div>\n" +
                            "                            <div class=\"form-group\" style=\"margin-top: 1px;margin-bottom: 5px\">\n" +
                            "                                <label>Answer A</label>\n" +
                            "                                <input class=\"form-control\" name=\"answer_3_A[]\" placeholder=\"Please Enter Answer\" required=\"text\"/>\n" +
                            "\n" +
                            "                            </div>\n" +
                            "                            <div class=\"form-group\" style=\"margin-top: 1px;margin-bottom: 5px\">\n" +
                            "                                <label>Answer B</label>\n" +
                            "                                <input class=\"form-control\" name=\"answer_3_B[]\" placeholder=\"Please Enter Answer\" required=\"text\"/>\n" +
                            "\n" +
                            "                            </div>\n" +
                            "                            <div class=\"form-group\" style=\"margin-top: 1px;margin-bottom: 5px\">\n" +
                            "                                <label>Answer C</label>\n" +
                            "                                <input class=\"form-control\" name=\"answer_3_C[]\" placeholder=\"Please Enter Answer\" required=\"text\" />\n" +
                            "\n" +
                            "                            </div>\n" +
                            "                            <div class=\"form-group\" style=\"margin-top: 1px;margin-bottom: 5px\">\n" +
                            "                                <label>Answer D</label>\n" +
                            "                                <input class=\"form-control\" name=\"answer_3_D[]\" placeholder=\"Please Enter Answer\" required=\"text\"/>\n" +
                            "\n" +
                            "                            </div>\n" +
                            "                            <div class=\"form-group\" style=\"margin-top: 1px;margin-bottom: 5px\">\n" +
                            "                                <label>Correct Answer</label>\n" +
                            "                                <select class=\"answerSelect\" name=\"answer6_3[]\">\n" +
                            "                                    <option value=\"A\" selected>A</option>\n" +
                            "                                    <option value=\"B\">B</option>\n" +
                            "                                    <option value=\"C\">C</option>\n" +
                            "                                    <option value=\"D\" >D</option>\n" +
                            "                                </select>" +
                            "\n" +
                            "                            </div>\n" +
                            "\n" +
                            "                        </div>\n" +
                            "                    </div>");
                        var d1 = "#question_Part6"+i4;
                        var a1 = "#questionPart6_1"+i4;
                        i4+=4;
                        $(d1).text(s4);
                        $(a1).val(s4);
                        var d2 = "#question_Part6"+j4;
                        var a2 = "#questionPart6_2"+j4;
                        j4+=4;
                        s4++;
                        $(d2).text(s4);
                        $(a2).val(s4);
                        var d3 = "#question_Part6"+k4;
                        var a3 = "#questionPart6_3"+k4;
                        k4+=4;
                        s4++;
                        $(d3).text(s4);
                        $(a3).val(s4);
                        $("#countPart6").val(s4);

                    });
                </script>

            </form>
        </div>
        <div id="part7" class="tab-pane fade">
            <div id="table-part-7" class="hidden">
                <h3 style="text-align: center">List Question</h3>
                <table data-has-data="false" class="table table-striped table-bordered table-hover" id="dataTables-example">
                    <thead>
                    <tr align="center">
                        <th style="text-align: center">Question</th>
                        <th style="text-align: center">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
            <form id="add7" action="{{route('upload.part7')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div>
                    <button type="submit" id="finish" class="btn btn-outline-primary"
                            style="display: block; margin: auto; float: right; font-size: large">Upload <i class="fa fa-upload"></i>
                    </button>
                    <button type="button" id="addQuestionPart7" class="btn btn-outline-primary" style="font-size: large">Add Question
                        <i class="fa fa-plus-square"></i>
                    </button>
                </div>
                <input name="countPart7" id="countPart7" hidden >
                <input name="countTeamPart7" id="countTeamPart7" hidden >
                <input name="countQuestion" id="countQuestion"  hidden>
                <div class="col-lg-6 ">

                    <h3 class="text-center" style="color: black;margin-top: 10px" id="question_order6"></h3>
                    <div class="panel-body" style="margin-top: 1px">
                        <div class="form-group" style="margin-top: 1px;margin-bottom: 5px">
                            <label>Image</label>
                            <input type="file" class="form-control" name="images[]" />
                            <div type="hidden" class="alert-warning">{{$errors->first('images')}}</div>
                            <div type="hidden" class="alert-warning">{{$errors->first('images.*')}}</div>
                        </div>
                        <div class="col-lg-4 ">
                            <div class="form-group" style="margin-top: 1px;margin-bottom: 5px">
                                <h6 id="questionOder13" style="font-size: initial"></h6>
                                <input id="questionOder_13" name="questionNumber_13[]" hidden >
                                <textarea class="form-control" name="question_1[]" placeholder="Please Enter question" required="text" ></textarea>

                            </div>
                            <div class="form-group" style="margin-top: 1px;margin-bottom: 5px">
                                <label>Answer A</label>
                                <input class="form-control" name="answer_1_A[]" placeholder="Please Enter Answer" required="text" />

                            </div>
                            <div class="form-group" style="margin-top: 1px;margin-bottom: 5px">
                                <label>Answer B</label>
                                <input class="form-control" name="answer_1_B[]" placeholder="Please Enter Answer" required="text"/>

                            </div>
                            <div class="form-group" style="margin-top: 1px;margin-bottom: 5px">
                                <label>Answer C</label>
                                <input class="form-control" name="answer_1_C[]" placeholder="Please Enter Answer" required="text"/>

                            </div>
                            <div class="form-group" style="margin-top: 1px;margin-bottom: 5px">
                                <label>Answer D</label>
                                <input class="form-control" name="answer_1_D[]" placeholder="Please Enter Answer"required="text" />

                            </div>
                            <div class="form-group" style="margin-top: 1px;margin-bottom: 5px">
                                <label>Correct Answer</label>
                                <select class="answerSelect" name="answer7_1[]">
                                    <option value="A" selected>A</option>
                                    <option value="B">B</option>
                                    <option value="C">C</option>
                                    <option value="D" >D</option>
                                </select>

                            </div>

                        </div>
                        <div class="col-lg-4 ">
                            <div class="form-group" style="margin-top: 1px;margin-bottom: 5px">
                                <h6 id="questionOder14" style="font-size: initial"></h6>
                                <input id="questionOder_14" name="questionNumber_14[]"  hidden>
                                <textarea class="form-control" name="question_2[]" placeholder="Please Enter question" required="text"></textarea>

                            </div>
                            <div class="form-group" style="margin-top: 1px;margin-bottom: 5px">
                                <label>Answer A</label>
                                <input class="form-control" name="answer_2_A[]" placeholder="Please Enter Answer"required="text" />

                            </div>
                            <div class="form-group" style="margin-top: 1px;margin-bottom: 5px">
                                <label>Answer B</label>
                                <input class="form-control" name="answer_2_B[]" placeholder="Please Enter Answer" required="text"/>

                            </div>
                            <div class="form-group" style="margin-top: 1px;margin-bottom: 5px">
                                <label>Answer C</label>
                                <input class="form-control" name="answer_2_C[]" placeholder="Please Enter Answer" required="text"/>

                            </div>
                            <div class="form-group" style="margin-top: 1px;margin-bottom: 5px">
                                <label>Answer D</label>
                                <input class="form-control" name="answer_2_D[]" placeholder="Please Enter Answer" required="text"/>

                            </div>
                            <div class="form-group" style="margin-top: 1px;margin-bottom: 5px">
                                <label>Correct Answer</label>
                                <select class="answerSelect" name="answer7_2[]">
                                    <option value="A" selected>A</option>
                                    <option value="B">B</option>
                                    <option value="C">C</option>
                                    <option value="D" >D</option>
                                </select>

                            </div>

                        </div>
                        <div class="col-lg-4 ">
                            <div class="form-group" style="margin-top: 1px;margin-bottom: 5px">
                                <h6 id="questionOder15" style="font-size: initial"></h6>
                                <input id="questionOder_15" name="questionNumber_15[]" hidden>
                                <textarea class="form-control" name="question_3[]" placeholder="Please Enter question" ></textarea>

                            </div>
                            <div class="form-group" style="margin-top: 1px;margin-bottom: 5px">
                                <label>Answer A</label>
                                <input class="form-control" name="answer_3_A[]" placeholder="Please Enter Answer" />

                            </div>
                            <div class="form-group" style="margin-top: 1px;margin-bottom: 5px">
                                <label>Answer B</label>
                                <input class="form-control" name="answer_3_B[]" placeholder="Please Enter Answer" />

                            </div>
                            <div class="form-group" style="margin-top: 1px;margin-bottom: 5px">
                                <label>Answer C</label>
                                <input class="form-control" name="answer_3_C[]" placeholder="Please Enter Answer"  />

                            </div>
                            <div class="form-group" style="margin-top: 1px;margin-bottom: 5px">
                                <label>Answer D</label>
                                <input class="form-control" name="answer_3_D[]" placeholder="Please Enter Answer" />

                            </div>
                            <div class="form-group" style="margin-top: 1px;margin-bottom: 5px">
                                <label>Correct Answer</label>
                                <select class="answerSelect" name="answer7_3[]">
                                    <option value="A" selected>A</option>
                                    <option value="B">B</option>
                                    <option value="C">C</option>
                                    <option value="D" >D</option>
                                </select>

                            </div>

                        </div>
                    </div>


                </div>
                <script>
                    var i5 = 0,j5=1,k5=2;
                    var s5 = 0;
                    var count = 1;
                    $("#addQuestionPart7").click(function () {
                        var d =$("#countPart7").val();
                        count++;
                        s5 = parseInt(d);
                        s5++;
                        $("#add7").append(" <div class=\"col-lg-6 \">\n" +
                            "\n" +
                            "                    <h3 class=\"text-center\" style=\"color: black;margin-top: 10px\" id=\"question_order6\"></h3>\n" +
                            "                    <div class=\"panel-body\" style=\"margin-top: 1px\">\n" +
                            "                        <div class=\"form-group\" style=\"margin-top: 1px;margin-bottom: 5px\">\n" +
                            "                            <label>Image</label>\n" +
                            "                            <input type=\"file\" class=\"form-control\" name=\"images[]\" />\n" +
                            "                            <div type=\"hidden\" class=\"alert-warning\">{{$errors->first('images')}}</div>\n" +
                            "                            <div type=\"hidden\" class=\"alert-warning\">{{$errors->first('images.*')}}</div>\n" +
                            "                        </div>\n" +
                            "                        <div class=\"col-lg-4 \">\n" +
                            "                            <div class=\"form-group\" style=\"margin-top: 1px;margin-bottom: 5px\">\n" +
                            "                                <h6 id=\"question_Part7"+i5+"\" style=\"font-size: initial\"></h6>\n" +
                            "                                <input id=\"questionPart7_1" +i5+"\" name=\"questionNumber_13[]\" hidden >\n" +
                            "                                <textarea class=\"form-control\" name=\"question_1[]\" placeholder=\"Please Enter question\" required=\"text\" ></textarea>\n" +
                            "\n" +
                            "                            </div>\n" +
                            "                            <div class=\"form-group\" style=\"margin-top: 1px;margin-bottom: 5px\">\n" +
                            "                                <label>Answer A</label>\n" +
                            "                                <input class=\"form-control\" name=\"answer_1_A[]\" placeholder=\"Please Enter Answer\" required=\"text\" />\n" +
                            "\n" +
                            "                            </div>\n" +
                            "                            <div class=\"form-group\" style=\"margin-top: 1px;margin-bottom: 5px\">\n" +
                            "                                <label>Answer B</label>\n" +
                            "                                <input class=\"form-control\" name=\"answer_1_B[]\" placeholder=\"Please Enter Answer\" required=\"text\"/>\n" +
                            "\n" +
                            "                            </div>\n" +
                            "                            <div class=\"form-group\" style=\"margin-top: 1px;margin-bottom: 5px\">\n" +
                            "                                <label>Answer C</label>\n" +
                            "                                <input class=\"form-control\" name=\"answer_1_C[]\" placeholder=\"Please Enter Answer\" required=\"text\"/>\n" +
                            "\n" +
                            "                            </div>\n" +
                            "                            <div class=\"form-group\" style=\"margin-top: 1px;margin-bottom: 5px\">\n" +
                            "                                <label>Answer D</label>\n" +
                            "                                <input class=\"form-control\" name=\"answer_1_D[]\" placeholder=\"Please Enter Answer\"required=\"text\" />\n" +
                            "\n" +
                            "                            </div>\n" +
                            "                            <div class=\"form-group\" style=\"margin-top: 1px;margin-bottom: 5px\">\n" +
                            "                                <label>Correct Answer</label>\n" +
                            "                                <select class=\"answerSelect\" name=\"answer7_1[]\">\n" +
                            "                                    <option value=\"A\" selected>A</option>\n" +
                            "                                    <option value=\"B\">B</option>\n" +
                            "                                    <option value=\"C\">C</option>\n" +
                            "                                    <option value=\"D\" >D</option>\n" +
                            "                                </select>\n" +
                            "\n" +
                            "                            </div>\n" +
                            "\n" +
                            "                        </div>\n" +
                            "                        <div class=\"col-lg-4 \">\n" +
                            "                            <div class=\"form-group\" style=\"margin-top: 1px;margin-bottom: 5px\">\n" +
                            "                                <h6 id=\"question_Part7"+j5+"\" style=\"font-size: initial\"></h6>\n" +
                            "                                <input id=\"questionPart7_2" +j5+"\" name=\"questionNumber_14[]\" hidden>\n" +
                            "                                <textarea class=\"form-control\" name=\"question_2[]\" placeholder=\"Please Enter question\" required=\"text\"></textarea>\n" +
                            "\n" +
                            "                            </div>\n" +
                            "                            <div class=\"form-group\" style=\"margin-top: 1px;margin-bottom: 5px\">\n" +
                            "                                <label>Answer A</label>\n" +
                            "                                <input class=\"form-control\" name=\"answer_2_A[]\" placeholder=\"Please Enter Answer\"required=\"text\" />\n" +
                            "\n" +
                            "                            </div>\n" +
                            "                            <div class=\"form-group\" style=\"margin-top: 1px;margin-bottom: 5px\">\n" +
                            "                                <label>Answer B</label>\n" +
                            "                                <input class=\"form-control\" name=\"answer_2_B[]\" placeholder=\"Please Enter Answer\" required=\"text\"/>\n" +
                            "\n" +
                            "                            </div>\n" +
                            "                            <div class=\"form-group\" style=\"margin-top: 1px;margin-bottom: 5px\">\n" +
                            "                                <label>Answer C</label>\n" +
                            "                                <input class=\"form-control\" name=\"answer_2_C[]\" placeholder=\"Please Enter Answer\" required=\"text\"/>\n" +
                            "\n" +
                            "                            </div>\n" +
                            "                            <div class=\"form-group\" style=\"margin-top: 1px;margin-bottom: 5px\">\n" +
                            "                                <label>Answer D</label>\n" +
                            "                                <input class=\"form-control\" name=\"answer_2_D[]\" placeholder=\"Please Enter Answer\" required=\"text\"/>\n" +
                            "\n" +
                            "                            </div>\n" +
                            "                            <div class=\"form-group\" style=\"margin-top: 1px;margin-bottom: 5px\">\n" +
                            "                                <label>Correct Answer</label>\n" +
                            "                                <select class=\"answerSelect\" name=\"answer7_2[]\">\n" +
                            "                                    <option value=\"A\" selected>A</option>\n" +
                            "                                    <option value=\"B\">B</option>\n" +
                            "                                    <option value=\"C\">C</option>\n" +
                            "                                    <option value=\"D\" >D</option>\n" +
                            "                                </select>\n" +
                            "\n" +
                            "                            </div>\n" +
                            "\n" +
                            "                        </div>\n" +
                            "                        <div class=\"col-lg-4 \">\n" +
                            "                            <div class=\"form-group\" style=\"margin-top: 1px;margin-bottom: 5px\">\n" +
                            "                                <h6 id=\"question_Part7"+k5+"\"style=\"font-size: initial\"></h6>\n" +
                            "                                <input id=\"questionPart7_3" +k5+"\"  name=\"questionNumber_15[]\" hidden>\n" +
                            "                                <textarea class=\"form-control\" name=\"question_3[]\" placeholder=\"Please Enter question\" required=\"text\"></textarea>\n" +
                            "\n" +
                            "                            </div>\n" +
                            "                            <div class=\"form-group\" style=\"margin-top: 1px;margin-bottom: 5px\">\n" +
                            "                                <label>Answer A</label>\n" +
                            "                                <input class=\"form-control\" name=\"answer_3_A[]\" placeholder=\"Please Enter Answer\" required=\"text\"/>\n" +
                            "\n" +
                            "                            </div>\n" +
                            "                            <div class=\"form-group\" style=\"margin-top: 1px;margin-bottom: 5px\">\n" +
                            "                                <label>Answer B</label>\n" +
                            "                                <input class=\"form-control\" name=\"answer_3_B[]\" placeholder=\"Please Enter Answer\" required=\"text\"/>\n" +
                            "\n" +
                            "                            </div>\n" +
                            "                            <div class=\"form-group\" style=\"margin-top: 1px;margin-bottom: 5px\">\n" +
                            "                                <label>Answer C</label>\n" +
                            "                                <input class=\"form-control\" name=\"answer_3_C[]\" placeholder=\"Please Enter Answer\" required=\"text\" />\n" +
                            "\n" +
                            "                            </div>\n" +
                            "                            <div class=\"form-group\" style=\"margin-top: 1px;margin-bottom: 5px\">\n" +
                            "                                <label>Answer D</label>\n" +
                            "                                <input class=\"form-control\" name=\"answer_3_D[]\" placeholder=\"Please Enter Answer\" required=\"text\"/>\n" +
                            "\n" +
                            "                            </div>\n" +
                            "                            <div class=\"form-group\" style=\"margin-top: 1px;margin-bottom: 5px\">\n" +
                            "                                <label>Correct Answer</label>\n" +
                            "                                <select class=\"answerSelect\" name=\"answer7_3[]\">\n" +
                            "                                    <option value=\"A\" selected>A</option>\n" +
                            "                                    <option value=\"B\">B</option>\n" +
                            "                                    <option value=\"C\">C</option>\n" +
                            "                                    <option value=\"D\" >D</option>\n" +
                            "                                </select>\n" +
                            "\n" +
                            "                            </div>\n" +
                            "\n" +
                            "                        </div>\n" +
                            "                    </div>");
                        var d1 = "#question_Part7"+i5;
                        var a1 = "#questionPart7_1"+i5;
                        i5+=4;
                        $(d1).text(s5);
                        $(a1).val(s5);
                        var d2 = "#question_Part7"+j5;
                        var a2 = "#questionPart7_2"+j5;
                        j5+=4;
                        s5++;
                        $(d2).text(s5);
                        $(a2).val(s5);
                        var d3 = "#question_Part7"+k5;
                        var a3 = "#questionPart7_3"+k5;
                        k5+=4;
                        s5++;
                        $(d3).text(s5);
                        $(a3).val(s5);
                        $("#countPart7").val(s5);

                    });
                </script>

            </form>
        </div>
    </div>

</div>
    <form action="{{route('updateQuestion')}}" method="post" enctype="multipart/form-data">
        @csrf

        <div class="modal fade" id="editQuestion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false" style="display: none;"data-backdrop="false">
            <div class="modal-dialog">
                <div class="loginmodal-container">
                    <div class="row">
                        <div class="col-md-12 col-md-offset-3">
                            <div class="panel panel-default" style="border: 3px solid #f1f1f1">
                                <div class="panel-body">
                                    <div class="text">
                                        <h2 class="text-center" style="color: black">Edit Question
                                            <button type="button" class="close" data-dismiss="modal">X</button>
                                        </h2>
                                        <div class="panel-body">
                                            <div class="col-lg-12-12 " id="question">
                                                <h3 class="text-center" style="color: black;margin-top: 10px" id="question_order"></h3>
                                                <div class="panel-body" style="margin-top: 1px">
                                                    <div class="form-group" style="margin-top: 1px;margin-bottom: 5px" id="formMp3">
                                                        <label>MP3</label>
                                                        <input id="partId" name="partId" hidden>
                                                        <input id="questionId" name="questionId" hidden >
                                                        <input id="questionNumber" name="questionNumber" hidden>
                                                        <input class="form-control"  id="mp3Edit" name="mp3Edit1" readonly />
                                                        <input type="file" id="inputMp3"  class="form-control"  name="mp3"/>
                                                    </div>
                                                    <div class="form-group" style="margin-top: 1px;margin-bottom: 5px" id="formImage">
                                                        <label>Image</label>
                                                        <input class="form-control" id="imagesEdit"  name="imagesEdit1" readonly />
                                                        <input type="file"  id="inputImage" class="form-control" name="images" />
                                                    </div>

                                                    <div class="form-group" style="margin-top: 15px;margin-bottom: 5px" >
                                                        <div style="width: 100%" class="checkbox-group">
                                                            <label style="margin-right: 10px;">Correct Answer </label>
                                                            {{--<label class="checkbox-inline" style="margin-left: 40px">--}}
                                                                {{--<input type="checkbox" id="A1"  class="checkbox" value="A"  name="answer1" style="margin-top: -3px"  required/>&#160;&#160;A</label>--}}
                                                            {{--<label class="checkbox-inline" style="margin-left: 40px" >--}}
                                                                {{--<input type="checkbox" id="B1"  class="checkbox" value="B"  name="answer1" style="margin-top: -3px" required />&#160;&#160;B</label>--}}
                                                            {{--<label class="checkbox-inline" style="margin-left: 40px">--}}
                                                                {{--<input type="checkbox"  id="C1" class="checkbox" value="C"  name="answer1" style="margin-top: -3px" required/>&#160;&#160;C</label>--}}
                                                            {{--<label class="checkbox-inline" style="margin-left: 40px">--}}
                                                                {{--<input type="checkbox"  id="D1" class="checkbox" value="D"   name="answer1" style="margin-top: -3px "required />&#160;&#160;D</label>--}}
                                                            <div class="answer1">
                                                            <select class="answerSelect" name="answer1">
                                                                <option value="A" >A</option>
                                                                <option value="B">B</option>
                                                                <option value="C">C</option>
                                                                <option value="D">D</option>
                                                            </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <button type="submit" class="btn btn-success" style="display: block; margin: auto;">Update</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
            $(function(){
                    var requiredCheckboxes = $('.checkbox-group :checkbox[required]');
                requiredCheckboxes.change(function(){
                    if(requiredCheckboxes.is(':checked')) {
                        requiredCheckboxes.removeAttr('required');
                    } else {
                        requiredCheckboxes.attr('required', 'required');
                    }
                });
            });
            $("input:checkbox").on('click', function() {
                // in the handler, 'this' refers to the box clicked on
                var $box = $(this);
                if ($box.is(":checked")) {
                    var group = "input:checkbox[name='" + $box.attr("name") + "']";
                    $(group).prop("checked", false);
                    $box.prop("checked", true);
                } else {
                    $box.prop("checked", false);
                }
            });
        </script>
    </form>
    <form action="{{route('updateQuestionPart2')}}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="modal fade" id="editQuestionPart2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false" style="display: none; "data-backdrop="false">
        <div class="modal-dialog">
            <div class="loginmodal-container">
                <div class="row">
                    <div class="col-md-12 col-md-offset-3">
                        <div class="panel panel-default" style="border: 3px solid #f1f1f1">
                            <div class="panel-body">
                                <div class="text">
                                    <h2 class="text-center" style="color: black">Edit Question
                                        <button type="button" class="close" data-dismiss="modal">X</button>
                                    </h2>
                                    <div class="panel-body">
                                        <div class="col-lg-12-12 " id="question">
                                            <h3 class="text-center" style="color: black;margin-top: 10px" id="question_order"></h3>
                                            <div class="panel-body" style="margin-top: 1px">
                                                <div class="form-group" style="margin-top: 1px;margin-bottom: 5px" id="formMp3">
                                                    <label>MP3</label>
                                                    <input id="partId2" name="partId" hidden>
                                                    <input id="teamPart2" name="teamPart2" hidden >
                                                    <input id="questionId2" name="questionId" hidden >
                                                    <input id="questionNumber2" name="questionNumber" hidden >
                                                    <input type="text" id="mp3Edit2" class="form-control" name="mp3Edit2" readonly/>
                                                    <input type="file" id="inputMp3"  class="form-control"  name="mp3"/>
                                                </div>
                                                <div class="form-group" style="margin-top: 15px;margin-bottom: 5px" >
                                                    <div style="width: 100%" class="checkbox-group">
                                                        <label style="margin-right: 10px;">Correct Answer </label>
                                                        <div class="answer2">
                                                            <select class="answerSelect" name="answer2">
                                                                <option value="A" >A</option>
                                                                <option value="B">B</option>
                                                                <option value="C">C</option>
                                                                <option value="D">D</option>
                                                            </select>
                                                        </div>

                                                    </div>
                                                </div>
                                                <button type="submit" class="btn btn-success" style="display: block; margin: auto;">Update</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
        <script>
            $(function(){
                var requiredCheckboxes = $('.checkbox-group :checkbox[required]');
                requiredCheckboxes.change(function(){
                    if(requiredCheckboxes.is(':checked')) {
                        requiredCheckboxes.removeAttr('required');
                    } else {
                        requiredCheckboxes.attr('required', 'required');
                    }
                });
            });
            $("input:checkbox").on('click', function() {
                // in the handler, 'this' refers to the box clicked on
                var $box = $(this);
                if ($box.is(":checked")) {
                    var group = "input:checkbox[name='" + $box.attr("name") + "']";
                    $(group).prop("checked", false);
                    $box.prop("checked", true);
                } else {
                    $box.prop("checked", false);
                }
            });
        </script>
</form>
    <form action="{{route('updateQuestionPart3')}}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="modal fade" id="editQuestionPart3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false" style="display: none; "data-backdrop="false">
            <div class="modal-dialog">
                <div class="loginmodal-container">
                    <div class="row">
                        <div class="col-md-12 col-md-offset-3">
                            <div class="panel panel-default" style="border: 3px solid #f1f1f1">
                                <div class="panel-body">
                                    <div class="text">
                                        <h2 class="text-center" style="color: black">Edit Question
                                            <button type="button" class="close" data-dismiss="modal">X</button>
                                        </h2>
                                        <div class="panel-body">
                                            <div class="col-lg-12-12 " id="question">
                                                <h3 class="text-center" style="color: black;margin-top: 10px" id="question_order"></h3>
                                                <div class="panel-body" style="margin-top: 1px">
                                                    <div class="form-group" style="margin-top: 1px;margin-bottom: 5px" id="formMp3">
                                                        <label>MP3</label>
                                                        <input id="partId3" name="partId3" hidden>
                                                        <input id="teamPart3" name="teamPart3" hidden>
                                                        <input id="questionId3" name="questionId3" hidden >
                                                        <input id="questionNumber3" name="questionNumber3" hidden>
                                                        <input type="text" id="mp3Edit3" class="form-control" name="mp3Edit3" readonly/>
                                                        <input type="file" id="inputMp3"  class="form-control"  name="mp3"/>
                                                    </div>
                                                    <div class="form-group" style="margin-top: 1px;margin-bottom: 5px">
                                                        <label>Question name </label>
                                                        <textarea class="form-control" id="questionName3" name="questionName"
                                                                  placeholder="Please Enter Question Name"></textarea>
                                                    </div>
                                                    <div class="form-group" style="margin-top: 1px;margin-bottom: 5px">
                                                        <label>Answer A</label>
                                                        <input class="form-control" id="answerA3" name="answerA"
                                                               placeholder="Please Enter Answer"/>
                                                    </div>
                                                    <div class="form-group" style="margin-top: 1px;margin-bottom: 5px">
                                                        <label>Answer B</label>
                                                        <input class="form-control" id="answerB3" name="answerB"
                                                               placeholder="Please Enter Answer"/>
                                                    </div>
                                                    <div class="form-group" style="margin-top: 1px;margin-bottom: 5px">
                                                        <label>Answer C</label>
                                                        <input class="form-control" id="answerC3" name="answerC"
                                                               placeholder="Please Enter Answer"/>
                                                    </div>
                                                    <div class="form-group" style="margin-top: 1px;margin-bottom: 5px">
                                                        <label>Answer D</label>
                                                        <input class="form-control" id="answerD3" name="answerD"
                                                               placeholder="Please Enter Answer"/>
                                                    </div>
                                                    <div class="form-group" style="margin-top: 15px;margin-bottom: 5px" >
                                                        <div style="width: 100%" class="checkbox-group">
                                                            <label style="margin-right: 10px;">Correct Answer </label>
                                                            <div class="answer3">
                                                                <select class="answerSelect" name="answer3">
                                                                    <option value="A" >A</option>
                                                                    <option value="B">B</option>
                                                                    <option value="C">C</option>
                                                                    <option value="D">D</option>
                                                                </select>
                                                            </div>

                                                        </div>
                                                    </div>
                                                    <button type="submit" class="btn btn-success" style="display: block; margin: auto;">Update</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <form action="{{route('updateQuestionPart4')}}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="modal fade" id="editQuestionPart4" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false" style="display: none; "data-backdrop="false">
            <div class="modal-dialog">
                <div class="loginmodal-container">
                    <div class="row">
                        <div class="col-md-12 col-md-offset-3">
                            <div class="panel panel-default" style="border: 3px solid #f1f1f1">
                                <div class="panel-body">
                                    <div class="text">
                                        <h2 class="text-center" style="color: black">Edit Question
                                            <button type="button" class="close" data-dismiss="modal">X</button>
                                        </h2>
                                        <div class="panel-body">
                                            <div class="col-lg-12-12 " id="question">
                                                <h3 class="text-center" style="color: black;margin-top: 10px" id="question_order"></h3>
                                                <div class="panel-body" style="margin-top: 1px">
                                                    <div class="form-group" style="margin-top: 1px;margin-bottom: 5px" id="formMp3">
                                                        <label>MP3</label>
                                                        <input id="partId4" name="partId4" hidden>
                                                        <input id="questionId4" name="questionId4" hidden >
                                                        <input id="teamPart4" name="teamPart4" hidden>
                                                        <input id="questionNumber4" name="questionNumber4" hidden>
                                                        <input type="text" id="mp3Edit4" class="form-control" name="mp3Edit4" readonly/>
                                                        <input type="file" id="inputMp3"  class="form-control"  name="mp3"/>
                                                    </div>
                                                    <div class="form-group" style="margin-top: 1px;margin-bottom: 5px">
                                                        <label>Question name </label>
                                                        <textarea class="form-control" id="questionName4" name="questionName"
                                                                  placeholder="Please Enter Question Name"></textarea>
                                                    </div>
                                                    <div class="form-group" style="margin-top: 1px;margin-bottom: 5px">
                                                        <label>Answer A</label>
                                                        <textarea class="form-control" id="answerA4" name="answerA"
                                                                  placeholder="Please Enter Answer"></textarea>
                                                    </div>
                                                    <div class="form-group" style="margin-top: 1px;margin-bottom: 5px">
                                                        <label>Answer B</label>
                                                        <textarea class="form-control" id="answerB4" name="answerB"
                                                                  placeholder="Please Enter Answer"></textarea>
                                                    </div>
                                                    <div class="form-group" style="margin-top: 1px;margin-bottom: 5px">
                                                        <label>Answer C</label>
                                                        <textarea class="form-control" id="answerC4" name="answerC"
                                                                  placeholder="Please Enter Answer"></textarea>
                                                    </div>
                                                    <div class="form-group" style="margin-top: 1px;margin-bottom: 5px">
                                                        <label>Answer D</label>
                                                        <textarea class="form-control" id="answerD4" name="answerD"
                                                                  placeholder="Please Enter Answer"></textarea>
                                                    </div>
                                                    <div class="form-group" style="margin-top: 1px;margin-bottom: 5px">
                                                        <label>Correct Answer </label>
                                                        <div class="answer4">
                                                            <select class="answerSelect" name="answer4">
                                                                <option value="A" >A</option>
                                                                <option value="B">B</option>
                                                                <option value="C">C</option>
                                                                <option value="D">D</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <button type="submit" class="btn btn-success" style="display: block; margin: auto;">Update</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <form action="{{route('updateQuestionPart5')}}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="modal fade" id="editQuestionPart5" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false" style="display: none; "data-backdrop="false">
            <div class="modal-dialog">
                <div class="loginmodal-container">
                    <div class="row">
                        <div class="col-md-12 col-md-offset-3">
                            <div class="panel panel-default" style="border: 3px solid #f1f1f1">
                                <div class="panel-body">
                                    <div class="text">
                                        <h2 class="text-center" style="color: black">Edit Question
                                            <button type="button" class="close" data-dismiss="modal">X</button>
                                        </h2>
                                        <div class="panel-body">
                                            <div class="col-lg-12-12 " id="question">
                                                <h3 class="text-center" style="color: black;margin-top: 10px" id="question_order"></h3>
                                                <div class="panel-body" style="margin-top: 1px">
                                                    <div class="form-group" style="margin-top: 1px;margin-bottom: 5px">
                                                        <label>Question Name </label>
                                                        <input id="partId5" name="partId5" hidden>
                                                        <input id="questionId5" name="questionId5" hidden >
                                                        <input id="questionNumber5" name="questionNumber5" hidden>
                                                        <textarea class="form-control" id="questionName5" name="questionName"
                                                                  placeholder="Please Enter Question Name"></textarea>
                                                    </div>
                                                    <div class="form-group" style="margin-top: 1px;margin-bottom: 5px">
                                                        <label>Answer A</label>
                                                        <input class="form-control" id="answerA5" name="answerA"
                                                               placeholder="Please Enter Answer"/>
                                                    </div>
                                                    <div class="form-group" style="margin-top: 1px;margin-bottom: 5px">
                                                        <label>Answer B</label>
                                                        <input class="form-control" id="answerB5" name="answerB"
                                                               placeholder="Please Enter Answer"/>
                                                    </div>
                                                    <div class="form-group" style="margin-top: 1px;margin-bottom: 5px">
                                                        <label>Answer C</label>
                                                        <input class="form-control" id="answerC5" name="answerC"
                                                               placeholder="Please Enter Answer"/>
                                                    </div>
                                                    <div class="form-group" style="margin-top: 1px;margin-bottom: 5px">
                                                        <label>Answer D</label>
                                                        <input class="form-control" id="answerD5" name="answerD"
                                                               placeholder="Please Enter Answer"/>
                                                    </div>
                                                    <div class="form-group" style="margin-top: 1px;margin-bottom: 5px">
                                                        <label>Correct Answer </label>
                                                        <div class="answer5">
                                                            <select class="answerSelect" name="answer5">
                                                                <option value="A" >A</option>
                                                                <option value="B">B</option>
                                                                <option value="C">C</option>
                                                                <option value="D">D</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <button type="submit" class="btn btn-success" style="display: block; margin: auto;">Update</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <form action="{{route('updateQuestionPart6')}}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="modal fade" id="editQuestionPart6" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false" style="display: none; "data-backdrop="false">
            <div class="modal-dialog">
                <div class="loginmodal-container">
                    <div class="row">
                        <div class="col-md-12 col-md-offset-3">
                            <div class="panel panel-default" style="border: 3px solid #f1f1f1">
                                <div class="panel-body">
                                    <div class="text">
                                        <h2 class="text-center" style="color: black">Edit Question
                                            <button type="button" class="close" data-dismiss="modal">X</button>
                                        </h2>
                                        <div class="panel-body">
                                            <div class="col-lg-12-12 " id="question">
                                                <h3 class="text-center" style="color: black;margin-top: 10px" id="question_order"></h3>
                                                <div class="panel-body" style="margin-top: 1px">
                                                    <div class="form-group" style="margin-top: 1px;margin-bottom: 5px" id="formMp3">
                                                        <label>Image</label>
                                                        <input id="partId6" name="partId6" hidden>
                                                        <input id="questionId6" name="questionId6" hidden >
                                                        <input id="teamPart6" name="teamPart6" hidden>
                                                        <input id="questionNumber6" name="questionNumber6" hidden>
                                                        <input type="text" id="imageEdit6" class="form-control" name="imageEdit6" readonly/>
                                                        <input type="file" id="inputImage"  class="form-control"  name="images"/>
                                                    </div>
                                                    <div class="form-group" style="margin-top: 1px;margin-bottom: 5px">
                                                        <label>Question Name </label>
                                                        <textarea class="form-control" id="questionName6" name="questionName"
                                                                  placeholder="Please Enter Question Name"></textarea>
                                                    </div>
                                                    <div class="form-group" style="margin-top: 1px;margin-bottom: 5px">
                                                        <label>Answer A</label>
                                                        <input class="form-control" id="answerA6" name="answerA"
                                                               placeholder="Please Enter Answer"/>
                                                    </div>
                                                    <div class="form-group" style="margin-top: 1px;margin-bottom: 5px">
                                                        <label>Answer B</label>
                                                        <input class="form-control" id="answerB6" name="answerB"
                                                               placeholder="Please Enter Answer"/>
                                                    </div>
                                                    <div class="form-group" style="margin-top: 1px;margin-bottom: 5px">
                                                        <label>Answer C</label>
                                                        <input class="form-control" id="answerC6" name="answerC"
                                                               placeholder="Please Enter Answer"/>
                                                    </div>
                                                    <div class="form-group" style="margin-top: 1px;margin-bottom: 5px">
                                                        <label>Answer D</label>
                                                        <input class="form-control" id="answerD6" name="answerD"
                                                               placeholder="Please Enter Answer"/>
                                                    </div>
                                                    <div class="form-group" style="margin-top: 1px;margin-bottom: 5px">
                                                        <label>Correct Answer </label>
                                                        <div class="answer6">
                                                            <select class="answerSelect" name="answer6">
                                                                <option value="A" >A</option>
                                                                <option value="B">B</option>
                                                                <option value="C">C</option>
                                                                <option value="D">D</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <button type="submit" class="btn btn-success" style="display: block; margin: auto;">Update</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <form action="{{route('updateQuestionPart7')}}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="modal fade" id="editQuestionPart7" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false" style="display: none; "data-backdrop="false">
            <div class="modal-dialog">
                <div class="loginmodal-container">
                    <div class="row">
                        <div class="col-md-12 col-md-offset-3">
                            <div class="panel panel-default" style="border: 3px solid #f1f1f1">
                                <div class="panel-body">
                                    <div class="text">
                                        <h2 class="text-center" style="color: black">Edit Question
                                            <button type="button" class="close" data-dismiss="modal">X</button>
                                        </h2>
                                        <div class="panel-body">
                                            <div class="col-lg-12-12 " id="question">
                                                <h3 class="text-center" style="color: black;margin-top: 10px" id="question_order"></h3>
                                                <div class="panel-body" style="margin-top: 1px">
                                                    <div class="form-group" style="margin-top: 1px;margin-bottom: 5px" id="formMp3">
                                                        <label>Image</label>
                                                        <input id="partId7" name="partId7" hidden>
                                                        <input id="questionId7" name="questionId7" hidden >
                                                        <input id="questionNumber7" name="questionNumber7"  hidden>
                                                        <input id="teamPart7" name="teamPart7" hidden>
                                                        <input type="text" id="imageEdit7" class="form-control" name="imageEdit7" readonly/>
                                                        <input type="file" id="inputImage"  class="form-control"  name="images"/>
                                                    </div>
                                                    <div class="form-group" style="margin-top: 1px;margin-bottom: 5px">
                                                        <label>Question Name </label>
                                                        <textarea class="form-control" id="questionName7" name="questionName"
                                                                  placeholder="Please Enter Question Name"></textarea>
                                                    </div>
                                                    <div class="form-group" style="margin-top: 1px;margin-bottom: 5px">
                                                        <label>Answer A</label>
                                                        <input class="form-control" id="answerA7" name="answerA"
                                                               placeholder="Please Enter Answer"/>
                                                    </div>
                                                    <div class="form-group" style="margin-top: 1px;margin-bottom: 5px">
                                                        <label>Answer B</label>
                                                        <input class="form-control" id="answerB7" name="answerB"
                                                               placeholder="Please Enter Answer"/>
                                                    </div>
                                                    <div class="form-group" style="margin-top: 1px;margin-bottom: 5px">
                                                        <label>Answer C</label>
                                                        <input class="form-control" id="answerC7" name="answerC"
                                                               placeholder="Please Enter Answer"/>
                                                    </div>
                                                    <div class="form-group" style="margin-top: 1px;margin-bottom: 5px">
                                                        <label>Answer D</label>
                                                        <input class="form-control" id="answerD7" name="answerD"
                                                               placeholder="Please Enter Answer"/>
                                                    </div>
                                                    <div class="form-group" style="margin-top: 1px;margin-bottom: 5px">
                                                        <label>Correct Answer </label>
                                                        <div class="answer7">
                                                            <select class="answerSelect" name="answer7">
                                                                <option value="A" >A</option>
                                                                <option value="B">B</option>
                                                                <option value="C">C</option>
                                                                <option value="D">D</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <button type="submit" class="btn btn-success" style="display: block; margin: auto;">Update</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <script>

        //Default load part 1
        $( document ).ready(function() {

            getQuestionsByPart(1);
            getQuestionsByPart(2);
            getQuestionsByPart(3);
            getQuestionsByPart(4);
            getQuestionsByPart(5);
            getQuestionsByPart(6);
            getQuestionsByPart(7);

            $('input[type="file"]').change(function(e){
                var fileName = e.target.files[0].name;
                if(fileName.includes(".mp3")){
                    $('#mp3Edit').val(fileName);
                }else{
                    $('#imagesEdit').val(fileName);
                }



            });
        });

        $(document).ready(function(){
            var partId = $('a.part').attr('id');
            console.log('Get questions by part ' + partId);
            var tablePart1 = $('#part' + partId).find('table');
            console.log('Has data: ' + tablePart1.attr('data-has-data'));
            if (tablePart1.attr('data-has-data') === 'false') {
                console.log('No data');
                getQuestionsByPart(partId)
            }
            getQuestionsByPart(partId)
        });


        function getQuestionsByPart(partId) {

            console.log('Get questions by part ' + partId);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            $.ajax({
                method: 'GET',
                dataType: 'json',
                url: '{!! url('/getQuestionsByPart')!!}' + '/' + partId,
                success: function (data) {

                    console.log('Questions Part ' + partId + ': ' + data);
                    var tablePart1 = $('#part' + partId).find('table');
                    // var editQuestion=$('#modal').find('');
                    tablePart1.attr('data-has-data', true);
                    var trData = '';
                    if(partId == 1) {

                        var i = 0;
                        if (data.length > 0) {
                            for (i = 0; i < data.length; i++) {
                                trData += '<tr class="odd gradeX" align="center">\n' +
                                    '                        <td>' + data[i]['questionNumber'] + '</td>\n' +
                                    '                        <td class="center">\n' +
                                    '                            <a href="#"  class="action btn btn-success" id= ' + data[i]['questionId'] + ' data-toggle="modal" data-target="#editQuestion"  > Edit\n' +
                                    '                                <i class="fa fa-edit"></i></a>\n' +
                                    '                        </td>\n' +
                                    '                    </tr>'


                            }




                        }

                        else {
                            $('#table-part-' + partId).html('<h3 style="text-align: center">No Question</h3>')
                        }
                        $("#count").val(i);
                        i = i + 1;
                        $("#question_order").text(i);


                    }
                    if(partId == 2) {
                        var i = 0;
                        if (data.length > 0) {
                            for (i = 0; i < data.length; i++) {
                                trData += '<tr class="odd gradeX" align="center">\n' +
                                    '                        <td>' + data[i]['questionNumber'] + '</td>\n' +
                                    '                        <td class="center">\n' +
                                    '                            <a href="#"  class="action2 btn btn-success" id= ' + data[i]['questionId'] + ' data-toggle="modal" data-target="#editQuestionPart2"  > Edit\n' +
                                    '                                <i class="fa fa-edit"></i></a>\n' +
                                    // '                           </n><button class="deleteQuestion btn btn-danger" id= ' + data[i]['questionId'] + '> Delete\n' +
                                    // '                                        <i class="fa fa-trash"></i></button >\n'+
                                    '                        </td>\n' +
                                    '                    </tr>'
                            }
                        $('#countQuestion').val(i);
                            $('#countTeamPart2').val(data[data.length -1]['team']);
                        }
                        else{
                            $('#table-part-' + partId).html('<h3 style="text-align: center">No Question</h3>')
                            $('#countTeamPart2').val(0);
                        }
                        i++;
                        $('#questionOder1').text(i);
                        $("#questionOder_1").val(i);
                        i++;
                        $('#questionOder2').text(i);
                        $("#questionOder_2").val(i);
                        i++;
                        $('#questionOder3').text(i);
                        $("#questionOder_3").val(i);

                        $('#countPart2').val(i);



                    }
                    if(partId == 3) {
                        var i = 0;
                        if (data.length > 0) {
                            for (i = 0; i < data.length; i++) {
                                trData += '<tr class="odd gradeX" align="center">\n' +
                                    '                        <td>' + data[i]['questionNumber'] + '</td>\n' +
                                    '                        <td class="center">\n' +
                                    '                            <a href="#"  class="action3 btn btn-success" id= ' + data[i]['questionId'] + ' data-toggle="modal" data-target="#editQuestionPart3"  > Edit\n' +
                                    '                                <i class="fa fa-edit"></i></a>\n' +
                                    // '                           </n><button class="deleteQuestion btn btn-danger" id= ' + data[i]['questionId'] + '> Delete\n' +
                                    // '                                        <i class="fa fa-trash"></i></button >\n'+
                                    '                        </td>\n' +
                                    '                    </tr>'
                            }
                            $('#countQuestion').val(i);
                            $('#countTeamPart3').val(data[data.length -1]['team']);
                        }
                        else{
                            $('#table-part-' + partId).html('<h3 style="text-align: center">No Question</h3>')
                            $('#countTeamPart3').val(0);
                        }
                        i++;
                        $('#questionOder4').text(i);
                        $("#questionOder_4").val(i);
                        i++;
                        $('#questionOder5').text(i);
                        $("#questionOder_5").val(i);
                        i++;
                        $('#questionOder6').text(i);
                        $("#questionOder_6").val(i);

                        $('#countPart3').val(i);


                    }
                    if(partId == 4) {
                        var i = 0;
                        if (data.length > 0) {
                            for (i = 0; i < data.length; i++) {
                                trData += '<tr class="odd gradeX" align="center">\n' +
                                    '                        <td>' + data[i]['questionNumber'] + '</td>\n' +
                                    '                        <td class="center">\n' +
                                    '                            <a href="#"  class="action4 btn btn-success" id= ' + data[i]['questionId'] + ' data-toggle="modal" data-target="#editQuestionPart4"  > Edit\n' +
                                    '                                <i class="fa fa-edit"></i></a>\n' +
                                    // '                           </n><button class="deleteQuestion btn btn-danger" id= ' + data[i]['questionId'] + '> Delete\n' +
                                    // '                                        <i class="fa fa-trash"></i></button >\n'+
                                    '                        </td>\n' +
                                    '                    </tr>'
                            }
                            $('#countQuestion').val(i);
                            $('#countTeamPart4').val(data[data.length -1]['team']);
                        }
                        else{
                            $('#table-part-' + partId).html('<h3 style="text-align: center">No Question</h3>')
                            $('#countTeamPart4').val(0);
                        }
                        i++;
                        $('#questionOder7').text(i);
                        $("#questionOder_7").val(i);
                        i++;
                        $('#questionOder8').text(i);
                        $("#questionOder_8").val(i);
                        i++;
                        $('#questionOder9').text(i);
                        $("#questionOder_9").val(i);

                        $('#countPart4').val(i);




                    }
                    if(partId == 5) {

                        var i = 0;
                        if (data.length > 0) {
                            for (i = 0; i < data.length; i++) {
                                trData += '<tr class="odd gradeX" align="center">\n' +
                                    '                        <td>' + data[i]['questionNumber'] + '</td>\n' +
                                    '                        <td class="center">\n' +
                                    '                            <a href="#"  class="action5 btn btn-success" id= ' + data[i]['questionId'] + ' data-toggle="modal" data-target="#editQuestionPart5"  > Edit\n' +
                                    '                                <i class="fa fa-edit"></i></a>\n' +
                                    // '                           </n><button class="deleteQuestion btn btn-danger" id= ' + data[i]['questionId'] + '> Delete\n' +
                                    // '                                        <i class="fa fa-trash"></i></button >\n'+
                                    '                        </td>\n' +
                                    '                    </tr>'


                            }
                        } else {
                            $('#table-part-' + partId).html('<h3 style="text-align: center">No Question</h3>')
                        }
                        $("#count5").val(i);
                        i = i + 1;
                        $("#question_order5").text(i);
                    }
                    if(partId == 6) {
                        var i = 0;
                        if (data.length > 0) {
                            for (i = 0; i < data.length; i++) {
                                trData += '<tr class="odd gradeX" align="center">\n' +
                                    '                        <td>' + data[i]['questionNumber'] + '</td>\n' +
                                    '                        <td class="center">\n' +
                                    '                            <a href="#"  class="action6 btn btn-success" id= ' + data[i]['questionId'] + ' data-toggle="modal" data-target="#editQuestionPart6"  > Edit\n' +
                                    '                                <i class="fa fa-edit"></i></a>\n' +
                                    // '                           </n><button class="deleteQuestion btn btn-danger" id= ' + data[i]['questionId'] + '> Delete\n' +
                                    // '                                        <i class="fa fa-trash"></i></button >\n'+
                                    '                        </td>\n' +
                                    '                    </tr>'
                            }
                            $('#countQuestion').val(i);
                            $('#countTeamPart6').val(data[data.length -1]['team']);
                        }
                        else{
                            $('#table-part-' + partId).html('<h3 style="text-align: center">No Question</h3>')
                            $('#countTeamPart6').val(0);
                        }
                        i++;
                        $('#questionOder10').text(i);
                        $("#questionOder_10").val(i);
                        i++;
                        $('#questionOder11').text(i);
                        $("#questionOder_11").val(i);
                        i++;
                        $('#questionOder12').text(i);
                        $("#questionOder_12").val(i);

                        $('#countPart6').val(i);


                    }
                    if(partId == 7) {
                        var i = 0;
                        if (data.length > 0) {
                            for (i = 0; i < data.length; i++) {
                                trData += '<tr class="odd gradeX" align="center">\n' +
                                    '                        <td>' + data[i]['questionNumber'] + '</td>\n' +
                                    '                        <td class="center">\n' +
                                    '                            <a href="#"  class="action7 btn btn-success" id= ' + data[i]['questionId'] + ' data-toggle="modal" data-target="#editQuestionPart7"  > Edit\n' +
                                    '                                <i class="fa fa-edit"></i></a>\n' +
                                    // '                           </n><button class="deleteQuestion btn btn-danger" id= ' + data[i]['questionId'] + '> Delete\n' +
                                    // '                                        <i class="fa fa-trash"></i></button >\n'+
                                    '                        </td>\n' +
                                    '                    </tr>'
                            }
                            $('#countQuestion').val(i);
                            $('#countTeamPart7').val(data[data.length -1]['team']);
                        }
                        else{
                            $('#table-part-' + partId).html('<h3 style="text-align: center">No Question</h3>')
                            $('#countTeamPart7').val(0);
                        }
                        i++;
                        $('#questionOder13').text(i);
                        $("#questionOder_13").val(i);
                        i++;
                        $('#questionOder14').text(i);
                        $("#questionOder_14").val(i);
                        i++;
                        $('#questionOder15').text(i);
                        $("#questionOder_15").val(i);

                        $('#countPart7').val(i);



                    }

                    tablePart1.find('tbody').html(trData);

                    $('a.action').on('click', function () {

                        var questionID = $(this).attr('id');
                        $('#questionId').val(questionID);
                        $('#partId').val(partId);
                        getQuestionsByID(questionID);
                            });
                    $('a.action2').on('click', function () {

                        var questionID = $(this).attr('id');
                        $('#questionId2').val(questionID);

                        getQuestionsByID(questionID);
                    });
                    $('a.action3').on('click', function () {

                        var questionID = $(this).attr('id');
                        $('#questionId3').val(questionID);
                        getQuestionsByID(questionID);
                    });
                    $('a.action4').on('click', function () {

                        var questionID = $(this).attr('id');
                        $('#questionId4').val(questionID);
                        getQuestionsByID(questionID);
                    });
                    $('a.action5').on('click', function () {

                        var questionID = $(this).attr('id');
                        $('#questionId5').val(questionID);
                        getQuestionsByID(questionID);
                    });
                    $('a.action6').on('click', function () {

                        var questionID = $(this).attr('id');
                        $('#questionId6').val(questionID);
                        getQuestionsByID(questionID);
                    });
                    $('a.action7').on('click', function () {

                        var questionID = $(this).attr('id');
                        $('#questionId7').val(questionID);
                        getQuestionsByID(questionID);
                    });




                    $('#table-part-' + partId).removeClass('hidden')

                },

                error: function (e) {
                    $('#part' + partId).find('table').attr('data-has-data', false);
                    console.log(e.message);
                }


            });

            function getQuestionsByID(questionID) {
                console.log('Get questions by ID' + questionID);

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });
                $.ajax({
                    method: 'GET',
                    dataType: 'json',
                    url: '{!! url('/getQuestionsByID')!!}' + '/' + questionID,
                    success: function (data) {
                        console.log('Questions Part ' + questionID + ': ' + data);
                        if(data['part']==="1"){
                            $('#formImage').show();
                            var mp3=data['fileMp3'];
                            var mp3Name= mp3.substring(33, 50);
                            $('#mp3Edit').val(mp3Name);
                            var image=data['image'];
                            var imageName= image.substring(33, 50);
                            $('#imagesEdit').val(imageName);

                            if(data['correctAnswer']==="A"){
                                $("div.answer1 select").val("A");

                            }

                            if(data['correctAnswer']==="B"){
                                $("div.answer1 select").val("B");

                            }

                            if(data['correctAnswer']==="C"){
                                $("div.answer1 select").val("C");


                            }

                            if(data['correctAnswer']==="D"){
                                $("div.answer1 select").val("D");


                            }

                            $('#questionNumber').val(data['questionNumber']);

                        }

                        if(data['part']==="2"){
                            var mp3=data['fileMp3'];
                            var mp3Name= mp3.substring(33, 50);
                            $('#mp3Edit2').val(mp3Name);

                            $('#questionNumber2').val(data['questionNumber']);
                            $('#partId2').val(data['part']);
                            $('#teamPart2').val(data['team']);
                            if(data['correctAnswer']==="A"){
                                $("div.answer2 select").val("A");

                            }

                            if(data['correctAnswer']==="B"){
                                $("div.answer2 select").val("B");

                            }

                            if(data['correctAnswer']==="C"){
                                $("div.answer2 select").val("C");


                            }

                            if(data['correctAnswer']==="D"){
                                $("div.answer2 select").val("D");


                            }

                        }
                        if(data['part']==="3"){
                            var mp3=data['fileMp3'];
                            var mp3Name= mp3.substring(33, 50);
                            $('#mp3Edit3').val(mp3Name);
                            $('#correctAnswer3').val(data['correctAnswer']);
                            $('#questionNumber3').val(data['questionNumber']);
                            $('#questionName3').text(data['questionName']);
                            $('#answerA3').val(data['a']);
                            $('#answerB3').val(data['b']);
                            $('#answerC3').val(data['c']);
                            $('#answerD3').val(data['d']);
                            $('#partId3').val(data['part']);
                            $('#teamPart3').val(data['team']);
                            if(data['correctAnswer']==="A"){
                                $("div.answer3 select").val("A");

                            }

                            if(data['correctAnswer']==="B"){
                                $("div.answer3 select").val("B");

                            }

                            if(data['correctAnswer']==="C"){
                                $("div.answer3 select").val("C");


                            }

                            if(data['correctAnswer']==="D"){
                                $("div.answer3 select").val("D");


                            }

                        }
                        if(data['part']==="4"){
                            var mp3=data['fileMp3'];
                            var mp3Name= mp3.substring(33, 50);
                            $('#mp3Edit4').val(mp3Name);
                            $('#correctAnswer4').val(data['correctAnswer']);
                            $('#questionNumber4').val(data['questionNumber']);
                            $('#questionName4').text(data['questionName']);
                            $('#answerA4').text(data['a']);
                            $('#answerB4').text(data['b']);
                            $('#answerC4').text(data['c']);
                            $('#answerD4').text(data['d']);
                            $('#partId4').val(data['part']);
                            $('#teamPart4').val(data['team']);
                            if(data['correctAnswer']==="A"){
                                $("div.answer4 select").val("A");

                            }

                            if(data['correctAnswer']==="B"){
                                $("div.answer4 select").val("B");

                            }

                            if(data['correctAnswer']==="C"){
                                $("div.answer4 select").val("C");


                            }

                            if(data['correctAnswer']==="D"){
                                $("div.answer4 select").val("D");


                            }


                        }
                        if(data['part']==="5"){
                            $('#correctAnswer5').val(data['correctAnswer']);
                            $('#questionNumber5').val(data['questionNumber']);
                            $('#questionName5').text(data['questionName']);
                            $('#answerA5').val(data['a']);
                            $('#answerB5').val(data['b']);
                            $('#answerC5').val(data['c']);
                            $('#answerD5').val(data['d']);
                            $('#partId5').val(data['part']);
                            if(data['correctAnswer']==="A"){
                                $("div.answer5 select").val("A");

                            }

                            if(data['correctAnswer']==="B"){
                                $("div.answer5 select").val("B");

                            }

                            if(data['correctAnswer']==="C"){
                                $("div.answer5 select").val("C");


                            }

                            if(data['correctAnswer']==="D"){
                                $("div.answer5 select").val("D");


                            }


                        }
                        if(data['part']==="6"){
                            $('#questionNumber6').val(data['questionNumber']);
                            $('#questionName6').text(data['questionName']);
                            var image=data['image'];
                            var imageName= image.substring(33, 50);
                            $('#imageEdit6').val(imageName);
                            $('#answerA6').val(data['a']);
                            $('#answerB6').val(data['b']);
                            $('#answerC6').val(data['c']);
                            $('#answerD6').val(data['d']);
                            $('#partId6').val(data['part']);
                            $('#teamPart6').val(data['team']);
                            if(data['correctAnswer']==="A"){
                                $("div.answer6 select").val("A");

                            }

                            if(data['correctAnswer']==="B"){
                                $("div.answer6 select").val("B");

                            }

                            if(data['correctAnswer']==="C"){
                                $("div.answer6 select").val("C");


                            }

                            if(data['correctAnswer']==="D"){
                                $("div.answer6 select").val("D");


                            }


                        }
                        if(data['part']==="7"){
                            $('#correctAnswer7').val(data['correctAnswer']);
                            $('#questionNumber7').val(data['questionNumber']);
                            $('#questionName7').text(data['questionName']);
                            var image=data['image'];
                            var imageName= image.substring(33, 50);
                            $('#imageEdit7').val(imageName);
                            $('#answerA7').val(data['a']);
                            $('#answerB7').val(data['b']);
                            $('#answerC7').val(data['c']);
                            $('#answerD7').val(data['d']);
                            $('#partId7').val(data['part']);
                            $('#teamPart7').val(data['team']);
                            if(data['correctAnswer']==="A"){
                                $("div.answer7 select").val("A");

                            }

                            if(data['correctAnswer']==="B"){
                                $("div.answer7 select").val("B");

                            }

                            if(data['correctAnswer']==="C"){
                                $("div.answer7 select").val("C");


                            }

                            if(data['correctAnswer']==="D"){
                                $("div.answer7 select").val("D");


                            }


                        }

                    },
                    error: function (e) {
                        console.log(e.message);
                    }
                });

            }
        }


    </script>


@endsection()


