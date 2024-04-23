@extends('adminlte::page')

@section('title', '中濃森林組合　-電子帳簿保存-')

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
<script src="https://cdn.jsdelivr.net/npm/bs-custom-file-input/dist/bs-custom-file-input.js"></script>
<script>
    bsCustomFileInput.init()
</script>

@endsection

<ul class="content_head">
    <li style="display: flex;align-items:center;">
        <h1 id="typename">電子帳簿保存</h1>
        <div>　>>　<?= $submit_type_name[0]->TypeName ?></div>
    </li>
    <li>
        <input type="submit" value="新規作成" class="btn btn-sm btn-secondary rounded-0 px-4" onclick="createnew();">
        <input type="submit" value="一覧印刷" class="btn btn-sm btn-secondary rounded-0 px-4" onclick="listopen();">
    </li>
</ul>

@stop

@section('content')


<?php if ($sbmtype == "1") : ?>
    @include('errl.errl_list')

<?php elseif ($sbmtype == "2") : ?>
    @include('errl.errl_input')

<?php elseif ($sbmtype == "3") : ?>
    @include('errl.errl_conf')

<?php elseif ($sbmtype == "4") : ?>
    @include('errl.errl_submit')
    <?php
    header("Location:./errl");
    exit();
    ?>

<?php elseif ($sbmtype == "5") : ?>
    <?php
    $file_sql = "SELECT * FROM `accountbook` WHERE ErrlNumber = " . $_POST['SerialNumber'];
    $file_st = $dbh->query($file_sql);
    $dlfile = $file_st->fetch();
    unlink("./UploadFiles/" . $dlfile['FileName']);
    $delete_sql = "DELETE FROM accountbook WHERE ErrlNumber = :id";
    $delete_stmt = $dbh->prepare($delete_sql);
    $delete_params = array(':id' => $_POST['SerialNumber']);
    $delete_stmt->execute($delete_params);
    header("Location:./errl");
    exit();
    ?>
<?php elseif ($sbmtype == "6") : ?>

<?php elseif ($sbmtype == "7") : ?>

<?php elseif ($sbmtype == "9") : ?>

<?php else : ?>
    @include('errl.errl_list')

<?php endif ?>

@stop