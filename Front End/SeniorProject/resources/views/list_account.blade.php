@extends('master_ad')
@section('content')
    <!-- Page Content -->
    <!--        <div id="page-wrapper">-->
    <!--            <div class="container-fluid">-->
    <!--                <div class="row">-->
    <form action="" method="post">
        <input type="hidden" name="_token" value="{!! csrf_token()!!}">
        <meta name="_token" content="{{csrf_token()}}" />
    <div class="col-lg-12">
        <h1 class="page-header">Account
            <small>List</small>
        </h1>
    </div>

    <!-- /.col-lg-12 -->
    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
        <thead>
        <tr align="center">
            <th>ID</th>
            <th>Email</th>
            <th>Role</th>
            <th>Delete</th>
            <th>Edit</th>
        </tr>
        </thead>

        <tbody>
        @foreach($arrays as $value)
        <tr class="odd gradeX" align="center">
            <td></td>
            <td>walter@gmail.com</td>
            <td>User</td>
            <td class="center"><i class="fa fa-trash-o  fa-fw"></i><a href="#" data-toggle="modal" data-target="#deleteModal"> Delete</a></td>
            <td class="center"><i class="fa fa-pencil fa-fw"></i> <a href="#">Edit</a></td>

        </tr>
@endforeach
        </tbody>
    </table>
    </form>
    <script>
        function deleteconfirm(msg) {
            if(window.confirm(msg)){
                return true;
            }
            return false;
        }
    </script>
    <!-- Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Confirm</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Do you want to delete this account?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Ok</button>
                </div>
            </div>
        </div>
    </div>
@endsection()
