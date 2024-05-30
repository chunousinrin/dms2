@extends('adminlte::page')

@section('title')
<?php
$cname = DB::table('conf_registername')
    ->where('RegisterID', '1')
    ->get();
echo $cname[0]->RegisterName . "　-森林情報検索-";
?>
@endsection

@section('content_header')
<link rel="stylesheet" href="/css/dms_table.css">
<link rel="stylesheet" href="/css/document_manage.css">

<?php

use Illuminate\Support\Facades\Auth;

$user = Auth::user();
//var_dump($_POST);
$dbh = new PDO('mysql:host=localhost;dbname=cf756484_dms;charset=utf8', 'cf756484_root', 'AgVj4jDXzK');
$pass = $_POST['pass'] ?? null;
$types = $_POST['types'] ?? null;
?>

@section('js')
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js" integrity="sha256-xLD7nhI62fcsEZK2/v8LsBcb4lG7dgULkuXoXB/j91c=" crossorigin="anonymous"></script>
<script src="https://rawgit.com/jquery/jquery-ui/master/ui/i18n/datepicker-ja.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/themes/flick/jquery-ui.min.css">
<script src="/js/document_manage.js"></script>

@endsection

@stop

@section('content')

<?php if (empty($types) && empty($pass)) : ?>
    @include('work.sinrinbo.sinrinbo_login')

<?php elseif ($pass === "sinrin") : ?>
    @include('work.sinrinbo.sinrinbo_list')

<?php elseif ($types === "list") : ?>
    @include('work.sinrinbo.sinrinbo_list')

<?php elseif ($pass !== 'sinrin') : ?>
    <div style="width: 100%;height:60vh ;position:relative;">
        <div class="loginbox text-center" style="position: absolute;top: 50%;left: 50%;transform: translate(-50%, -50%);">
            <h1>森林情報検索システム</h1>
            <div class="form-group">
                <p style="color:crimson">パスワードが間違っています</p>
                <form action="" method="post">
                    @csrf
                    <input type="password" class="form-control text-center" name="pass" style="margin: 0 auto;width:20em;" autofocus><br>
                    <input type="submit" value="ログイン" class="btn btn-secondary rounded-0">
                </form>
            </div>
        </div>
    </div>

<?php else : ?>
    @include('work.sinrinbo.sinrinbo_login')

<?php endif ?>
@stop