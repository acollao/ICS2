@extends('layouts.app' )

@section('title') {{'Add New Records'}} @endsection

@push('styles')
<style>
    label {
        font-weight: 500;
    }

    .col-right {
        text-align: right;
        padding-right: 1rem;
    }

    .col-left{
        font-weight: 500;
    }

    .table-alvin{
        display: table;
        width:100%;
    }

    .btn-alvin {
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
        background-color: #4CAF50;
        border: 1px;
        margin-left: 5px;
        border-radius: 4px;
        padding: 3px 10px;
        transition-duration: 0.4s;
        box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2), 0 6px 20px 0 rgba(0,0,0,0.19);
    }

    .btn-alvin:hover {
        background-color: #4CAF50; /* Green */
        color: white;
        box-shadow: 0 12px 16px 0 rgba(0,0,0,0.24), 0 17px 50px 0 rgba(0,0,0,0.19);
    }
    
</style>
@endpush
@section('content')
<div class="container-fluid px-4">
    <h4 class="mt-4">Add New Issue</h4>
    <ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="{{route('home.index')}}">Home</a></li>
        <li class="breadcrumb-item active">Data</li>
    </ol>
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Select Project
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <div class="input-group">
                        <form id="submitForm">
                            <table>
                                <tr>
                                    <td>
                                        <select class="form-select select2" name="project_db" id="project-db" aria-label="alvin-label">
                                                @foreach($projects as $projKey => $projName)
                                                    <option value="{{$projName->dbase_group}}|{{$projName->dbase_data}}|{{$projName->extProjectName}}">{{$projName->ProjectName}}</option>
                                                @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <button type="submit" class="btn-alvin" type="button">SHOW</button>
                                    </td>
                                </tr>
                            </table>
                        </form>
                    </div>
                </div>
            </div>   
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Select BoxFilename
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <div id="transmittal">
                        <form id="submitForm2">
                            <select class="form-select select2" name="boxfilename" id="boxfilename" aria-label="alvin-label">
                                    <option value="None" selected>None</option>
                            </select>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-warning" id="btnChoose">CHOOSE</button>
        </div>
    </div>
@endsection

@push('child-scripts')
<script type="text/javascript">
   $(document).ready(function() {
    $('body').on("submit", "#submitForm", function(e) {
        e.preventDefault();
        let projectDB = document.getElementById("project-db").value;
            let projectSplit = projectDB.split("|");
            let tblName = projectSplit[1];
            let dbNameGroup = projectSplit[0];
            let data = {
                tblName: tblName,
                dbNameGroup: dbNameGroup,
            };

            $.ajax({
                type: "POST",
                url: "{{ route('data.showBoxfilename') }}",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: data,
                dataType: "json",
                success: function(response) {
                    $("#boxfilename").html("");
                    $("#boxfilename").attr("multiple");
                    $.each(response.boxFilenames, function(key, item) {
                        $("#boxfilename").append(
                            "<option value=\"" + item.boxFilename + "\">" + item.boxFilename + "<option>"
                        );
                    });
                },
                error: function(response){
                    Swal.fire({
                        title: 'Unauthorized transaction.',
                        icon: 'warning',
                        iconColor: 'red',
                        timer: 3000,
                        toast: true,
                        position: 'top-right',
                        toast: true,
                        showConfirmButton: false,
                    });
                }
            })
    })

    $('body').on("click", "#btnChoose", function(e) {
        e.preventDefault();
        let projectDB = document.getElementById("project-db").value;
            let projectSplit = projectDB.split("|");
            let tblName = projectSplit[1];
            let dbNameGroup = projectSplit[0];
            let data = {
                tblName: tblName,
                dbNameGroup: dbNameGroup,
                boxfilename: document.getElementById("boxfilename").value
            };

            var url = "{{URL::to('/add/dataEntry')}}?" + $.param(data)
            window.location = url;
    })


   })

</script>
@endpush