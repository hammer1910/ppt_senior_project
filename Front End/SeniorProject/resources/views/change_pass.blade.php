@extends('Home_Master')
{{--@section('controller','Category')--}}
{{--@section('action','Add')--}}
@section('content')

    <!-- /.col-lg-12 -->
    <div class="col-lg-7" style="padding-top:50px">
        <h2 style="text-align: center">Change Password</h2>
        {{--<form action="{!! route('manager.user.pass') !!}" method="post">--}}
        <form action="{!! route('change_pass') !!}" method="post">
            <input type="hidden" name="_token" value="{!! csrf_token()!!}">
            <div class="form-group">
                <label>Password</label>
                <input type="password" class="form-control" name="password" placeholder="Please Enter Your Password"   />
                <div class="alert-warning" >{{$errors->first('password')}}</div>
            </div>
            <div class="form-group">
                <label>New Password</label>
                <input type="password" class="form-control" name="new_pass" placeholder="Please Enter Your New Password" />
                <div class="alert-warning" >{{$errors->first('new_pass')}}</div>

            </div>
            <div class="form-group">
                <label>Confirm Password</label>
                <input type="password"  class="form-control" name="confirm_pass" placeholder="Please Enter Confirm Your Password"  />
                <div class="alert-warning" >{{$errors->first('confirm_pass')}}</div>

            </div>

            <button type="submit" class="btn badge-danger" style="display: block; margin: auto;">Update</button>
            {{--<button type="reset" class="btn btn-default">Reset</button>--}}
            @if (session('messaerror'))
                <div class="alert alert-success" style="text-align: center; font-size: large">
                    <strong>Success!</strong> {{session('messaerror')}}
                </div>
            @endif
        </form>
    </div>

@endsection()



