@extends('adminlte::page')

@section('title')
<?php
$cname = DB::table('conf_registername')
    ->where('RegisterID', '1')
    ->get();
echo $cname[0]->RegisterName . "　-稟議書-";
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
        <h1 id="typename">稟議書</h1>
        <div>　>>　<?= $submit_type_name['TypeName'] ?></div>
    </li>
    <li>
        <input type="button" value="新規作成" class="btn btn-sm btn-secondary rounded-0 px-4" onclick="createnew();">
    </li>
</ul>

@stop

@section('content')

<?php if ($sbmtype == "1") : ?>
    @include('draft.draft_list')

<?php elseif ($sbmtype == "2") : ?>
    @include('draft.draft_input')

<?php elseif ($sbmtype == "3") : ?>
    @include('draft.draft_conf')

<?php elseif ($sbmtype == "4") : ?>
    @include('draft.draft_submit')
    <?php
    header("Location:./draft");
    exit();
    ?>

<?php elseif ($sbmtype == "5") : ?>
    <?php
    $delete_sql = "DELETE FROM draft WHERE DraftNumber = :id";
    $delete_stmt = $dbh->prepare($delete_sql);
    $delete_params = array(':id' => $_POST['SerialNumber']);
    $delete_stmt->execute($delete_params);
    header("Location:./draft");
    exit();
    ?>

<?php elseif ($sbmtype == "6") : ?>
    @include('draft.draft_restate')

<?php elseif ($sbmtype == "10") : ?>
    <?php
    if (empty($_POST['Comment'])) {
        $comment = "";
    } else {
        $comment = $_POST['Comment'] . "(" . $user['name'] . ")";
    }
    $comment_sql = "INSERT INTO draft_browsed (DraftNumber, BrowseUserID, Comment, Update_at) VALUES (:DraftNumber, :BrowseUserID, :Comment, now())";
    $comment_stmt = $dbh->prepare($comment_sql);
    $comment_params = array(':DraftNumber' => $_POST['SerialNumber'], ':BrowseUserID' => $user['id'], ':Comment' => $comment);
    $comment_stmt->execute($comment_params);
    ?>
    @include('draft.draft_restate')

<?php endif ?>

@stop