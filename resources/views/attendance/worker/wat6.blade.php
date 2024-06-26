    <?php

    if (empty($_GET['kyo'])) {
        $kyo = date("Y-m-d");
        $open = "";
    } else {
        $kyo = ($_GET['kyo']);
        $open = "open";
    }
    $dbh = new PDO('mysql:host=localhost;dbname=' . env('DB_DATABASE') . ';charset=utf8', env('DB_USERNAME'), env('DB_PASSWORD'));
    $atnowsql = "SELECT wgm.kyo AS wgmAttendanceDay, wgm.WorkerNameID AS wgmWNI, wgm.WorkerName AS wgmWN, worker_attendance_view.* FROM ( SELECT *, '" . $kyo . "' AS kyo FROM worker_group_member) AS wgm LEFT JOIN worker_attendance_view ON wgm.kyo = worker_attendance_view.AttendanceDay AND wgm.WorkerNameID = worker_attendance_view.WorkerNameID;";
    $atnowstmt = $dbh->query($atnowsql);
    ?>

    <details <?= " " . $open ?>>
        <summary style="display:none">表示</summary>
        <table style="width:100%;margin: 0 auto;font-size:0.9rem;border-collapse:collapse;">
            <tbody>
                <?php
                while ($atnow = $atnowstmt->fetch(PDO::FETCH_BOTH)) : ?>
                    <tr>
                        <td style="border-bottom: 1px solid lightseagreen;"><?= $atnow['wgmWN'] ?></td>
                        <?php
                        if (!empty($atnow['watID2']) && !empty($atnow['watID'])) {
                            $at2 = " - ";
                        } else {
                            $at2 = '';
                        } ?>
                        <td style="border-bottom: 1px solid lightseagreen;"><?= $atnow['AttendanceType'] . $at2 . $atnow['AttendanceType2'] ?></td>
                        <td style="border-bottom: 1px solid lightseagreen;"><?= $atnow['NumberOfDaysWorked'] ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </details>