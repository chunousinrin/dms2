<?php
try {

    // INSERT文を変数に格納
    $sql = "INSERT INTO equipment_refuel (EquipmentID, RefuelDate, FuelVolume, GasStation, FuelingLocations, InputUserID, Remark) VALUES (:EquipmentID, :RefuelDate, :FuelVolume, :GasStation, :FuelingLocations, :InputUserID, :Remark)";

    // 挿入する値は空のまま、SQL実行の準備をする
    $stmt = $dbh->prepare($sql);

    // 挿入する値を配列に格納する
    $params = array(
        ':EquipmentID' => $_POST['EquipmentID'],
        ':RefuelDate' => $_POST['RefuelDate'],
        ':FuelVolume' => $_POST['FuelVolume'],
        ':GasStation' => $_POST['GasStation'],
        ':FuelingLocations' => $_POST['FuelingLocations'],
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
