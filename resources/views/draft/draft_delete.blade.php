@extends('adminlte::page')

@section('title', '中濃森林組合　-稟議書-')

@section('content_header')
<script>
    window.onload = function() {
        document.getElementById("l2").checked = true;
        document.getElementById("l2-3").checked = true;
    }
</script>
<h1>削除完了</h1>
@stop

@section('content')

<?php

// (1) 削除するデータを用意
$id = $_GET['bizNumber'];

// (2) データベースに接続
$pdo = new PDO('mysql:dbname=dms;host=localhost', 'root', '');

// (3) SQL作成
$stmt = $pdo->prepare("DELETE FROM draft WHERE DraftNumber = :id");

// (4) 登録するデータをセット
$stmt->bindParam(':id', $id, PDO::PARAM_INT);

// (5) SQL実行
$res = $stmt->execute();

// (6) データベースの接続解除
$pdo = null;

?>

<a class="btn btn-secondary rounded-0" href="/draft">稟議書トップ</a>
<a class="btn btn-secondary rounded-0" href="/">Home</a>

@stop

@section('js')

@stop