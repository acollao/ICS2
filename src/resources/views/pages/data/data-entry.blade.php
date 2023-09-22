@extends('layouts.app' )

@section('title') {{'Add New Records'}} @endsection

@push('styles')
<style>
     .table-alvin{
        display: table;
        width:100%;
        border-collapse: collapse;
    }
    td{
        width: 50%;
        text-align: left;
        border: 1px solid black;
        padding: 10px;
    }
    .table-alvin, tr, td{
        border: 1px solid;
    }
    
</style>
@endpush
@section('content')
<div class="container-fluid px-4">
    <h4 class="mt-4">Data Entry</h4>
    <ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="{{route('data.index')}}">ADD DATA</a></li>
        <li class="breadcrumb-item active">Data Entry</li>
    </ol>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Select Project
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-6">
                  <table class="table-alvin">
                    <tr>
                        <td>Box Filename : {{$boxFilename}}</td>
                        <td>Special Character Table</td>
                    </tr>
                    <tr>
                        <td>Search By ISBN13</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <label for="">By ISBN13</label>
                            <input type="text" class="form-control form-control-sm">
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                        <div class="form-group">
                            <label for=""><b>By Copyright Year</b></label>
                            <input class="form-control form-control-sm" type="text">
                            <label for=""><b>By Title</b></label>
                            <input class="form-control form-control-sm" type="text">
                            <button class="btn btn-warning">get details</button>
                        </div>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                    </tr>
                  </table>
                </div>
            </div>   
        </div>
        <div class="card-footer">
            <button class="btn btn-danger" id="btnSelect">PREVIEW LAST</button>
            <button class="btn btn-danger" id="btnSelect">SAVE</button>
        </div>
    </div>

@endsection

@push('child-scripts')
<script type="text/javascript">
   $(document).ready(function() {

   })

</script>
@endpush