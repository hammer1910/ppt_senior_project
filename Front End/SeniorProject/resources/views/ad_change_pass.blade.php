@extends('master_ad')
{{--@section('controller','Category')--}}
{{--@section('action','Add')--}}
@section('content')

    <!-- /.col-lg-12 -->
    <div class="col-lg-7" style="padding-top:50px">
        <h2 style="text-align: center">Change Password</h2>
        <form action="{!! route('manager.admin.pass') !!}" method="post">
            <input type="hidden" name="_token" value="{!! csrf_token()!!}">
            <div class="form-group">
                <label>Password</label>
                <input class="form-control" name="password" placeholder="Please Enter Your Password"  />
            </div>
            <div class="form-group">
                <label>New Password</label>
                <input class="form-control" name="new_pass" placeholder="Please Enter Your New Password"  />
                <p class="help is-danger">{{ $errors->first('txtCateName') }}</p>
            </div>
            <div class="form-group">
                <label>Confirm Password</label>
                <input class="form-control" name="confirm_pass" placeholder="Please Enter Confirm Your Password" />
                <p class="help is-danger">{{ $errors->first('txtOrder') }}</p>
            </div>

            <button type="submit" class="btn btn-outline-primary">Update</button>
            {{--<button type="reset" class="btn btn-default">Reset</button>--}}
        </form>
    </div>

@endsection()



