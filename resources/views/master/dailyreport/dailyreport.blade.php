@extends('adminlte::page')

@section('title', '中濃森林組合　-勤怠管理-')

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
        <h1 id="typename">業務日報</h1>
        <div>　>>　<?= $submit_type_name[0]->TypeName ?></div>
    </li>
</ul>

@stop

@section('content')

<?php if ($sbmtype == "1") : ?>
    @include('master.dailyreport.dailyreport_list')

<?php elseif ($sbmtype == "2") : ?>

<?php elseif ($sbmtype == "3") : ?>

<?php elseif ($sbmtype == "4") : ?>
    <?php
    $sql = "UPDATE drs_reports SET WorkingDay = :WorkingDay,AmIndustry = :AmIndustry,AmRemark = :AmRemark,PmIndustry = :PmIndustry,PmRemark = :PmRemark,Remark = :Remark,Weather1 = :Weather1,Weather2  = :Weather2 WHERE No = :No";
    $stmt = $dbh->prepare($sql);
    $params = array(
        ':WorkingDay' => $_POST['WorkingDay'],
        ':AmIndustry' => $_POST['AmIndustry'],
        ':AmRemark' => $_POST['AmRemark'],
        ':PmIndustry' => $_POST['PmIndustry'],
        ':PmRemark' => $_POST['PmRemark'],
        ':Remark' => $_POST['Remark'],
        ':Weather1' => $_POST['AmWeather'],
        ':Weather2' => $_POST['PmWeather'],
        ':No' => $_POST['CurrentNo']
    );
    $stmt->execute($params);
    header("Location:./dailyreport");
    exit();
    ?>

<?php elseif ($sbmtype == "5") : ?>
    <?php
    /*$delete_sql = "DELETE FROM bank WHERE BankID = :id";
    $delete_stmt = $dbh->prepare($delete_sql);
    $delete_params = array(':id' => $_POST['BankID']);
    $delete_stmt->execute($delete_params);
    header("Location:./bank");
    exit();*/
    ?>

<?php elseif ($sbmtype == "6") : ?>

<?php elseif ($sbmtype == "7") : ?>

<?php elseif ($sbmtype == "9") : ?>
    @include('master.dailyreport.dailyreport_input')

<?php else : ?>
    @include('master.dailyreport.dailyreport_list')

<?php endif ?>
@stop