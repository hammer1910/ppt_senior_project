@extends('Home_Master')
@section('content')
    <!-- Page Content -->
    <!--        <div id="page-wrapper">-->
    <!--            <div class="container-fluid">-->
    <!--                <div class="row">-->
    <script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
    @if (session('message'))
        <div class="alert alert-success" style="text-align: center; font-size: large">
            <strong>Success!</strong> {{session('message')}}
        </div>
    @endif
    <form action="" method="post">
        <input type="hidden" name="_token" value="{!! csrf_token()!!}">
        <meta name="_token" content="{{csrf_token()}}" />
        <div class="col-lg-12">
            <h1 class="page-header">List Account

            </h1>
        </div>

        <!-- /.col-lg-12 -->
        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
            <thead>
            <tr align="center">
                <th style="text-align: center">ID</th>
                <th style="text-align: center">Email</th>
                <th style="text-align: center">First Name</th>
                <th style="text-align: center">Role</th>
                <th style="text-align: center">Action</th>

            </tr>
            </thead>

            <tbody>
            <?php $question = 0?>
            @foreach($arrays as $value)
                <?php $question =$question+1 ?>
                <tr class="odd gradeX" align="center">
                    <div class="account_ID" data-question-id="{{$value['accountId']}}"></div>
                    <td>{{$question}}</td>
                    <td>{{$value['email']}}</td>
                    <td>{{$value['fullName']}}</td>
                    <td>{{$value['roles'][0]}}</td>
                    {{--<td class="center"><i class="fa fa-trash-o  fa-fw"></i><a href="#" data-toggle="modal" data-target="#deleteModal"> Delete</a></td>
                    --}}
                    <td class="center">
                        {{--<i class="fa fa-trash-o  fa-fw"></i><input id="{{$value['accountId']}}" type="button"  value="Delete" class="delete" onclick="return myFunction();">--}}
                        <button id="{{$value['accountId']}}" type="button" value="Delete" data-toggle="modal" data-target="#deleteModal" class="deleteMember btn btn-danger" > Delete
                            <i class="fa fa-trash"></i></button>
                        <button id="{{$value['accountId']}}" type="button" value="Edit" class="editAccount btn btn-success" data-toggle="modal" data-target="#editAccount"  > Edit
                            <i class="fa fa-edit"></i></button>
                    </td>

                </tr>

            @endforeach

            <script>
                function myFunction() {
                    if(!confirm("Are You Sure to delete this"))
                        event.preventDefault();
                }
            </script>
            <script>


                $("button.deleteMember").click(function() {
                    var accountId = $(this).attr('id');
                    var x = confirm("Do you want to delete this user?");
                    if (x) {
                        deleteMember(accountId);
                    }
                    else
                        return false;
                });
                function deleteMember(accountId) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                        }
                    });
                    $.ajax({
                        method: 'DELETE',
                        dataType: 'json',
                        url: '{!! url('/deleteUser')!!}' + '/' + accountId,
                        success: function (data) {
                            location.reload();
                            console.log(data);
                        },
                        error: function (e) {
                            console.log(e.message);
                        }
                    });
                }
            </script>
            </tbody>
        </table>

        <script>
            $("button.editAccount").click(function() {
                var accountId = $(this).attr('id');
                getGroupInfo(accountId);

            });
            function getGroupInfo(accountId) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });
                $.ajax({
                    method: 'GET',
                    dataType: 'json',
                    url: '{!! url('/getAccountById')!!}' + '/' + accountId,
                    success: function (data) {

                        $('#accountId').val(data['accountId']);
                        $('#email').val(data['email']);
                        $('#fullName').val(data['fullName']);
                        $('#address').val(data['address']);
                        $('#phoneNumber').val(data['phoneNumber']);

                    },
                    error: function (e) {
                        console.log(e.message);
                    }
                });

            }
        </script>

                </div>
            </div>
    </form>
    <form action="{{route('updateAccount')}}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="modal fade" id="editAccount" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false" style="display: none; "data-backdrop="false">
            <div class="modal-dialog">
                <div class="loginmodal-container">
                    <div class="row">
                        <div class="col-md-12 col-md-offset-3">
                            <div class="panel panel-default" style="border: 3px solid #f1f1f1">
                                <div class="panel-body">
                                    <div class="text">
                                        <h2 class="text-center" style="color: black">Edit Account
                                            <button type="button" class="close" data-dismiss="modal">X</button>
                                        </h2>
                                        <div class="panel-body">
                                            <div class="col-lg-12-12 " id="question">
                                                <h3 class="text-center" style="color: black;margin-top: 10px" id="question_order"></h3>
                                                <div class="panel-body" style="margin-top: 1px">
                                                    <div class="form-group" style="margin-top: 1px;margin-bottom: 5px">
                                                        <label>Email </label>
                                                        <input id="accountId" name="accountId" hidden  >
                                                        <input type="text" class="form-control" id="email" name="email"
                                                               placeholder="Please Enter Question Name"/>
                                                    </div>
                                                    <div class="form-group" style="margin-top: 1px;margin-bottom: 5px">
                                                        <label>Full Name</label>
                                                        <input class="form-control" id="fullName" name="fullName"
                                                               placeholder="Please Enter Answer"/>
                                                    </div>
                                                    <div class="form-group" style="margin-top: 1px;margin-bottom: 5px">
                                                        <label>Phone Number</label>
                                                        <input class="form-control" id="phoneNumber" name="phoneNumber"
                                                               placeholder="Please Enter Answer"/>
                                                    </div>
                                                    <div class="form-group" style="margin-top: 1px;margin-bottom: 5px">
                                                        <label>Address</label>
                                                        <input class="form-control" id="address" name="address"
                                                               placeholder="Please Enter Answer"/>
                                                    </div>
                                                    <button type="submit" class="btn btn-success" style="display: block; margin: auto;">Update</button>
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
        </div>
    </form>
    <!-- Modal -->

@endsection()
