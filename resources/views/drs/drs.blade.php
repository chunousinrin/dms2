@extends('adminlte::page')

@section('title')
<?php
$cname = DB::table('conf_registername')
    ->where('RegisterID', '1')
    ->get();
echo $cname[0]->RegisterName . "　-業務日報-";
?>
@endsection

@section('content_header')
<link rel="stylesheet" href="/css/dms_table.css">
<link rel="stylesheet" href="/css/document_manage.css">

<?php

use Illuminate\Support\Facades\Auth;

$user = Auth::user();
$dbh = new PDO('mysql:host=localhost;dbname=' . env('DB_DATABASE') . ';charset=utf8', env('DB_USERNAME'), env('DB_PASSWORD'));
if (!empty($_POST['sbmtype'])) {
    $sbmtype = $_POST['sbmtype'];
} elseif (!empty($_GET['sbmtype'])) {
    $sbmtype = $_GET['sbmtype'];
} else {
    $sbmtype = '1';
};
//var_dump($_POST);
$submit_type_name = DB::table('submit_type')
    ->where('TypeID', $sbmtype)
    ->get();
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
        <div>　>>　<?= $submit_type_name[0]->TypeName ?></div>
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