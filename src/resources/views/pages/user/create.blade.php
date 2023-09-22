@extends('layouts.app' )

@section('title', 'ICS - User Add')

@section('content')

<div class="container-fluid px-4">
    <h4 class="mt-4">User Record</h4>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{route('user')}}">User List</a></li>
        <li class="breadcrumb-item active">Add</li>
    </ol>
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Add New User
        </div>
        <div class="card-body">
            <form method="POST" action="{{url('user/create')}}">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-fullname">Full Name</label>
                            <input type="text" class="form-control" id="basic-default-fullname" placeholder="" value="" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-fullname">Username</label>
                            <input type="text" class="form-control" id="basic-default-fullname" placeholder="" value="" />
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="basic-default-email">Email</label>
                    <div class="input-group input-group-merge">
                        <input type="email" id="basic-default-email" class="form-control" placeholder="" aria-label="email" aria-describedby="basic-default-email2" value="" />
                    </div>
                    <div class="form-text"> You can use letters, numbers & periods </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-fullname">Password</label>
                            <input type="password" class="form-control" id="basic-default-fullname" placeholder="" value="spiglobal@123" disabled />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-fullname">Role</label>
                            <select id="role" name="role" class="form-select" id="user-role">
                                <option value="admin">Admin</option>
                                <option value="user1">Supervisor</option>
                                <option value="user2">Team Lead</option>
                                <option value="user3">Team Member</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div>
                    <button class="btn btn-primary" type="submit">SAVE NEW USER</button>
                </div>
            </form>
        </div>

    </div>
</div>


@endsection