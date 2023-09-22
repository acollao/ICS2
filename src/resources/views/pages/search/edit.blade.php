@extends('layouts.app' )

@section('title') {{'Edit Records'}} @endsection

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
</style>
@endpush
@section('content')
<div class="container-fluid px-4">
    <h4 class="mt-4">Edit Record</h4>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{route('search.index')}}">Search</a></li>
        <li class="breadcrumb-item active">Edit</li>
    </ol>

    <div class="card mb-4">
        <div class="card-header">
                <i class="fas fa-table me-1"></i>
                Select Field to display/edit only
        </div>
        <div class="card-body">
            @if(isset($fields))
                @foreach($fields as $field)
                    @if($field=="id")
                        <input type="checkbox" value="{{$result[0]->$field}}" name="field" id="{{$field}}" checked>
                        <label for="{{$field}}">ID</label>
                    @else
                        <input type="checkbox" value="{{$result[0]->$field}}" name="field" id="{{$field}}">
                        <label for="{{$field}}">{{\App\Http\Helpers\Helper::RenameFieldname($field)}}</label>
                    @endif
                @endforeach
            @endif
        </div>
        <div class="card-footer">
            <button onclick="displayResult()" class="btn btn-success" style="width: 10%">Apply</button>
        </div>
    </div>
     
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Edit Record
        </div>
        
        @if(isset($result) && isset($fields))
            <form method="POST" action="/search/update" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <table class="table-alvin" id="tableResult">
                               
                            </table>
                        </div>
                    </div>
				</div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-warning" style="width: 10%">SAVE</button>
                </div>
            </form>
        @else
        <div>No record found...</div>
        @endif
       
    </div>
</div>
@endsection

@push('child-scripts')
<script type="text/javascript">
function displayResult(){
    var checkboxes = document.getElementsByName('field');
    $("table.table-alvin").html("");
    for (var i = 0; i < checkboxes.length; i++) {
        if(checkboxes[i].checked){
            var val = checkboxes[i].value;
            if(checkboxes[i].id == "dateReceived" || checkboxes[i].id == "rsd" || checkboxes[i].id == "dateEval" 
            || checkboxes[i].id == "dateLastEdit" || checkboxes[i].id == "dateEntered" 
            || checkboxes[i].id == "mccAssignedTime" || checkboxes[i].id == "dateReturnedToClient" 
            || checkboxes[i].id == "actualDateReturned" || checkboxes[i].id == "dateSourceMod" 
            || checkboxes[i].id == "lastCidUpdateDate" || checkboxes[i].id == "revalDate")
            {
                $("table.table-alvin").append(
                "<tr>\
                <td class=\"col-left\">" + checkboxes[i].id + "</td>\
                <td><input class=\"form-control form-control-sm\" type=\"date\" name=\"" + checkboxes[i].id + "\" value=\"" + val +"\"></td>\
                </tr>"
            )
            }
            else{
                $("table.table-alvin").append(
                "<tr>\
                <td class=\"col-left\">" + checkboxes[i].id + "</td>\
                <td><input class=\"form-control form-control-sm\" type=\"text\" name=\"" + checkboxes[i].id + "\" value=\"" + val +"\"></td>\
                </tr>"
            )
            }
        }
    }    
}
</script>
@endpush