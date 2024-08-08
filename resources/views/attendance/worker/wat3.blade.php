<?php
$wgl_sql = "SELECT * FROM worker_list WHERE WorkerGroupID = " . $_POST['options'] . " ORDER BY WorkerGroupID ASC,WorkerNameID ASC";
$wgl_st = $dbh->query($wgl_sql);
if (empty($_GET['ipt'])) {
    $ipt = "";
    $printlink = "?ipt=prnt";
} elseif ($_GET['ipt'] === "admin") {
    $ipt = "admin";
    $printlink = "?ipt=admin";
} else {
    $ipt = "";
    $printlink = "?ipt=prnt";
}
?>

<form action="<?= $printlink ?>" method="post">
    @csrf
    <input type="hidden" name="shukkinbi" id="shukkinbi" value="<?= $_POST['shukkinbi'] ?? null ?>">
    <div class="fs text-center" style="width: 100%;padding:1.5em;border-bottom:2px solid gray;">出勤日　：　<?= $_POST['shukkinbi'] ?></div>
    <section class="table-responsive">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <td class="bs rb text-nowrap">氏名</td>
                    <td class="bs rb text-center text-nowrap">出勤</td>
                    <td class="bs rb text-nowrap">休暇等</td>
                </tr>
            </thead>
            <tbody class="table-group-divider">
                <?php $opt2 = 0;
                $wnicount = 0;
                while ($result = $wgl_st->fetch(PDO::FETCH_BOTH)) :
                    $opt2 = $opt2 + 1 ?>
                    <?php
                    /*$wnicsql = "SELECT count(*)as cnt FROM worker_attendance WHERE AttendanceDay = '" . $_POST['shukkinbi'] . "' AND WorkerNameID = " . $result['WorkerNameID'];
                    $wnicstmt = $dbh->query($wnicsql);
                    $wnic = $wnicstmt->fetch();*/

                    $wnisql = "SELECT * FROM worker_attendance WHERE AttendanceDay = '" . $_POST['shukkinbi'] . "' AND WorkerNameID = " . $result['WorkerNameID'];
                    $wnistmt = $dbh->query($wnisql);
                    $wni = $wnistmt->fetch();
                    if (empty($wni['WorkerNameID'])) : ?>
                        <tr class="js-selectEnableRadio">
                            <td class="form-group col-3 text-nowrap rb">
                                <label class="col-form-label"><?= $result['WorkerName'] ?></label>
                                <input type="hidden" name="workerid<?= $opt2; ?>" id="workerid<?= $opt2; ?>" value="<?= $result['WorkerNameID'] ?>" hidden>
                                <input type="text" name="workername<?= $opt2; ?>" id="workername<?= $opt2; ?>" value="<?= $result['WorkerName'] ?>" hidden>
                                <?php $wnicount += 1; ?>
                            </td>
                            <td class="col-2 text-center rb">
                                <input type="radio" name="shukkin<?= $opt2; ?>" id="shukkin<?= $opt2; ?>" class="form-check-input border-success" style="width:1.5em;height:1.5em;" value="1">
                            </td>
                            <td class="col-5 text-nowrap">
                                <select name="yukyu<?= $opt2; ?>" class="form-select fs">
                                    <option value="0" selected hidden>選択</option>
                                    <?php
                                    $attypesql = "SELECT * FROM worker_attendace_type WHERE watID > 1;";
                                    $attypest = $dbh->query($attypesql);
                                    while ($attype = $attypest->fetch(PDO::FETCH_BOTH)) : ?>
                                        <option value="<?= $attype['watID'] ?>"><?= $attype['AttendanceType'] ?></option>
                                    <?php endwhile; ?>
                                </select>
                                <input type="hidden" name="kensu" id="kensu" value="<?= $opt2 ?>">
                            </td>
                        </tr>
                    <?php endif ?>
                <?php endwhile; ?>
                <?php
                if ($wnicount == "0") {
                    echo "<tr><td colspan='6' class='col-12 text-center'>入力済</td></tr>";
                    $dsbl = "disabled";
                } else {
                    $dsbl = null;
                }
                ?>
            </tbody>
        </table>
    </section>
    <input type="text" name="sbmtype" id="sbmtype" value="3" hidden>
    <div style="display: flex;">
        <div class="btn bs bsh fs rounded-0" style="width: 100%;padding:1.5em 0" onclick="history.back();">戻る</div>
        <input class="btn bs bsh fs rounded-0" style="width: 100%;" type="submit" value="確認" <?= $dsbl ?>>
        <div class="btn bs bsh fs rounded-0" style="width: 100%;padding:1.5em 0" id="gotop">Top</div>
    </div>
</form>
<?php
if ($ipt == "admin") : ?>
    <div style="position: absolute; bottom:0;left:0;background-color:chocolate;color:white;width:100%;text-align:center;">管理者モード</div>
<?php endif ?>