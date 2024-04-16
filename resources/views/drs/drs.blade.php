@extends('adminlte::page')

@section('title', '中濃森林組合　-業務日報-')

@section('content_header')
<link rel="stylesheet" href="/css/dms_table.css">
<link rel="stylesheet" href="/css/document_manage.css">

<?php

use Illuminate\Support\Facades\Auth;

$user = Auth::user();
$dbh = new PDO('mysql:host=localhost;dbname=dms;charset=utf8', 'root', '');
if (!empty($_POST['sbmtype'])) {
    $sbmtype = $_POST['sbmtype'];
} elseif (!empty($_GET['sbmtype'])) {
    $sbmtype = $_GET['sbmtype'];
} else {
    $sbmtype = '1';
};
//var_dump($_POST);
$submit_type_sql = "SELECT * FROM submit_type WHERE TypeID = {$sbmtype}";
$submit_type_stmt = $dbh->query($submit_type_sql);
$submit_type_name = $submit_type_stmt->fetch();
?>

@section('js')
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js" integrity="sha256-xLD7nhI62fcsEZK2/v8LsBcb4lG7dgULkuXoXB/j91c=" crossorigin="anonymous"></script>
<script src="https://rawgit.com/jquery/jquery-ui/master/ui/i18n/datepicker-ja.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/themes/flick/jquery-ui.min.css">
<script src="/js/document_manage.js"></script>

@endsection

<ul class="content_head">
    <li style="display: flex;align-items:center;">
        <h1 id="typename">業務日報</h1>
        <div>　>>　<?= $submit_type_name['TypeName'] ?></div>
    </li>
    <li>
        <button type="submit" class="btn btn-sm btn-secondary rounded-0 px-4" onclick="document.getElementById('sbmtype').value='2'; document.f_list.submit();">新規作成</button>
        <button type="submit" class="btn btn-sm btn-secondary rounded-0 px-4" onclick="document.getElementById('sbmtype').value='1'; document.f_list.submit();">履歴</button>
    </li>
</ul>

@stop

@section('content')

<?php if ($sbmtype == "1") : ?>
    @include('drs.drs_list')

<?php elseif ($sbmtype == "2") : ?>
    @include('drs.drs_input')

<?php elseif ($sbmtype == "3") : ?>

<?php elseif ($sbmtype == "4") : ?>
    @include('drs.drs_submit')
    <?php
    header("Location:./drs");
    exit();
    ?>

<?php elseif ($sbmtype == "5") : ?>
    <?php
    $delete_sql = "DELETE FROM drs_reports WHERE No = :id";
    $delete_stmt = $dbh->prepare($delete_sql);
    $delete_params = array(':id' => $_POST['SerialNumber']);
    $delete_stmt->execute($delete_params);
    header("Location:./drs");
    exit();
    ?>

<?php elseif ($sbmtype == "6") : ?>
    @include('drs.drs_list')

<?php elseif ($sbmtype == "7") : ?>

<?php elseif ($sbmtype == "9") : ?>

<?php else : ?>

<?php endif ?>
@stop