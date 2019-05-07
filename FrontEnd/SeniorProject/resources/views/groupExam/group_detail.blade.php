@extends('Home_Master')
@section('content')
    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="_token" content="{{ csrf_token() }}">

    {{--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>--}}
    {{--<script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>--}}
    {{--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>--}}
    {{--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>--}}
    {{--<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>--}}
    {{--<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">--}}
    {{--<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>';--}}
    @if (session('message'))
        <div class="alert alert-success" style="text-align: center; font-size: large">
            <strong>Success!</strong> {{session('message')}}
        </div>
    @endif
        <ul class="nav nav-tabs" id="myTab">
            <li class="active"><a  href="#home" data-toggle="tab">Exam</a></li>
            <li><a  href="#menu1" data-toggle="tab">Member</a></li>
            {{--@if (session('user_id')== $listExams['ownerId'])--}}
            {{----}}
                {{--@endif--}}
        </ul>
    <script type="text/javascript">
        $(document).ready(function(){

            $('a[data-toggle="tab"]').on('show.bs.tab', function(e) {
                localStorage.setItem('activeTab1', $(e.target).attr('href'));
            });
            var activeTab = localStorage.getItem('activeTab1');

            if(activeTab) {
                $('#myTab a[href="' + activeTab + '"]').tab('show');
            }

        });
    </script>
</head>

    <div class="tab-content" style="margin-left: 20px">

        <div id="home" class="tab-pane fade in active">
            <h3 style="text-align: center">Exam</h3>
            @if (session('user_id')== $listExams['ownerId'])
            <button type="button" class="btn btn-success"  data-toggle="modal" data-target="#login" style="float: right; margin-bottom: 10px">Create Exam</button>
           @endif
                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                <thead>
                <tr align="center">
                    <th style="text-align: center">Name Exam</th>
                    <th style="text-align: center">Action</th>
                </tr>
                </thead>
                @foreach($listExams['examResults'] as $listExam)
                    <tbody>
                    <tr class="odd gradeX" align="center">
                        <td>{{$listExam['name']}}</td>
                        <td class="center">
                            @if($listExam['status']=='Do Exam')
                                <a href="{{URL::to('/listQuestionPart1')}}/{{$listExam['examId']}}" id="{{$listExam['examId']}}"
                                   class="doExam btn btn-success"> Do Exam</a>
                            @endif
                            @if($listExam['status']=='Continue Do Exam')
                                <a href="{{URL::to('/listQuestionPart1')}}/{{$listExam['examId']}}" id="{{$listExam['examId']}}"
                                   class="doExam btn btn-primary">Continue</a>
                            @endif
                            @if($listExam['status']=='Finish')
                                <a href="{{ URL::to('/') }}/examID/{{$listExam['examId']}}" id="{{$listExam['examId']}}"
                                   class="compare btn btn-info">Compare</a>
                            @endif

                            @if (session('user_id')== $listExams['ownerId'])
                                <input value="{{$listExam['examId']}}" name="examId" style="display: none">
                                <a href="{{URL::to('') }}/upload/{{$listExam['examId']}}" id="{{$listExam['examId']}}"  class="action btn btn-success" >Upload
                                    <i class="fa fa-upload"></i></a>
                                </a>
                            @endif
                                @if (session('user_id')== $listExams['ownerId'])
                                <button id="{{$listExam['examId']}}" type="button" value="Delete" class="deleteExam btn btn-danger" > Delete
                                    <i class="fa fa-trash"></i></button>
                                    @endif
                        </td>
                    </tr>
                    </tbody>
                @endforeach
            </table>
            <script>
                $("button.deleteExam").click(function() {
                    var examId = $(this).attr('id');
                    var x = confirm("Do you want to delete this exam?");
                    if (x) {
                        deleteExam(examId);
                    }
                    else
                        return false;
                });
                function deleteExam(examId) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                        }
                    });
                    $.ajax({
                        method: 'DELETE',
                        dataType: 'json',
                        url: '{!! url('/deleteExam')!!}' + '/' + examId,
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

            <form action="{{route('createExam')}}" method="post" enctype="multipart/form-data">
                @csrf

                <div class="modal fade" id="login" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false" style="display: none;margin-top: 80px"data-backdrop="false">
                    <div class="modal-dialog">
                        <div class="loginmodal-container">
                            <div class="row">
                                <div class="col-md-10 col-md-offset-3">
                                    <div class="panel panel-default" style="border: 3px solid #f1f1f1">
                                        <div class="panel-body">
                                            <div class="text">
                                                <h2 class="text-center" style="color: black">Create Exam <button type="button" class="close" data-dismiss="modal">X</button></h2>
                                                <div class="panel-body">
                                                    <form  id="register-form" role="form" autocomplete="off" class="form" method="post" >
                                                        <div class="form-group">
                                                            <label>Exam</label>
                                                            <input type="text" class="form-control" name="groupID" value="{{$groupId}}" style="display: none"  />
                                                                <label>Name</label>
                                                                <input type="text" class="form-control" name="examName"   />
                                                        </div>

                                                        <button type="submit" class="btn btn-success" style="display: block; margin: auto;">Create</button>
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
            </form>
        </div>
        <div id="menu1" class="tab-pane fade" style="margin-left: 20px">
            <h3 style="text-align: center">List Member</h3>
            {{--<a href=""  id="addMembers"  class="action btn btn-success" data-toggle="modal" data-target="#addMembers"style="float: right; margin-bottom: 10px"> Add Members </a>--}}
            @if (session('user_id')== $listExams['ownerId'])
            <button type="button" class="btn btn-success"  id="adds" data-toggle="modal" data-target="#addMembers" style="float: right; margin-bottom: 10px">Add Member</button>
            @endif
            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                <thead>
                <tr align="center">
                    <th style="text-align: center">Email</th>
                    <th style="text-align: center">Full Name</th>
                    @if (session('user_id')== $listExams['ownerId'])
                    <th style="text-align: center">Action</th>
                        @endif
                </tr>
                </thead>
                @foreach($members as $member)
                    <tbody>
                        <tr class="odd gradeX" align="center">
                            <td>{{$member['email']}}</td>
                            <td>{{$member['fullName']}}</td>
                            @if (session('user_id')== $listExams['ownerId'])
                            <td class="center">

                                <button id="{{$member['accountId']}}" type="button" value="Delete" class="deleteMember btn btn-danger" > Delete
                                    <i class="fa fa-trash"></i></button>
                            </td>
                                @endif
                        </tr>
                    </tbody>
                @endforeach
                <script>
                    $("a.compare").click(function() {
                        var examID = $(this).attr('id');
                        getExamID(examID)

                    });
                    function getExamID(examID) {
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                            }
                        });
                        $.ajax({
                            method: 'get',
                            dataType: 'json',
                            url: '{!! url('/examID')!!}' + '/' + examID,
                            success: function (data) {
                                console.log(data);
                            },
                            error: function (e) {
                                console.log(e.message);
                            }
                        });
                    }
                </script>
                <script>

                    $("a.doExam").click(function() {
                        var examId = $(this).attr('id');
                        getQuestionPart1(examId)

                    });
                    function getQuestionPart1(examId) {
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                            }
                        });
                        $.ajax({
                            method: 'get',
                            dataType: 'json',
                            url: '{!! url('/listQuestionPart1')!!}' + '/' + examId,
                            success: function (data) {
                                alert(data.status);
                            },
                            error: function (e) {
                                console.log(e.message);
                            }
                        });
                    }

                </script>
                <script>
                    $("button.deleteMember").click(function() {
                        var memberId = $(this).attr('id');
                        var x = confirm("Do you want to delete this member?");
                        if (x) {
                            deleteMember(memberId);
                        }
                        else
                            return false;
                    });
                    function deleteMember(memberId) {
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                            }
                        });
                        $.ajax({
                            method: 'DELETE',
                            dataType: 'json',
                            url: '{!! url('/deleteMember')!!}' + '/' + memberId,
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
            </table>
            <form action="{{route('addMember')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal" id="addMembers" data-backdrop="false" style="margin-top: 80px">
                    <div class="modal-dialog">
                        <div class="row">
                            <div class="col-md-12 col-md-offset-2">
                        <div class="modal-content" style="border: 3px solid #f1f1f1">
                            <!-- Modal Header -->

                                    <div class="modal-header">
                                        <h4 class="modal-title" align="center">Add Member
                                            <button type="button" class="close" data-dismiss="modal">X</button></h4>

                                    </div>
                                    <div class="modal-body">
                                        <div style="margin-bottom: 20px; margin-left: 100px;">
                                            <input id="accountId" name="accountId" hidden>
                                            <input type="text" id="username" name="username" placeholder="Enter user name..." style="margin-right: 30px;height: 35px;border-radius: 5px;"  required>
                                            <button type="button" id="search" class="btn btn-primary">Search</button>
                                        </div>
                                        <table class="table table-bordered"  >
                                            <thead>
                                            <tr >
                                                <th style="text-align: center">User Name</th>
                                                <th style="text-align: center">Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <script>
            //Default load part 1
            $( document ).ready(function() {
            });

            $('#search').on('click', function () {
                var userName = $('#username').val();
                console.log('Search member:  ' +userName);
                searchMember(userName);
                console.log('Search Ok ' );
            });
            function searchMember(userName) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });
                $.ajax({
                    method: 'GET',
                    dataType: 'json',
                    url:'{!! url('/searchMember')!!}'+'/'+userName,
                    success: function(data){
                        var tablePart1 = $('#addMembers').find('table');
                        tablePart1.attr('data-has-data', true);
                        var trData = '';
                        var i;
                        for (i = 0; i < data.length; i++) {
                            trData += '<tr class="odd gradeX" align="center">\n' +
                                '                        <td>' + data[i]['fullName'] + '</td>\n' +
                                '                        <td class="center">\n' +
                                '                            <button  type="submit" class="Add btn btn-success" id= ' + data[i]['accountId'] + ' data-toggle="modal" data-target="#editQuestion"  > Add\n' +
                                '                                <i class="fa fa-plus"></i></button  >\n' +
                                '                        </td>\n' +
                                '                    </tr>'
                        }
                        tablePart1.find('tbody').html(trData);
                        $('button.Add').on('click', function () {
                            var accountId = $(this).attr('id');
                            $('#accountId').val(accountId);
                        });

                    },
                    error: function(e){
                    }
                });
            }
        </script>

    </div>
@endsection()


