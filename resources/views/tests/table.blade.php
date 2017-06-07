<table class="table table-responsive" id="tests-table">
    <thead>
        <th>Title</th>
        <th>Post Date</th>
        <th>Body</th>
        <th>Password</th>
        <th>Token</th>
        <th>Email</th>
        <th>Author Gender</th>
        <th>Post Type</th>
        <th>Post Visits</th>
        <th>Category</th>
        <th>Category Short</th>
        <th>Is Private</th>
        <th>Ext1</th>
        <th>Ext2</th>
        <th>Ext3</th>
        <th>Ext4</th>
        <th colspan="3">Action</th>
    </thead>
    <tbody>
    @foreach($tests as $test)
        <tr>
            <td>{!! $test->title !!}</td>
            <td>{!! $test->post_date !!}</td>
            <td>{!! $test->body !!}</td>
            <td>{!! $test->password !!}</td>
            <td>{!! $test->token !!}</td>
            <td>{!! $test->email !!}</td>
            <td>{!! $test->author_gender !!}</td>
            <td>{!! $test->post_type !!}</td>
            <td>{!! $test->post_visits !!}</td>
            <td>{!! $test->category !!}</td>
            <td>{!! $test->category_short !!}</td>
            <td>{!! $test->is_private !!}</td>
            <td>{!! $test->ext1 !!}</td>
            <td>{!! $test->ext2 !!}</td>
            <td>{!! $test->ext3 !!}</td>
            <td>{!! $test->ext4 !!}</td>
            <td>
                {!! Form::open(['route' => ['tests.destroy', $test->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('tests.show', [$test->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('tests.edit', [$test->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>