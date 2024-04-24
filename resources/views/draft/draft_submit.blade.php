<?php

try {
    //DB名、ユーザー名、パスワードを変数に格納
    $dsn = 'mysql:dbname=cf756484_dms;host=localhost;charset=utf8';
    $user = 'cf756484_root';
    $password = 'AgVj4jDXzK';

    $PDO = new PDO($dsn, $user, $password); //PDOでMySQLのデータベースに接続
    $PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //PDOのエラーレポートを表示

    //input.phpの値を取得
    $DraftTypeId = $_POST['DraftTypeId'];
    $SerialNumber = $_POST['SerialNumber'];
    $CreatedDate = $_POST['CreatedDate'];
    $TitleName = $_POST['TitleName'];
    $Contents = $_POST['Contents'];
    $Layout = $_POST['Layout'];
    $userID = $_POST['UserID'];
    $userName = $_POST['UserName'];

    $sql = "INSERT INTO draft (
        userID,
        userName,
        CreatedDate,
        DraftTypeId,
        DraftNumber,
        Title,
        Contents,
        Multiplepage)
        VALUES (
        :userID, 
        :userName, 
        :CreatedDate,
        :DraftTypeId, 
        :DraftNumber,
        :Title, 
        :Contents,
        :Multiplepage)";
    $stmt = $PDO->prepare($sql); //値が空のままSQL文をセット
    $params = array(
        ':userID' => $userID,
        ':userName' => $userName,
        ':DraftTypeId' => $DraftTypeId,
        ':CreatedDate' => $CreatedDate,
        ':DraftNumber' => $SerialNumber,
        ':Title' => $TitleName,
        ':Contents' => $Contents,
        ':Multiplepage' => $Layout
    );
    $stmt->execute($params); //挿入する値が入った変数をexecuteにセットしてSQLを実行

} catch (PDOException $e) {
    exit('データベースに接続できませんでした。' . $e->getMessage());
}
