<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="_token" content="{{ csrf_token() }}">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <link href="{{ url('admin/bower_components/bootstrap/dist/css/bootstrap.min.css')}}" rel="stylesheet">

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
    {{--<link rel="stylesheet" href="{{asset('css/sidebar.css')}}">--}}
    <script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
    <link href="http://projects.sergiodinislopes.pt/flexdatalist/src/jquery.flexdatalist.css?1.8.5" rel="stylesheet"
          type="text/css">
    <!--ThemeFlat-->
    {{--<link rel="shortcut icon" href="{{url('assets/img/favicon.ico')}}" type="image/x-icon">--}}

    <!-- Font awesome -->
    <link href="{{url('assets/css/font-awesome.css')}}" rel="stylesheet">
    <!-- Bootstrap -->
    <link href="{{url('assets/css/bootstrap.css')}}" rel="stylesheet">
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
            <a href=""><img src="{{ URL::to('/') }}/images/logo.png" style="width: 50px;height: 50px;margin:auto 0px"></a>
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
        <div class="sidebar-nav sidebar-collapse">
            <ul class="nav" id="side-menu">
                <li >
                    <a href="{{route('group_ID')}}" style="color: black"><i class="fa fa-group fa-fw"></i> Group<span
                            class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li>
                            <a href="{{route('createGroup')}}" style="color: black">Create Group</a>
                        </li>
                        <li >
                            <a href="{{route('listGroup')}}" style="color: black">Manage Group</a>
                        </li>
                        <li class="active">
                            <a href="" style="color: black">List Group
                                <span class="fa arrow"></span></a>
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
                <li>
                    <a href="#" style="color: black"><i class="fa fa-user fa-fw"></i> Manage Account<span class="fa arrow"></span></a>
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
        <div class="row" id="content" style="background-color: white;">
            <a class="scrollToTop" href="#">
                <i class="fa fa-angle-up"></i>
            </a>
            <!-- END SCROLL TOP BUTTON -->
            <!-- Start Slider -->
            <section id="mu-slider">
                <!-- Start single slider item -->
                <div class="mu-slider-single">
                    <div class="mu-slider-img">
                        <figure>
                            <img src="{{url('assets/img/slider/1.jpg')}}" alt="img">
                        </figure>
                    </div>
                    <div class="mu-slider-content">
                        <h4>Welcome To Let's TOEIC</h4>
                        <span></span>
                        <h2>All You Need To Know About TOEIC</h2>
                        <p>TOEIC stands for “Test of English for International Communication” .
                            It tests an individual’s proficiency in professional/business English.
                            This standardised test is administered by Educational Testing Services (ETS),
                            the same organization that administers the GRE and TOEFL.</p>


                    </div>
                </div>
                <!-- Start single slider item -->
                <!-- Start single slider item -->
                <div class="mu-slider-single">
                    <div class="mu-slider-img">
                        <figure>
                            <img src="{{url('assets/img/slider/2.jpg')}}" alt="img">
                        </figure>
                    </div>
                    <div class="mu-slider-content">
                        <h4>Welcome To Let's TOEIC</h4>
                        <span></span>
                        <h2>English language is the key to success</h2>
                        <p>The most optimum route to the zenith of success revolves across the English language.
                            With 335 million speakers throughout the world,
                            English as a language plays a vital role in the daily chores of life improving the career prospects.
                            Several scientists who have studied the language have explained that speaking any foreign language is good for the brain.</p>

                    </div>
                </div>
                <!-- Start single slider item -->
                <!-- Start single slider item -->
                <div class="mu-slider-single">
                    <div class="mu-slider-img">
                        <figure>
                            <img src="{{url('assets/img/slider/3.jpg')}}" alt="img">
                        </figure>
                    </div>
                    <div class="mu-slider-content">
                        <h4>Welcome To Let's TOEIC</h4>
                        <span></span>
                        <h2>Do you know why learning English is so important?</h2>
                        <p>Learning English is important and people all over the world decide to study it as a second language.
                            Many countries include English as a second language in their school syllabus and children start learning English at a young age.</p>

                    </div>
                </div>
                <!-- Start single slider item -->
            </section>
            <!-- End Slider -->
            <!-- Start service  -->
            <section id="mu-service">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12 col-md-12">
                        </div>
                    </div>
                </div>
            </section>
            <!-- End service  -->

            <!-- Start about us -->
            <section id="mu-about-us">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mu-about-us-area">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6">
                                        <div class="mu-about-us-left">
                                            <!-- Start Title -->
                                            <div class="mu-title">
                                                <h2>About Us</h2>
                                            </div>
                                            <!-- End Title -->
                                            <p>This application provides an environment for everyone who wants
                                                to learn and practice in English. In this application, they
                                                can do a TOEIC test which uploaded by someone in the friend
                                                group, given their own answer for that test. They can discuss in
                                                the group, upload any related files (pdf, images, mp3) and compare
                                                their answer to someone in that group.</p>
                                            <ul>
                                                <li>Canh (Adam) V. TRUONG</li>
                                                <li>Vuong (Walter) K. TRAN</li>
                                                <li>Thuc (Ronald) D. NGUYEN</li>
                                            </ul>

                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <div class="mu-about-us-right">
                                            <a id="mu-abtus-video" href="https://www.youtube.com/embed/HN3pm9qYAUs" target="mutube-video">
                                                <img src="{{url('assets/img/about-us.jpg')}}" alt="img">
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- End about us -->

            <!-- jQuery library -->
            <script src="{{url('assets/js/jquery.min.js')}}"></script>
            <!-- Include all compiled plugins (below), or include individual files as needed -->
            <script src="{{url('assets/js/bootstrap.js')}}"></script>
            <!-- Slick slider -->
            <script type="text/javascript" src="{{url('assets/js/slick.js')}}"></script>
            <!-- Counter -->
            <script type="text/javascript" src="{{url('assets/js/waypoints.js')}}"></script>
            <script type="text/javascript" src="{{url('assets/js/jquery.counterup.js')}}"></script>
            <!-- Mixit slider -->
            <script type="text/javascript" src="{{url('assets/js/jquery.mixitup.js')}}"></script>
            <!-- Add fancyBox -->
            <script type="text/javascript" src="{{url('assets/js/jquery.fancybox.pack.js')}}"></script>


            <!-- Custom js -->
            <script src="{{url('assets/js/custom.js')}}"></script>

        </div>
    </div>
<!-- /#wrapper -->

<!-- jQuery -->
        {{--<script src="{{ url('admin/bower_components/jquery/dist/jquery.min.js')}}"></script>--}}
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
    </div>
</body>
</html>
