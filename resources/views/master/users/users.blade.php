@extends('adminlte::page')

@section('title')
<?php
$cname = DB::table('conf_registername')
    ->where('RegisterID', '1')
    ->get();
echo $cname[0]->RegisterName . "　-ユーザー管理-";
?>
@endsection

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

@endsection

<ul class="content_head">
    <li style="display: flex;align-items:center;">
        <h1 id="typename">登録ユーザー</h1>
        <div>　>>　<?= $submit_type_name['TypeName'] ?></div>
    </li>
</ul>

@stop

@section('content')

<?php if ($sbmtype == "1") : ?>
    @include('master.users.users_list')

<?php elseif ($sbmtype == "2") : ?>

<?php elseif ($sbmtype == "3") : ?>

<?php elseif ($sbmtype == "4") : ?>

<?php elseif ($sbmtype == "5") : ?>
    <?php
    $delete_sql = "DELETE FROM users WHERE id = :id";
    $delete_stmt = $dbh->prepare($delete_sql);
    $delete_params = array(':id' => $_POST['UpdateID']);
    $delete_stmt->execute($delete_params);
    header("Location:./users");
    exit();
    ?>

<?php elseif ($sbmtype == "6") : ?>

<?php elseif ($sbmtype == "7") : ?>

<?php elseif ($sbmtype == "9") : ?>
    <?php
    $sql = "UPDATE users SET
    users.name=:name,
    email=:email,
    department=:department,
    section=:section,
    position=:position,
    used=:used,
    authtype=:authtype
    WHERE id = :id";
    $stmt = $dbh->prepare($sql);
    $params = array(
        ':name' => $_POST['UpdateName'] ?? null,
        ':email' => $_POST['UpdateEmail'] ?? null,
        ':department' => $_POST['UpdateDepartment'] ?? null,
        ':section' => $_POST['UpdateSection'] ?? null,
        ':position' => $_POST['UpdatePosition'] ?? null,
        ':used' => $_POST['UpdateUsed'] ?? null,
        ':authtype' => $_POST['UpdateAuthtype'] ?? null,
        ':id' => $_POST['UpdateID'] ?? null
    );
    $stmt->execute($params);
    header("Location:./users");
    exit();
    ?>

<?php else : ?>
    @include('master.users.users_list')

<?php endif ?>
@stop