@extends('Home_Master')
@section('content')
    @if (session('message'))
        <div class="alert alert-success" style="text-align: center; font-size: large">
            <strong>{{session('message')}}</strong>
        </div>
    @endif
<h3 style="text-align: center">List Group</h3>
{{--<a href=""  id="addMembers"  class="action btn btn-success" data-toggle="modal" data-target="#addMembers"style="float: right; margin-bottom: 10px"> Add Members </a>--}}
<table class="table table-striped table-bordered table-hover" id="dataTables-example">
    <thead>
    <tr align="center">
        <th style="text-align: center">Group Name</th>

            <th style="text-align: center">Action</th>

    </tr>
    </thead>
    @foreach($listGroups as $listGroup)
        <tbody>
        <tr class="odd gradeX" align="center">
            <td>{{$listGroup['groupName']}}</td>
            <td class="center">
                    <button id="{{$listGroup['groupId']}}" type="button" value="Delete" class="deleteGroup btn btn-danger" > Delete
                        <i class="fa fa-trash"></i></button>
                    <button id="{{$listGroup['groupId']}}" type="button" value="edit" class="editGroup btn btn-success"  data-toggle="modal" data-target="#editGroup"  > Edit
                    <i class="fa fa-edit"></i></button>
            </td>

        </tr>
        </tbody>
        @endforeach
</table>
<form action="{{route('updateGroup')}}" method="post" enctype="multipart/form-data">
    @csrf

    <div class="modal fade" id="editGroup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false" style="display: none;margin-top: 22px"data-backdrop="false">
        <div class="modal-dialog">
            <div class="loginmodal-container">
                <div class="row">
                    <div class="col-md-12 col-md-offset-2">
                        <div class="panel panel-default" style="border: 3px solid #f1f1f1">
                            <div class="panel-body">
                                <div class="text">
                                    <h2 class="text-center" style="color: black">Edit Group
                                        <button type="button" class="close" data-dismiss="modal">X</button>
                                    </h2>
                                    <div class="panel-body">
                                        <div class="col-lg-12-12 " id="question">
                                            <div class="panel-body" style="margin-top: 1px">
                                                <div class="form-group" style="margin-top: 1px;margin-bottom: 5px">
                                                    <label>Name</label>
                                                    <input id="groupId" name="groupId" hidden >
                                                    <input type="text" id="groupName" class="form-control" name="groupName" />
                                                </div>
                                                <div class="form-group" style="margin-top: 1px;margin-bottom: 5px" >
                                                    <label>Description</label>
                                                    <textarea class="form-control"  id="description" name="description" placeholder="Please Enter Description"></textarea>

                                                </div>
                                                <button type="submit" class="btn btn-success" style="display: block; margin: auto;">Upload</button>
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
<script>
    $("button.deleteGroup").click(function() {
        var groupId = $(this).attr('id');
        var x = confirm("Do you want to delete this group?");
        if (x) {
            deleteGroup(groupId);
        }
        else
            return false;
    });
    function deleteGroup(groupId) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        $.ajax({
            method: 'DELETE',
            dataType: 'json',
            url: '{!! url('/deleteGroup')!!}' + '/' + groupId,
            success: function (data) {
                location.reload();
                console.log(data);
            },
            error: function (e) {
                console.log(e.message);
            }
        });
    }
    $("button.editGroup").click(function() {
        var groupId = $(this).attr('id');
        getGroupInfo(groupId);

    });
    function getGroupInfo(groupId) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        $.ajax({
            method: 'GET',
            dataType: 'json',
            url: '{!! url('/getGroupById')!!}' + '/' + groupId,
            success: function (data) {
                $('#groupId').val(data['groupId']);
                $('#groupName').val(data['name']);
                if(data['description'] != null){
                $('#description').text(data['description']);
                }
                console.log(data['description']);

            },
            error: function (e) {
                console.log(e.message);
            }
        });

    }
</script>
@endsection
