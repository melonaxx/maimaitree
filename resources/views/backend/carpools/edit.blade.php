@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Carpools
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($carpools, ['route' => ['carpools.update', $carpools->id], 'method' => 'patch']) !!}

                        @include('backend.carpools.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection