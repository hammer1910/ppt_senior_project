@extends('admin')
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
                <th>ID</th>
                <th>Email</th>
                <th>First Name</th>
                <th>Role</th>
                <th>Delete</th>
                <th>Edit</th>
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
                    <td>{{$value['roles']}}</td>
                    {{--<td class="center"><i class="fa fa-trash-o  fa-fw"></i><a href="#" data-toggle="modal" data-target="#deleteModal"> Delete</a></td>
                    --}}
                    <td class="center">
                        {{--<i class="fa fa-trash-o  fa-fw"></i><input id="{{$value['accountId']}}" type="button"  value="Delete" class="delete" onclick="return myFunction();">--}}
                        <button id="{{$value['accountId']}}" type="button" value="Delete" data-toggle="modal" data-target="#deleteModal" class="deleteMember btn btn-danger" > Delete
                            <i class="fa fa-trash"></i>
                    </td>
                    <td class="center">
                        <button id="" type="button" value="Delete" class="deleteMember btn btn-success" > Edit
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

                </div>
            </div>
    </form>

    <!-- Modal -->

@endsection()
