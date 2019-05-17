@extends('Home_Master')
@section('content')
    @if (session('message'))
        <div class="alert alert-success" style="text-align: center; font-size: large">
            <strong>{{session('message')}}</strong>
        </div>
    @endif
     <div class="col-lg-6 ">
         <h2 style="text-align: center;font-size: xx-large;margin-top: 50px">Profile</h2>
         <form action="{{route('edit_profile')}}" method="post">
             <input type="hidden" name="_token" value="{!! csrf_token()!!}">
             <div class="form-group">
                 <label style="font-size: large">Email</label>
                 <input style="font-size: large" class="form-control" name="email" value="{{$email}}" />
             </div>
             <div class="form-group">
                 <label style="font-size: large">Full Name</label>
                 <input style="font-size: large" class="form-control" name="fullName" placeholder="Please Enter Your First Name" value="{{$fullName}}" />
             </div>
            <div class="form-group">
                <label style="font-size: large">Phone number</label>
                <input style="font-size: large" class="form-control" name="phone_number" placeholder="Please Enter Your Phone Number"  value="{{$phone}}"/>
            </div>
            <div class="form-group">
                <label style="font-size: large">Address</label>
                <input style="font-size: large" class="form-control" name="address" placeholder="Please Enter Your Address" value="{{$address}}" />
                {{--<textarea class="form-control" rows="3" name="txtDescription"></textarea>--}}
            </div>
            <button type="submit" class="btn btn-success" style="display: block; margin: auto;">Update</button>
            {{--<button type="reset" class="btn btn-default">Reset</button>--}}
             @if (session('messaerror'))
                 <div type="hidden" class="alert-warning" style="text-align: center" >{{session('messaerror')}}<div>
             @endif
                     </div>
                 </div>
            </form>
    </div>

@endsection()


