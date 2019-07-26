<?php
/**
 * Created by IntelliJ IDEA.
 * User: walter
 * Date: 27/02/2019
 * Time: 09:41
 */
?>

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
    <link rel="stylesheet" href="{{'css/register.css'}}">
    <title>Register</title>
</head>
<body>

<H1>Let's TOEIC</H1>

<form action="{{route('register')}}" method="post" >
    @csrf
    <div class="container">
        <h2>Register new account</h2>

        <div class="form-group">
            <label for="email"><b>Email</b></label>
            <input type="email" id="email" placeholder="Enter Your Email" name="email">
            <div class="alert-warning" >{{$errors->first('email')}}</div>
        </div>
        <div class="form-group">
            <label for="fullName"><b>Full Name</b></label>
            <input type="text" placeholder="Enter Your Full Name" name="fullName" >
            <div class="alert-warning" >{{$errors->first('fullName')}}</div>
        </div>
        <div class="form-group">
            <label for="password"><b>Password</b></label>
            <input type="password" placeholder="Enter Your Password" name="password" >
            <div class="alert-warning" >{{$errors->first('password')}}</div>
        </div>
        <div class="form-group">
            <label for="passwordconfirm"><b>Confirm Password</b></label>
            <input type="password" placeholder="Enter Your Confirm Password" name="confirmpassword">
            <div class="alert-warning" >{{$errors->first('confirmpassword')}}</div>

        </div>
        <button class="register" type="submit" name="register" >Register</button>
        <a href="{{ url('login') }}" class="cancel" role="button" style="text-decoration: none;color: white">Cancel</a>
        @if (isset($message))

            <div type="hidden" class="alert-warning" style="text-align: center" >{{$message}}<div>
                    @endif
        {{--<button  class="cancel"   name="cancel" > <a href="{{ url('login') }}" style="text-decoration: none;color: white">Cancel</a></button>--}}
        {{--<button  class="cancel" onclick="{{route('return')}}" name="cancel">Cancel</button>--}
        {{--<a class="btn btn-default btn-close" href="{{ route('login') }}">Cancel</a>--}}
    </div>
            </div>
    </div>
</form>

</body>
</html>

