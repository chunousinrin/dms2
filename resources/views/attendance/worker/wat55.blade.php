<?php
var_dump($_POST);

$dbh = new PDO('mysql:host=localhost;dbname=' . env('DB_DATABASE') . ';charset=utf8', env('DB_USERNAME'), env('DB_PASSWORD'));

$sql = "UPDATE worker_attendance SET NumberOfDaysWorked = :NumberOfDaysWorked WHERE waID = :waID";

$stmt = $dbh->prepare($sql);

$params = array(':NumberOfDaysWorked' => $_POST['sqlnodw'], ':waID' => $_POST['sqlswaid']);

$stmt->execute($params);

$alert = "<script type='text/javascript'>alert('更新しました');</script>";

echo $alert;
