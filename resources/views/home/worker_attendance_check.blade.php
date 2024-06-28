<?php
$dbh = new PDO('mysql:host=localhost;dbname=' . env('DB_DATABASE') . ';charset=utf8', env('DB_USERNAME'), env('DB_PASSWORD'));
$atnowsql = "SELECT wgm.kyo AS wgmAttendanceDay, wgm.WorkerNameID AS wgmWNI, wgm.WorkerName AS wgmWN, worker_attendance_view.* FROM ( SELECT *, DATE(NOW()) AS kyo FROM worker_group_member) AS wgm LEFT JOIN worker_attendance_view ON wgm.kyo = worker_attendance_view.AttendanceDay AND wgm.WorkerNameID = worker_attendance_view.WorkerNameID WHERE worker_attendance_view.NumberOfDaysWorked is null;";
$atnowstmt = $dbh->query($atnowsql);
?>

<div class="shadow bg-white p-3 mb-2">
    <details>
        <summary>作業班出退勤未入力者</summary>
        <?php
        while ($atnow = $atnowstmt->fetch(PDO::FETCH_BOTH)) : ?>
            <div><?= $atnow['wgmWN'] ?></div>
        <?php endwhile; ?>

    </details>
</div>