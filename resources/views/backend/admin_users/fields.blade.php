<br/>
<div class="form-group col-sm-12">
    {!! Form::label('name', '用户名:',['class'=>'col-sm-5 control-label text-right']) !!}
    <div class="col-sm-3">
        {!! Form::text('name', null, ['class' => 'form-control name','required'=>'true']) !!}
        <span style="color:red;font-size:25px;position: absolute;top: 5px;right: 0px;" class="pull-right">*</span>
    </div>
</div>
<div class="form-group col-sm-12">
    {!! Form::label('email', '邮箱:',['class'=>'col-sm-5 control-label text-right']) !!}
    <div class="col-sm-3">
        {!! Form::text('email', null, ['class' => 'form-control email','required'=>'true']) !!}
        <span style="color:red;font-size:25px;position: absolute;top: 5px;right: 0px;" class="pull-right">*</span>
    </div>
</div>
<div class="form-group col-sm-12">
    {!! Form::label('password', '密码:',['class'=>'col-sm-5 control-label text-right']) !!}
    <div class="col-sm-3">
        {!! Form::password('password', ['class'=>'form-control','required'=>'true']) !!}
        <span style="color:red;font-size:25px;position: absolute;top: 5px;right: 0px;" class="pull-right">*</span>
    </div>
</div>
<div class="form-group col-sm-12">
    {!! Form::label('copy_password', '确认密码:',['class'=>'col-sm-5 control-label text-right']) !!}
    <div class="col-sm-3">
        {!! Form::text('copy_password', null, ['class' => 'form-control copy_password','required'=>'true']) !!}
        <span style="color:red;font-size:25px;position: absolute;top: 5px;right: 0px;" class="pull-right">*</span>
    </div>
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12 text-center">
    {!! Form::submit('保存', ['class' => 'btn btn-primary']) !!}
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <a href="{!! route('adminUsers.index') !!}" class="btn btn-default">取消</a>
</div>
