@extends('adminlte::page')

@section('title', '中濃森林組合　-組合情報-')

@section('content_header')
<link rel="stylesheet" href="/css/dms_table.css">
<link rel="stylesheet" href="/css/document_manage.css">

<?php

use Illuminate\Support\Facades\Auth;

$user = Auth::user();
//var_dump($_POST);
$dbh = new PDO('mysql:host=localhost;dbname=forest_union;charset=utf8', 'root', '');
?>

@section('js')
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js" integrity="sha256-xLD7nhI62fcsEZK2/v8LsBcb4lG7dgULkuXoXB/j91c=" crossorigin="anonymous"></script>
<script src="https://rawgit.com/jquery/jquery-ui/master/ui/i18n/datepicker-ja.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/themes/flick/jquery-ui.min.css">
<script src="/js/document_manage.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bs-custom-file-input/dist/bs-custom-file-input.js"></script>
<script>
    bsCustomFileInput.init()
</script>

@endsection
<ul class="content_head">
    <li style="display: flex;align-items:center;">
        <h1 id="typename">組合員情報</h1>
    </li>
</ul>


@stop

@section('content')

@include('work.forestunion.forestunion_list')

@stop