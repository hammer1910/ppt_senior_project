@extends('Home')
{{--@section('controller','Category')--}}
{{--@section('action','Add')--}}
@section('content')
    <!-- /.col-lg-12 -->
    <div class="col-lg-8 " >
        <h2 style="text-align: center">Add Member</h2>

        <form action="" method="post">
            <input type="hidden" name="_token" value="{!! csrf_token()!!}">
            <div class="form-group">
                <label>Group Name</label>
                <input class="form-control" name="group_name" placeholder="Please Enter Group Name" />
            </div>
            <div class="form-group">
            <label>Member</label>
            <select id="multiselect" multiple="multiple" style="width: 100%">
            @foreach($arrays as $value)
            <option value="{{$value['accountId']}}">{{$value['email']}}</option>
            @endforeach
            </select>

            </div>
            <div style="display: block; text-align: center">
                <button type="submit" class="btn btn-default" style="text-align: center">Create</button>
                <button type="button" class="btn btn-default">Cancel</button>
                {{--<a href="{{route('home')}}">Click</a>--}}
            </div>


            <p></p>

            @if (session('message'))
                <div type="hidden" class="alert-warning" style="text-align: center" >{{session('message')}}<div>
                        @endif
                    </div>
                </div>
                <script>
                    $(document).ready(function() {
                        $('#multiselect').multiselect({
                            buttonWidth : '160px',
                            includeSelectAllOption : true,
                            nonSelectedText: 'Select an Option'
                        });
                    });
                </script>
        </form>
    </div>

@endsection()


