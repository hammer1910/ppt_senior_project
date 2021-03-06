<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="_token" content="{{ csrf_token() }}">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    {{--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">--}}
    {{--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>--}}
    {{--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>--}}
    {{--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">--}}
    {{--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>--}}
    {{--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>--}}
    {{--<link href="{{ url('admin/bower_components/bootstrap/dist/css/bootstrap.min.css')}}" rel="stylesheet">--}}

    <!-- MetisMenu CSS -->
    <link href="{{ url('admin/bower_components/metisMenu/dist/metisMenu.min.css')}}" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="{{ url('admin/dist/css/sb-admin-2.css')}}" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="{{ url('admin/bower_components/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet"
          type="text/css">

    <!-- DataTables CSS -->
    <link href="{{ url('admin/bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css')}}"
          rel="stylesheet">

    <!-- DataTables Responsive CSS -->
    <link href="{{ url('admin/bower_components/datatables-responsive/css/dataTables.responsive.css')}}"
          rel="stylesheet">
    <link rel="shortcut icon" type="image/png" href="{{url('images/icon.png')}}"/>
    <link href="{{url('assets/css/font-awesome.css')}}" rel="stylesheet">
    {{--<link rel="stylesheet" href="{{asset('css/sidebar.css')}}">--}}
    {{--<script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>--}}
    <link href="{{url('js/jquery.flexdatalist.min.css')}}" rel="stylesheet" type="text/css">
    <script src="{{url('js/jquery.flexdatalist.min.js')}}"></script>
    <link href="http://projects.sergiodinislopes.pt/flexdatalist/src/jquery.flexdatalist.css?1.8.5" rel="stylesheet"
          type="text/css">
    {{--<script src="{{ url('admin/bower_components/jquery/dist/jquery.min.js')}}"></script>--}}
    {{--<script src="http://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>--}}
    <script
        src="https://code.jquery.com/jquery-1.12.4.min.js"
        integrity="sha256-ZosEbRLbNQzLpnKIkEdrPv7lOy9C27hHQ+Xp8a4MxAQ="
        crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    {{--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>--}}
    {{--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>--}}
{{--<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>--}}
    <!-- Font awesome -->
    <link href="{{url('assets/css/font-awesome.css')}}" rel="stylesheet">
    <!-- Bootstrap -->
    {{--<link href="{{url('assets/css/bootstrap.css')}}" rel="stylesheet">--}}
    <!-- Slick slider -->
    <link rel="stylesheet" type="text/css" href="{{url('assets/css/slick.css')}}">
    <!-- Fancybox slider -->
    <link rel="stylesheet" href="{{url('assets/css/jquery.fancybox.css')}}" type="text/css" media="screen" />
    <!-- Theme color -->
    <link id="switcher" href="{{url('assets/css/theme-color/default-theme.css')}}" rel="stylesheet">

    <!-- Main style sheet -->
    <link href="{{url('assets/css/style.css')}}" rel="stylesheet">
    <!-- Google Fonts -->
    <link href='https://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,400italic,300,300italic,500,700' rel='stylesheet' type='text/css'>

</head>
<body>
<nav class="navbar-light" style="background-color: #e3f2fd;position: sticky">
    <div class="container-fluid">
        <div class="navbar-header" style="margin-right: 50px">
            <a href=""><img src="{{ URL::to('/') }}/images/LogoToeic.png" style="width: 50px;height: 50px;margin:auto 0px;margin-left: 20px;"></a>
        </div>
        <ul class="nav navbar-nav">
            <li class="active"><a href="{{route('home')}}">Home</a></li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
            <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown"
                                    href="#"></a>
            </li>
            <li><a href="{{route('logout')}}"><span class="glyphicon glyphicon-log-in"></span> Log out</a></li>
        </ul>
    </div>
</nav>
<div id="wrapper" style="margin-top: 0px">
    <!-- Navigation -->
    <div class="navbar-default sidebar" role="navigation" style="margin-top: 0px">
        <div class="image" style="width: 250px;height: 100px;text-align: center; background-color: #a6e1ec"  >
            <div class="app-sidebar__user"><img class="app-sidebar__user-avatar" style="margin-top: 5px" src="{{url('images/user_profile.png')}}" alt="User Image">
            </div>
            <label for="fullname"><b>{{session('fullName')}}</b></label>
        </div>
        <div class="sidebar-nav navbar-collapse">
            <ul class="nav" id="side-menu">
                <li class="active">
                    <a href="{{route('group_ID')}}" style="color: black"><i class="fa fa-group fa-fw"></i> Group<span
                            class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse in">
                        <li >
                            <a href="{{route('createGroup')}}"style="color: black">Create Group</a>
                        </li>
                        <li >
                            <a href="{{route('listGroup')}}" style="color: black" class="manageGroup">Manage Group</a>
                        </li>

                        <li >
                            <a href=""style="color: black">List Group<span
                                    class="fa arrow"></span></a>
                            <ul class="nav nav-third-level" style="overflow: hidden;">
                                @foreach($listGroups as $value)
                                    <li>
                                        <a href="{{ URL::to('/') }}/groupDetail/{{$value['groupId']}}" class="group_exam" style="color: black"
                                           id="{{$value['groupId']}}" name="{{$value['groupName']}}"><i class="fa">{{$value['groupId']}}</i>  - {{$value['groupName']}}</a>
                                    </li>
                                    <script>
                                        $("a.group_exam").click(function () {
                                            var id = $(this).attr('id');
                                            var id = $("{{$value['groupId']}}").attr("id")
                                            $.ajaxSetup({
                                                headers: {
                                                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                                                }
                                            });
                                            $.ajax({
                                                method: 'POST',
                                                dataType: 'json',
                                                url: "{{ url('/createExam') }}",
                                                data: {"groupId": id},
                                                success: function (data) {
                                                    console.log("ID: " + data);
                                                },
                                                error: function (e) {
                                                    console.log(e.message);
                                                }
                                            });
                                        });
                                    </script>
                                @endforeach
                            </ul>
                        </li>

                    </ul>
                </li>
                @if (session('role')=="Admin")
                <li>
                    <a href="{{route('admin')}}" style="color: black"><i class="fa fa-list fa-fw"></i> List User</a>

                </li>
                @endif
                <li>
                    <a href="#" style="color: black"><i class="fa fa-user fa-fw"></i> Manage Profile<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li>
                            <a href="{{route('manager.user.profile')}}" style="color: black">Profile</a>
                        </li>
                        <li>
                            <a href="{{route('manager.user.pass')}}" style="color: black">Change Password</a>
                        </li>
                    </ul>
                    <!-- /.nav-second-level -->
                </li>
            </ul>
        </div>
    </div>
    <!-- Page Content -->
    <div id="page-wrapper">
        <div class="col-lg-12">
        </div>
        <div class="row" id="content" style="background-color: white;">

            @yield('content')
        </div>
    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->

    <!-- Bootstrap Core JavaScript -->
    <script src="{{ url('admin/bower_components/bootstrap/dist/js/bootstrap.min.js')}}"></script>
    <!-- Metis Menu Plugin JavaScript -->
    <script src="{{ url('admin/bower_components/metisMenu/dist/metisMenu.min.js')}}"></script>
    <!-- Custom Theme JavaScript -->
    <script src="{{ url('admin/dist/js/sb-admin-2.js')}}"></script>
    <!-- DataTables JavaScript -->
    <script src="{{ url('admin/bower_components/DataTables/media/js/jquery.dataTables.min.js')}}"></script>
    <script
        src="{{ url('admin/bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js')}}"></script>
    <script src="{{ url('admin/dist/js/myScript.js')}}"></script>
    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
    </script>

    <script>
        $("#menu-toggle").click(function (e) {
            e.preventDefault();
            $("#wrapper").toggleClass("menuDisplayed");
        })
    </script>
</div>
</body>
</html>
