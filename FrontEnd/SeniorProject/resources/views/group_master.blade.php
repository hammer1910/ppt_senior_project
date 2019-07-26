@extends('group')
{{--@section('controller','Category')--}}
{{--@section('action','Add')--}}
@section('content')
<div id="page-content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">

            </div>
            <ul class="nav nav-tabs">
                <li class="active"><a data-toggle="tab" href="#home">Exam</a></li>
                <li><a data-toggle="tab" href="#menu1">Member</a></li>


            </ul>

            <div class="tab-content">
                <div id="home" class="tab-pane fade in active">
                    <h3>Exam</h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                </div>
                <div id="menu1" class="tab-pane fade">
                    <h3>Member</h3>
                    <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                </div>
            </div>
        </div>

        @if (session('message'))
            <div type="hidden" class="alert-warning" style="text-align: center" >{{session('message')}}<div>
                    @endif
                </div>
            </div>

    </div>
</div>
</div>
    @endsection
