@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Someups
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($someups, ['route' => ['someups.update', $someups->id], 'method' => 'patch']) !!}

                        @include('backend.someups.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection