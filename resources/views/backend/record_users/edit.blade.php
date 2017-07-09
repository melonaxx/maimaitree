@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Record User
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($recordUser, ['route' => ['recordUsers.update', $recordUser->id], 'method' => 'patch']) !!}

                        @include('backend.record_users.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection