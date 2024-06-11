<?php
try {
    $PDO = new PDO('mysql:host=localhost;dbname=' . env('DB_DATABASE') . ';charset=utf8', env('DB_USERNAME'), env('DB_PASSWORD'));
    $PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //PDOのエラーレポートを表示
    $sql = "INSERT INTO drs_reports(
            WorkingDay,
            UserID,
            AmIndustry,
            AmRemark,
            PmIndustry,
            PmRemark,
            Remark,
            Weather1,
            Weather2
        )
        VALUES(
            :WorkingDay,
            :UserID,
            :AmIndustry,
            :AmRemark,
            :PmIndustry,
            :PmRemark,
            :Remark,
            :Weather1,
            :Weather2)";
    $stmt = $PDO->prepare($sql); //値が空のままSQL文をセット
    $params = array(
        ':WorkingDay' => $_POST['WorkingDay'],
        ':UserID' => $_POST['UserID'],
        ':AmIndustry' => $_POST['AmIndustry'],
        ':AmRemark' => $_POST['AmRemark'],
        ':PmIndustry' => $_POST['PmIndustry'],
        ':PmRemark' => $_POST['PmRemark'],
        ':Remark' => $_POST['Remark'],
        ':Weather1' => $_POST['Weather1'],
        ':Weather2' => $_POST['Weather2']
    );
    $stmt->execute($params); //挿入する値が入った変数をexecuteにセットしてSQLを実行
    $_POST = array();
} catch (PDOException $e) {
    exit('データベースに接続できませんでした。' . $e->getMessage());
}
