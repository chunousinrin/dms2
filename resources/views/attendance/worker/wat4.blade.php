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

        if ($shukkin == 3) {
            $watID = $yukyu;
        } else {
            $watID = $shukkin;
        };

        if (!empty($_POST['shukkin' . $i])) {
            $kensu = $kensu + 1;
            $watsql = "SELECT * FROM worker_attendace_type WHERE watID = '" . $watID . "'";
            $watstmt = $dbh->query($watsql);
            $wat = $watstmt->fetch(); ?>
            <div class="fs" style="display:flex;border-bottom:1px solid gray;">
                <div style="width: 100%;padding:1.5em;"><?= $_POST['workername' . $i] ?></div>
                <div style="width: 100%;padding:1.5em;"><?= $wat['AttendanceType'] ?></div>
            </div>
            <div style="display:none;">
                <input type="text" name="WorkerNameID<?= $i ?>" id="WorkerNameID<?= $i ?>" value="<?= $_POST['workerid' . $i] ?>">
                <input type="text" name="watID<?= $i ?>" id="watID<?= $i ?>" value="<?= $watID ?>">
                <input type="text" name="kensu" id="kensu" value="<?= $i ?>">
            </div>
    <?php
        } else {
            echo null;
        };
    }
    if (empty($kensu)) {
        echo "<div class='fs text-center' style='padding:1.5em;'>保存するデータがありません</div>";
        $dsbl = "disabled";
    } else {
        $dsbl = null;
    }
    ?>
    <input type="text" name="sbmtype" id="sbmtype" value="4" hidden>
    <div class="fs" style="display: flex;">
        <div class="btn bs bsh fs rounded-0" style="width: 100%;padding:1.5em 0" onclick="history.back();">戻る</div>
        <input class="btn bs bsh fs rounded-0" style="width: 100%;" type="submit" value="保存" <?= $dsbl ?>>
        <div class="btn bs bsh fs rounded-0" style="width: 100%;padding:1.5em 0" id="gotop">Top</div>
    </div>
</form>