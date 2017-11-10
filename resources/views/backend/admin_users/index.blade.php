@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>Backend用户管理
            <small>Backend用户列表</small>
        </h1>
        <ol class="breadcrumb">
            <li>
                <a href="/backend/adminUsers">
                    <i class="fa fa-dashboard"></i>
                    Backend用户管理
                </a>
            </li>
            <li class="active">
                Backend用户列表
            </li>
        </ol>
    </section>
    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')
        <div class="box box-default">
            <div class="box-body">
                @include('backend.admin_users.search')
            </div>
        </div>

        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body">
                <div class="pull-right">
                    <a href="/backend/adminUsers/create">
                        <i class="fa fa-plus"></i>&nbsp;&nbsp;添加用户
                    </a>
                </div>
                @include('backend.admin_users.table')
            </div>
        </div>
    </div>
@endsection

