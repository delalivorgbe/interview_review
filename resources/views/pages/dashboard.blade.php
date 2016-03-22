@extends('layouts.admin_template')

@section('page_title')
    ALU|Dashboard
@endsection

@section('page_header')
    Dashboard
@endsection


@section('menu')
    <!-- Sidebar Menu -->
    <ul class="sidebar-menu">
        <li class="header"></li>
        {{--<li class="active"><a href="{{ url('dashboard') }}"><i class="fa fa-dashboard"></i><span>Dashboard</span></a></li>--}}
        <li><a href="{{ url('students') }}"><i class="fa fa-users"></i><span>Students</span></a></li>
        <li><a href="{{ url('forms') }}"><i class="fa fa-file-text"></i><span>Document Request</span></a></li>
        <li><a href="{{ url('forum') }}"><i class="fa fa-comment"></i><span>Forums</span></a></li>
    </ul><!-- /.sidebar-menu -->
@endsection


