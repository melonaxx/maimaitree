<table class="table table-responsive" id="carpools-table">
    <thead>
        <th>Uid</th>
        <th>Name</th>
        <th>Sex</th>
        <th>Phone</th>
        <th>Type</th>
        <th>Origin</th>
        <th>By Way</th>
        <th>Terminal</th>
        <th>Time</th>
        <th>Number</th>
        <th>Price</th>
        <th>Frequency</th>
        <th>Relief</th>
        <th>Watch</th>
        <th>Status</th>
        <th colspan="3">Action</th>
    </thead>
    <tbody>
    @foreach($carpools as $carpools)
        <tr>
            <td>{!! $carpools->uid !!}</td>
            <td>{!! $carpools->name !!}</td>
            <td>{!! $carpools->sex !!}</td>
            <td>{!! $carpools->phone !!}</td>
            <td>{!! $carpools->type !!}</td>
            <td>{!! $carpools->origin !!}</td>
            <td>{!! $carpools->by_way !!}</td>
            <td>{!! $carpools->terminal !!}</td>
            <td>{!! $carpools->time !!}</td>
            <td>{!! $carpools->number !!}</td>
            <td>{!! $carpools->price !!}</td>
            <td>{!! $carpools->frequency !!}</td>
            <td>{!! $carpools->relief !!}</td>
            <td>{!! $carpools->watch !!}</td>
            <td>{!! $carpools->status !!}</td>
            <td>
                {!! Form::open(['route' => ['carpools.destroy', $carpools->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('carpools.show', [$carpools->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('carpools.edit', [$carpools->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>