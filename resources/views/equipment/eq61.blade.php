<?php
try {

    // INSERT文を変数に格納
    $sql = "INSERT INTO equipment_maintenance (EquipmentID, MaintenanceDetails, Cost, EffectiveDate, InputUserID, Remark) VALUES (:EquipmentID, :MaintenanceDetails, :Cost, :EffectiveDate, :InputUserID, :Remark)";

    // 挿入する値は空のまま、SQL実行の準備をする
    $stmt = $dbh->prepare($sql);

    // 挿入する値を配列に格納する
    $params = array(
        ':EquipmentID' => $_POST['EquipmentID'],
        ':MaintenanceDetails' => $_POST['MaintenanceDetails'],
        ':Cost' => $_POST['Cost'],
        ':EffectiveDate' => $_POST['EffectiveDate'],
        ':InputUserID' => $_POST['InputUserID'],
        ':Remark' => $_POST['Remark']
    );

    // 挿入する値が入った変数をexecuteにセットしてSQLを実行
    $stmt->execute($params);

    // 登録完了のメッセージ
    echo "登録しました";
    header("Location:./equipment?sbmtype=20&machineID=" . $_POST['EquipmentID']);
    exit();
} catch (Exception $e) {
    echo 'エラーが発生しました。:' . $e->getMessage();
}
