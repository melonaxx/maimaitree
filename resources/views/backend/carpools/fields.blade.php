<!-- Uid Field -->
<div class="form-group col-sm-6">
    {!! Form::label('uid', 'Uid:') !!}
    {!! Form::text('uid', null, ['class' => 'form-control']) !!}
</div>

<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Name:') !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<!-- Sex Field -->
<div class="form-group col-sm-6">
    {!! Form::label('sex', 'Sex:') !!}
    {!! Form::text('sex', null, ['class' => 'form-control']) !!}
</div>

<!-- Phone Field -->
<div class="form-group col-sm-6">
    {!! Form::label('phone', 'Phone:') !!}
    {!! Form::text('phone', null, ['class' => 'form-control']) !!}
</div>

<!-- Type Field -->
<div class="form-group col-sm-6">
    {!! Form::label('type', 'Type:') !!}
    {!! Form::text('type', null, ['class' => 'form-control']) !!}
</div>

<!-- Origin Field -->
<div class="form-group col-sm-6">
    {!! Form::label('origin', 'Origin:') !!}
    {!! Form::text('origin', null, ['class' => 'form-control']) !!}
</div>

<!-- By Way Field -->
<div class="form-group col-sm-6">
    {!! Form::label('by_way', 'By Way:') !!}
    {!! Form::text('by_way', null, ['class' => 'form-control']) !!}
</div>

<!-- Terminal Field -->
<div class="form-group col-sm-6">
    {!! Form::label('terminal', 'Terminal:') !!}
    {!! Form::text('terminal', null, ['class' => 'form-control']) !!}
</div>

<!-- Time Field -->
<div class="form-group col-sm-6">
    {!! Form::label('time', 'Time:') !!}
    {!! Form::text('time', null, ['class' => 'form-control']) !!}
</div>

<!-- Number Field -->
<div class="form-group col-sm-6">
    {!! Form::label('number', 'Number:') !!}
    {!! Form::text('number', null, ['class' => 'form-control']) !!}
</div>

<!-- Price Field -->
<div class="form-group col-sm-6">
    {!! Form::label('price', 'Price:') !!}
    {!! Form::text('price', null, ['class' => 'form-control']) !!}
</div>

<!-- License Field -->
<div class="form-group col-sm-6">
    {!! Form::label('license', 'License:') !!}
    {!! Form::text('license', null, ['class' => 'form-control']) !!}
</div>

<!-- Car Type Field -->
<div class="form-group col-sm-6">
    {!! Form::label('car_type', 'Car Type:') !!}
    {!! Form::text('car_type', null, ['class' => 'form-control']) !!}
</div>

<!-- Volume Field -->
<div class="form-group col-sm-6">
    {!! Form::label('volume', 'Volume:') !!}
    {!! Form::text('volume', null, ['class' => 'form-control']) !!}
</div>

<!-- Weight Field -->
<div class="form-group col-sm-6">
    {!! Form::label('weight', 'Weight:') !!}
    {!! Form::text('weight', null, ['class' => 'form-control']) !!}
</div>

<!-- Frequency Field -->
<div class="form-group col-sm-6">
    {!! Form::label('frequency', 'Frequency:') !!}
    {!! Form::text('frequency', null, ['class' => 'form-control']) !!}
</div>

<!-- Remark Field -->
<div class="form-group col-sm-6">
    {!! Form::label('remark', 'Remark:') !!}
    {!! Form::text('remark', null, ['class' => 'form-control']) !!}
</div>

<!-- Relief Field -->
<div class="form-group col-sm-6">
    {!! Form::label('relief', 'Relief:') !!}
    {!! Form::text('relief', null, ['class' => 'form-control']) !!}
</div>

<!-- Watch Field -->
<div class="form-group col-sm-6">
    {!! Form::label('watch', 'Watch:') !!}
    {!! Form::text('watch', null, ['class' => 'form-control']) !!}
</div>

<!-- Status Field -->
<div class="form-group col-sm-6">
    {!! Form::label('status', 'Status:') !!}
    {!! Form::text('status', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('carpools.index') !!}" class="btn btn-default">Cancel</a>
</div>
