<?php

use Brick\Math\BigInteger;

try {
    //DB名、ユーザー名、パスワードを変数に格納
    $PDO = new PDO('mysql:host=localhost;dbname=cf756484_dms;charset=utf8', 'cf756484_root', 'AgVj4jDXzK');
    $PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //PDOのエラーレポートを表示

    //input.phpの値を取得

    $DraftNumber = $_POST['DraftNumber'];
    $BrowseUserID = $_POST['pbrowsed'];
    $Coment = $_POST['pcoment'];

    $sql = "INSERT INTO draft_browsed (
            DraftNumber,
            BrowseUserID,
            Coment)
        VALUES (
            :DraftNumber,
            :BrowseUserID,
            :Coment)";
    $stmt = $PDO->prepare($sql); //値が空のままSQL文をセット
    $params = array(':DraftNumber' => $DraftNumber, ':BrowseUserID' => $BrowseUserID, ':Coment' => $Coment);
    $stmt->execute($params); //挿入する値が入った変数をexecuteにセットしてSQLを実行

} catch (PDOException $e) {
    exit('データベースに接続できませんでした。' . $e->getMessage());
}
?>

<p>保存</p>