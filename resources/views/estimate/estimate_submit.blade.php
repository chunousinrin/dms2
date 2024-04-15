<?php

try {
    //DB名、ユーザー名、パスワードを変数に格納
    $dsn = 'mysql:dbname=dms;host=localhost;charset=utf8';
    $user = 'root';
    $password = '';

    $PDO = new PDO($dsn, $user, $password); //PDOでMySQLのデータベースに接続
    $PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //PDOのエラーレポートを表示

    //input.phpの値を取得
    $classicationId = $_POST['classicationId'];
    $UserID = $_POST['UserID'];
    $UserName = $_POST['UserName'];
    $CreatedDate = $_POST['CreatedDate'];
    $Branch = $_POST['Branch'];
    $EstimateNumber = $_POST['SerialNumber'];
    $EstimateName = $_POST['TitleName'];
    $Customer = $_POST['Customer'];
    $CustomerAdd = $_POST['CustomerAdd'];
    $Location = $_POST['Location'];
    $ScheduledDate = $_POST['ScheduledDate'];
    $EffectiveDate = $_POST['EffectiveDate'];
    $Tax = $_POST['Tax'];
    $Remark = $_POST['Remark'];
    $Memo = $_POST['Memo'];
    $StaffDisplay = $_POST['StaffDisplay'];
    $CDDisplay = $_POST['cddisplay'];
    $UnitPriceEstimate = $_POST['UnitPriceEstimate'];

    $sql = "INSERT INTO estimate (
            classicationId,
            UserID,
            UserName,
            CreatedDate,
            Branch,
            EstimateNumber,
            EstimateName,
            Customer,
            CustomerAdd,
            Location,
            ScheduledDate,
            EffectiveDate,
            Tax,
            Remark,
            Memo,
            Summary,
            Quantity,
            Unit,
            UnitPrice,
            StaffDisplay,
            CDDisplay,
            UnitPriceEstimate) 
        VALUES (
            :classicationId,
            :UserID,
            :UserName,
            :CreatedDate,
            :Branch,
            :EstimateNumber,
            :EstimateName,
            :Customer,
            :CustomerAdd,
            :Location,
            :ScheduledDate,
            :EffectiveDate,
            :Tax,
            :Remark,
            :Memo,
            :Summary,
            :Quantity,
            :Unit,
            :UnitPrice,
            :StaffDisplay,
            :CDDisplay,
            :UnitPriceEstimate)";
    $stmt = $PDO->prepare($sql); //値が空のままSQL文をセット
    $blcnt = -1;

    while ($blcnt < 59) { //4列×15行=60
        $blcnt = $blcnt + 1;
        $InputItems1 = $_POST['InputItems' . $blcnt];
        $blcnt = $blcnt + 1;
        $InputItems2 = $_POST['InputItems' . $blcnt];
        $blcnt = $blcnt + 1;
        $InputItems3 = $_POST['InputItems' . $blcnt];
        $blcnt = $blcnt + 1;
        $InputItems4 = $_POST['InputItems' . $blcnt];
        $params = array(
            'classicationId' => $classicationId,
            'UserID' => $UserID,
            'UserName' => $UserName,
            'CreatedDate' => $CreatedDate,
            'Branch' => $Branch,
            'EstimateNumber' => $EstimateNumber,
            'EstimateName' => $EstimateName,
            'Customer' => $Customer,
            'CustomerAdd' => $CustomerAdd,
            'Location' => $Location,
            'ScheduledDate' => $ScheduledDate,
            'EffectiveDate' => $EffectiveDate,
            'Tax' => $Tax,
            'Remark' => $Remark,
            'Memo' => $Memo,
            'Summary' => $InputItems1,
            'Quantity' => $InputItems2,
            'Unit' => $InputItems3,
            'UnitPrice' => $InputItems4,
            'StaffDisplay' => $StaffDisplay,
            'CDDisplay' => $CDDisplay,
            'UnitPriceEstimate' => $UnitPriceEstimate
        );
        $stmt->execute($params); //挿入する値が入った変数をexecuteにセットしてSQLを実行
    };
} catch (PDOException $e) {
    exit('データベースに接続できませんでした。' . $e->getMessage());
}
