<?php
$category_id = $_GET['category_id'];
$response = array();
$dbh = new PDO('mysql:host=localhost;dbname=cf756484_dms;charset=utf8', 'cf444722_root', 'U7jC6Xaq');
if (strlen($category_id) != 0) {
    $machine_sql = "SELECT ID,CategoryID,MachineName FROM view_equipment_list WHERE CategoryID = " . $category_id;
} else {
    $machine_sql = "SELECT ID,CategoryID,MachineName FROM view_equipment_list";
}
$machine_stmt = $dbh->query($machine_sql);
while ($machine = $machine_stmt->fetch(PDO::FETCH_ASSOC)) {
    array_push($response, $machine);
};
echo (json_encode($response));
