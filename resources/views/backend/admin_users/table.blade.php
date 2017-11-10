<table class="table table-responsive" id="adminUsers-table">
    <thead>
        <th>ID</th>
        <th>姓名</th>
        <th>邮箱</th>
        <th>加入时间</th>
        <th colspan="3">操作</th>
    </thead>
    <tbody>
    @foreach($adminUsers as $adminUsers)
        <tr>
            <td>{!! $adminUsers->id !!}</td>
            <td>{!! $adminUsers->name !!}</td>
            <td>{!! $adminUsers->email !!}</td>
            <td>{!! $adminUsers->created_at !!}</td>
            <td>
                {!! Form::open(['route' => ['adminUsers.destroy', $adminUsers->id], 'method' => 'delete']) !!}
                    <a href="{!! route('adminUsers.edit', [$adminUsers->id]) !!}" class='btn btn-default btn-xs'>编辑</a>
                    {!! Form::button('删除', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>