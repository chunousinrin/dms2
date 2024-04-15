@extends('adminlte::page')

@section('title', '中濃森林組合　-稟議書-')

@section('content_header')
<script>
    window.onload = function() {
        document.getElementById("l2").checked = true;
        document.getElementById("l2-3").checked = true;
    }
</script>
<h1>保存完了しました</h1>
@stop

@section('content')
<?php

try {
    //DB名、ユーザー名、パスワードを変数に格納
    $dsn = 'mysql:dbname=dms;host=localhost;charset=utf8';
    $user = 'root';
    $password = '';

    $PDO = new PDO($dsn, $user, $password); //PDOでMySQLのデータベースに接続
    $PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //PDOのエラーレポートを表示

    //input.phpの値を取得
    $userID = $_POST['puid'];
    $userName = $_POST['puname'];
    $DraftNumber = $_POST['pbango'];
    $DraftTypeId = $_POST['pshurui'];
    $CreatedDate = $_POST['pkianbi'];
    $Title = $_POST['phyodai'];
    $Contents = $_POST['pnaiyo'];
    $Documents = $_POST['pshorui'];
    $Attachment = $_POST['ptenpux1'];
    $Attachment2 = $_POST['ptenpux2'];
    $Attachment3 = $_POST['ptenpux3'];
    $Attachment4 = $_POST['ptenpux4'];
    $Attachment5 = $_POST['ptenpux5'];
    $Multiplepage = $_POST['pmultiple'];

    $sql = "INSERT INTO draft (
        userID, 
        userName, 
        DraftTypeId,
        CreatedDate, 
        DraftNumber,
        Title, 
        Contents, 
        Documents, 
        Attachment,
        Attachment2,
        Attachment3,
        Attachment4,
        Attachment5,
        Multiplepage) 
        VALUES (
        :userID, 
        :userName, 
        :DraftTypeId,
        :CreatedDate, 
        :DraftNumber,
        :Title, 
        :Contents, 
        :Documents, 
        :Attachment,
        :Attachment2,
        :Attachment3,
        :Attachment4,
        :Attachment5,
        :Multiplepage)";
    $stmt = $PDO->prepare($sql); //値が空のままSQL文をセット
    $params = array(
        ':userID' => $userID,
        ':userName' => $userName,
        ':DraftTypeId' => $DraftTypeId,
        ':CreatedDate' => $CreatedDate,
        ':DraftNumber' => $DraftNumber,
        ':Title' => $Title,
        ':Contents' => $Contents,
        ':Documents' => $Documents,
        ':Attachment' => $Attachment,
        ':Attachment2' => $Attachment2,
        ':Attachment3' => $Attachment3,
        ':Attachment4' => $Attachment4,
        ':Attachment5' => $Attachment5,
        ':Multiplepage' => $Multiplepage
    );
    $stmt->execute($params); //挿入する値が入った変数をexecuteにセットしてSQLを実行

} catch (PDOException $e) {
    exit('データベースに接続できませんでした。' . $e->getMessage());
}
?>

<a class="btn btn-secondary rounded-0" href="/draft">起案書トップ</a>
<a class="btn btn-secondary rounded-0" href="/">Home</a>
@stop

@section('js')

@stop