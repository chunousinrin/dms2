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

    @section('js')
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js" integrity="sha256-xLD7nhI62fcsEZK2/v8LsBcb4lG7dgULkuXoXB/j91c=" crossorigin="anonymous"></script>
    <script src="https://rawgit.com/jquery/jquery-ui/master/ui/i18n/datepicker-ja.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/themes/flick/jquery-ui.min.css">
    <script src="/js/document_manage.js"></script>
    @endsection