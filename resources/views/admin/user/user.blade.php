@extends('adminlte::page')

@section('title')
<?php
$cname = DB::table('conf_registername')
    ->where('RegisterID', '1')
    ->get();
echo $cname[0]->RegisterName . "　-マスタ管理-";
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
?>

@section('js')
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js" integrity="sha256-xLD7nhI62fcsEZK2/v8LsBcb4lG7dgULkuXoXB/j91c=" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1/i18n/jquery.ui.datepicker-ja.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/themes/flick/jquery-ui.min.css">
<script src="/js/document_manage.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bs-custom-file-input/dist/bs-custom-file-input.js"></script>
<script>
    bsCustomFileInput.init()
</script>

@endsection

<ul class="content_head">
    <li style="display: flex;align-items:center;">
        <h1 id="typename">登録ユーザー</h1>
    </li>
</ul>

@stop

@section('content')

<?php if ($sbmtype == "1") : ?>
    @include('admin.user.user_edit')
<?php elseif ($sbmtype == "2") : ?>

<?php elseif ($sbmtype == "3") : ?>

<?php elseif ($sbmtype == "4") : ?>

<?php elseif ($sbmtype == "5") : ?>

<?php elseif ($sbmtype == "6") : ?>

<?php elseif ($sbmtype == "7") : ?>

<?php elseif ($sbmtype == "9") : ?>
    <?php
    if ($_POST['password'] === $_POST['old_password']) {
        $pwd = $_POST['password'];
    } else {
        $pwd = Hash::make($_POST['password']);
    }

    if (empty($_FILES['stamp']['name'])) {
        $sql = "UPDATE users SET
            users.name=:name,
            users.email=:email,
            users.password=:password,
            department=:department,
            section=:section,
            position=:position
            WHERE `id` = :id";
        $params = array(
            ':name' => $_POST['name'],
            ':email' => $_POST['email'],
            ':password' => $pwd,
            ':department' => $_POST['department'] ?? null,
            ':section' => $_POST['section'] ?? null,
            ':position' => $_POST['position'] ?? null,
            ':id' => $_POST['id']
        );
    } else {
        $stamp = file_get_contents($_FILES['stamp']['tmp_name']);
        $sql = "UPDATE users SET
            users.name=:name,
            users.email=:email,
            users.password=:password,
            department=:department,
            section=:section,
            position=:position,
            stamp=:stamp
            WHERE `id` = :id";
        $params = array(
            ':name' => $_POST['name'],
            ':email' => $_POST['email'],
            ':password' => $pwd,
            ':department' => $_POST['department'] ?? null,
            ':section' => $_POST['section'] ?? null,
            ':position' => $_POST['position'] ?? null,
            ':stamp' => $stamp,
            ':id' => $_POST['id']
        );
    };
    $stmt = $dbh->prepare($sql);
    $stmt->execute($params);
    header("Location:./settings");
    exit();
    ?>
<?php else : ?>

<?php endif ?>
@stop