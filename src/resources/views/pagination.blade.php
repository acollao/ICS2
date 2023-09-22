<table class="table">
    @foreach ($items as $item)
    <tr>
        <td>{{$item->name}}</td>
        <td>{{$item->username}}</td>
        <td>{{$item->email}}</td>
        <td>{{$item->created_at}}</td>
        <td>{{$item->role_id}}</td>
    </tr>

    @endforeach
</table>

<div id="pagination">
    {{ $items->links() }}
</div>
