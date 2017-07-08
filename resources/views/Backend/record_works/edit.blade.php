@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Record Work
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($recordWork, ['route' => ['recordWorks.update', $recordWork->id], 'method' => 'patch']) !!}

                        @include('backend.record_works.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection