<div class="card">
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
