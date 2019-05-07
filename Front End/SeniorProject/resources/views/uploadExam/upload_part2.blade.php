@extends('Home')
@section('content')
    <form id="add" action="{{route('upload.part2')}}" method="post" enctype="multipart/form-data">
        @csrf
        <div>
            <h3 class="text-center" style="color: black;margin-top: 10px; font-size: xx-large">Part 1</h3>
            @if (session('message'))
                <div class="alert alert-success" style="text-align: center; font-size: large">
                    <strong>Success!</strong> {{session('message')}}
                </div>
            @endif


            <button type="submit"  id="finish" class="btn btn-outline-primary"
                    style="display: block; margin: auto; float: right">Upload
            </button>

            <input type="button" id="btn2" class="btn" value="Add Question">
        </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

        <div class="col-lg-4 ">

            <h3 class="text-center" style="color: black;margin-top: 10px">Question 1</h3>
            <div class="panel-body" style="margin-top: 1px">
                <div class="form-group" style="margin-top: 1px;margin-bottom: 5px">
                    <label>MP3</label>
                    <input type="file" class="form-control" name="mp3[]"/>
                </div>
                <div class="form-group" style="margin-top: 1px;margin-bottom: 5px">
                    <label>Image</label>
                    <input type="file" class="form-control" name="images[]"/>
                </div>

                <div class="form-group" style="margin-top: 1px;margin-bottom: 5px" id="answer">

                    <label>Correct Answer </label>

                    <input class="form-control" name="correct_answer[]"
                           placeholder="Please Enter Correct Answer"/>




                </div>
            </div>


        </div>

        {{--<div id ="add">11</div>--}}



        <script>
            $(document).ready(function () {
                var i = 2;
                $("#btn2").click(function () {

                    $("#add").append(" <div class=\"col-lg-4 \" >\n" +
                        "\n" +
                        "            <h3 class=\"text-center\" style=\"color: black;margin-top: 10px\">Question "+(i++)+"</h3>\n" +
                        "            <div class=\"panel-body\" style=\"margin-top: 1px\">\n" +
                        "                    <div class=\"form-group\" style=\"margin-top: 1px;margin-bottom: 5px\">\n" +
                        "                        <label>MP3</label>\n" +
                        "                        <input type=\"file\" class=\"form-control\" name=\"mp3[]\"/>\n" +
                        "                    </div>\n" +
                        "                    <div class=\"form-group\" style=\"margin-top: 1px;margin-bottom: 5px\">\n" +
                        "                        <label>Image</label>\n" +
                        "                        <input type=\"file\" class=\"form-control\" name=\"images[]\"/>\n" +
                        "                    </div>\n" +
                        "\n" +
                        "                    <div class=\"form-group\" style=\"margin-top: 1px;margin-bottom: 5px\" id=\"answer\">\n" +
                        "\n" +
                        "                        <label>Correct Answer </label>\n" +
                        "                        <div>\n" +
                        "                            <input class=\"form-control\" name=\"correct_answer[]\"\n" +
                        "                                   placeholder=\"Please Enter Correct Answer\"/>\n" +
                        "\n" +
                        "\n" +
                        "                        </div>\n" +
                        "\n" +
                        "                            </div>\n");
                });
                // $("#add_question").click(function () {
                //     $("#answer").append("\n" +
                //         "                                                <div class=\"form-group\"style=\"margin-top: 1px;margin-bottom: 5px\" id=\"answer\">\n" +
                //         "\n" +
                //         "                                                    <label>Correct Answer </label>\n" +
                //         "                                                    <input type=\"button\" id=\"add_question\" style=\"float: right\" value=\"+\" >\n" +
                //         "                                                    <div>\n" +
                //         "                                                    <input class=\"form-control\"  name=\"correct_answer\"\n" +
                //         "                                                           placeholder=\"Please Enter Correct Answer\"/>\n" +
                //         "\n" +
                //         "\n" +
                //         "                                                    </div>")
                // });

            });
        </script>

    </form>
@endsection()



{{--@extends('master')--}}
{{--@section('controller','Category')--}}
{{--@section('action','Add')--}}
{{--@section('content')--}}
{{--<p>ID: {{$id}}</p>--}}
{{--<!-- /.col-lg-12 -->--}}
{{--<div class="col-lg-4" style="padding-top:10px;height: 10px;">--}}
{{--<h2 style="text-align: center">Upload Part 1</h2>--}}

{{--<form enctype="multipart/form-data" >--}}
{{--<div class="col-lg-7 ">--}}
{{--<input type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#login-modal"--}}
{{--value="ADD" style="margin-top: 20px;">--}}
{{--@if (session('message'))--}}
{{--<div type="hidden" class="alert-warning" style="text-align: center">{{session('message')}}--}}
{{--@endif--}}
{{--</div>--}}
{{--</div>--}}
{{--</form>--}}


{{--<form action="{{route('upload.part1')}}" method="post" enctype="multipart/form-data">--}}
{{--@csrf--}}

{{--<div class="modal fade" id="login-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false" style="display: none;">--}}
{{--<div class="modal-dialog">--}}
{{--<div class="loginmodal-container">--}}
{{--<div class="row">--}}
{{--<div class="col-md-10 col-md-offset-1">--}}
{{--<div class="panel panel-default">--}}
{{--<div class="panel-body">--}}
{{--<div class="text">--}}
{{--<h2 class="text-center" style="color: black">Part 1</h2>--}}
{{--<div class="panel-body">--}}
{{--<form  id="register-form" role="form" autocomplete="off" class="form" method="post" >--}}
{{--<div class="form-group">--}}
{{--<label>MP3</label>--}}
{{--<input type="file" class="form-control" name="mp3"   />--}}
{{--</div>--}}
{{--<div class="form-group">--}}
{{--<label>Image</label>--}}
{{--<input type="file" class="form-control" name="images"/>--}}
{{--</div>--}}
{{--<div class="form-group">--}}
{{--<label>Correct Answer</label>--}}
{{--<input class="form-control" name="correct_answer" placeholder="Please Enter Correct Answer" />--}}
{{--</div>--}}
{{--<button type="submit" class="btn btn-outline-primary" style="display: block; margin: auto;">Add</button>--}}
{{--</form>--}}

{{--</div>--}}
{{--</div>--}}
{{--</div>--}}
{{--</div>--}}
{{--</div>--}}
{{--</div>--}}
{{--</div>--}}


{{--</div>--}}
{{--</div>--}}
{{--</div>--}}

{{--</form>--}}

{{--@endsection()--}}


