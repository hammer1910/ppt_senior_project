@extends('master_ad')
{{--@section('controller','Category')--}}
{{--@section('action','Add')--}}
@section('content')

    <!-- /.col-lg-12 -->
    <div class="col-lg-7" style="padding-top:50px">
        <h2 style="text-align: center">Profile</h2>
        <form action="{!! route('manager.admin.profile') !!}" method="post">
            <input type="hidden" name="_token" value="{!! csrf_token()!!}">
            <div class="form-group">
                <label>First Name</label>
                <input class="form-control" name="first_name" placeholder="Please Enter Your First Name"  />
            </div>
            <div class="form-group">
                <label>Last Name</label>
                <input class="form-control" name="last_name" placeholder="Please Enter Your Last Name"  />
                <p class="help is-danger">{{ $errors->first('txtCateName') }}</p>
            </div>
            {{--<div class="form-group">--}}
            {{--<label>Email</label>--}}
            {{--<input class="form-control" name="email" placeholder="Please Enter Your Email" />--}}
            {{--<p class="help is-danger">{{ $errors->first('txtOrder') }}</p>--}}
            {{--</div>--}}
            <div class="form-group">
                <label>Phone number</label>
                <input class="form-control" name="phone_number" placeholder="Please Enter Your Phone Number" />
                <p class="help is-danger">{{ $errors->first('txtKeywords') }}</p>
            </div>
            <div class="form-group">
                <label>Address</label>
                <input class="form-control" name="address" placeholder="Please Enter Your Address" />
                {{--<textarea class="form-control" rows="3" name="txtDescription"></textarea>--}}
            </div>
            <button type="submit" class="btn btn-default">Update</button>
            {{--<button type="reset" class="btn btn-default">Reset</button>--}}
        </form>
    </div>

@endsection()


