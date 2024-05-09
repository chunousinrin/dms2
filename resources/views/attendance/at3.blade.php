<?php
$dbh = new PDO('mysql:host=localhost;dbname=dms;charset=utf8', 'root', '');

if (!empty($_POST['limit'])) {
    $limit = $_POST['limit'];
} else {
    $limit = 25;
}

if (!empty($_POST['startDate']) && !empty($_POST['endDate'])) {
    $src1 = " AND attendance.WorkingDay BETWEEN '" . $_POST['startDate'] . "' AND '" . $_POST['endDate'] . "'";
} else {
    $src1 = null;
}

if (!empty($_POST['userlist'])) {
    $src2 = " AND users.id = " . $_POST['userlist'];
} else {
    $src2 = null;
}

$at_sql = "SELECT attendance.*,users.name FROM attendance LEFT JOIN users ON attendance.UserID=users.id WHERE 1" . $src1 . $src2 . " ORDER BY WorkingDay DESC,UserID ASC LIMIT " . $limit;
$at_st = $dbh->query($at_sql);
$ul_sql = "SELECT * FROM users WHERE used = 1 ORDER BY id ASC";
$ul_st = $dbh->query($ul_sql);

?>

<form action="" method="post" name="f_list" id="f_list">
    @csrf

    <div class="search_box" style="padding-bottom:1em;">
        <table class="table table-sm table-borderless" style="width: 70%;margin:0!important;">
            <tr>
                <td>出勤日</td>
                <td style="display: flex;align-items:center">
                    <input type="text" name="startDate" class="form-control rounded-0 datepicker" value="<?= $_POST['startDate'] ?? null ?>">
                    <span style="padding:0 1em;">～</span>
                    <input type="text" name="endDate" class="form-control rounded-0 datepicker" value="<?= $_POST['endDate'] ?? null ?>">
                </td>
            </tr>
            <tr>
                <td>従業員名</td>
                <td>
                    <select name="userlist" id="userlist" class="form-control rounded-0">
                        <?php if (!empty($_POST['userlist'])) :
                            $ul2_sql = "SELECT * FROM users WHERE id = " . $_POST['userlist'];
                            $ul2_st = $dbh->query($ul2_sql);
                            $slduser = $ul2_st->fetch(); ?>
                            <option value="<?= $slduser['id'] ?>" hidden selected><?= $slduser['name'] ?></option>
                        <?php else : ?>
                            <option value="" hidden selected></option>
                        <?php endif ?>
                        <?php while ($userlist = $ul_st->fetch(PDO::FETCH_BOTH)) : ?>
                            <option value="<?= $userlist['id'] ?>"><?= $userlist['name'] ?></option>
                        <?php endwhile ?>
                        <option value=""></option>
                    </select>
                </td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <input type="submit" class="btn btn-sm btn-secondary rounded-0 col-1" value="検索" onclick="search_click();">
                </td>
            </tr>
        </table>
    </div>

    <div style="width:100%;">
        <div class="form-group row m-0 my-1">
            <label for="limit" class="col-11 col-form-label text-right font-weight-normal">表示件数</label>
            <select name="limit" id="limit" class="form-control rounded-0 col-1" onchange="search_click();document.f_list.submit();">
                <option value="<?= $limit ?>" selected hidden><?= $limit ?></option>
                <option value="25">25</option>
                <option value="50">50</option>
                <option value="100">100</option>
                <option value="200">200</option>
            </select>
        </div>
    </div>

    <input type="text" value="<?= $at_sql ?>" name="atlist" hidden>
    <input type="text" id="sbmtype" name="sbmtype" value="<?= $sbmtype ?>" hidden>
</form>

<div class="table-wrap">
    <table class="table table-bordered table-sm table-hover" id="table">
        <thead style="position: sticky;top:calc(-1em - 1px);">
            <tr class="table-success">
                <td class="col-sm-1">勤務日</td>
                <td class="col-sm-2">氏名</td>
                <td class="col-sm-1">出勤時間</td>
                <td class="col-sm-1">時間内退勤</td>
                <td class="col-sm-1">時間内出勤</td>
                <td class="col-sm-1">退勤時間</td>
                <td class="col-sm-5">備考</td>
            </tr>
        </thead>
        <tbody>
            <?php while ($atd = $at_st->fetch(PDO::FETCH_BOTH)) : ?>
                <tr>
                    <td class="text-center"><?= $atd['WorkingDay'] ?></td>
                    <td><?= $atd['name'] ?></td>
                    <td class="text-center"><?= $atd['AttendanceTime'] ?></td>
                    <td class="text-center"><?= $atd['OutingTime'] ?></td>
                    <td class="text-center"><?= $atd['ReentryTime'] ?></td>
                    <td class="text-center"><?= $atd['LeavingTime'] ?></td>
                    <td><?= $atd['Remark'] ?></td>
                </tr>
            <?php endwhile ?>
        </tbody>
    </table>
</div>