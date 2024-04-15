<?php

try {
    //DB名、ユーザー名、パスワードを変数に格納
    $dsn = 'mysql:dbname=dms;host=localhost;charset=utf8';
    $user = 'root';
    $password = '';

    $PDO = new PDO($dsn, $user, $password); //PDOでMySQLのデータベースに接続
    $PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //PDOのエラーレポートを表示

    //input.phpの値を取得
    $UserID = $_POST['UserID'];
    $UserName = $_POST['UserName'];
    $CreatedDate = $_POST['CreatedDate'];
    $CDDisplay = $_POST['cddisplay'];
    $Branch = $_POST['Branch'];
    $StaffDisplay = $_POST['StaffDisplay'];
    $classicationId = $_POST['classicationId'];
    $BillNumber = $_POST['SerialNumber'];
    $BizName = $_POST['TitleName'];
    $Customer = $_POST['Customer'];
    $CustomerAdd = $_POST['CustomerAdd'];
    $Location = $_POST['Location'];
    $CompletionDate = $_POST['CompletionDate'];
    $CompletionDate2 = $_POST['CompletionDate2'];
    $BankID1 = $_POST['BankID1'];
    $BankID2 = $_POST['BankID2'];
    $BankID3 = $_POST['BankID3'];
    $PaymentDueDate = $_POST['PaymentDueDate'];
    $PaymentDate = $_POST['PaymentDate'];
    $Tax = $_POST['Tax'];
    $Remark = $_POST['Remark'];
    $Memo = $_POST['Memo'];

    $sql = "INSERT INTO bill (
            UserID,
            UserName,
            CreatedDate,
            Branch,
            classicationId,
            BillNumber,
            BizName,
            Customer,
            CustomerAdd,
            Location,
            CompletionDate,
            CompletionDate2,
            BankID1,
            BankID2,
            BankID3,
            PaymentDueDate,
            PaymentDate,
            Tax,
            Remark,
            Memo,
            Summary,
            Quantity,
            Unit,
            UnitPrice,
            StaffDisplay,
            CDDisplay) 
        VALUES (
            :UserID,
            :UserName,
            :CreatedDate,
            :Branch,
            :classicationId,
            :BillNumber,
            :BizName,
            :Customer,
            :CustomerAdd,
            :Location,
            :CompletionDate,
            :CompletionDate2,
            :BankID1,
            :BankID2,
            :BankID3,
            :PaymentDueDate,
            :PaymentDate,
            :Tax,
            :Remark,
            :Memo,
            :Summary,
            :Quantity,
            :Unit,
            :UnitPrice,
            :StaffDisplay,
            :CDDisplay)";
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
            'UserID' => $UserID,
            'UserName' => $UserName,
            'CreatedDate' => $CreatedDate,
            'Branch' => $Branch,
            'StaffDisplay' => $StaffDisplay,
            'classicationId' => $classicationId,
            'BillNumber' => $BillNumber,
            'BizName' => $BizName,
            'Customer' => $Customer,
            'CustomerAdd' => $CustomerAdd,
            'Location' => $Location,
            'CompletionDate' => $CompletionDate,
            'BankID1' => $BankID1,
            'BankID2' => $BankID2,
            'BankID3' => $BankID3,
            'PaymentDueDate' => $PaymentDueDate,
            'PaymentDate' => $PaymentDate,
            'Tax' => $Tax,
            'Remark' => $Remark,
            'Memo' => $Memo,
            'CDDisplay' => $CDDisplay,
            'CompletionDate2' => $CompletionDate2,
            'Summary' => $InputItems1,
            'Quantity' => $InputItems2,
            'Unit' => $InputItems3,
            'UnitPrice' => $InputItems4
        );
        $stmt->execute($params); //挿入する値が入った変数をexecuteにセットしてSQLを実行
    };
} catch (PDOException $e) {
    exit('データベースに接続できませんでした。' . $e->getMessage());
}
