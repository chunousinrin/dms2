<?php
if ($_POST['ID'] < 1000) {
    $sql = "UPDATE equipment_list SET ";
} else {
    $sql = "UPDATE equipment_rental_list SET ";
}
$Manufacturer = NULL;
$BaseMachine = NULL;
$Standard = NULL;
$EquipmentID1 = NULL;
$EquipmentID2 = NULL;
$Introduction = NULL;
$Superintendent = NULL;
if (!empty($_POST['Manufacturer'])) {
    $Manufacturer = $_POST['Manufacturer'];
};
if (!empty($_POST['BaseMachine'])) {
    $BaseMachine = $_POST['BaseMachine'];
};
if (!empty($_POST['Standard'])) {
    $Standard = $_POST['Standard'];
};
if (!empty($_POST['EquipmentID1'])) {
    $EquipmentID1 = $_POST['EquipmentID1'];
};
if (!empty($_POST['EquipmentID2'])) {
    $EquipmentID2 = $_POST['EquipmentID2'];
};
if (!empty($_POST['Introduction'])) {
    $Introduction = $_POST['Introduction'];
};
if (!empty($_POST['Superintendent'])) {
    $Superintendent = $_POST['Superintendent'];
};

try {
    // UPDATE文を変数に格納
    $sql = $sql
        . "CategoryID = :CategoryID, "
        . "MachineName = :MachineName, "
        . "Ownership = :Ownership, "
        . "Manufacturer = :Manufacturer, "
        . "BaseMachine = :BaseMachine, "
        . "Standard = :Standard, "
        . "EquipmentID1 = :EquipmentID1, "
        . "EquipmentID2 = :EquipmentID2, "
        . "Introduction = :Introduction, "
        . "Superintendent = :Superintendent "
        . "WHERE ID = :ID;";

    // 更新する値と該当のIDは空のまま、SQL実行の準備をする
    $stmt = $dbh->prepare($sql);

    // 更新する値と該当のIDを配列に格納する
    $params = array(
        ':ID' => $_POST['ID'],
        ':CategoryID' => $_POST['CategoryID'],
        ':MachineName' => $_POST['MachineName'],
        ':Ownership' => $_POST['Ownership'],
        ':Manufacturer' => $Manufacturer,
        ':BaseMachine' => $BaseMachine,
        ':Standard' => $Standard,
        ':EquipmentID1' => $EquipmentID1,
        ':EquipmentID2' => $EquipmentID2,
        ':Introduction' => $Introduction,
        ':Superintendent' => $Superintendent
    );

    // 更新する値と該当のIDが入った変数をexecuteにセットしてSQLを実行
    $stmt->execute($params);
    echo "更新しました";
    header("Location:./equipment?sbmtype=20&machineID=" . $_POST['EquipmentID']);
    exit();
} catch (Exception $e) {
    echo 'エラーが発生しました。:' . $e->getMessage();
}
