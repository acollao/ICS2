<div class="table-container">
    <table class="table">
        <thead>
            <tr>
                @if(isset($headers)) 
                    @foreach($headers as $header)
                        <th>{{ $header == "id" ? "Action" : $header }}</th>
                    @endforeach 
                @endif
            </tr>
        </thead>
        <tbody>
            @if(isset($results)) 
           
                @foreach($results as $row) 
                    <tr>
                    @php $counter = 0 @endphp
                        @foreach($row as $cell)
                            @if($counter === 0)
                            <td class="col-2">
                                <a class="btn btn-warning btn-sm" data-id="{{$cell}}" id="edit"><i class="fas fa-edit"></i></a>&nbsp;
                                <a class="btn btn-danger btn-sm" data-id="{{$cell}}" id="delete-confirm"><i class="fas fa-trash-alt"></i></a>
                            </td>
                            @else
                                <td>{{ $cell }}</td>
                            @endif
                            <p hidden>{{ $counter++ }}</p>    
                        @endforeach
                    </tr>
                @endforeach 
            @endif
        </tbody>
    </table>

    @if(isset($results)) {!! $results->links() !!} @endif
</div>
