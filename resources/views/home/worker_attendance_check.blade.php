<div class="shadow bg-white p-3 mb-2">
    <div class="text-center" style="position: relative;">作業班出退勤
        <button class="btn btn-sm btn-info py-0 rounded-0" style="position: absolute; top:0;right:0;">印刷</button>
    </div>
    <form action="" method="post">
        @csrf
        <input type="text" name="kyo" id="kyo" class="form-control rounded-0 datepicker" placeholder="日付を選択" onchange="submit();" value="<?= $_POST['kyo'] ?? null ?>">
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
        <summary style="display:none">表示</summary>
        <table style="margin: 0 auto;font-size:0.9rem">
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