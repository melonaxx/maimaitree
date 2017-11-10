@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>Backend用户管理
            <small>编辑Backend用户</small>
        </h1>
        <ol class="breadcrumb">
            <li>
                <a href="/backend/adminUsers">
                    <i class="fa fa-dashboard"></i>
                    Backend用户管理
                </a>
            </li>
            <li class="active">
                编辑Backend用户
            </li>
        </ol>
    </section>
    <div class="content">
        @include('adminlte-templates::common.errors')
        <div class="box box-primary">

            <div class="box-body">
                <div class="row">
                    {!! Form::open(['route' => 'adminUsers.store']) !!}

                        @include('backend.admin_users.fields')

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
