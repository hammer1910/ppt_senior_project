<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Admin - Walter</title>

    <!-- Bootstrap Core CSS -->
    <link href="{{ url('admin/bower_components/bootstrap/dist/css/bootstrap.min.css')}}" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="{{ url('admin/bower_components/metisMenu/dist/metisMenu.min.css')}}" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="{{ url('admin/dist/css/sb-admin-2.css')}}" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="{{ url('admin/bower_components/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet" type="text/css">

    <!-- DataTables CSS -->
    <link href="{{ url('admin/bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css')}}" rel="stylesheet">

    <!-- DataTables Responsive CSS -->
    <link href="{{ url('admin/bower_components/datatables-responsive/css/dataTables.responsive.css')}}" rel="stylesheet">
    <link rel="shortcut icon" type="image/png" href="{{url('images/icon.png')}}"/>
    <link rel="stylesheet" href="{{asset('css/sidebar.css')}}">
    <script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
    <link href="{{url('js/jquery.flexdatalist.min.css')}}" rel="stylesheet" type="text/css">
    <script src="{{url('js/jquery.flexdatalist.min.js')}}"></script>
    <link href="http://projects.sergiodinislopes.pt/flexdatalist/src/jquery.flexdatalist.css?1.8.5" rel="stylesheet" type="text/css">
</head>

<body>

<div id="wrapper">

    <!-- Navigation -->
    <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0; height: auto; background-color: #31b0d5">

        <div class="navbar-header">
            <a href="#" class="btn btn-success" id="menu-toggle" style="margin-top: 8px;margin-left: 14px"><i class="fa fa-align-left"></i></a>
        </div>
        <!-- /.navbar-header -->
    </nav>
    <div id="sidebar-wrapper">
        <div class="navbar-default sidebar" style="margin-top: 0px;">
            <div class="image" style="width: 250px;height: 100px;text-align: center; background-color: #a6e1ec"  >
                <div class="app-sidebar__user"><img class="app-sidebar__user-avatar" src="{{url('images/user_profile.png')}}" alt="User Image">
                </div>
                <label for="fullname"><b>{{session()->get('lastname')}}</b></label>
            </div>
            <div class="sidebar-nav navbar-collapse">

                <ul class="nav" id="side-menu">
                    <li>
                        <a href="#" style="color: black"><i class="fa fa-user fa-fw"></i> User<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                 <a href="{{route('manager.user.profile')}}" style="color: black">Profile</a>
                            </li>
                            <li>
                                <a href="{{route('manager.user.pass')}}" style="color: black">Change Password</a>
                            </li>
                             <li>
                                 <a href="{{route('logout')}}" style="color: black">Logout</a>
                             </li>
                        </ul>
                    {{--<li>--}}
                        {{--<a href="#" style="color: black"><i class="fa fa-group fa-fw"></i> Group<span class="fa arrow"></span></a>--}}
                        {{--<ul class="nav nav-second-level">--}}
                    {{--<li>--}}
                        {{--<a href="{{route('manager.user.create')}}" style="color: black">Create Group</a>--}}
                    {{--</li>--}}
                        {{--</ul>--}}
                    {{--</li>--}}
                    {{--<li>--}}
                        {{--<a href="#" style="color: black"><i class="fa fa-adjust fa-fw"></i> Do Exam<span class="fa arrow"></span></a>--}}
                        {{--<ul class="nav nav-second-level">--}}


                            {{--<li>--}}
                                {{--<a href="{{route('question_part1')}}" target="_blank" style="color: black">Part 1</a>--}}
                            {{--</li>--}}
                        {{--</ul>--}}
                    {{--</li>--}}
                    {{--<li>--}}
                            {{--<a href="#" style="color: black"><i class="fa fa-upload fa-fw"></i> Upload<span class="fa arrow"></span></a>--}}
                            {{--<ul class="nav nav-second-level">--}}
                                {{--<li>--}}
                                    {{--<a href="{{route('upload.upload1',$id)}}" style="color: black">Part 1</a>--}}
                                {{--</li>--}}
                                {{--<li>--}}
                                    {{--<a href="{{route('upload.upload2',$id)}}" style="color: black">Part 2</a>--}}
                                {{--</li>--}}
                                {{--<li>--}}
                                    {{--<a href="{{route('upload.upload3',$id)}}" style="color: black">Part 3</a>--}}
                                {{--</li>--}}
                                {{--<li>--}}
                                    {{--<a href="{{route('upload.upload4',$id)}}" style="color: black">Part 4</a>--}}
                                {{--</li>--}}
                                {{--<li>--}}
                                    {{--<a href="{{route('upload.upload5',$id)}}" style="color: black">Part 5</a>--}}
                                {{--</li>--}}
                                {{--<li>--}}
                                    {{--<a href="{{route('upload.upload6',$id)}}" style="color: black">Part 6</a>--}}
                                {{--</li>--}}
                                {{--<li>--}}
                                    {{--<a href="{{route('upload.upload7',$id)}}" style="color: black">Part 7</a>--}}
                                {{--</li>--}}
                                {{--<li>--}}
                        {{--<a href="{{route('upload.upload',$id)}}" style="color: black">Part 3</a>--}}
                    {{--</li>--}}
                    {{--<li>--}}
                        {{--<a href="{{route('upload.upload',$id)}}" style="color: black">Part 4</a>--}}
                    {{--</li>--}}
                    {{--<li>--}}
                        {{--<a href="{{route('upload.upload',$id)}}" style="color: black">Part 5</a>--}}
                    {{--</li>--}}
                    {{--<li>--}}
                        {{--<a href="{{route('upload.upload',$id)}}" style="color: black">Part 6</a>--}}
                    {{--</li>--}}
                    {{--<li>--}}
                        {{--<a href="{{route('upload.upload',$id)}}" style="color: black">Part 7</a>--}}
                    {{--</li>--}}
                {{--</ul>--}}
                {{--<!-- /.nav-second-level -->--}}
                {{--</li>--}}
                </ul>
                </li>
            </div>
            <!-- /.sidebar-collapse -->
        </div>
        <!-- /.navbar-static-side -->
    </div>


    <!-- Page Content -->
    <div id="page-content-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">

                </div>
                @yield('content')
            </div>
        </div>

        <!--Eng day la noi chua noi dung -->
        <!-- /.row -->
        <!--        </div>-->
        <!-- /.container-fluid -->
        <!--    </div>-->
        <!-- /#page-wrapper -->

    </div>

    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="{{ url('admin/bower_components/jquery/dist/jquery.min.js')}}"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="{{ url('admin/bower_components/bootstrap/dist/js/bootstrap.min.js')}}"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="{{ url('admin/bower_components/metisMenu/dist/metisMenu.min.js')}}"></script>

    <!-- Custom Theme JavaScript -->
    <script src="{{ url('admin/dist/js/sb-admin-2.js')}}"></script>

    <!-- DataTables JavaScript -->
    <script src="{{ url('admin/bower_components/DataTables/media/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{ url('admin/bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js')}}"></script>
    <script src="{{ url('admin/dist/js/myScript.js')}}"></script>
    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>

    </script>
</div>
<script>

    $("#menu-toggle").click(function (e) {
        e.preventDefault();
        $("#wrapper").toggleClass("menuDisplayed");
    })
</script>
</body>

</html>
