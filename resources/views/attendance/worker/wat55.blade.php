<?php
var_dump($_POST);
// UPDATE文を変数に格納
$dbh = new PDO('mysql:host=localhost;dbname=' . env('DB_DATABASE') . ';charset=utf8', env('DB_USERNAME'), env('DB_PASSWORD'));

$sql = "UPDATE worker_attendance SET NumberOfDaysWorked = :NumberOfDaysWorked WHERE waID = :waID";

// 更新する値と該当のIDは空のまま、SQL実行の準備をする
$stmt = $dbh->prepare($sql);

// 更新する値と該当のIDを配列に格納する
$params = array(':NumberOfDaysWorked' => $_POST['sqlnodw'], ':waID' => $_POST['sqlswaid']);

// 更新する値と該当のIDが入った変数をexecuteにセットしてSQLを実行
$stmt->execute($params);

// 更新完了のメッセージ
$alert = "<script type='text/javascript'>alert('更新しました');</script>";

// ②echoで①を表示する
echo $alert;
