@extends('adminlte::page')

@section('title', '中濃森林組合　-組合情報-')

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
$submit_type_sql = "SELECT * FROM submit_type WHERE TypeID = {$sbmtype}";
$submit_type_stmt = $dbh->query($submit_type_sql);
$submit_type_name = $submit_type_stmt->fetch();
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
        <h1 id="typename">組合情報</h1>
        <div>　>>　<?= $submit_type_name['TypeName'] ?></div>
    </li>
</ul>

@stop

@section('content')

<?php if ($sbmtype == "1") : ?>
    @include('admin.company.company_list')

<?php elseif ($sbmtype == "2") : ?>

<?php elseif ($sbmtype == "3") : ?>

<?php elseif ($sbmtype == "4") : ?>
    <?php
    /*$insert_sql = "INSERT INTO bank (
            BankName,
            BankBranch,
            AccountType,
            AccountNumber) 
        VALUES (
            :BankName,
            :BankBranch,
            :AccountType,
            :AccountNumber)";
    $insert_stmt = $dbh->prepare($insert_sql);
    $insert_params = array(
        ':BankName' => $_POST['BankName'] ?? null,
        ':BankBranch' => $_POST['BankBranch'] ?? null,
        ':AccountType' => $_POST['AccountType'] ?? null,
        ':AccountNumber' => $_POST['AccountNumber'] ?? null,
    );
    $insert_stmt->execute($insert_params);
    header("Location:./bank");
    exit();*/
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
    <?php
    var_dump($_POST);
    echo '<br>';
    var_dump($_FILES);
    if (empty($_FILES['UpSignatureStamp']['tmp_name'])) {
        $sql = "UPDATE company SET 
            BranchName = :BranchName,
            Representative=:Representative,
            PostCode=:PostCode, 
            Address=:Address,
            Phone=:Phone,
            Fax=:Fax 
            WHERE BranchId = :BranchId";
        $params = array(
            ':BranchName' => $_POST['UpBranchName'] ?? null,
            ':Representative' => $_POST['UpRepresentative'] ?? null,
            ':PostCode' => $_POST['UpPostCode'] ?? null,
            ':Address' => $_POST['UpAddress'] ?? null,
            ':Phone' => $_POST['UpPhone'] ?? null,
            ':Fax' => $_POST['UpFax'] ?? null,
            ':BranchId' => $_POST['SerialNumber']
        );
    } else {
        $stamp = file_get_contents($_FILES['UpSignatureStamp']['tmp_name']);
        $sql = "UPDATE company SET 
            BranchName = :BranchName,
            Representative=:Representative,
            SignatureStamp=:SignatureStamp,
            PostCode=:PostCode, 
            Address=:Address,
            Phone=:Phone,
            Fax=:Fax 
            WHERE BranchId = :BranchId";
        $params = array(
            ':BranchName' => $_POST['UpBranchName'] ?? null,
            ':Representative' => $_POST['UpRepresentative'] ?? null,
            ':SignatureStamp' => $stamp,
            ':PostCode' => $_POST['UpPostCode'] ?? null,
            ':Address' => $_POST['UpAddress'] ?? null,
            ':Phone' => $_POST['UpPhone'] ?? null,
            ':Fax' => $_POST['UpFax'] ?? null,
            ':BranchId' => $_POST['SerialNumber']
        );
    }
    $stmt = $dbh->prepare($sql);
    $stmt->execute($params);
    header("Location:./company");
    exit();
    ?>

<?php else : ?>

<?php endif ?>
@stop