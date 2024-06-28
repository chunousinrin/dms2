@extends('adminlte::page')
@section('title', 'Dashboard')

@section('css')
<link rel="stylesheet" href="css/dms_home.css">
@stop

@section('content_header')

@stop

@section('content')

<style>
</style>


<ul class="home_content">

    <li class="home_center">
        <hr class="hchr">
        @include('home.button')
        <hr>
        @include('home.license')
        <hr>
        @include('home.release')
    </li>
    <li class="home_right">
        <ul>
            <li>@include('home.cal')</li>
            <li>@include('home.worker_attendance_check')</li>
            <li>@include('home.minical')</li>
            <li>@include('home.topic')</li>
        </ul>
    </li>
    @endsection