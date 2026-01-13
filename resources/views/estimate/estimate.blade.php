@extends('adminlte::page')

@section('title')
<?php
$cname = DB::table('conf_registername')
    ->where('RegisterID', '1')
    ->get();
echo $cname[0]->RegisterName . "　-見積書-";
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
$submit_type_sql = "SELECT * FROM submit_type WHERE TypeID = {$sbmtype}";
$submit_type_stmt = $dbh->query($submit_type_sql);
$submit_type_name = $submit_type_stmt->fetch();
?>

@section('js')
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js" integrity="sha256-xLD7nhI62fcsEZK2/v8LsBcb4lG7dgULkuXoXB/j91c=" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1/i18n/jquery.ui.datepicker-ja.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/themes/flick/jquery-ui.min.css">
<script src="/js/document_manage.js"></script>
@endsection

<ul class="content_head">
    <li style="display: flex;align-items:center;">
        <h1 id="typename">見積書</h1>
        <div>　>>　<?= $submit_type_name['TypeName'] ?></div>
    </li>
    <li>
        <input type="submit" value="新規作成" class="btn btn-sm btn-secondary rounded-0 px-4" onclick="createnew();">
        <input type="submit" value="設計用作成" class="btn btn-sm btn-secondary rounded-0 px-4" onclick="fordesign();">
    </li>
</ul>

@stop

@section('content')

<?php if ($sbmtype == "1") : ?>
    @include('estimate.estimate_list')

<?php elseif ($sbmtype == "2") : ?>
    @include('estimate.estimate_input')

<?php elseif ($sbmtype == "3") : ?>
    @include('estimate.estimate_conf')

<?php elseif ($sbmtype == "4") : ?>
    @include('estimate.estimate_submit')
    <?php
    header("Location:./estimate");
    exit();
    ?>

<?php elseif ($sbmtype == "5") : ?>
    <?php
    $id = $_POST['SerialNumber'];
    if (substr($id, 0, 2) == 11) {
        $stmt = $dbh->prepare("DELETE FROM estimate WHERE EstimateNumber = :id");
    } else {
        $stmt = $dbh->prepare("DELETE FROM estimate2 WHERE Es2Number = :id");
    }
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $res = $stmt->execute();
    header("Location:./estimate");
    exit();
    ?>

<?php elseif ($sbmtype == "6") : ?>

<?php elseif ($sbmtype == "8") : ?>
    @include('estimate.estimate2_input')

<?php elseif ($sbmtype == "7") : ?>
    @include('work.sending')

<?php elseif ($sbmtype == "9") : ?>
<?php elseif ($sbmtype == "12") : ?>
    @include('estimate.estimate2_submit')
    <?php
    header("Location:./estimate");
    exit();
    ?>

<?php elseif ($sbmtype == "13") : ?>
    @include('estimate.estimate_to_bill')

<?php else : ?>
    @include('estimate.estimate_list')

<?php endif ?>
@stop