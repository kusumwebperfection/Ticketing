@extends('admin/adminMaster')
@section('title', 'Users')
@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-md-10 mt-4">
            <div class="card">
                <div class="table-responsive">
                    <table class="table align-items-center mb-0">
                        @if(count($users) > 0)
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">User Name</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Function</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Change Role</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Created At</th>
                                <th class="text-secondary opacity-7">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                            <tr>
                                <td>
                                    <div class="d-flex px-2 py-1">
                                        <div>
                                            @if (is_null($user->profile_pic))
                                            <img src="{{ asset('/public/img/SuperAdminPic.png') }}" class="avatar avatar-sm me-3">
                                            @else
                                            <img src="{{ asset('storage/' .$user->profile_pic) }}" class="avatar avatar-sm me-3">
                                            @endif
                                        </div>
                                        <div class="d-flex flex-column justify-content-center">
                                            <h6 class="mb-0 text-xs">{{$user->name}}</h6>
                                            <p class="text-xs text-secondary mb-0">{{$user->email}}</p>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @foreach($user['roles'] as $roles)
                                    <p class="text-xs font-weight-bold mb-0">{{$roles->name}}</p>
                                    @endforeach
                                    <p class="text-xs text-secondary mb-0">Organization</p>
                                </td>
                                <td class="align-middle text-center text-sm">
                                    <span class="badge badge-sm bg-gradient-success">
                                        @can('Manage Roles')
                                        <select class="roleSelect" name="role" userid='{{$user->id}}'>
                                            @foreach(roleDropdown() as $roleId => $roleName)
                                            @if($user->currentRole()->id)
                                            <option value="{{ $roleId }}" {{ $user->currentRole()->id == $roleId ? 'selected' : '' }}>{{ $roleName }}</option>
                                            @endif
                                            @endforeach
                                        </select>
                                        @endcan
                                    </span>
                                </td>
                                <td class="align-middle text-center">
                                    <span class="text-secondary text-xs font-weight-bold">{{$user->created_at->format('d/m/y')}}</span>
                                </td>
                                <td class="align-middle">
                                    <a href="javascript:;" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Edit user">
                                        Edit
                                    </a>
                                    <a class="delete-role-btn btn btn-link text-danger text-gradient px-3 mb-0 deleteUser" userid='{{$user->id}}' href="javascript:;">
                                        <i class="far fa-trash-alt me-2" aria-hidden="true"></i>Delete
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        @endif
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $('.roleSelect').change(function() {
        var roleId = $(this).val();
        var userId = $(this).attr('userid');
        var data = {
            _token: '{{ csrf_token() }}',
            _method: 'PUT',
            role_id: roleId,
            action: 'updateRole',
        };
        $.ajax({
            type: 'POST',
            url: '/users/' + userId,
            data: data,
            success: function(response) {
                location.reload();
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
                // Handle error response
            }
        });
    });

    $('.deleteUser').click(function() {
        var userId = $(this).attr('userid');
        var data = {
            _token: '{{ csrf_token() }}',
            _method: 'DELETE',
        };
        $.ajax({
            type: 'POST',
            url: '/users/' + userId,
            data: data,
            success: function(response) {
                location.reload();
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
                // Handle error response
            }
        });
    });
</script>
@endsection