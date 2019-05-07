@extends('Home_Master')

@section('content')
    <!-- /.col-lg-12 -->
    @if (session('message'))
        <div class="alert alert-success" style="text-align: center; font-size: large">
            <strong>{{session('message')}}</strong>
        </div>
    @endif
    <div class="col-lg-8 " style="margin-top: 30px">
        <h2 style="text-align: center">Create new group</h2>

        <form action="{{route('create_group')}}" method="post">
            <input type="hidden" name="_token" value="{!! csrf_token()!!}">
            <div class="form-group">
                <label>Group Name</label>
                <input class="form-control" name="group_name" placeholder="Please Enter Group Name" />
            </div>
            <div class="form-group">
                <label>Description</label>
                <textarea class="form-control" name="description" placeholder="Please Enter Description"></textarea>
            </div>
            <div style="display: block; text-align: center">
                <button type="submit" class="btn btn-success" style="text-align: center">Create </button>
                <button type="button" class="btn btn-default">Cancel</button>
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


