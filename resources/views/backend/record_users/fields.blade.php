<!-- Openid Field -->
<div class="form-group col-sm-6">
    {!! Form::label('openid', 'Openid:') !!}
    {!! Form::text('openid', null, ['class' => 'form-control']) !!}
</div>

<!-- Uname Field -->
<div class="form-group col-sm-6">
    {!! Form::label('uname', 'Uname:') !!}
    {!! Form::text('uname', null, ['class' => 'form-control']) !!}
</div>

<!-- Nick Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('nick_name', 'Nick Name:') !!}
    {!! Form::text('nick_name', null, ['class' => 'form-control']) !!}
</div>

<!-- Gender Field -->
<div class="form-group col-sm-6">
    {!! Form::label('gender', 'Gender:') !!}
    {!! Form::text('gender', null, ['class' => 'form-control']) !!}
</div>

<!-- Daily Salary Field -->
<div class="form-group col-sm-6">
    {!! Form::label('daily_salary', 'Daily Salary:') !!}
    {!! Form::text('daily_salary', null, ['class' => 'form-control']) !!}
</div>

<!-- Tel Field -->
<div class="form-group col-sm-6">
    {!! Form::label('tel', 'Tel:') !!}
    {!! Form::text('tel', null, ['class' => 'form-control']) !!}
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

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('recordUsers.index') !!}" class="btn btn-default">Cancel</a>
</div>
