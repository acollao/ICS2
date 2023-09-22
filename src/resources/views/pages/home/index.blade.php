@extends('layouts.app' )

@section('title') {{'Dashboard'}} @endsection

@section('content')
<div class="container-fluid px-4">
    <h4 class="mt-4">Dashboard</h4>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
        <li class="breadcrumb-item active">Tables</li>
    </ol>

    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
    <!-- cards -->
    <div class="row">
        <div class="col-xl-3 col-md-6">
            <div class="card bg-primary text-white mb-4">
                <div class="card-body">Total Users</div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="#">View Details</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-warning text-white mb-4">
                <div class="card-body">Total Projects Enrolled</div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="#">View Details</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-success text-white mb-4">
                <div class="card-body">Online Users</div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="#">View Details</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-danger text-white mb-4">
                <div class="card-body">Activities</div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="#">View Details</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
    </div>

    <!-- tables -->
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Project List
        </div>
        <div class="card-body">
            <table id="datatablesSimple">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Database</th>
                        <th>DB Group</th>
                        <th>TableName</th>
                        <th>Ext Project Name</th>
                        <th>ShowInMCC</th>
                        <th>Weekly Report Email</th>
                    </tr>
                </thead>
                <tbody>
                    @if(isset($projects))
                    @foreach($projects as $project)
                    <tr>
                        <td>{{$project->ProjectName}}</td>
                        <td>{{$project->dbase}}</td>
                        <td>{{$project->dbase_group}}</td>
                        <td>{{$project->dbase_data}}</td>
                        <td>{{$project->extProjectName}}</td>
                        @if($project->showInMcc == 1)
                        <td style="text-align: center;"><input class="form-check-input" type="checkbox" value="" id="flexCheckChecked" checked></td>
                        @else
                        <td><input class="form-check-input" type="checkbox" value="" id="flexCheckDefault"></td>
                        @endif
                        <td>{{$project->weekly_report_email}}</td>
                    </tr>
                    @endforeach
                    @endif
                </tbody>

            </table>
        </div>
    </div>


</div>
@endsection

@push('child-scripts')
<script type="text/javascript">

</script>
@endpush