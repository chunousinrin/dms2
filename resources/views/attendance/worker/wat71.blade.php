<?php

if (!empty($_GET['StartVal'])) {
    $stdate = $_GET['StartVal'];
} elseif (!empty($_POST['StartVal'])) {
    $stdate = $_POST['StartVal'];
} else {
    $stdate = null;
}

if (!empty($_GET['EndVal'])) {
    $eddate = $_GET['EndVal'];
} elseif (!empty($_POST['EndVal'])) {
    $eddate = $_POST['EndVal'];
} else {
    $eddate = null;
}

$response = array();

//$dbh = new PDO('mysql:host=localhost;dbname=cf444722_dms;charset=utf8mb4', 'cf444722_root', 'U7jC6Xaq');
$dbh = new PDO('mysql:host=localhost;dbname=' . env('DB_DATABASE') . ';charset=utf8', env('DB_USERNAME'), env('DB_PASSWORD'));

$worker_sql = "select worker_attendance.WorkerNameID as ID, worker_group_member.WorkerName AS Name,"
    . " count(case when watID = 1 then 1 else null end) as 出勤,"
    . " count(case when watID2 = 2 then 1 else null end) as 一日欠勤,"
    . " count(case when watID2 = 3 then 1 else null end) as 一日有給,"
    . " count(case when watID2 = 4 then 1 else null end) as 半日欠勤,"
    . " count(case when watID2 = 5 then 1 else null end) as 半日有給,"
    . " count(case when watID2 = 6 then 1 else null end) as 特別休暇,"
    . " count(case when watID2 = 7 then 1 else null end) as 労災"
    . " from worker_attendance"
    . " LEFT JOIN"
    . " worker_group_member ON"
    . " worker_attendance.WorkerNameID=worker_group_member.WorkerNameID"
    . " WHERE AttendanceDay BETWEEN '" . $stdate . "' AND '" . $eddate . "'"
    . " group by worker_attendance.WorkerNameID";

$worker_stmt = $dbh->query($worker_sql);
while ($result = $worker_stmt->fetch(PDO::FETCH_BOTH)) {
    array_push($response, $result);
};

echo (json_encode($response));
