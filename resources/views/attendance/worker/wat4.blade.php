<form action="" method="post">
    <input type="hidden" name="shukkinbi" id="shukkinbi" value="<?= $_POST['shukkinbi'] ?? null ?>">
    <div class="fs bs text-center" style="width: 100%;padding:1.5em;border-bottom:2px solid gray;">出勤日　：　<?= $_POST['shukkinbi'] ?></div>
    @csrf
    <?php
    $kensu = 0;
    for ($i = 1; $i < $_POST['kensu'] + 1; $i++) {
        if (empty($_POST['shukkin' . $i])) {
            $shukkin = 0;
        } else {
            $shukkin = $_POST['shukkin' . $i];
        };
        if (empty($_POST['yukyu' . $i])) {
            $yukyu = 0;
        } else {
            $yukyu = $_POST['yukyu' . $i];
        };
        if ($yukyu == 4 || $yukyu == 5 || $yukyu == 0) {
            $shukkin = 1;
            $one2two = " - ";
        } else {
            $shukkin = 0;
            $one2two = '';
        }

        $wat1sql = "SELECT * FROM worker_attendace_type WHERE watID = '" . $shukkin . "'";
        $wat1stmt = $dbh->query($wat1sql);
        $wat1 = $wat1stmt->fetch();
        $wat2sql = "SELECT * FROM worker_attendace_type WHERE watID = '" . $yukyu . "'";
        $wat2stmt = $dbh->query($wat2sql);
        $wat2 = $wat2stmt->fetch();
        $at = $shukkin + $yukyu;
    ?>
        <?php
        if (!empty($at)) {
            $wd = $wat1['NumberOfDaysWorked'] + $wat2['NumberOfDaysWorked'];
            if ($wd > 1) {
                $wds = 1;
            } elseif ($wd < 0) {
                $wds = 0;
            } else {
                $wds = $wd;
            };

            $kensu = $kensu + 1; ?>
            <div class="fs" style="display:flex;border-bottom:1px solid gray;">
                <div style="width: 100%;padding:1.5em;"><?= $_POST['workername' . $i] ?></div>
                <div style="width: 100%;padding:1.5em;"><?= $wat1['AttendanceType'] ?><?= $one2two . $wat2['AttendanceType'] ?></div>
                <div style="width: 100%;padding:1.5em;"><?= number_format($wds, 1) ?></div>
            </div>
            <div style="display:none;">
                <input type="text" name="WorkerNameID<?= $i ?>" id="WorkerNameID<?= $i ?>" value="<?= $_POST['workerid' . $i] ?>">
                <input type="text" name="watID<?= $i ?>" id="watID<?= $i ?>" value="<?= $shukkin ?>">
                <input type="text" name="watID2<?= $i ?>" id="watID2<?= $i ?>" value="<?= $yukyu ?>">
                <input type="text" name="NumberOfDaysWorked<?= $i ?>" id="NumberOfDaysWorked<?= $i ?>" value="<?= $wds ?>">
                <input type="text" name="kensu" id="kensu" value="<?= $i ?>">
            </div>
    <?php
        } else {
            echo null;
        };
    }
    /*    if (empty($kensu)) {
        echo "<div class='fs text-center' style='padding:1.5em;'>保存するデータがありません</div>";
        $dsbl = "disabled";
    } else {
        $dsbl = null;
    }*/
    ?>
    <input type="text" name="sbmtype" id="sbmtype" value="4" hidden>
    <div class="fs" style="display: flex;">
        <div class="btn bs bsh fs rounded-0" style="width: 100%;padding:1.5em 0" onclick="history.back();">戻る</div>
        <input class="btn bs bsh fs rounded-0" style="width: 100%;" type="submit" value="保存">
        <div class="btn bs bsh fs rounded-0" style="width: 100%;padding:1.5em 0" id="gotop">Top</div>
    </div>
</form>