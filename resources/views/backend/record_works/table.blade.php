<table class="table table-responsive" id="recordWorks-table">
    <thead>
        <th>Uid</th>
        <th>Type</th>
        <th>Classify</th>
        <th>Salary</th>
        <th>Date</th>
        <th>Work Time</th>
        <th colspan="3">Action</th>
    </thead>
    <tbody>
    @foreach($recordWorks as $recordWork)
        <tr>
            <td>{!! $recordWork->uid !!}</td>
            <td>{!! $recordWork->type !!}</td>
            <td>{!! $recordWork->classify !!}</td>
            <td>{!! $recordWork->salary !!}</td>
            <td>{!! $recordWork->date !!}</td>
            <td>{!! $recordWork->work_time !!}</td>
            <td>
                {!! Form::open(['route' => ['recordWorks.destroy', $recordWork->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('recordWorks.show', [$recordWork->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('recordWorks.edit', [$recordWork->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>