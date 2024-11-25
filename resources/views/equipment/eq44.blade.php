<?php
// DELETE文を変数に格納
$eq44sql = "DELETE FROM equipment_usage_history WHERE ID = :id";

// 削除するレコードのIDは空のまま、SQL実行の準備をする
$eq44stmt = $dbh->prepare($eq44sql);

// 削除するレコードのIDを配列に格納する
$params = array(':id' => $_POST['deleteID']);

// 削除するレコードのIDが入った変数をexecuteにセットしてSQLを実行
$eq44stmt->execute($params);

// 削除完了のメッセージ
echo "削除しました";
header("Location:./equipment?sbmtype=20&machineID=" . $_POST['EquipmentID']);
exit();