@extends('layouts.admin_template')

@section('page_title')
    ALU|Dashboard
@endsection

@section('page_header')
    Dashboard
@endsection

@section('navbar_username')
    Delali Vorgbe
@endsection

@section('menu')
        <!-- Sidebar Menu -->
    <ul class="sidebar-menu">
        <li class="header"></li>
        <!-- Optionally, you can add icons to the links -->
        <li class="active"><a href="#"><i class="fa fa-dashboard"></i><span>Dashboard</span></a></li>
        <li><a href="#"><i class="fa fa-users"></i><span>Students</span></a></li>
        <li><a href="#"><i class="fa fa-file-text"></i><span>Document Request</span></a></li>
        <li><a href="#"><i class="fa fa-comment"></i><span>Forums</span></a></li>
    </ul><!-- /.sidebar-menu -->
@endsection

@section('menu_username')
    Delali Vorgbe
@endsection

@section('menu_user_image')
    <img src="{{ asset("/bower_components/admin-lte/dist/img/user2-160x160.jpg") }}" class="img-circle" alt="User Image" />
@endsection