@extends('layouts.app' )

@section('title', 'ICS - User Management')

@section('content')

<div class="container-fluid px-4">
    <ol class="breadcrumb mb-4 mt-4">
        <li class="breadcrumb-item"><a href="{{route('user.index')}}">User List</a></li>
        <li class="breadcrumb-item active">Edit User</li>
    </ol>
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Edit User
        </div>
        <div class="card-body">
            @if($errors->any())
            <div class="alert alert-success">
                <p>{{ $errors->first() }}</p>
            </div>
            @endif

            @if ($message = Session::get('status'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
            @endif
            <form method="POST" action="{{route('user.update', $user[0]->id)}}" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-fullname">Full Name</label>
                            <input type="text" name="name" class="form-control" id="basic-default-fullname" placeholder="Fullname" value="{{$user[0]->name}}" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-fullname">Username</label>
                            <input type="text" name="username" class="form-control" id="basic-default-fullname" placeholder="John Doe" value="{{$user[0]->username}}" />
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="basic-default-email">Email</label>
                    <div class="input-group input-group-merge">
                        <input type="email" name="email" id="basic-default-email" class="form-control" placeholder="Email" aria-label="email" aria-describedby="basic-default-email2" value="{{$user[0]->email}}" />
                    </div>
                    <div class="form-text"> You can use letters, numbers & periods </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-fullname">Password</label>
                            <input type="password" class="form-control" id="basic-default-fullname" placeholder="Password" value="spiglobal@123" disabled />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-fullname">Role</label>
                            <select id="role" name="role" class="form-select">
                                <option value="1" {{$user[0]->role_id == 1 ? 'selected' : ''}}>Admin</option>
                                <option value="2" {{$user[0]->role_id == 2 ? 'selected' : ''}}>Supervisor</option>
                                <option value="3" {{$user[0]->role_id == 3 ? 'selected' : ''}}>Team Lead</option>
                                <option value="4" {{$user[0]->role_id == 4 ? 'selected' : ''}}>Team Member</option>
                            </select>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Save</button>
            </form>
        </div>
    </div>
</div>


@endsection