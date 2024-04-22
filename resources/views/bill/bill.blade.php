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
//$submit_type_sql = "SELECT * FROM submit_type WHERE TypeID = {$sbmtype}";
//$submit_type_stmt = $dbh->query($submit_type_sql);
//$submit_type_name = $submit_type_stmt->fetch();

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
        <h1 id="typename">請求書</h1>
        <div>　>>　<?= $submit_type_name->TypeName; ?></div>
    </li>
    <li>
        <input type="submit" value="新規作成" class="btn btn-sm btn-secondary rounded-0 px-4" onclick="createnew();">
        <input type="submit" value="一覧印刷" class="btn btn-sm btn-secondary rounded-0 px-4" onclick="listopen();">
    </li>
</ul>

@stop

@section('content')

<?php if ($sbmtype == "1") : ?>
    @include('bill.bill_list')

<?php elseif ($sbmtype == "2") : ?>
    @include('bill.bill_input')

<?php elseif ($sbmtype == "3") : ?>
    @include('bill.bill_conf')

<?php elseif ($sbmtype == "4") : ?>
    @include('bill.bill_submit')
    <?php
    header("Location:./bill");
    exit();
    ?>

<?php elseif ($sbmtype == "5") : ?>
    <?php
    $delete_sql = "DELETE FROM bill WHERE BillNumber = :id";
    $delete_stmt = $dbh->prepare($delete_sql);
    $delete_params = array(':id' => $_POST['SerialNumber']);
    $delete_stmt->execute($delete_params);
    header("Location:./bill");
    exit();
    ?>

<?php elseif ($sbmtype == "6") : ?>
    @include('bill.bill_processing')

<?php elseif ($sbmtype == "7") : ?>
    @include('work.sending')

<?php elseif ($sbmtype == "9") : ?>
    <?php
    $sql = "UPDATE bill SET PaymentDate = :PaymentDate, Memo = :Memo WHERE 	BillNumber = :id";
    $stmt = $dbh->prepare($sql);
    $params = array(':PaymentDate' => $_POST['PaymentDate'] ?? null, ':Memo' => $_POST['Memo'], ':id' => $_POST['SerialNumber']);
    $stmt->execute($params);
    ?>
    @include('bill.bill_processing')

<?php else : ?>
    @include('bill.bill_list')

<?php endif ?>
@stop