<br/>
<div class="form-group col-sm-12">
    {!! Form::label('source', '上传资源:',['class'=>'col-sm-5 control-label  text-right']) !!}
    <div class="col-sm-3">
        <div class="file">
            请选择文件
            <input type="file" multiple="multiple" name="source[]">
        </div>
        <div style="color:#F79709">注：文件大小不能超过2M</div>
    </div>
</div>

<div class="form-group col-sm-11 text-center">
    {!! Form::submit('保存', ['class' => 'btn btn-primary']) !!}
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <a href="{!! route('someups.index') !!}" class="btn btn-default">返回</a>
</div>
