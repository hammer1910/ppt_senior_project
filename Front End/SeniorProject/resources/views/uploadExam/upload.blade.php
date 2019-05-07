@extends('Home_Master')
@section('content')
    {{--<script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>--}}
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

                        <div class="form-group" style="margin-top: 1px;margin-bottom: 5px">
                            <label>Correct Answer </label>
                            <input class="form-control" name="correct_answer[]"
                                   placeholder="Please Enter Correct Answer" />
                            <div type="hidden" class="alert-warning">{{$errors->first('correct_answer')}}</div>
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

                            $("#add").append("<div class=\"col-lg-4 \">\n" +
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
                                "                        <div class=\"form-group\" style=\"margin-top: 1px;margin-bottom: 5px\">\n" +
                                "                            <label>Correct Answer </label>\n" +
                                "                            <input class=\"form-control\" name=\"correct_answer[]\"\n" +
                                "                                   placeholder=\"Please Enter Correct Answer\" />\n" +
                                "                            <div type=\"hidden\" class=\"alert-warning\">{{$errors->first('correct_answer')}}</div>\n" +
                                "                        </div>\n" +
                                "                    </div>\n" +
                                "                </div>");
                            var d = "#question_order1"+i;
                            $(d).text(s);
                            i++;
                        });

                </script>
                <script>
                    $("a.delete").on('click', function () {
                        var questionId = $(this).attr('id');
                        var x = confirm("Do you want to delete this group?");
                        if (x) {
                            deleteQuestion(questionId);
                        }
                        else
                            return false;
                    });
                    function deleteQuestion(questionId) {
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                            }
                        });
                        $.ajax({
                            method: 'DELETE',
                            dataType: 'json',
                            url: '{!! url('/deleteQuestion')!!}' + '/' + questionId,
                            success: function (data) {
                                location.reload();
                                console.log(data);
                            },
                            error: function (e) {
                                console.log(e.message);
                            }
                        });
                    }
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

                            <h6 id="questionOder1" style="font-size: initial"></h6>
                            <input id="questionOder_1"name="questionNumber_1[]" hidden>
                            <input class="form-control" name="correct_answer_1[]"
                                   placeholder="Please Enter Correct Answer" required="text"/>
                        </div>
                        <div class="form-group" style="margin-top: 1px;margin-bottom: 5px" id="answer">

                            <h6 id="questionOder2" style="font-size: initial"></h6>
                            <input id="questionOder_2" name="questionNumber_2[]" hidden>
                            <input class="form-control" name="correct_answer_2[]"
                                   placeholder="Please Enter Correct Answer" required="text"/>
                        </div>
                        <div class="form-group" style="margin-top: 1px;margin-bottom: 5px" id="answer">

                            <h6 id="questionOder3" style="font-size: initial"></h6>
                            <input id="questionOder_3" name="questionNumber_3[]" hidden>
                            <input class="form-control" name="correct_answer_3[]"
                                   placeholder="Please Enter Correct Answer" required="text"/>
                        </div>
                    </div>
                </div>

                <script>
                    var i = 0,j=1,k=2;
                    var s1 = 0, s2 = 0, s3= 0;
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
                                "                    <H6 id=\"question_Part2"+i+"\" style=\"font-size: initial\"> </H6 >\n" +
                                "                    <input type=\"hidden\" id=\"questionPart2_1" +i+"\" class=\"form-control\" name=\"questionNumber_1[]\"  />\n" +
                                "                    <input class=\"form-control\" name=\"correct_answer_1[]\"\n" +
                                "                           placeholder=\"Please Enter Correct Answer\" required=\"text\"/>\n" +
                                "                </div>\n" +
                                "                <div class=\"form-group\" style=\"margin-top: 1px;margin-bottom: 5px\" id=\"answer\">\n" +
                                "\n" +
                                "                    <H6 id=\"question_Part2"+j+"\" style=\"font-size: initial\" > </H6 >\n" +
                                "                    <input type=\"hidden\" id=\"questionPart2_2"+j+"\" class=\"form-control\" name=\"questionNumber_2[]\" />\n" +
                                "                    <input class=\"form-control\" name=\"correct_answer_2[]\"\n" +
                                "                           placeholder=\"Please Enter Correct Answer\" required=\"text\"/>\n" +
                                "                </div>\n" +
                                "                <div class=\"form-group\" style=\"margin-top: 1px;margin-bottom: 5px\" id=\"answer\">\n" +
                                "\n" +
                                "                    <H6 id=\"question_Part2"+k+"\"  style=\"font-size: initial\"></H6  >\n" +
                                "                    <input type=\"hidden\" id=\"questionPart2_3"+k+"\" class=\"form-control\" name=\"questionNumber_3[]\" />\n" +
                                "                    <input class=\"form-control\" name=\"correct_answer_3[]\"\n" +
                                "                           placeholder=\"Please Enter Correct Answer\" required=\"text\"/>\n" +
                                "                </div>\n" +
                                "               \n" +
                                "            </div>\n" +
                                "\n" +
                                "\n" +
                                "        </div> ");
                            var d1 = "#question_Part2"+i;
                            var a1 = "#questionPart2_1"+i;
                            i+=4;
                            $(d1).text(s1);
                            $(a1).val(s1);
                            var d2 = "#question_Part2"+j;
                            var a2 = "#questionPart2_2"+j;
                            j+=4;
                            s1++;
                            $(d2).text(s1);
                            $(a2).val(s1);
                            var d3 = "#question_Part2"+k;
                            var a3 = "#questionPart2_3"+k;
                            k+=4;
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
                                <input class="form-control" name="question_1[]" placeholder="Please Enter question" required="text" />

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
                                <input class="form-control" name="correct_answer_1[]" placeholder="Please Enter Correct Answer"required="text" />

                            </div>

                        </div>
                        <div class="col-lg-4 ">
                            <div class="form-group" style="margin-top: 1px;margin-bottom: 5px">
                                <h6 id="questionOder5" style="font-size: initial"></h6>
                                <input id="questionOder_5" name="questionNumber_5[]"hidden >
                                <input class="form-control" name="question_2[]" placeholder="Please Enter question" required="text"/>

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
                                <input class="form-control" name="correct_answer_2[]" placeholder="Please Enter Correct Answer"required="text" />

                            </div>

                        </div>
                        <div class="col-lg-4 ">
                            <div class="form-group" style="margin-top: 1px;margin-bottom: 5px">
                                <h6 id="questionOder6" style="font-size: initial"></h6>
                                <input id="questionOder_6" name="questionNumber_6[]" hidden >
                                <input class="form-control" name="question_3[]" placeholder="Please Enter question" required="text"/>

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
                                <input class="form-control" name="correct_answer_3[]" placeholder="Please Enter Correct Answer"required="text" />

                            </div>

                        </div>
                    </div>


                </div>
                <script>
                    var i = 0,j=1,k=2;
                    var s1 = 0, s2 = 0, s3= 0;
                    var count = 1;
                    $("#addQuestionPart3").click(function () {
                        var d =$("#countPart3").val();
                        count++;
                        s1 = parseInt(d);
                        s1++;
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
                            "                                <h6 id=\"question_Part2"+i+"\"  style=\"font-size: initial\"></h6>\n" +
                            "                                <input id=\"questionPart2_1" +i+"\" name=\"questionNumber_4[]\" hidden>\n" +
                            "                                <input class=\"form-control\" name=\"question_1[]\" placeholder=\"Please Enter question\" required=\"text\" />\n" +
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
                            "                                <input class=\"form-control\" name=\"correct_answer_1[]\" placeholder=\"Please Enter Correct Answer\"required=\"text\" />\n" +
                            "\n" +
                            "                            </div>\n" +
                            "\n" +
                            "                        </div>\n" +
                            "                        <div class=\"col-lg-4 \">\n" +
                            "                            <div class=\"form-group\" style=\"margin-top: 1px;margin-bottom: 5px\">\n" +
                            "                                <h6 id=\"question_Part2"+j+"\" style=\"font-size: initial\"></h6>\n" +
                            "                                <input id=\"questionPart2_2"+j+"\" name=\"questionNumber_5[]\" hidden>\n" +
                            "                                <input class=\"form-control\" name=\"question_2[]\" placeholder=\"Please Enter question\" required=\"text\"/>\n" +
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
                            "                                <input class=\"form-control\" name=\"correct_answer_2[]\" placeholder=\"Please Enter Correct Answer\"required=\"text\" />\n" +
                            "\n" +
                            "                            </div>\n" +
                            "\n" +
                            "                        </div>\n" +
                            "                        <div class=\"col-lg-4 \">\n" +
                            "                            <div class=\"form-group\" style=\"margin-top: 1px;margin-bottom: 5px\">\n" +
                            "                                <h6 id=\"question_Part2"+k+"\"style=\"font-size: initial\"></h6>\n" +
                            "                                <input id=\"questionPart2_3"+k+"\" name=\"questionNumber_6[]\" hidden>\n" +
                            "                                <input class=\"form-control\" name=\"question_3[]\" placeholder=\"Please Enter question\" required=\"text\"/>\n" +
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
                            "                                <input class=\"form-control\" name=\"correct_answer_3[]\" placeholder=\"Please Enter Correct Answer\"required=\"text\" />\n" +
                            "\n" +
                            "                            </div>\n" +
                            "\n" +
                            "                        </div>\n" +
                            "                    </div>\n" +
                            "\n" +
                            "\n" +
                            "                </div>");
                        var d1 = "#question_Part2"+i;
                        var a1 = "#questionPart2_1"+i;
                        i+=4;
                        $(d1).text(s1);
                        $(a1).val(s1);
                        var d2 = "#question_Part2"+j;
                        var a2 = "#questionPart2_2"+j;
                        j+=4;
                        s1++;
                        $(d2).text(s1);
                        $(a2).val(s1);
                        var d3 = "#question_Part2"+k;
                        var a3 = "#questionPart2_3"+k;
                        k+=4;
                        s1++;
                        $(d3).text(s1);
                        $(a3).val(s1);
                        $("#countPart3").val(s1);

                    });
                </script>

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
                                <input class="form-control" name="question_1[]" placeholder="Please Enter question" required="text" />

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
                                <input class="form-control" name="correct_answer_1[]" placeholder="Please Enter Correct Answer"required="text" />

                            </div>

                        </div>
                        <div class="col-lg-4 ">
                            <div class="form-group" style="margin-top: 1px;margin-bottom: 5px">
                                <h6 id="questionOder8" style="font-size: initial"></h6>
                                <input id="questionOder_8" name="questionNumber_8[]" hidden >
                                <input class="form-control" name="question_2[]" placeholder="Please Enter question" required="text"/>

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
                                <input class="form-control" name="correct_answer_2[]" placeholder="Please Enter Correct Answer"required="text" />

                            </div>

                        </div>
                        <div class="col-lg-4 ">
                            <div class="form-group" style="margin-top: 1px;margin-bottom: 5px">
                                <h6 id="questionOder9" style="font-size: initial"></h6>
                                <input id="questionOder_9" name="questionNumber_9[]" hidden >
                                <input class="form-control" name="question_3[]" placeholder="Please Enter question" required="text"/>

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
                                <input class="form-control" name="correct_answer_3[]" placeholder="Please Enter Correct Answer"required="text" />

                            </div>

                        </div>
                    </div>


                </div>
                <script>
                    var i = 0,j=1,k=2;
                    var s1 = 0, s2 = 0, s3= 0;
                    var count = 1;
                    $("#addQuestionPart4").click(function () {
                        var d =$("#countPart4").val();
                        count++;
                        s1 = parseInt(d);
                        s1++;
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
                            "                                <h6 id=\"question_Part2"+i+"\"  style=\"font-size: initial\"></h6>\n" +
                            "                                <input id=\"questionPart2_1" +i+"\" name=\"questionNumber_7[]\" hidden>\n" +
                            "                                <input class=\"form-control\" name=\"question_1[]\" placeholder=\"Please Enter question\" required=\"text\" />\n" +
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
                            "                                <input class=\"form-control\" name=\"correct_answer_1[]\" placeholder=\"Please Enter Correct Answer\"required=\"text\" />\n" +
                            "\n" +
                            "                            </div>\n" +
                            "\n" +
                            "                        </div>\n" +
                            "                        <div class=\"col-lg-4 \">\n" +
                            "                            <div class=\"form-group\" style=\"margin-top: 1px;margin-bottom: 5px\">\n" +
                            "                                <h6 id=\"question_Part2"+j+"\" style=\"font-size: initial\"></h6>\n" +
                            "                                <input id=\"questionPart2_2"+j+"\" name=\"questionNumber_8[]\" hidden>\n" +
                            "                                <input class=\"form-control\" name=\"question_2[]\" placeholder=\"Please Enter question\" required=\"text\"/>\n" +
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
                            "                                <input class=\"form-control\" name=\"correct_answer_2[]\" placeholder=\"Please Enter Correct Answer\"required=\"text\" />\n" +
                            "\n" +
                            "                            </div>\n" +
                            "\n" +
                            "                        </div>\n" +
                            "                        <div class=\"col-lg-4 \">\n" +
                            "                            <div class=\"form-group\" style=\"margin-top: 1px;margin-bottom: 5px\">\n" +
                            "                                <h6 id=\"question_Part2"+k+"\"style=\"font-size: initial\"></h6>\n" +
                            "                                <input id=\"questionPart2_3"+k+"\" name=\"questionNumber_9[]\" hidden>\n" +
                            "                                <input class=\"form-control\" name=\"question_3[]\" placeholder=\"Please Enter question\" required=\"text\"/>\n" +
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
                            "                                <input class=\"form-control\" name=\"correct_answer_3[]\" placeholder=\"Please Enter Correct Answer\"required=\"text\" />\n" +
                            "\n" +
                            "                            </div>\n" +
                            "\n" +
                            "                        </div>\n" +
                            "                    </div>\n" +
                            "\n" +
                            "\n" +
                            "                </div>");
                        var d1 = "#question_Part2"+i;
                        var a1 = "#questionPart2_1"+i;
                        i+=4;
                        $(d1).text(s1);
                        $(a1).val(s1);
                        var d2 = "#question_Part2"+j;
                        var a2 = "#questionPart2_2"+j;
                        j+=4;
                        s1++;
                        $(d2).text(s1);
                        $(a2).val(s1);
                        var d3 = "#question_Part2"+k;
                        var a3 = "#questionPart2_3"+k;
                        k+=4;
                        s1++;
                        $(d3).text(s1);
                        $(a3).val(s1);
                        $("#countPart4").val(s1);

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
                            <input class="form-control" name="question[]" placeholder="Please Enter question" required="text"/>
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
                            <input class="form-control" name="correct_answer[]" placeholder="Please Enter Correct Answer" required="text"/>

                        </div>
                    </div>


                </div>
                <script>
                    var i = 0;
                    var count = 1;
                    $("#addQuestionPart5").click(function () {
                        var d =$("#question_order5").text();
                        count++;
                        var s = parseInt(d) + i;
                        s+=1;

                        $("#add5").append("<div class=\"col-lg-4 \">\n" +
                            "                    <h3 class=\"text-center\" style=\"color: black;margin-top: 10px\" id=\"question_order5_1"+i+"\"></h3>\n" +
                            "                    <div class=\"panel-body\" style=\"margin-top: 1px\">\n" +
                            "                        <div class=\"form-group\" style=\"margin-top: 1px;margin-bottom: 5px\">\n" +
                            "                            <label>Question</label>\n" +
                            "                            <input class=\"form-control\" name=\"question[]\" placeholder=\"Please Enter question\" required=\"text\"/>\n" +
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
                            "                            <input class=\"form-control\" name=\"correct_answer[]\" placeholder=\"Please Enter Correct Answer\" required=\"text\"/>\n" +
                            "\n" +
                            "                        </div>\n" +
                            "                    </div>\n" +
                            "\n" +
                            "\n" +
                            "                </div>");
                        var d = "#question_order5_1"+i;
                        $(d).text(s);
                        i++;
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
                                <input class="form-control" name="question_1[]" placeholder="Please Enter question" required="text" />

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
                                <input class="form-control" name="correct_answer_1[]" placeholder="Please Enter Correct Answer"required="text" />

                            </div>

                        </div>
                        <div class="col-lg-4 ">
                            <div class="form-group" style="margin-top: 1px;margin-bottom: 5px">
                                <h6 id="questionOder11" style="font-size: initial"></h6>
                                <input id="questionOder_11" name="questionNumber_11[]"  hidden>
                                <input class="form-control" name="question_2[]" placeholder="Please Enter question" required="text"/>

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
                                <input class="form-control" name="correct_answer_2[]" placeholder="Please Enter Correct Answer"required="text" />

                            </div>

                        </div>
                        <div class="col-lg-4 ">
                            <div class="form-group" style="margin-top: 1px;margin-bottom: 5px">
                                <h6 id="questionOder12" style="font-size: initial"></h6>
                                <input id="questionOder_12" name="questionNumber_12[]" hidden>
                                <input class="form-control" name="question_3[]" placeholder="Please Enter question" required="text"/>

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
                                <input class="form-control" name="correct_answer_3[]" placeholder="Please Enter Correct Answer"required="text" />

                            </div>

                        </div>
                    </div>


                </div>
                <script>
                    var i = 0,j=1,k=2;
                    var s1 = 0, s2 = 0, s3= 0;
                    var count = 1;
                    $("#addQuestionPart6").click(function () {
                        var d =$("#countPart6").val();
                        count++;
                        s1 = parseInt(d);
                        s1++;
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
                            "                                <h6 id=\"question_Part2"+i+"\" style=\"font-size: initial\"></h6>\n" +
                            "                                <input id=\"questionPart2_1" +i+"\" name=\"questionNumber_10[]\"  hidden>\n" +
                            "                                <input class=\"form-control\" name=\"question_1[]\" placeholder=\"Please Enter question\" required=\"text\" />\n" +
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
                            "                                <input class=\"form-control\" name=\"correct_answer_1[]\" placeholder=\"Please Enter Correct Answer\"required=\"text\" />\n" +
                            "\n" +
                            "                            </div>\n" +
                            "\n" +
                            "                        </div>\n" +
                            "                        <div class=\"col-lg-4 \">\n" +
                            "                            <div class=\"form-group\" style=\"margin-top: 1px;margin-bottom: 5px\">\n" +
                            "                                <h6 id=\"question_Part2"+j+"\" style=\"font-size: initial\"></h6>\n" +
                            "                                <input id=\"questionPart2_2" +j+"\" name=\"questionNumber_11[]\" hidden>\n" +
                            "                                <input class=\"form-control\" name=\"question_2[]\" placeholder=\"Please Enter question\" required=\"text\"/>\n" +
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
                            "                                <input class=\"form-control\" name=\"correct_answer_2[]\" placeholder=\"Please Enter Correct Answer\"required=\"text\" />\n" +
                            "\n" +
                            "                            </div>\n" +
                            "\n" +
                            "                        </div>\n" +
                            "                        <div class=\"col-lg-4 \">\n" +
                            "                            <div class=\"form-group\" style=\"margin-top: 1px;margin-bottom: 5px\">\n" +
                            "                                <h6 id=\"question_Part2"+k+"\"style=\"font-size: initial\"></h6>\n" +
                            "                                <input id=\"questionPart2_3" +k+"\"  name=\"questionNumber_12[]\" hidden>\n" +
                            "                                <input class=\"form-control\" name=\"question_3[]\" placeholder=\"Please Enter question\" required=\"text\"/>\n" +
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
                            "                                <input class=\"form-control\" name=\"correct_answer_3[]\" placeholder=\"Please Enter Correct Answer\"required=\"text\" />\n" +
                            "\n" +
                            "                            </div>\n" +
                            "\n" +
                            "                        </div>\n" +
                            "                    </div>");
                        var d1 = "#question_Part2"+i;
                        var a1 = "#questionPart2_1"+i;
                        i+=4;
                        $(d1).text(s1);
                        $(a1).val(s1);
                        var d2 = "#question_Part2"+j;
                        var a2 = "#questionPart2_2"+j;
                        j+=4;
                        s1++;
                        $(d2).text(s1);
                        $(a2).val(s1);
                        var d3 = "#question_Part2"+k;
                        var a3 = "#questionPart2_3"+k;
                        k+=4;
                        s1++;
                        $(d3).text(s1);
                        $(a3).val(s1);
                        $("#countPart6").val(s1);

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
                                <input class="form-control" name="question_1[]" placeholder="Please Enter question" required="text" />

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
                                <input class="form-control" name="correct_answer_1[]" placeholder="Please Enter Correct Answer"required="text" />

                            </div>

                        </div>
                        <div class="col-lg-4 ">
                            <div class="form-group" style="margin-top: 1px;margin-bottom: 5px">
                                <h6 id="questionOder14" style="font-size: initial"></h6>
                                <input id="questionOder_14" name="questionNumber_14[]"  hidden>
                                <input class="form-control" name="question_2[]" placeholder="Please Enter question" required="text"/>

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
                                <input class="form-control" name="correct_answer_2[]" placeholder="Please Enter Correct Answer"required="text" />

                            </div>

                        </div>
                        <div class="col-lg-4 ">
                            <div class="form-group" style="margin-top: 1px;margin-bottom: 5px">
                                <h6 id="questionOder15" style="font-size: initial"></h6>
                                <input id="questionOder_15" name="questionNumber_15[]" hidden>
                                <input class="form-control" name="question_3[]" placeholder="Please Enter question" />

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
                                <input class="form-control" name="correct_answer_3[]" placeholder="Please Enter Correct Answer" />

                            </div>

                        </div>
                    </div>


                </div>
                <script>
                    var i = 0,j=1,k=2;
                    var s1 = 0, s2 = 0, s3= 0;
                    var count = 1;
                    $("#addQuestionPart7").click(function () {
                        var d =$("#countPart7").val();
                        count++;
                        s1 = parseInt(d);
                        s1++;
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
                            "                                <h6 id=\"question_Part2"+i+"\" style=\"font-size: initial\"></h6>\n" +
                            "                                <input id=\"questionPart2_1" +i+"\" name=\"questionNumber_13[]\" hidden >\n" +
                            "                                <input class=\"form-control\" name=\"question_1[]\" placeholder=\"Please Enter question\" required=\"text\" />\n" +
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
                            "                                <input class=\"form-control\" name=\"correct_answer_1[]\" placeholder=\"Please Enter Correct Answer\"required=\"text\" />\n" +
                            "\n" +
                            "                            </div>\n" +
                            "\n" +
                            "                        </div>\n" +
                            "                        <div class=\"col-lg-4 \">\n" +
                            "                            <div class=\"form-group\" style=\"margin-top: 1px;margin-bottom: 5px\">\n" +
                            "                                <h6 id=\"question_Part2"+j+"\" style=\"font-size: initial\"></h6>\n" +
                            "                                <input id=\"questionPart2_2" +j+"\" name=\"questionNumber_14[]\" hidden>\n" +
                            "                                <input class=\"form-control\" name=\"question_2[]\" placeholder=\"Please Enter question\" required=\"text\"/>\n" +
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
                            "                                <input class=\"form-control\" name=\"correct_answer_2[]\" placeholder=\"Please Enter Correct Answer\"required=\"text\" />\n" +
                            "\n" +
                            "                            </div>\n" +
                            "\n" +
                            "                        </div>\n" +
                            "                        <div class=\"col-lg-4 \">\n" +
                            "                            <div class=\"form-group\" style=\"margin-top: 1px;margin-bottom: 5px\">\n" +
                            "                                <h6 id=\"question_Part2"+k+"\"style=\"font-size: initial\"></h6>\n" +
                            "                                <input id=\"questionPart2_3" +k+"\"  name=\"questionNumber_15[]\" hidden>\n" +
                            "                                <input class=\"form-control\" name=\"question_3[]\" placeholder=\"Please Enter question\" required=\"text\"/>\n" +
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
                            "                                <input class=\"form-control\" name=\"correct_answer_3[]\" placeholder=\"Please Enter Correct Answer\"required=\"text\" />\n" +
                            "\n" +
                            "                            </div>\n" +
                            "\n" +
                            "                        </div>\n" +
                            "                    </div>");
                        var d1 = "#question_Part2"+i;
                        var a1 = "#questionPart2_1"+i;
                        i+=4;
                        $(d1).text(s1);
                        $(a1).val(s1);
                        var d2 = "#question_Part2"+j;
                        var a2 = "#questionPart2_2"+j;
                        j+=4;
                        s1++;
                        $(d2).text(s1);
                        $(a2).val(s1);
                        var d3 = "#question_Part2"+k;
                        var a3 = "#questionPart2_3"+k;
                        k+=4;
                        s1++;
                        $(d3).text(s1);
                        $(a3).val(s1);
                        $("#countPart7").val(s1);

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

                                                    <div class="form-group" style="margin-top: 1px;margin-bottom: 5px">
                                                        <label>Correct Answer </label>
                                                        <input class="form-control" id="correctAnswerEdit" name="correct_answer"
                                                               placeholder="Please Enter Correct Answer"/>
                                                    </div>
                                                    <button type="submit" class="btn btn-success" style="display: block; margin: auto;">Upload</button>
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
                                                    <input id="partId" name="partId" hidden>
                                                    <input id="questionId" name="questionId" hidden >
                                                    <input id="questionNumber" name="questionNumber" hidden>
                                                    <input type="text" id="mp3Edit2" class="form-control" name="mp3Edit2" readonly/>
                                                    <input type="file" id="inputMp3"  class="form-control"  name="mp3"/>
                                                </div>
                                                <div class="form-group" style="margin-top: 1px;margin-bottom: 5px">
                                                    <label>Correct Answer </label>
                                                    <input class="form-control" id="correctAnswerEdit2" name="correct_answer"
                                                           placeholder="Please Enter Correct Answer"/>
                                                </div>
                                                <button type="submit" class="btn btn-success" style="display: block; margin: auto;">Upload</button>
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


                    if (partId == 1) {

                        var i = 0;
                        if (data.length > 0) {
                            for (i = 0; i < data.length; i++) {
                                trData += '<tr class="odd gradeX" align="center">\n' +
                                    '                        <td>' + data[i]['questionNumber'] + '</td>\n' +
                                    '                        <td class="center">\n' +
                                    '                            <a href="#"  class="action btn btn-success" id= ' + data[i]['questionId'] + ' data-toggle="modal" data-target="#editQuestion"  > Edit\n' +
                                    '                                <i class="fa fa-edit"></i></a>\n' +
                                    // '                            <a href="#"  class="delete btn btn-danger" id= ' + data[i]['questionId'] + '> Delete\n' +
                                    //     '<i class="fa fa-trash"></i></button>\n'+
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


                    }else if(partId == 2) {
                        var i = 0;
                        if (data.length > 0) {
                            for (i = 0; i < data.length; i++) {
                                trData += '<tr class="odd gradeX" align="center">\n' +
                                    '                        <td>' + data[i]['questionNumber'] + '</td>\n' +
                                    '                        <td class="center">\n' +
                                    '                            <a href="#"  class="action btn btn-success" id= ' + data[i]['questionId'] + ' data-toggle="modal" data-target="#editQuestionPart2"  > Edit\n' +
                                    '                                <i class="fa fa-edit"></i></a>\n' +
                                    '                        </td>\n' +
                                    '                    </tr>'
                            }
                        $('#countQuestion').val(i);
                        }
                        else{
                            $('#table-part-' + partId).html('<h3 style="text-align: center">No Question</h3>')
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
                                    '                            <a href="#"  class="action btn btn-success" id= ' + data[i]['questionId'] + ' data-toggle="modal" data-target="#editQuestionPart2"  > Edit\n' +
                                    '                                <i class="fa fa-edit"></i></a>\n' +
                                    '                        </td>\n' +
                                    '                    </tr>'
                            }
                            $('#countQuestion').val(i);
                        }
                        else{
                            $('#table-part-' + partId).html('<h3 style="text-align: center">No Question</h3>')
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
                                    '                            <a href="#"  class="action btn btn-success" id= ' + data[i]['questionId'] + ' data-toggle="modal" data-target="#editQuestionPart2"  > Edit\n' +
                                    '                                <i class="fa fa-edit"></i></a>\n' +
                                    '                        </td>\n' +
                                    '                    </tr>'
                            }
                            $('#countQuestion').val(i);
                        }
                        else{
                            $('#table-part-' + partId).html('<h3 style="text-align: center">No Question</h3>')
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
                    if (partId == 5) {

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
                                    '                            <a href="#"  class="action btn btn-success" id= ' + data[i]['questionId'] + ' data-toggle="modal" data-target="#editQuestionPart2"  > Edit\n' +
                                    '                                <i class="fa fa-edit"></i></a>\n' +
                                    '                        </td>\n' +
                                    '                    </tr>'
                            }
                            $('#countQuestion').val(i);
                        }
                        else{
                            $('#table-part-' + partId).html('<h3 style="text-align: center">No Question</h3>')
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
                                    '                            <a href="#"  class="action btn btn-success" id= ' + data[i]['questionId'] + ' data-toggle="modal" data-target="#editQuestionPart2"  > Edit\n' +
                                    '                                <i class="fa fa-edit"></i></a>\n' +
                                    '                        </td>\n' +
                                    '                    </tr>'
                            }
                            $('#countQuestion').val(i);
                        }
                        else{
                            $('#table-part-' + partId).html('<h3 style="text-align: center">No Question</h3>')
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
                    $('#table-part-' + partId).removeClass('hidden')

                },
                error: function (e) {
                    $('#part' + partId).find('table').attr('data-has-data', false);
                    console.log(e.message);
                }


            });

            function getQuestionsByID(questionID) {
                console.log('Get questions by part ' + questionID);

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
                            $('#correctAnswerEdit').val(data['correctAnswer']);
                        }
                        if(data['part']==="2"){
                            var mp3=data['fileMp3'];
                            var mp3Name= mp3.substring(33, 50);
                            $('#mp3Edit2').val(mp3Name);
                            $('#correctAnswerEdit2').val(data['correctAnswer']);
                        }
                        $('#questionNumber').val(data['questionNumber']);

                    },
                    error: function (e) {
                        console.log(e.message);
                    }
                });

            }
        }


    </script>

@endsection()


