@extends('admin/adminMaster')
@section('title', 'permissions')
@section('content')
@if(session('success'))
<div>{{ session('success') }}</div>
@endif
<div class="container-fluid py-4">
    @if(count($permissions) > 0)
    <div class="row">
        <div class="col-md-10 mt-4">
            <div class="card">
                <div class="card-header pb-0 px-3 d-flex justify-content-between">
                    <h6 class="mb-0"> Permissions </h6>
                    <button id="btnAddpermission" type="button" class="btn bg-gradient-success btn-block mb-3" data-bs-toggle="modal" data-bs-target="#addpermissionModal">
                        Add New permission
                    </button>
                </div>
                <div class="card-body pt-4 p-3">
                    <ul class="list-group">
                        @foreach($permissions as $permission)
                        <li class="list-group-item border-0 d-flex p-4 mb-2 bg-gray-100 border-radius-lg">
                            <div class="d-flex flex-row align-items-center">
                                <div class="mr-3" style="margin-right: 10px;">
                                    <h6 class="text-sm">{{ $permission->name }}</h6>
                                </div>
                            </div>
                            <div class="ms-auto text-end">
                                <a class="delete-permission-btn btn btn-link text-danger text-gradient px-3 mb-0" rid="{{ $permission->id }}" href="javascript:;"><i class="far fa-trash-alt me-2" aria-hidden="true"></i>Delete</a>
                                <a class="btnEditpermission" rname="{{ $permission->name }}" rid="{{ $permission->id }}" class="btn btn-link text-dark px-3 mb-0" href="javascript:;" data-bs-toggle="modal" data-bs-target="#addpermissionModal"><i class="fas fa-pencil-alt text-dark me-2" aria-hidden="true"></i>Edit</a>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="modal fade" id="addpermissionModal" tabindex="-1" permission="dialog" aria-labelledby="addpermissionModalTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" permission="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addpermissionModalLabel">Add New Permission</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <form id="addpermissionForm" action="{{ route('permissions.store') }}" method="POST">
                        <div class="modal-body">
                            @csrf
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Permission Name:</label>
                                <input type="text" class="form-control" value="" name="name" id="addName">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn bg-gradient-primary">Create permission</button>
                        </div>
                    </form>
                    <form id="updatepermissionForm" action="{{ route('permissions.update', $permission) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Permission Name:</label>
                                <input type="text" class="form-control" value="" name="name" id="updateName">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn bg-gradient-primary">Update Permission</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @else
    <div class="row">
        <div class="col-md-10 mt-4">
            <div class="card">
                <div class="card-header pb-0 px-3 d-flex justify-content-between">
                    <h6 class="mb-0 w-100 d-flex justify-content-center align-items-center"> No permissions found.</h6>
                    <button id="btnAddpermission" type="button" class="btn bg-gradient-success btn-block mb-3 w-15" data-bs-toggle="modal" data-bs-target="#addpermissionModal">
                        Add New permission
                    </button>
                </div>
            </div>
        </div>
        <div class="col-md-4">
        <div class="modal fade" id="addpermissionModal" tabindex="-1" permission="dialog" aria-labelledby="addpermissionModalTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" permission="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addpermissionModalLabel">Add New Permission</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <form id="addpermissionForm" action="{{ route('permissions.store') }}" method="POST">
                        <div class="modal-body">
                            @csrf
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Permission Name:</label>
                                <input type="text" class="form-control" value="" name="name" id="addName">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn bg-gradient-primary">Create Permission</button>
                        </div>
                    </form>                    
                </div>
            </div>
        </div>
    </div>
    </div>
    @endif
</div>

<script>
    $("#btnAddpermission").click(function() {
        $("#addpermissionModalLabel").text('Add New permission'), $("#updatepermissionForm").hide().siblings("#addpermissionForm").show();
    });
    $(".btnEditpermission").click(function() {
        var actionUrl = $("#updatepermissionForm").attr('action');
        actionUrl = actionUrl.substring(0, actionUrl.lastIndexOf('/') + 1) + $(this).attr('rid');
        $("#addpermissionModalLabel").text('Update permission'), $("#updatepermissionForm").attr('action', actionUrl).show().siblings("#addpermissionForm").hide(), $("#updateName").val($(this).attr('rname'));
    });

    $(document).ready(function() {
        $('.delete-permission-btn').click(function() {
            var permissionId = $(this).attr('rid');
            $.ajax({
                url: '/permissions/' + permissionId,
                type: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    location.reload();
                },
                error: function(error) {
                    location.reload();
                    console.error('Error deleting permission:', error);
                }
            });
        });
    });
</script>

@endsection