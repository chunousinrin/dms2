<div class="shadow bg-white p-3 mb-2">
    <form action="" method="post">
        @csrf
        <input type="text" name="kyo" id="kyo" class="datepicker" onchange="submit();">
    </form>
    <?php

    if (empty($_POST['kyo'])) {
        $kyo = date("Y-m-d");
        $open = "";
    } else {
        $kyo = ($_POST['kyo']);
        $open = "open";
    }
    $dbh = new PDO('mysql:host=localhost;dbname=' . env('DB_DATABASE') . ';charset=utf8', env('DB_USERNAME'), env('DB_PASSWORD'));
    $atnowsql = "SELECT wgm.kyo AS wgmAttendanceDay, wgm.WorkerNameID AS wgmWNI, wgm.WorkerName AS wgmWN, worker_attendance_view.* FROM ( SELECT *, '" . $kyo . "' AS kyo FROM worker_group_member) AS wgm LEFT JOIN worker_attendance_view ON wgm.kyo = worker_attendance_view.AttendanceDay AND wgm.WorkerNameID = worker_attendance_view.WorkerNameID;";
    $atnowstmt = $dbh->query($atnowsql);
    ?>

    <details <?= " " . $open ?>>
        <summary>作業班出退勤未入力者</summary>
        <table style="margin: 0 auto;">
            <thead>
                <tr>
                    <td colspan="3"><?= $_POST['kyo'] ?? null ?></td>
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
    </details>
</div>