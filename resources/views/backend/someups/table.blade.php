<table class="table table-responsive table-hover" id="someups-table">
    <thead>
        <th>ID</th>
        <th>标题</th>
        <th>文件名</th>
        <th>文件大小</th>
        <th>创建时间</th>
        <th colspan="3">操作</th>
    </thead>
    <tbody>
    @foreach($someups as $someups)
        <tr>
            <td>{!! $someups->id !!}</td>
            <td>{!! $someups->title !!}</td>
            <td>{!! $someups->file_name !!}</td>
            <td>{!! $someups->size !!}</td>
            <td>{!! $someups->created_at !!}</td>
            <td>
                {!! Form::open(['route' => ['someups.destroy', $someups->id], 'method' => 'delete']) !!}
                    <a href="{!! $someups->source !!}" class='btn btn-info btn-xs' target="_blank">预览</a>
                    {{--<a href="{!! route('someups.edit', [$someups->id]) !!}" class='btn btn-default btn-xs'>编辑</a>--}}
                    {!! Form::button('删除', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('你确定要删除么?')"]) !!}
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>