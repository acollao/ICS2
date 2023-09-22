@extends('layouts.app' )

@section('title') {{'Upload Template'}} @endsection

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
        border-collapse: collapse;
    }

    .thead {
        font-weight: 900;
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
    .fixed-height{
        height: 250px;
        padding:3px; 
    }
    
    .scrollable-content{
        overflow:auto;
        height:224px;
    }
</style>
@endpush
@section('content')
<div class="container-fluid px-4">
    <h4 class="mt-4">Upload Template</h4>
    <ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="{{route('home.index')}}">Home</a></li>
        <li class="breadcrumb-item active">Addons</li>
    </ol>
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Select Project ({{$tblname}})
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
                                                <option value="{{$projName->dbase_group}}|{{$projName->dbase_data}}|{{$projName->extProjectName}} | {{ $projName->ProjectID }}" {{$projName->dbase_data == $tblname ? 'selected="selected"' : ''}}>{{$projName->ProjectName}}</option>
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
        <div class="card-header"><i class="fas fa-table me-1"></i>Select Fieldname/Template</div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="card mb-2 fixed-height">
                        <div class="card-header">Fields</div>
                        <div class="card-body scrollable-content" id="fieldContent">
                           
                        </div>
                        <div class="card-footer">
                            <button class="btn btn-success" id="btnCreate">Create</button>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card mb-2 fixed-height">
                        <div class="card-header">Template</div>
                        <div class="card-body scrollable-content">
                            <table class="table-alvin" id="tbl-template">

                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Select Filename
        </div>
        <form id="fileUploadForm">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <div id="transmittal">
                            <div class="mb-3">
                                <label for="formFileSm" class="form-label">Select .xls template</label>
                                <input class="form-control form-control-sm" id="fileInput" type="file" accept=".xlsx">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button class="btn btn-warning" type="submit" id="btnUpload">Upload</button>
            </div>
        </form>
    </div>
@endsection

@push('child-scripts')
<script type="text/javascript">
   $(document).ready(function() {
        $('body').on("click", "#btnCreate", function(e) {
            e.preventDefault();
            var chkBox = document.getElementsByName('chkfield');
            let projectDB = document.getElementById("project-db").value;
            let projectSplit = projectDB.split("|");
            let tblName = projectSplit[1];
            let dbNameGroup = projectSplit[0];
            let projectId = projectSplit[3];
            var fields = [];
            // get all the checkbox field with check and store it in an array
            for (var i = 0; i < chkBox.length; i++) {
                if(chkBox[i].checked){
                    fields.push(chkBox[i].value);
                }
            }

            alert();

            if(fields.length === 0){
                Swal.fire({
                    title: 'No Fields selected!',
                    icon: 'error',
                    iconColor: 'red',
                    timer: 3000,
                    toast: true,
                    position: 'top-right',
                    toast: true,
                    showConfirmButton: false,
                });
                return;
            }else{
                let data = {
                    fields     : fields,
                    project_db : dbNameGroup,
                    project_tbl: tblName,
                    projectId  : projectId
                    }

                $.ajax({
                    type: "POST",
                    url: "{{ route('addons.create-template') }}",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: data,
                    dataType: "json",
                    success: function(response) {
                        displayTemplate(response);
                        Swal.fire({
                            title: 'New Template Created',
                            icon: 'success',
                            iconColor: 'green',
                            timer: 3000,
                            toast: true,
                            position: 'top-right',
                            toast: true,
                            showConfirmButton: false,
                        });
                    },
                    error: function(response){
                        if(response.status == 500){
                            Swal.fire({
                            title: 'Error: 500 Internal server',
                            icon: 'error',
                            iconColor: 'red',
                            timer: 3000,
                            toast: true,
                            position: 'top-right',
                            toast: true,
                            showConfirmButton: false,
                        });
                        }
                    }
                })
            }
        });

        $('body').on("submit", "#submitForm", function(e) {
            e.preventDefault();
            let projectDB = document.getElementById("project-db").value;
            let projectSplit = projectDB.split("|");
            let tblName = projectSplit[1];
            let dbNameGroup = projectSplit[0];
            let projectId = projectSplit[3];
            let data = {
                tblName: tblName,
                dbNameGroup: dbNameGroup,
                projectId: projectId
            };

            $.ajax({
                type: "GET",
                url: "{{ route('addons.get-template') }}",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: data,
                dataType: "json",
                success: function(response) {
                    $("body").removeClass("loading");
                    $("#fieldContent").html("");
                    $.each(response.fields, function(key, item) {
                        $("#fieldContent").append(
                            `<div class="form-check">
                                <input class="form-check-input" name="chkfield" type="checkbox" value="` + item + `" id="flexCheckDefault">
                                <label class="form-check-label" for="flexCheckDefault">
                                    ` + item + `
                                </label>
                            </div>`
                        )
                    })
                    
                    // display template available
                    displayTemplate(response);
                    
                    Swal.fire({
                    title: 'Loading Fields',
                    icon: 'success',
                    iconColor: 'green',
                    timer: 3000,
                    toast: true,
                    position: 'top-right',
                    toast: true,
                    showConfirmButton: false,
                });
                },
            });
        });

        $('body').on("click", "#btnExport", function(e) {
            e.preventDefault();
            let filename = $(this).data("id");
            let data = {
                    filename: filename
                };

                var url = "{{URL::to('/downloadFile')}}?" + $.param(data)
                window.location = url;
        });

        $('#fileUploadForm').submit(function (e) {
            e.preventDefault();

            let projectDB = document.getElementById("project-db").value;
            let templateName = document.getElementById("fileInput").value;
            let projectSplit = projectDB.split("|");
            let tblName = projectSplit[1];
            let dbNameGroup = projectSplit[0];
            let projectId = projectSplit[3];
            // Create a FormData object to store the form data
            var formData = new FormData();
            formData.append('file', $('#fileInput')[0].files[0]);
            formData.append('dbNameGroup', dbNameGroup);
            formData.append('tblName', tblName);
            formData.append('projectId', projectId);

            if(templateName == ""){
                Swal.fire({
                    title: 'Please select template to process or incorrect template used.',
                    icon: 'error',
                    iconColor: 'red',
                    timer: 3000,
                    toast: true,
                    position: 'top-right',
                    toast: true,
                    showConfirmButton: false,
                });
                return;
            }
            var tmpName = templateName.split("\\").pop();
            if(!tmpName.startsWith(tblName)){
                Swal.fire({
                    title: 'Incorrect template used.',
                    icon: 'error',
                    iconColor: 'red',
                    timer: 3000,
                    toast: true,
                    position: 'top-right',
                    toast: true,
                    showConfirmButton: false,
                });
                return;
            }

            Swal.fire({
                    title: 'Please Confirm',
                    text: "This template will be uploaded to " + tblName,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Upload'
                })
                .then((willUpload) => {
                    if (willUpload) {
                        $.ajax({
                            type: "POST",
                            url: "{{ route('addons.upload-template') }}",
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            data: formData,
                            //dataType: "json",
                            processData: false,
                            contentType: false,
                            success: function(data) {
                                $("body").removeClass("loading");
                                if (data.status === 200) {
                                    Swal.fire({
                                        title: 'Record Uploaded successfully',
                                        icon: 'success',
                                        iconColor: 'green',
                                        showClass: {
                                            popup: 'animate__animated animate__fadeInDown'
                                        },
                                        hideClass: {
                                            popup: 'animate__animated animate__fadeOutUp'
                                        }
                                    });
                                } else if (data.status == 400) {
                                    Swal.fire({
                                        title: 'Error: ' + data.message,
                                        icon: 'error',
                                        iconColor: 'red',
                                        showClass: {
                                            popup: 'animate__animated animate__fadeInDown'
                                        },
                                        hideClass: {
                                            popup: 'animate__animated animate__fadeOutUp'
                                        }
                                    });
                                } else if (data.status == 401) {
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
                                } else  if (data.status == 500) {
                                    Swal.fire({
                                        title: 'Error: ' + data.message,
                                        icon: 'error',
                                        iconColor: 'red',
                                        showClass: {
                                            popup: 'animate__animated animate__fadeInDown'
                                        },
                                        hideClass: {
                                            popup: 'animate__animated animate__fadeOutUp'
                                        }
                                    });
                                }
                            },
                            error: function(xhr, status, error){
                                console.error(error);
                                console.error(status);
                                console.error(xhr);
                                Swal.fire('Error in Ajax.')
                            }
                        });
                    }
                });
            
        })

        function displayTemplate(response){
            $("#tbl-template").html("");
            $("#tbl-template").append(
                `<thead class="thead"><tr>
                    <td>Action</td>
                    <td>Name</td>
                    <td>Created_By</td>
                    <td>Date_Created</td>
                    <td>Last_Used</td>
                </tr></thead><tbody>`
            );
            $.each(response.templates, function(key, item) {
                $("#tbl-template").append(
                   `<tr>
                        <td><a class="btn btn-danger btn-sm" data-id="` + item.template + `" id="btnExport"><i class="fa fa-download" aria-hidden="true"></i></a></td>
                        <td>` + item.template + `</td>
                        <td>` + item.created_by + `</td>
                        <td>` + item.date_created + `</td>
                        <td>` + item.last_used + `</td>
                    </tr>`
                )
            })

            $("#tbl-template").append(`</tbody>`)
        }
    });
</script>
@endpush

