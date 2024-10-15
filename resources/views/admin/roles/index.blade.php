@extends('admin/adminMaster')
@section('title', 'Roles')
@section('content')
@if(session('success'))
<div>{{ session('success') }}</div>
@endif
<div class="container-fluid py-4">
    @if(count($roles) > 0)
    <div class="row">
        <div class="col-md-10 mt-4">
            <div class="card">
                <div class="card-header pb-0 px-3 d-flex justify-content-between flex-wrap">
                    <h6 class="mb-0"> Roles And Permissions</h6>
                    <button id="btnAddRole" type="button" class="btn bg-gradient-success btn-block mb-3" data-bs-toggle="modal" data-bs-target="#addRoleModal">
                        Add New Role
                    </button>
                </div>
                <div class="card-body pt-4 p-3">
                    <ul class="list-group">
                        @foreach($roles as $role)
                        <li class="list-group-item border-0 d-flex p-4 mb-2 bg-gray-100 border-radius-lg">
                            <div class="d-flex flex-row align-items-center flex-wrap">
                                <div class="mr-3" style="margin-right: 10px;">
                                    <h6 class="text-sm">{{ $role->name }}</h6>
                                </div>
                                @foreach($permissions as $permission)
                                <div class="form-check" style="margin-right: 20px;">
                                    <label class="custom-control-label" for="{{ $permission->name }}">{{ $permission->name }}</label>
                                    <input type="checkbox" class="form-check-input" id="{{ $permission->name }}" rid="{{ $role->id }}" value="{{ $permission->id }}" {{ $role->hasPermissionTo($permission) ? 'checked' : '' }}>
                                </div>
                                @endforeach
                            </div>
                            <div class="ms-auto text-end">
                                <a class="delete-role-btn btn btn-link text-danger text-gradient px-3 mb-0" rid="{{ $role->id }}" href="javascript:;"><i class="far fa-trash-alt me-2" aria-hidden="true"></i>Delete</a>
                                <a class="btnEditRole" rname="{{ $role->name }}" rid="{{ $role->id }}" class="btn btn-link text-dark px-3 mb-0" href="javascript:;" data-bs-toggle="modal" data-bs-target="#addRoleModal"><i class="fas fa-pencil-alt text-dark me-2" aria-hidden="true"></i>Edit</a>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="modal fade" id="addRoleModal" tabindex="-1" role="dialog" aria-labelledby="addRoleModalTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addRoleModalLabel">Add New Role</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <form id="addRoleForm" action="{{ route('roles.store') }}" method="POST">
                        <div class="modal-body">
                            @csrf
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Role Name:</label>
                                <input type="text" class="form-control" value="" name="name" id="addName">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn bg-gradient-primary">Create Role</button>
                        </div>
                    </form>
                    <form id="updateRoleForm" action="{{ route('roles.update', $role) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Role Name:</label>
                                <input type="text" class="form-control" value="" name="name" id="updateName">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn bg-gradient-primary">Update Role</button>
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
                    <h6 class="mb-0 w-100 d-flex justify-content-center align-items-center"> No roles found.</h6>
                    <button id="btnAddRole" type="button" class="btn bg-gradient-success btn-block mb-3 w-15" data-bs-toggle="modal" data-bs-target="#addRoleModal">
                        Add New Role
                    </button>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="modal fade" id="addRoleModal" tabindex="-1" role="dialog" aria-labelledby="addRoleModalTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addRoleModalLabel">Add New Role</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <form id="addRoleForm" action="{{ route('roles.store') }}" method="POST">
                            <div class="modal-body">
                                @csrf
                                <div class="form-group">
                                    <label for="recipient-name" class="col-form-label">Role Name:</label>
                                    <input type="text" class="form-control" value="" name="name" id="addName">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn bg-gradient-primary">Create Role</button>
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
    $("#btnAddRole").click(function() {
        $("#addRoleModalLabel").text('Add New Role'), $("#updateRoleForm").hide().siblings("#addRoleForm").show();
    });
    $(".btnEditRole").click(function() {
        var actionUrl = $("#updateRoleForm").attr('action');
        actionUrl = actionUrl.substring(0, actionUrl.lastIndexOf('/') + 1) + $(this).attr('rid');
        $("#addRoleModalLabel").text('Update Role'), $("#updateRoleForm").attr('action', actionUrl).show().siblings("#addRoleForm").hide(), $("#updateName").val($(this).attr('rname'));
    });

    $(document).ready(function() {
        $('.delete-role-btn').click(function() {
            var roleId = $(this).attr('rid');
            $.ajax({
                url: '/roles/' + roleId,
                type: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    location.reload();
                },
                error: function(error) {
                    location.reload();
                    console.error('Error deleting role:', error);
                }
            });
        });
    });


    $('input[type="checkbox"]').change(function() {
        var roleId = $(this).attr('rid');
        var permissionId = $(this).val();
        var isChecked = $(this).is(':checked');
        $.ajax({
            url: '/roles/' + roleId + '/permissions/' + permissionId,
            type: 'PUT',
            data: {
                _token: '{{ csrf_token() }}',
                isChecked: isChecked
            },
            success: function(response) {
                location.reload();
            },
            error: function(xhr, status, error) {
                location.reload();
            }
        });
    });
</script>

@endsection