@extends('layouts.app' ) @section('title') {{ "Search Project" }} @endsection

@push('styles')
<style>
    /* Style the container and table */
.table-container {
    max-height: 600px; /* Set a maximum height for the container */
    overflow-y: scroll; /* Enable vertical scrolling */
}

table {
    width: 100%;
    border-collapse: collapse;
}

/* Style table headers and cells as needed */
th, td {
    border: 1px solid #ddd;
    padding: 8px;
    text-align: left;
}
</style>
@endpush

@section('content')

<div class="container-fluid px-4">
    <h4 class="mt-4">Record Management</h4>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item">
            <a href="{{ route('home.index') }}">Home</a>
        </li>
        <li class="breadcrumb-item active">Search</li>
    </ol>
    @if (session('status'))
    <div class="alert alert-success">
        {{ session("status") }}
    </div>
    @endif
    <div class="card mb-4">
        <div class="card-body">
            SEARCH MENU - a menu link that lets users search for specific data
            from unique, duplicate and in query database. Page is accessible to
            all users.
        </div>
    </div>
    <form
        id="submitSearchForm"
        action="{{ url('/search.searchjobname') }}"
        method="post"
    >
        @csrf
        <div class="card mb-4">
            <div class="card-header">Select Project and Table</div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Project Name</label>
                            @if(count($projects))
                            <select
                                class="form-control select2"
                                name="project_db"
                                id="project-db"
                                style="width: 100%"
                            >
                                @foreach($projects as $projKey => $projName)
                                <option
                                    value="{{$projName->dbase_group}}|{{$projName->dbase_data}}|{{$projName->extProjectName}}"
                                >
                                    {{$projName->ProjectName}}
                                </option>
                                @endforeach
                            </select>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Look In Table</label>
                            <select
                                class="form-control select2"
                                name="project_db_type"
                                id="project-table"
                                style="width: 100%"
                            >
                                <option>UNIQUE</option>
                                <option>DUPLICATE</option>
                                <option>QUERY</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">Filter Selection by Fieldname</div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <table>
                            <tr>
                                <td>Search By</td>
                                <td>
                                    <select
                                        class="form-select form-select-sm"
                                        name="field1"
                                        id="field1"
                                        style="width: 100%"
                                    >
                                        @include('pages/search/fields')
                                    </select>
                                </td>
                                <td>
                                    <input
                                        class="form-control form-control-sm"
                                        type="text"
                                        name="fieldValue1"
                                        id="fieldValue1"
                                        style="width: 100%"
                                    />
                                </td>
                                <td>
                                    <select
                                        class="form-select form-select-sm"
                                        name="operator1"
                                        id="operator1"
                                        style="width: 100%"
                                    >
                                        <option value="AND" selected>
                                            AND
                                        </option>
                                        <option value="OR">OR</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>
                                    <select
                                        class="form-select form-select-sm"
                                        name="field2"
                                        id="field2"
                                        style="width: 100%"
                                    >
                                    @include('pages/search/fields')
                                    </select>
                                </td>
                                <td>
                                    <input
                                        class="form-control form-control-sm"
                                        type="text"
                                        name="fieldValue2"
                                        id="fieldValue2"
                                        style="width: 100%"
                                    />
                                </td>
                                <td>
                                    <select
                                        class="form-select form-select-sm"
                                        name="operator2"
                                        id="operator2"
                                        style="width: 100%"
                                    >
                                        <option value="AND">AND</option>
                                        <option value="OR">OR</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>
                                    <select
                                        class="form-select form-select-sm"
                                        name="field3"
                                        id="field3"
                                        style="width: 100%"
                                    >
                                    @include('pages/search/fields')
                                    </select>
                                </td>
                                <td>
                                    <input
                                        class="form-control form-control-sm"
                                        type="text"
                                        name="fieldValue3"
                                        id="fieldValue3"
                                        style="width: 100%"
                                    />
                                </td>
                                <td></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button
                    class="btn btn-warning btn-search"
                    id="btn-search"
                    type="submit"
                >
                    SEARCH
                </button>
                <button class="btn btn-primary btn-search" id="edit" hidden>
                    TEST
                </button>
                <button
                    class="btn btn-primary btn-search excel"
                    id="excel"
                    hidden
                >
                    Export
                </button>
            </div>
        </div>
    </form>
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            DataTable Records
        </div>
        <div class="card-body">
            <div id="search-results">@include('pages.search.paginated')</div>
        </div>
        <div class="card-footer">
            <button class="btn btn-danger" id="deleteAll">DELETE ALL</button>
            <button class="btn btn-success" id="export">EXPORT TO XLS</button>
        </div>
    </div>
