@extends('adminlte::page')

@section('title', '中濃森林組合　-請求書-')

@section('content_header')
<link rel="stylesheet" href="/css/dms_table.css">
<link rel="stylesheet" href="/css/document_manage.css">

<?php

use Illuminate\Support\Facades\Auth;

$user = Auth::user();
$dbh = new PDO('mysql:host=localhost;dbname=cf756484_dms;charset=utf8', 'cf756484_root', 'AgVj4jDXzK');
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
        <h1 id="typename">事業分類</h1>
        <div>　>>　<?= $submit_type_name[0]->TypeName; ?></div>
    </li>
    <li>
        <div class="btn btn-sm btn-secondary rounded-0 px-4" onclick="createnew();">新規追加</div>
    </li>
</ul>

@stop

@section('content')

<?php if ($sbmtype == "1") : ?>
    @include('master.classication.classication_list')

<?php elseif ($sbmtype == "2") : ?>
    @include('master.classication.classication_input')

<?php elseif ($sbmtype == "3") : ?>

<?php elseif ($sbmtype == "4") : ?>
    <?php
    $insert_sql = "INSERT INTO classication (
            Name,
            Remark) 
        VALUES (
            :Name,
            :Remark)";
    $insert_stmt = $dbh->prepare($insert_sql);
    $insert_params = array(
        ':Name' => $_POST['ClassicationName'] ?? null,
        ':Remark' => $_POST['Remark'] ?? null,
    );
    $insert_stmt->execute($insert_params);
    header("Location:./classication");
    exit();
    ?>

<?php elseif ($sbmtype == "5") : ?>
    <?php
    $delete_sql = "DELETE FROM classication WHERE Id = :id";
    $delete_stmt = $dbh->prepare($delete_sql);
    $delete_params = array(':id' => $_POST['UpdateID']);
    $delete_stmt->execute($delete_params);
    header("Location:./classication");
    exit();
    ?>

<?php elseif ($sbmtype == "6") : ?>

<?php elseif ($sbmtype == "7") : ?>

<?php elseif ($sbmtype == "9") : ?>
    <?php
    $sql = "UPDATE classication SET classication.Name = :Name,Remark=:Remark WHERE Id = :id";
    $stmt = $dbh->prepare($sql);
    $params = array(':Name' => $_POST['UpdateName'] ?? null, ':Remark' => $_POST['UpdateRemark'], ':id' => $_POST['UpdateID']);
    $stmt->execute($params);
    header("Location:./classication");
    exit();
    ?>

<?php else : ?>
    @include('master.classication.classication_list')

<?php endif ?>
@stop