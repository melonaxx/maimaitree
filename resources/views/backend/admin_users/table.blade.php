<table class="table table-responsive" id="adminUsers-table">
    <thead>
        <th>Name</th>
        <th colspan="3">Action</th>
    </thead>
    <tbody>
    @foreach($adminUsers as $adminUsers)
        <tr>
            <td>{!! $adminUsers->name !!}</td>
            <td>
                {!! Form::open(['route' => ['adminUsers.destroy', $adminUsers->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('adminUsers.show', [$adminUsers->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('adminUsers.edit', [$adminUsers->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>