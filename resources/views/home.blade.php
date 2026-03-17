@extends('adminlte::page')
@section('title', 'Dashboard')

@section('css')
<link rel="stylesheet" href="css/dms_home.css">
<style>
    .ui-datepicker {
        z-index: 1000 !important;
    }
</style>
@stop

@section('content_header')

@stop

@section('content')
<div class="row">

    <div class="col-12 col-md-9">
        <div class="row no-gutters">
            @include('home.button')
        </div>
        <hr>
        <div class="row no-gutters">
            @include('home.license')
        </div>
        <hr>
        <div class="row no-gutters">
            @include('home.release')
        </div>
    </div>

    <div class="col-12 col-md-3 d-none d-md-block">

        <div class="card" style="background-color: lightseagreen;color:white;font-weight:extra-bold;">
            <div class="card-body text-center">
                <div class="card-text" style="font-size: 1.5rem;line-height:1.5rem;">{{ now()->format('F')}}</div>
                <div class="card-text" style="font-size: 7rem;line-height:7rem;">{{ now()->format('d')}}</div>
                <div class="card-text" style="font-size: 1.5rem;line-height:1.5rem">{{ now()->format('l') }}</div>
            </div>
        </div>

        <div class="row no-gutters">
            @include('home.worker_attendance_check')
        </div>
        <div class="row no-gutters">
            @include('home.minical')
        </div>
        <div class="row no-gutters">
            @include('home.topic')
        </div>
    </div>
</div>

@endsection

@section('js')
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js" integrity="sha256-xLD7nhI62fcsEZK2/v8LsBcb4lG7dgULkuXoXB/j91c=" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1/i18n/jquery.ui.datepicker-ja.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/themes/flick/jquery-ui.min.css">
<script src="/js/document_manage.js"></script>
@endsection