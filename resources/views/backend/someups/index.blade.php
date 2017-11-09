@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>资源管理
            <small>资源列表</small>
        </h1>
        <ol class="breadcrumb">
            <li>
                <a href="/backend/someups">
                    <i class="fa fa-dashboard"></i>
                    资源管理
                </a>
            </li>
            <li class="active">
                资源列表
            </li>
        </ol>
    </section>
    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="box box-default">
            <div class="box-body">
                @include('backend.someups.search')
            </div>
        </div>
        <div class="box box-primary">
            <div class="box-body">
                <div class="pull-right">
                    <a href="/backend/someups/create">
                        <i class="fa fa-plus"></i>&nbsp;&nbsp;添加资源
                    </a>
                </div>
                @include('backend.someups.table')
            </div>
        </div>
    </div>
@endsection

