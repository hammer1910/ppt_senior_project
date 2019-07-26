@extends('Home')
@section('content')
    <form id="add" action="" method="post" enctype="multipart/form-data">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-flexdatalist/2.2.4/jquery.flexdatalist.css"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-flexdatalist/2.2.4/jquery.flexdatalist.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-flexdatalist/2.2.4/jquery.flexdatalist.min.css"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-flexdatalist/2.2.4/jquery.flexdatalist.min.js"></script>
        @csrf
        <div>
            <h3 class="text-center" style="color: black;margin-top: 10px; font-size: xx-large">List Group</h3>
            @if (session('message'))
                <div class="alert alert-success" style="text-align: center; font-size: large">
                    <strong>Success!</strong> {{session('message')}}
                </div>
            @endif
            <?php $group =0 ?>
        @foreach($arrays as $value)
                <?php $group =$group+1 ?>
                {{--<div class="col-lg-6 " style="border: solid 1px">--}}
            {{--<div class="card" style="width:400px">--}}
                {{--<div class="card-body">--}}
                    {{----}}
                    {{--<h4 class="card-title">{{$value['groupName']}}</h4>--}}
                    {{--<p class="card-text">Some example text some example text. John Doe is an architect and engineer</p>--}}
                    {{--<a href="#" class="btn btn-primary stretched-link">See Profile</a>--}}
                {{--</div>--}}
            {{--</div>--}}
                {{--</div>--}}
                <div class="col-lg-4 " >
                    <div class="card" style="width:400px">
                        <h3 class="text-center" style="color: black;margin-top: 10px">Group {{$group}}</h3>
                        <div class="card-body">
                            <h4 class="card-title"><label >Group Name:&#160 </label>  <label>{{$value['groupName']}}</label></h4>
                            <p class="card-text">  <label>Description: &#160 </label><label>{{$value['description']}}</label></p>
                            <p class="card-text">  <label>Member: &#160 </label>
                                <input type='text'
                                       placeholder='Member'
                                       class='flexdatalist'
                                       data-min-length='2'
                                       data-search-disabled='1'
                                       multiple=''
                                       data-selection-required='1'
                                       list='languages'
                                       name='language_search_disabled' style="border: solid 1px" value="">
                                {{--<input type='text'--}}
                                       {{--placeholder='Member'--}}
                                       {{--class='flexdatalist'--}}
                                       {{--data-min-length='1'--}}
                                       {{--multiple='multiple'--}}
                                       {{--list='languages'--}}
                                       {{--name='member[]' style="border: solid 1px" value="{{$value['groupName']}}">--}}

                                <datalist id="languages">
                                    @foreach($accounts as $account)
                                    <option value="">{{$account['lastName']}}</option>
                                    @endforeach
                                </datalist>

                            </p>
                            {{--<input name="id_group" value="{{$value['groupId']}}">--}}
                            <a href="" data-toggle="modal" data-target="#login-modal" class="btn btn-primary stretched-link" name="AddMember">Add member</a>
                            <a href="#" class="btn btn-primary stretched-link">Create Exam</a>
                            <a href="#" class="btn btn-primary stretched-link">Delete Group</a>
                        </div>
                    </div>



                </div>
            <script>
                $('.flexdatalist').flexdatalist({
                    minLength: 1
                });
            </script>
        @endforeach


        </div>

        {{--<div id ="add">11</div>--}}


        <script>
            $(document).ready(function () {
                var i = 2;
                $("#btn2").click(function () {

                    $("#add").append(" <div class=\"col-lg-4 \" >\n" +
                        "\n" +
                        "            <h3 class=\"text-center\" style=\"color: black;margin-top: 10px\">Question " + (i++) + "</h3>\n" +
                        "            <div class=\"panel-body\" style=\"margin-top: 1px\">\n" +
                        "                    <div class=\"form-group\" style=\"margin-top: 1px;margin-bottom: 5px\">\n" +
                        "                        <label>MP3</label>\n" +
                        "                        <input type=\"file\" class=\"form-control\" name=\"mp3[]\" required=\"mp3\"/>\n" +
                        "                    </div>\n" +
                        "                    <div class=\"form-group\" style=\"margin-top: 1px;margin-bottom: 5px\">\n" +
                        "                        <label>Image</label>\n" +
                        "                        <input type=\"file\" class=\"form-control\" name=\"images[]\" required=\"image\"/>\n" +
                        "                    </div>\n" +
                        "\n" +
                        "                    <div class=\"form-group\" style=\"margin-top: 1px;margin-bottom: 5px\" id=\"answer\">\n" +
                        "\n" +
                        "                        <label>Correct Answer </label>\n" +
                        "                        <div>\n" +
                        "                            <input class=\"form-control\" name=\"correct_answer[]\"\n" +
                        "                                   placeholder=\"Please Enter Correct Answer\" required=\"text\"/>\n" +
                        "\n" +
                        "\n" +
                        "                        </div>\n" +
                        "\n" +
                        "                            </div>\n");
                });
                $('.flexdatalist').flexdatalist({
                    selectionRequired: 1,
                    minLength: 1
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
    <form action="{{route('add_member')}}" method="post">
        @csrf

        <div class="modal fade" id="login-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="margin-top: 150px"  aria-hidden="false" data-backdrop="false">
            <div class="modal-dialog">
                <div class="loginmodal-container">
                    <div class="row">
                        <div class="col-md-10 col-md-offset-2">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <div class="text-center">
                                        <h2 class="text-center" style="color: black">Add Member</h2>
                                        <div class="panel-body">
                                            <form id="register-form" role="form" autocomplete="off" class="form"
                                                  method="post">
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <label>Member:  </label>
                                                        <input type='text'
                                                               placeholder='Members'
                                                               class='flexdatalist'
                                                               data-min-length='1'
                                                               data-search-disabled='1'
                                                               multiple=''
                                                               data-selection-required='1'
                                                               list='members'
                                                               name='language_search_disabled'>

                                                            <datalist id="members[]">
                                                                @foreach($accounts as $account)
                                                                    <option value="PHP">{{$account['lastName']}}</option>
                                                                @endforeach
                                                            </datalist>


                                                    </div>
                                                    <div type="hidden" class="alert-warning"
                                                         style="color: red;">{{$errors->first('emailaddress')}}</div>
                                                </div>
                                                <div class="form-group">
                                                    <input name="recover-submit"
                                                           class="btn btn-lg btn-primary btn-block"
                                                           value="Add Member" data-toggle="modal"
                                                           data-target="#myModal"
                                                           type="submit">
                                                </div>
                                               <script>
                                                   $('.flexdatalist').flexdatalist({
                                                       selectionRequired: 1,
                                                       searchDisabled: 1,
                                                       minLength: 1
                                                   });
                                               </script>
                                                {{--<script>--}}
                                                    {{--$('#members').select2({--}}
                                                        {{--placeholder: "Choose tags...",--}}
                                                        {{--minimumInputLength: 2,--}}
                                                        {{--ajax: {--}}
                                                            {{--url: '/tags/find',--}}
                                                            {{--dataType: 'json',--}}
                                                            {{--data: function (params) {--}}
                                                                {{--return {--}}
                                                                    {{--q: $.trim(params.term)--}}
                                                                {{--};--}}
                                                            {{--},--}}
                                                            {{--processResults: function (data) {--}}
                                                                {{--return {--}}
                                                                    {{--results: data--}}
                                                                {{--};--}}
                                                            {{--},--}}
                                                            {{--cache: true--}}
                                                        {{--}--}}
                                                    {{--});--}}
                                                {{--</script>--}}
                                            </form>

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


