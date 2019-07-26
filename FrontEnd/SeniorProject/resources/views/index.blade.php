<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
    <title>Home</title>

</head>
<body>
<nav class="navbar navbar-light" style="background-color: #e3f2fd;>đi ăn ơm
    <div class="container-fluid">
        <div class="navbar-header" style="margin-right: 50px">
            <a href=""><img src="{{'images/logo.png'}}" style="width: 50px;height: 50px;margin:auto 0px"></a>
        </div>
        <ul class="nav navbar-nav">
            <li class="active"><a href="#">Home</a></li>
            <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">Group <span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li><a href="#">Page 1-1</a></li>
                    <li><a href="#">Page 1-2</a></li>
                    <li><a href="#">Page 1-3</a></li>
                </ul>
            </li>
            <li><a href="#">Page 2</a></li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
            <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#"><span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li><a href="#">Manager Account</a></li>
                    {{--<li><a href="#">Page 1-2</a></li>--}}
                    {{--<li><a href="#">Page 1-3</a></li>--}}
                </ul>
            </li>
            {{--<li><a href="#"><span class="glyphicon glyphicon-user"></span> User Name</a></li>--}}
            <li><a href="#"><span class="glyphicon glyphicon-bell"></span> Notification</a></li>
            <li><a href="{{route('login')}}"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
        </ul>
    </div>
</nav>


    @yield('content')


</body>
</html>
