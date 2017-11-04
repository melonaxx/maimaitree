<!-- Openid Field -->
<div class="form-group col-sm-6">
    {!! Form::label('openid', 'Openid:') !!}
    {!! Form::text('openid', null, ['class' => 'form-control']) !!}
</div>

<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Name:') !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<!-- Nickname Field -->
<div class="form-group col-sm-6">
    {!! Form::label('nickname', 'Nickname:') !!}
    {!! Form::text('nickname', null, ['class' => 'form-control']) !!}
</div>

<!-- Sex Field -->
<div class="form-group col-sm-6">
    {!! Form::label('sex', 'Sex:') !!}
    {!! Form::text('sex', null, ['class' => 'form-control']) !!}
</div>

<!-- Age Field -->
<div class="form-group col-sm-6">
    {!! Form::label('age', 'Age:') !!}
    {!! Form::text('age', null, ['class' => 'form-control']) !!}
</div>

<!-- Phone Field -->
<div class="form-group col-sm-6">
    {!! Form::label('phone', 'Phone:') !!}
    {!! Form::text('phone', null, ['class' => 'form-control']) !!}
</div>

<!-- Country Field -->
<div class="form-group col-sm-6">
    {!! Form::label('country', 'Country:') !!}
    {!! Form::text('country', null, ['class' => 'form-control']) !!}
</div>

<!-- Province Field -->
<div class="form-group col-sm-6">
    {!! Form::label('province', 'Province:') !!}
    {!! Form::text('province', null, ['class' => 'form-control']) !!}
</div>

<!-- City Field -->
<div class="form-group col-sm-6">
    {!! Form::label('city', 'City:') !!}
    {!! Form::text('city', null, ['class' => 'form-control']) !!}
</div>

<!-- Source Field -->
<div class="form-group col-sm-6">
    {!! Form::label('source', 'Source:') !!}
    {!! Form::text('source', null, ['class' => 'form-control']) !!}
</div>

<!-- Status Field -->
<div class="form-group col-sm-6">
    {!! Form::label('status', 'Status:') !!}
    {!! Form::text('status', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('users.index') !!}" class="btn btn-default">Cancel</a>
</div>
