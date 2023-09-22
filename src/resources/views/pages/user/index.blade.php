@extends('layouts.app' )

@section('title') {{'User Management'}} @endsection

@section('content')

<div class="container-fluid px-4">
    <h4 class="mt-4">User Management</h4>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{route('home.index')}}">Home</a></li>
        <li class="breadcrumb-item active">User</li>
    </ol>
    <div class="message">
        @if ($message = Session::get('status'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
        @elseif(session('failed'))
        <div class="alert alert-success">
            <p>{{ session('failed')}}</p>
        </div>
        @endif
    </div>
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            User List
        </div>
        <div class="card-body">
            <table id="datatablesSimple">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Created</th>
                        <th>Role</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="user-list">
                    @if(isset($users))
                    @foreach($users as $user)
                    <tr>
                        <td>{{$user->name}}</td>
                        <td>{{$user->username}}</td>
                        <td>{{$user->email}}</td>
                        <td>{{$user->created_at}}</td>
                        <td>{{$user->role}}</td>
                        <td>
                            <a href="{{route('user.editUser', $user->id)}}">
                                <button class="btn btn-warning btn-sm"><i class="fa fa-pencil-square" aria-hidden="true"></i></button>
                            </a>

                            <a data-id="{{$user->id}}" id="btnUserDelete"">
                                <button class=" btn btn-danger btn-sm"><i class="fa fa-trash" aria-hidden="true"></i></button>
                            </a>


                        </td>
                    </tr>
                    @endforeach
                    @endif
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            <a href="{{route('user.add')}}"><button class="btn btn-primary">ADD NEW USER</button></a>
        </div>
    </div>
</div>


@endsection

@push('child-scripts')
<script type="text/javascript">
    $(document).on("click", "#btnUserDelete", function(e) {
        event.preventDefault();
        let user_id = $(this).data("id");
        let data = {
            id: user_id
        }
        Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            })
            .then((result) => {
                if (result.isConfirmed) {
                    $.ajaxSetup({
                        headers: {
                            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                        },
                    });
                    $.ajax({
                        type: "POST",
                        url: "/user/delete",
                        data: data,
                        dataType: "json",
                        success: function(data) {
                            if (data.status == 200) {
                                Swal.fire({
                                    title: 'Record deleted successfully',
                                    icon: 'success',
                                    iconColor: 'green',
                                    timer: 3000,
                                    toast: true,
                                    position: 'top-right',
                                    toast: true,
                                    showConfirmButton: false,
                                });

                                window.location.href = "/user"
                            }
                        },
                    });
                }
            });
    })
</script>
@endpush