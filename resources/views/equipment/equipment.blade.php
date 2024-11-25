@extends('adminlte::page')

@section('title')
<?php
$cname = DB::table('conf_registername')
    ->where('RegisterID', '1')
    ->get();
echo $cname[0]->RegisterName . "　-重機管理-";
?>
@endsection

@section('content_header')
<link rel="stylesheet" href="/css/dms_table.css">
<link rel="stylesheet" href="/css/document_manage.css">
<style>
    .sdw {
        box-shadow: 5px 5px 5px -5px #464646;
    }

    .content-wrapper>.content {
        padding-bottom: 2em !important;
    }
</style>

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

$machine_list_sql = "SELECT * FROM view_equipment_list";
$machine_list_stmt = $dbh->query($machine_list_sql);

$reserve_sql = "SELECT equipment_usage_history.*,worker_group.WorkerGroupName,view_equipment_list.MachineName FROM `equipment_usage_history` left JOIN worker_group ON equipment_usage_history.WorkerGroupInUse=worker_group.WorkerGroupID LEFT JOIN view_equipment_list ON equipment_usage_history.EquipmentID=view_equipment_list.ID WHERE equipment_usage_history.EndDate>=CURDATE()";
$reserve_stmt = $dbh->query($reserve_sql);
?>
@section('js')
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js" integrity="sha256-xLD7nhI62fcsEZK2/v8LsBcb4lG7dgULkuXoXB/j91c=" crossorigin="anonymous"></script>
<script src="https://rawgit.com/jquery/jquery-ui/master/ui/i18n/datepicker-ja.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/themes/flick/jquery-ui.min.css">
<link href="https://use.fontawesome.com/releases/v6.2.0/css/all.css" rel="stylesheet">
<script src="/js/document_manage.js"></script>



@endsection
<ul class="content_head">
    <li style="display: flex;align-items:center;">
        <h1 id="typename">重機管理</h1>
    </li>
</ul>


@stop

@section('content')
<?php if ($sbmtype == "1") : ?>
    @include('equipment.eq10')

<?php elseif ($sbmtype == "20") : ?>
    @include('equipment.eq20')

<?php elseif ($sbmtype == "30") : ?>
    @include('equipment.eq30')

<?php elseif ($sbmtype == "31") : ?>
    @include('equipment.eq31')

<?php elseif ($sbmtype == "40") : ?>
    @include('equipment.eq40')

<?php elseif ($sbmtype == "41") : ?>
    @include('equipment.eq41')
    @include('equipment.eq20')

<?php elseif ($sbmtype == "43") : ?>
    @include('equipment.eq43')

<?php elseif ($sbmtype == "44") : ?>
    @include('equipment.eq44')
    @include('equipment.eq20')

<?php elseif ($sbmtype == "50") : ?>
    @include('equipment.eq50')

<?php elseif ($sbmtype == "51") : ?>
    @include('equipment.eq51')
    @include('equipment.eq20')

<?php elseif ($sbmtype == "52") : ?>
    @include('equipment.eq52')

<?php elseif ($sbmtype == "53") : ?>
    @include('equipment.eq53')
    @include('equipment.eq20')

<?php elseif ($sbmtype == "60") : ?>
    @include('equipment.eq60')

<?php elseif ($sbmtype == "61") : ?>
    @include('equipment.eq61')
    @include('equipment.eq20')

<?php elseif ($sbmtype == "62") : ?>
    @include('equipment.eq62')

<?php elseif ($sbmtype == "63") : ?>
    @include('equipment.eq63')
    @include('equipment.eq20')

<?php else : ?>
    @include('equipment.eq10')

<?php endif ?>
@stop