<?php
/*$dbh = new PDO('mysql:host=localhost;dbname=' . env('DB_DATABASE') . ';charset=utf8', env('DB_USERNAME'), env('DB_PASSWORD'));*/
$dbh = new PDO('mysql:host=localhost;dbname=cf756484_dms;charset=utf8', 'cf756484_root', 'AgVj4jDXzK');
$atnowsql = "SELECT wgm.kyo AS wgmAttendanceDay, wgm.WorkerNameID AS wgmWNI, wgm.WorkerName AS wgmWN, worker_attendance_view.* FROM ( SELECT *, DATE(NOW()) AS kyo FROM worker_group_member) AS wgm LEFT JOIN worker_attendance_view ON wgm.kyo = worker_attendance_view.AttendanceDay AND wgm.WorkerNameID = worker_attendance_view.WorkerNameID WHERE worker_attendance_view.NumberOfDaysWorked is null;";
$atnowstmt = $dbh->query($atnowsql);
?>

<table style="margin: 0 auto;">
    <thead>
        <tr>
            <td colspan="3"><?= 'now' ?></td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td></td>
        </tr>
        <?php
        while ($atnow = $atnowstmt->fetch(PDO::FETCH_BOTH)) : ?>
            <tr>
                <td><?= $atnow['wgmWN'] ?></td>
                <?php
                if (!empty($atnow['watID2']) && !empty($atnow['watID'])) {
                    $at2 = " - ";
                } else {
                    $at2 = '';
                } ?>
                <td><?= $atnow['AttendanceType'] . $at2 . $atnow['AttendanceType2'] ?></td>
                <td><?= $atnow['NumberOfDaysWorked'] ?></td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>