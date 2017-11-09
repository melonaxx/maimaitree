{!! Form::open(['route' => 'someups.index','style'=>'margin:10px','method'=>'get']) !!}

<div class="col-xs-3">
    <div class="form-group">
        {!! Form::label('file_name','文件名:',['class'=>'form-label']) !!}
        {{ Form::text('file_name',$file_name,['class'=>'form-control file_name select2']) }}
    </div>
</div>
<div class="col-xs-2 pull-right">
    <div class="form-group">
        <br/>
        {!! Form::submit('搜索',['class'=>'btn btn-md btn-primary pull-right searchLesson']) !!}
    </div>
</div>
{!! Form::close() !!}