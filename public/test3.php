<?php
$machine_id = $_GET['machine_id'];
$response2 = array();
$dbh = new PDO('mysql:host=localhost;dbname=cf756484_dms;charset=utf8', 'cf444722_root', 'U7jC6Xaq');
if (!empty($machine_id)) {
    $equipment_sql = "SELECT equipment_usage_history.*,worker_group.WorkerGroupName,view_equipment_list.MachineName FROM `equipment_usage_history` left JOIN worker_group ON equipment_usage_history.WorkerGroupInUse=worker_group.WorkerGroupID LEFT JOIN view_equipment_list ON equipment_usage_history.EquipmentID=view_equipment_list.ID WHERE equipment_usage_history.EndDate>=CURDATE() AND EquipmentID = '" . $machine_id . "'";
} else {
    $equipment_sql = "SELECT equipment_usage_history.*,worker_group.WorkerGroupName,view_equipment_list.MachineName FROM `equipment_usage_history` left JOIN worker_group ON equipment_usage_history.WorkerGroupInUse=worker_group.WorkerGroupID LEFT JOIN view_equipment_list ON equipment_usage_history.EquipmentID=view_equipment_list.ID WHERE equipment_usage_history.EndDate>=CURDATE()";
}
$equipment_stmt = $dbh->query($equipment_sql);
while ($equipment = $equipment_stmt->fetch(PDO::FETCH_ASSOC)) {
    array_push($response2, $equipment);
};
echo (json_encode($response2));
