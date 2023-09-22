@extends('layouts.app' )

@section('title', 'ICS - User Add')

@section('content')

<div class="container-fluid px-4">
    <h4 class="mt-4">User Management</h4>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{route('user.index')}}">User List</a></li>
        <li class="breadcrumb-item active">Add</li>
    </ol>
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Add New User
        </div>
        <div class="card-body">
            @if($errors->any())
            <h4>{{$errors->first()}}</h4>
            @endif
            @if (session('status'))
            <div class="alert alert-success" role="alert">
                <button type="button" class="close" data-dismiss="alert">×</button>
                {{ session('status') }}
            </div>
            @elseif(session('failed'))
            <div class="alert alert-danger" role="alert">
                <button type="button" class="close" data-dismiss="alert">×</button>
                {{ session('failed') }}
            </div>
            @endif
            <form method="POST" action="{{route('user.store')}}" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-fullname">Full Name</label>
                            <input type="text" name="name" class="form-control" id="basic-default-fullname" placeholder="" value="" require />
                            @error('name')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-fullname">Username</label>
                            <input type="text" name="username" class="form-control" id="basic-default-fullname" placeholder="" value="" require />
                            @error('username')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="basic-default-email">Email</label>
                    <div class="input-group input-group-merge">
                        <input type="email" name="email" id="basic-default-email" class="form-control" placeholder="" aria-label="email" aria-describedby="basic-default-email2" value="" />
                    </div>
                    @error('email')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                    <div class="form-text"> You can use letters, numbers & periods </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-fullname">Password</label>
                            <input type="password" name="password" class="form-control" id="basic-default-fullname" placeholder="" value="spiglobal@123" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-fullname">Role</label>
                            <select id="role" name="role" class="form-select" id="user-role">
                                @foreach($roles as $key => $role)
                                <option value="{{$role->id}}" {{$role->id == "4"}} ? selected : "">{{$role->description}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div>
                    <button class="btn btn-primary" type="submit">ADD NEW USER</button>
                </div>
            </form>
        </div>

    </div>
</div>


@endsection