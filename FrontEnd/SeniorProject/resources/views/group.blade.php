@extends('Home')
{{--@section('controller','Category')--}}
{{--@section('action','Add')--}}
@section('content')
    <meta name="_token" content="{{ csrf_token() }}">
    <!-- /.col-lg-12 -->
    <div style="margin-left: 20px">
        <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#home">Exam</a></li>
            <li><a data-toggle="tab" href="#menu1">Member</a></li>
        </ul>

    </div>
    <div class="tab-content" style="margin-left: 20px">
        <div id="home" class="tab-pane fade in active">
            <h3>Exam</h3>

            {{--@foreach($array as $value)--}}
            {{--<p>{{$value['email']}}</p>--}}
            {{--@endforeach--}}
        </div>
        <div id="menu1" class="tab-pane fade" style="margin-left: 20px">
            <h3 style="text-align: center">List Member</h3>
            <button type="button" class="btn btn-success" style="float: right; margin-bottom: 10px">ADD</button>
            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                <thead>
                <tr align="center">

                    <th>Email</th>
                    <th>Full Name</th>
                    <th>Action</th>
                </tr>
                </thead>
                {{--@foreach($members as $value)--}}
                    <tbody>
                    <tr class="odd gradeX" align="center">
                        <td></td>
                        <td>Walter</td>
                        <td class="center"><i class="fa fa-trash-o  fa-fw"></i><a href="#" data-toggle="modal" data-target="#deleteModal"> Delete</a></td></tr>
                    </tbody>
                {{--@endforeach--}}
            </table>
        </div>
    </div>



                {{--<script>--}}
                    {{--$(document).ready(function() {--}}
                        {{--$('#multiselect').multiselect({--}}
                            {{--buttonWidth : '160px',--}}
                            {{--includeSelectAllOption : true,--}}
                            {{--nonSelectedText: 'Select an Option'--}}
                        {{--});--}}
                    {{--});--}}
                {{--</script>--}}


@endsection()


