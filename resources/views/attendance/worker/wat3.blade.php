<?php
$wgl_sql = "SELECT * FROM worker_list WHERE WorkerGroupID = " . $_POST['options'] . " ORDER BY WorkerGroupID ASC,WorkerNameID ASC";
$wgl_st = $dbh->query($wgl_sql); ?>

<form action="" method="post">
    @csrf
    <input type="hidden" name="shukkinbi" id="shukkinbi" value="<?= $_POST['shukkinbi'] ?? null ?>">
    <div class="fs text-center" style="width: 100%;padding:1.5em;border-bottom:2px solid gray;">出勤日　：　<?= $_POST['shukkinbi'] ?></div>
    <section class="">
        <table class="table table-hover">
            <thead>
                <tr>
                    <td class="bs">ID</td>
                    <td class="bs">氏名</td>
                    <td class="bs">出勤</td>
                    <td class="bs">欠勤</td>
                    <td class="bs">休暇等</td>
                </tr>
            </thead>
            <tbody class="table-group-divider">
                <?php $opt2 = 0;
                while ($result = $wgl_st->fetch(PDO::FETCH_BOTH)) :
                    $opt2 = $opt2 + 1 ?>
                    <?php
                    $wnicsql = "SELECT count(*)as cnt FROM worker_attendance WHERE AttendanceDay = '" . $_POST['shukkinbi'] . "' AND WorkerNameID = " . $result['WorkerNameID'];
                    $wnicstmt = $dbh->query($wnicsql);
                    $wnic = $wnicstmt->fetch();

                    $wnisql = "SELECT * FROM worker_attendance WHERE AttendanceDay = '" . $_POST['shukkinbi'] . "' AND WorkerNameID = " . $result['WorkerNameID'];
                    $wnistmt = $dbh->query($wnisql);
                    $wni = $wnistmt->fetch();
                    if (empty($wni['WorkerNameID'])) : ?>
                        <tr class="js-selectEnableRadio">
                            <td class="form-group col-1">
                                <label class="col-form-label"><?= $result['WorkerNameID'] ?></label>
                                <input type="text" name="workerid<?= $opt2; ?>" id="workerid<?= $opt2; ?>" value="<?= $result['WorkerNameID'] ?>" hidden>
                            </td>
                            <td class="form-group col-2">
                                <label class="col-form-label"><?= $result['WorkerName'] ?></label>
                                <input type="text" name="workername<?= $opt2; ?>" id="workername<?= $opt2; ?>" value="<?= $result['WorkerName'] ?>" hidden>
                            </td>
                            <td class="form-group col-1 ">
                                <input type="radio" name="shukkin<?= $opt2; ?>" id="shukkin<?= $opt2; ?>" class="form-check-input border-success" style="width:1.5em;height:1.5em;" value="1">
                            </td>
                            <td class="form-group col-1 ">
                                <input type="radio" name="shukkin<?= $opt2; ?>" id="kekkin<?= $opt2; ?>" class="form-check-input border-success" style="width:1.5em;height:1.5em;" value="2">
                            </td>
                            <td class="form-group col-2 ">
                                <input type="radio" name="shukkin<?= $opt2; ?>" id="other<?= $opt2; ?>" class="form-check-input border-success" style="width:1.5em;height:1.5em;" value="3">
                                <select class="select" name="yukyu<?= $opt2; ?>" data-sync="shukkin<?= $opt2; ?>" class="form-select border-success rounded-0" data-active="3" disabled="disabled">
                                    <option value="0" selected hidden>選択</option>
                                    <option value="3">1日有給</option>
                                    <option value="4">午前有給</option>
                                    <option value="5">午後有給</option>
                                    <option value="6">忌引</option>
                                </select>
                                <input type="hidden" name="kensu" id="kensu" value="<?= $opt2 ?>">
                            </td>
                        </tr>
                    <?php endif ?>
                <?php endwhile; ?>
                <?php
                if (!empty($wnic['cnt'])) {
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