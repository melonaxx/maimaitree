<table class="table table-responsive" id="users-table">
    <thead>
        <th>Openid</th>
        <th>Name</th>
        <th>Nickname</th>
        <th>Sex</th>
        <th>Age</th>
        <th>Phone</th>
        <th>Status</th>
        <th colspan="3">Action</th>
    </thead>
    <tbody>
    @foreach($users as $users)
        <tr>
            <td>{!! $users->openid !!}</td>
            <td>{!! $users->name !!}</td>
            <td>{!! $users->nickname !!}</td>
            <td>{!! $users->sex !!}</td>
            <td>{!! $users->age !!}</td>
            <td>{!! $users->phone !!}</td>
            <td>{!! $users->status !!}</td>
            <td>
                {!! Form::open(['route' => ['users.destroy', $users->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('users.show', [$users->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('users.edit', [$users->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>