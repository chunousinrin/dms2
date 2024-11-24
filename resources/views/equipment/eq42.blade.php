<?php
if (!empty($_POST['StartDay'])) {
    $startday = $_POST['StartDay'];
} elseif (!empty($_GET['StartDay'])) {
    $startday = $_GET['StartDay'];
}

if (!empty($_POST['EquipmentID'])) {
    $machineID = $_POST['EquipmentID'];
} elseif (!empty($_GET['EquipmentID'])) {
    $machineID = $_GET['EquipmentID'];
}

$response = array();
$dbh = new PDO('mysql:host=localhost;dbname=cf756484_dms;charset=utf8', 'cf444722_root', 'U7jC6Xaq');
$reserve_sql = "SELECT COUNT(*)AS reservecount FROM `equipment_usage_history` left JOIN worker_group ON equipment_usage_history.WorkerGroupInUse=worker_group.WorkerGroupID LEFT JOIN view_equipment_list ON equipment_usage_history.EquipmentID=view_equipment_list.ID WHERE EndDate>='" . $startday . "' AND EquipmentID=" . $machineID;
$reserve_stmt = $dbh->query($reserve_sql);
while ($reserve = $reserve_stmt->fetch(PDO::FETCH_ASSOC)) {
    array_push($response, $reserve);
};
echo (json_encode($response));
