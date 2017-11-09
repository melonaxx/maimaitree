@extends('layouts.app')

@section('css')
    <style>
        .file {
            position: relative;
            display: inline-block;
            background: #D0EEFF;
            border: 1px solid #99D3F5;
            border-radius: 4px;
            padding: 4px 12px;
            overflow: hidden;
            color: #1E88C7;
            text-decoration: none;
            text-indent: 0;
            line-height: 20px;
        }
        .file input {
            position: absolute;
            font-size: 100px;
            right: 0;
            top: 0;
            opacity: 0;
        }
        .file:hover {
            background: #AADFFD;
            border-color: #78C3F3;
            color: #004974;
            text-decoration: none;
        }
    </style>
@endsection

@section('content')
    <section class="content-header">
        <h1>资源管理
            <small>添加资源</small>
        </h1>
        <ol class="breadcrumb">
            <li>
                <a href="/backend/someups">
                    <i class="fa fa-dashboard"></i>
                    资源管理
                </a>
            </li>
            <li class="active">
                添加资源
            </li>
        </ol>
    </section>
    <div class="content">
        @include('adminlte-templates::common.errors')
        <div class="box box-primary">

            <div class="box-body">
                <div class="row">
                    {!! Form::open(['route' => 'someups.store','enctype'=>'multipart/form-data']) !!}

                        @include('backend.someups.fields')

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