</div>

@endsection 
@push('child-scripts')

<script type="text/javascript">
    window.addEventListener("unload", cleanSearchResult(), false);

    function cleanSearchResult() {
        if (sessionStorage.getItem("search_result") !== null) {
            sessionStorage.removeItem("search_result");
        }

        if (sessionStorage.getItem("query") !== null) {
            sessionStorage.removeItem("query");
        }
    }

    $(document).ready(function () {
        $("body").on("click", "#btn-test", function (e) {
            e.preventDefault();
            if (sessionStorage.getItem("search_result") !== null) {
                const storedRecords = JSON.parse(
                    sessionStorage.getItem("search_result")
                );
                console.log(storedRecords[0].jobname);
            }
        });

        const fetch_data = (page) => {
            let projectDB = document.getElementById("project-db").value;
            let projectSplit = projectDB.split("|");
            let tblName = projectSplit[1];
            let dbNameGroup = projectSplit[0];
            let data = {
                tblName: tblName,
                dbNameGroup: dbNameGroup,
                field1: $("#field1").val(),
                field2: $("#field2").val(),
                field3: $("#field3").val(),
                fieldValue1: $("#fieldValue1").val(),
                fieldValue2: $("#fieldValue2").val(),
                fieldValue3: $("#fieldValue3").val(),
                operator1: $("#operator1").val(),
                operator2: $("#operator2").val(),
            };

            $.ajax({
                type: "POST",
                url: "{{ route('search.searchjobname') }}/?page=" + page,
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
                data: data,
                dataType: "json",
                success: function (data) {
                    $("table").html("");
                    $("table").html(data);
                },
            });
        };

        // search record and display result
        $("body").on("submit", "#submitSearchForm", function (e) {
            e.preventDefault();

            $("#search-results").html("");
            let projectDB = document.getElementById("project-db").value;
            let projectSplit = projectDB.split("|");
            let tblName = projectSplit[1];
            let dbNameGroup = projectSplit[0];
            let data = {
                tblName: tblName,
                dbNameGroup: dbNameGroup,
                field1: $("#field1").val(),
                field2: $("#field2").val(),
                field3: $("#field3").val(),
                fieldValue1: $("#fieldValue1").val(),
                fieldValue2: $("#fieldValue2").val(),
                fieldValue3: $("#fieldValue3").val(),
                operator1: $("#operator1").val(),
                operator2: $("#operator2").val(),
            };

            var inputValue = document.getElementById("fieldValue1").value;
            if ($("#fieldValue1").val() === "") {
                alert("Field is empty");
                $("body").removeClass("loading");
                cleanSearchResult();
            } else {
                sessionStorage.setItem("query", JSON.stringify(data));

                $.ajax({
                    type: "POST",
                    url: "{{ route('search.searchjobname') }}",
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                            "content"
                        ),
                    },
                    data: data,
                    dataType: "json",
                    success: function (data) {
                        
                        $("#search-results").html(data.html);
                    },
                });
            }
        });
        // reset function
        $("body").on("click", "#btnReset", function (e) {
            e.preventDefault();
            $("#field1").prop("selectedIndex", 0);
            $("#field2").prop("selectedIndex", 0);
            $("#field3").prop("selectedIndex", 0);
            $("input[type=text]").each(function () {
                $(this).val("");
            });
            sessionStorage.removeItem("query");
            sessionStorage.removeItem("search_result");
        });
        // edit specific record
        $("body").on("click", "#edit", function (e) {
            e.preventDefault();
            let form = document.getElementById("btn-search");
            let projectDB = document.getElementById("project-db").value;
            let projectSplit = projectDB.split("|");
            let dbname = projectSplit[0];
            let tblname = projectSplit[1];
            let id = $(this).data("id");
            let data = {
                dbname: dbname,
                tblname: tblname,
                id: id,
            };

            if (dbname !== null && tblname !== null && id !== null) {
                var url = "{{URL::to('/search/edit')}}?" + $.param(data);
                window.location = url;
            } else {
                alert("No records to export.");
            }
        });
        // delete specific record
        $("body").on("click", "#delete-confirm", function (e) {
            e.preventDefault();
            let form = document.getElementById("btn-search");
            let projectDB = document.getElementById("project-db").value;
            let projectSplit = projectDB.split("|");
            let dbname = projectSplit[0];
            let tblname = projectSplit[1];
            let id = $(this).data("id");
            let data = {
                dbname: dbname,
                tblname: tblname,
                id: id,
            };

            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!",
            }).then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        type: "POST",
                        url: "{{ route('search.deletejobnameById') }}",
                        headers: {
                            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                                "content"
                            ),
                        },
                        data: data,
                        dataType: "json",
                        success: function (data) {
                            if (data.status == 200) {
                                Swal.fire({
                                    title: "Record deleted successfully",
                                    icon: "success",
                                    iconColor: "green",
                                    timer: 3000,
                                    toast: true,
                                    position: "top-right",
                                    toast: true,
                                    showConfirmButton: false,
                                });
                                form.click();
                            } else if (data.status == 401) {
                                Swal.fire({
                                    title: "Unauthorized transaction.",
                                    icon: "warning",
                                    iconColor: "red",
                                    timer: 3000,
                                    toast: true,
                                    position: "top-right",
                                    toast: true,
                                    showConfirmButton: false,
                                });
                            }
                        },
                    });
                }
            });
        });
        // delete all record
        $("body").on("click", "#delete-all", function (e) {
            e.preventDefault();
            let form = document.getElementById("btn-search");
            let projectDB = document.getElementById("project-db").value;
            let projectSplit = projectDB.split("|");
            let dbname = projectSplit[0];
            let tblname = projectSplit[1];

            const storedRecords = JSON.parse(
                sessionStorage.getItem("search_result")
            );
            var jobname = storedRecords[0].jobname;
            let data = {
                dbname: dbname,
                tblname: tblname,
                jobname: jobname,
            };

            Swal.fire({
                title: "Are you sure you want to delete all records with selected jobname?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!",
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        url: "{{ route('search.deletejobname') }}",
                        headers: {
                            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                                "content"
                            ),
                        },
                        data: data,
                        dataType: "json",
                        success: function (data) {
                            sessionStorage.removeItem("search_result");
                            form.click();
                            Swal.fire({
                                title: "Jobname delete successfully",
                                icon: "success",
                                iconColor: "green",
                                timer: 3000,
                                toast: true,
                                position: "top-right",
                                toast: true,
                                showConfirmButton: false,
                            });
                        },
                    });
                }
            });
        });
        // delete all record using button
        $("body").on("click", "#deleteAll", function (e) {
            e.preventDefault();
            let form = document.getElementById("btn-search");
            let projectDB = document.getElementById("project-db").value;
            let projectSplit = projectDB.split("|");
            let dbname = projectSplit[0];
            let tblname = projectSplit[1];

            if (sessionStorage.getItem("query") !== null) {
                const query = JSON.parse(sessionStorage.getItem("query"));

                Swal.fire({
                    title: "Are you sure you want to delete all records with selected jobname?",
                    text: "You won't be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, delete it!",
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "POST",
                            url: "{{ route('search.deletejobname') }}",
                            headers: {
                                "X-CSRF-TOKEN": $(
                                    'meta[name="csrf-token"]'
                                ).attr("content"),
                            },
                            data: query,
                            dataType: "json",
                            success: function (data) {
                                sessionStorage.removeItem("search_result");
                                form.click();
                                Swal.fire({
                                    title: "Jobname delete successfully",
                                    icon: "success",
                                    iconColor: "green",
                                    timer: 3000,
                                    toast: true,
                                    position: "top-right",
                                    toast: true,
                                    showConfirmButton: false,
                                });
                            },
                        });
                    }
                });
            }
        });

        $("body").on("click", "#export", function (e) {
            e.preventDefault();
            let form = document.getElementById("btn-search");
            let projectDB = document.getElementById("project-db").value;
            let projectSplit = projectDB.split("|");
            let dbname = projectSplit[0];
            let tblname = projectSplit[1];

            if (sessionStorage.getItem("query") !== null) {
                const query = JSON.parse(sessionStorage.getItem("query"));
                var url = "{{URL::to('/search/export')}}?" + $.param(query);

                window.location = url;
            } else {
                alert("No records to export.");
            }
        });
    });
</script>
@endpush
