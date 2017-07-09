<table class="table table-responsive" id="recordUsers-table">
    <thead>
        <th>Openid</th>
        <th>Uname</th>
        <th>Nick Name</th>
        <th>Gender</th>
        <th>Daily Salary</th>
        <th colspan="3">Action</th>
    </thead>
    <tbody>
    @foreach($recordUsers as $recordUser)
        <tr>
            <td>{!! $recordUser->openid !!}</td>
            <td>{!! $recordUser->uname !!}</td>
            <td>{!! $recordUser->nick_name !!}</td>
            <td>{!! $recordUser->gender !!}</td>
            <td>{!! $recordUser->daily_salary !!}</td>
            <td>
                {!! Form::open(['route' => ['recordUsers.destroy', $recordUser->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('recordUsers.show', [$recordUser->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('recordUsers.edit', [$recordUser->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>