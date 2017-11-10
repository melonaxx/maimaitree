
{!! Form::open(['route' => 'adminUsers.index','style'=>'margin:10px','method'=>'get']) !!}
<div class="col-xs-3">
    <div class="form-group">
        {!! Form::label('system','系统类型:',['class'=>'form-label']) !!}
        {{ Form::select('system', array(2,3,5), null, ['class'=>'form-control system']) }}
    </div>
</div>


<div class="col-xs-2 pull-right">
    <div class="form-group">
        <br/>
        {!! Form::submit('搜索',['class'=>'searchCourse btn btn-md btn-primary pull-right']) !!}
    </div>
</div>
{!! Form::close() !!}
