<!-- Title Field -->
<div class="form-group col-sm-6">
    {!! Form::label('title', 'Title:') !!}
    {!! Form::text('title', null, ['class' => 'form-control']) !!}
</div>

<!-- Post Date Field -->
<div class="form-group col-sm-6">
    {!! Form::label('post_date', 'Post Date:') !!}
    {!! Form::date('post_date', null, ['class' => 'form-control']) !!}
</div>

<!-- Body Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('body', 'Body:') !!}
    {!! Form::textarea('body', null, ['class' => 'form-control']) !!}
</div>

<!-- Password Field -->
<div class="form-group col-sm-6">
    {!! Form::label('password', 'Password:') !!}
    {!! Form::password('password', ['class' => 'form-control']) !!}
</div>

<!-- Token Field -->
<div class="form-group col-sm-6">
    {!! Form::label('token', 'Token:') !!}
    {!! Form::text('token', null, ['class' => 'form-control']) !!}
</div>

<!-- Email Field -->
<div class="form-group col-sm-6">
    {!! Form::label('email', 'Email:') !!}
    {!! Form::email('email', null, ['class' => 'form-control']) !!}
</div>

<!-- Author Gender Field -->
<div class="form-group col-sm-6">
    {!! Form::label('author_gender', 'Author Gender:') !!}
    {!! Form::number('author_gender', null, ['class' => 'form-control']) !!}
</div>

<!-- Post Type Field -->
<div class="form-group col-sm-6">
    {!! Form::label('post_type', 'Post Type:') !!}
    {!! Form::text('post_type', null, ['class' => 'form-control']) !!}
</div>

<!-- Post Visits Field -->
<div class="form-group col-sm-6">
    {!! Form::label('post_visits', 'Post Visits:') !!}
    {!! Form::number('post_visits', null, ['class' => 'form-control']) !!}
</div>

<!-- Category Field -->
<div class="form-group col-sm-6">
    {!! Form::label('category', 'Category:') !!}
    {!! Form::text('category', null, ['class' => 'form-control']) !!}
</div>

<!-- Category Short Field -->
<div class="form-group col-sm-6">
    {!! Form::label('category_short', 'Category Short:') !!}
    {!! Form::text('category_short', null, ['class' => 'form-control']) !!}
</div>

<!-- Is Private Field -->
<div class="form-group col-sm-6">
    {!! Form::label('is_private', 'Is Private:') !!}
    <label class="checkbox-inline">
        {!! Form::hidden('is_private', false) !!}
        {!! Form::checkbox('is_private', '1', null) !!} 1
    </label>
</div>

<!-- Ext1 Field -->
<div class="form-group col-sm-6">
    {!! Form::label('ext1', 'Ext1:') !!}
    {!! Form::text('ext1', null, ['class' => 'form-control']) !!}
</div>

<!-- Ext2 Field -->
<div class="form-group col-sm-6">
    {!! Form::label('ext2', 'Ext2:') !!}
    {!! Form::text('ext2', null, ['class' => 'form-control']) !!}
</div>

<!-- Ext3 Field -->
<div class="form-group col-sm-6">
    {!! Form::label('ext3', 'Ext3:') !!}
    {!! Form::text('ext3', null, ['class' => 'form-control']) !!}
</div>

<!-- Ext4 Field -->
<div class="form-group col-sm-6">
    {!! Form::label('ext4', 'Ext4:') !!}
    {!! Form::text('ext4', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('tests.index') !!}" class="btn btn-default">Cancel</a>
</div>
