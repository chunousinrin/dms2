<?php
if (!empty($_POST['limit'])) {
    $limit = $_POST['limit'];
} else {
    $limit = 25;
}

if (!empty($_POST['startDate']) && !empty($_POST['endDate'])) {
    $srch = " AND WorkingDay Between '" . $_POST['startDate'] . "' AND '" . $_POST['endDate'] . "'";
} elseif (!empty($_POST['startDate']) && empty($_POST['endDate'])) {
    $srch = " AND WorkingDay >= '" . $_POST['startDate'] . "'";
} elseif (empty($_POST['startDate']) && !empty($_POST['endDate'])) {
    $srch = " AND WorkingDay Between '1' AND '" . $_POST['endDate'] . "'";
} else {
    $srch = null;
}

?>

<form action="" method="post" name="f_list" id="f_list">
    @csrf

    <div class="search_box" style="padding-bottom: 1em;align-items:center">
        <div class="input-group">
            <input type="text" name="startDate" class="form-control rounded-0 datepicker" placeholder="検索開始日" value="<?= $_POST['startDate'] ?? null ?>">
            <div style="padding:0.375rem 0.75rem">　～　</div>
            <input type="text" name="endDate" class="form-control rounded-0 datepicker" placeholder="検索終了日" value="<?= $_POST['endDate'] ?? null ?>">
            <input class="btn btn-sm btn-secondary rounded-0 col-1" value="検索" onclick="document.f_list.submit();">
        </div>
    </div>

    <hr>

    <div style="width:100%;display:flex;">
        <div style="width: 100%;">履歴一覧</div>
        <div style="width: 100%;text-align:right;">
            <span>表示件数</span>
            <select name="limit" onchange="submit()">
                <option value="<?= $limit ?>" selected hidden><?= $limit ?></option>
                <option value="25">25</option>
                <option value="50">50</option>
                <option value="100">100</option>
                <option value="200">200</option>
            </select>
        </div>
    </div>

    <div class="table-wrap">
        <table class="table table-bordered table-sm table-hover" id="table">
            <thead style="position: sticky;top:calc(-1em - 1px);">
                <tr class="table-success">
                    <td></td>
                    <td>出勤日</td>
                    <td style="display:none;">No</td>
                    <td>業種</td>
                    <td>摘要</td>
                    <td>業種</td>
                    <td>摘要</td>
                    <td>天気</td>
                </tr>
            </thead>
            <tbody>
                <?php
                $drs_sql = "SELECT * FROM drs_history WHERE UserID = {$user['id']} {$srch} ORDER BY WorkingDay DESC LIMIT {$limit} ";
                $drs_st = $dbh->query($drs_sql);
                while ($drs = $drs_st->fetch(PDO::FETCH_BOTH)) { ?>
                    <tr>
                        <td style='text-align:center;'>
                            <div class="btns btn btn-sm btn-secondary rounded-0" style="background-image:url(https://icongr.am/fontawesome/trash-o.svg?color=ffffff);" onclick="dl()"></div>
                        </td>
                        <td><?= $drs['WorkingDay'] ?></td>
                        <td style="display:none;"><?= $drs['No'] ?></td>
                        <td><?= $drs['AmIndustry'] ?></td>
                        <td><?= $drs['AmRemark'] ?></td>
                        <td><?= $drs['PmIndustry'] ?></td>
                        <td><?= $drs['PmRemark'] ?></td>
                        <td>
                            <?php
                            if (!empty($drs['PmWeather'])) {
                                echo $drs['AmWeather'] . " - " . $drs['PmWeather'];
                            } else {
                                echo $drs['AmWeather'];
                            } ?>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <input type="hidden" id="SerialNumber" name="SerialNumber">
    <input type="hidden" id="sbmtype" name="sbmtype" value="<?= $sbmtype ?>">
</form>