
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
    <link rel="shortcut icon" type="image/png" href="{{'images/icon.png'}}"/>
    <link rel="stylesheet" href="{{'css/loginn.css'}}">
    <script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
    <title>Login</title>
</head>
<body>
    <H1>LET'S TOEIC</H1>
<form action="{{route('login')}}" method="post">
    @csrf
    <div class="container">

            <h2>Login</h2>
            <div class="form-group">
                <label for="email"><b>Email</b></label>
                <input type="text"  placeholder="Enter Your Email" name="email" >
                <div type="hidden" class="alert-warning" >{{$errors->first('email')}}</div>

            </div>
            <div class="form-group">
                <label for="password"><b>Password</b></label>
                <input type="password" placeholder="Enter Your Password" name="password">
                <div type="hidden" class="alert-warning" >{{$errors->first('password')}}</div>
            </div>
            <div class="forgetpass">
                <ul>
                    <li>
                        <a href="#"  data-toggle="modal" data-target="#login-modal">Forgot password?</a>
                    </li>
                </ul>
            </div>
            <button class="login" type="submit" name="login" >Login</button>
            <a href="{{ url('register') }}" class="register" role="button" style="text-decoration: none;color: white">Register</a>
        @if (session('messaerror'))

        <div type="hidden" class="alert-warning" style="text-align: center" >{{session('messaerror')}}<div>
        @endif
                @if (session('message'))
                    <div type="hidden" class="alert-warning" style="text-align: center;size: legal" >{{session('message')}}
                        <div>
                            @endif
    </div>
                    </div>
            </div>
        </div>
    </div>

</form>

    <form action="{{route('forgotpass')}}" method="post">
        @csrf

        <div class="modal fade" id="login-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false" style="display: none; margin-top: 150px;">
            <div class="modal-dialog">
                <div class="loginmodal-container">
                    <div class="row">
                        <div class="col-md-8 col-md-offset-2">
                            <div class="panel panel-default">
                                <button type="button" class="close" data-dismiss="modal" style="margin-right: 10px">X</button>
                                <div class="panel-body">
                                    <div class="text-center">
                                        <h2 class="text-center" style="color: black">Forgot Password?
                                           </h2>
                                        <p>You can reset your password here.</p>
                                        <div class="panel-body">
                                            <form id="register-form" role="form" autocomplete="off" class="form" method="post">
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><i class="glyphicon glyphicon-envelope color-blue"></i></span>
                                                        <input id="email" name="emailaddress" placeholder="email address" class="form-control"  >

                                                    </div>
                                                    <div type="hidden" class="alert-warning" style="color: red;" >{{$errors->first('emailaddress')}}</div>
                                                </div>
                                                <div class="form-group">
                                                    <input name="recover-submit" class="btn btn-lg btn-primary btn-block" value="Reset Password" data-toggle="modal" data-target="#myModal"
                                                           type="submit">
                                                </div>
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

</body>
</html>
