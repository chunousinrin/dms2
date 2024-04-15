<?php
$sql = "SELECT * FROM drs_reports WHERE No = " . $_POST['UpdateID'];
$stmt = $dbh->query($sql);
$result = $stmt->fetch();

$user_sql = "SELECT * FROM users WHERE id = " . $result['UserID'];
$user_stmt = $dbh->query($user_sql);
$createuser = $user_stmt->fetch();

$amindustry_sql = "SELECT * FROM drs_industries WHERE ID = " . $result['AmIndustry'];
$amindustry_stmt = $dbh->query($amindustry_sql);
$amindustry = $amindustry_stmt->fetch();

$amweather_sql = "SELECT * FROM drs_weathers WHERE WeatherID = " . $result['Weather1'];
$amweather_stmt = $dbh->query($amweather_sql);
$amweather = $amweather_stmt->fetch();

$pmindustry_sql = "SELECT * FROM drs_industries WHERE ID = " . $result['PmIndustry'];
$pmindustry_stmt = $dbh->query($pmindustry_sql);
$pmindustry = $pmindustry_stmt->fetch();

$pmweather_sql = "SELECT * FROM drs_weathers WHERE WeatherID = " . $result['Weather2'];
$pmweather_stmt = $dbh->query($pmweather_sql);
$pmweather = $pmweather_stmt->fetch();

?>

<form action="" method="post" name="f_input">
    @csrf
    <table class="table table-hover table-borderless ctable">
        <tbody>
            <tr>
                <td class="table-success col-sm-2">勤務日<span class="required_item">必須</span></td>
                <td>
                    <input type="text" id="WorkingDay" name="WorkingDay" class="form-control rounded-0" value="<?= $result['WorkingDay'] ?>" required>
                </td>
            </tr>
            <tr>
                <td class="table-success col-sm-2">ユーザー<span class="required_item">必須</span></td>
                <td>
                    <select name="UserID" id="UserID" class="form-control rounded-0">
                        <option selected hidden value="<?= $result['UserID'] ?>"><?= $createuser['name'] ?></option>
                        <?php
                        $user_sql = "SELECT * FROM users ORDER BY id ASC";
                        $user_stmt = $dbh->query($user_sql);
                        while ($createuser = $user_stmt->fetch(PDO::FETCH_BOTH)) { ?>
                            <option value="<?= $createuser['id'] ?>"><?= $createuser['name'] ?></option>
                        <?php } ?>
                    </select>
                </td>
            </tr>
        </tbody>
    </table>

    <table class="table table-hover table-borderless ctable">
        <tbody>
            <tr>
                <td class="table-success col-sm-2">午前天気<span class="required_item">必須</span></td>
                <td>
                    <select name="AmWeather" id="AmWeather" class="form-control rounded-0">
                        <option value="<?= $amweather['WeatherID'] ?>" selected hidden><?= $amweather['Weather'] ?></option>
                        <?php
                        $amweather_sql = "SELECT * FROM drs_weathers ORDER BY WeatherID ASC";
                        $amweather_stmt = $dbh->query($amweather_sql);
                        while ($amweather = $amweather_stmt->fetch(PDO::FETCH_BOTH)) { ?>
                            <option value="<?= $amweather['WeatherID'] ?>"><?= $amweather['Weather'] ?></option>
                        <?php } ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td class="table-success col-sm-2">午前業種<span class="required_item">必須</span></td>
                <td>
                    <select name="AmIndustry" id="AmIndustry" class="form-control rounded-0" required>
                        <option value="<?= $amindustry['ID'] ?>" selected hidden><?= $amindustry['Industry'] ?></option>
                        <?php
                        $amindustry_sql = "SELECT * FROM drs_industries ORDER BY ID ASC";
                        $amindustry_stmt = $dbh->query($amindustry_sql);
                        while ($amindustry = $amindustry_stmt->fetch(PDO::FETCH_BOTH)) { ?>
                            <option value="<?= $amindustry['ID'] ?>"><?= $amindustry['Industry'] ?></option>
                        <?php } ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td class="table-success col-sm-2">午前摘要<span class="required_item">必須</span></td>
                <td>
                    <input type="text" id="AmRemark" name="AmRemark" class="form-control rounded-0" value="<?= $result['AmRemark'] ?>" required>
                </td>
            </tr>
        </tbody>
    </table>

    <table class="table table-hover table-borderless ctable">
        <tbody>
            <tr>
                <td class="table-success col-sm-2">午後天気<span class="required_item">必須</span></td>
                <td>
                    <select name="PmWeather" id="PmWeather" class="form-control rounded-0">
                        <option value="<?= $pmweather['WeatherID'] ?>" selected hidden><?= $pmweather['Weather'] ?></option>
                        <?php
                        $pmweather_sql = "SELECT * FROM drs_weathers ORDER BY WeatherID ASC";
                        $pmweather_stmt = $dbh->query($pmweather_sql);
                        while ($pmweather = $pmweather_stmt->fetch(PDO::FETCH_BOTH)) { ?>
                            <option value="<?= $pmweather['WeatherID'] ?>"><?= $pmweather['Weather'] ?></option>
                        <?php } ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td class="table-success col-sm-2">午後業種<span class="required_item">必須</span></td>
                <td>
                    <select name="PmIndustry" id="PmIndustry" class="form-control rounded-0" required>
                        <option value="<?= $pmindustry['ID'] ?>" selected hidden><?= $pmindustry['Industry'] ?></option>
                        <?php
                        $pmindustry_sql = "SELECT * FROM drs_industries ORDER BY ID ASC";
                        $pmindustry_stmt = $dbh->query($pmindustry_sql);
                        while ($pmindustry = $pmindustry_stmt->fetch(PDO::FETCH_BOTH)) { ?>
                            <option value="<?= $pmindustry['ID'] ?>"><?= $pmindustry['Industry'] ?></option>
                        <?php } ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td class="table-success col-sm-2">午後摘要<span class="required_item">必須</span></td>
                <td>
                    <input type="text" id="PmRemark" name="PmRemark" class="form-control rounded-0" value="<?= $result['PmRemark'] ?>" required>
                </td>
            </tr>
        </tbody>
    </table>

    <table class="table table-hover table-borderless ctable">
        <tbody>
            <tr>
                <td class="table-success col-sm-2">摘要</td>
                <td>
                    <input type="text" id="Remark" name="Remark" class="form-control rounded-0" value="<?= $result['Remark'] ?>">
                </td>
            </tr>
        </tbody>
    </table>
    <div style="width:100%;text-align:center;" class="pb-5">
        <button class="btn btn-secondary rounded-0 btn-sm px-4" onclick="history.back()">戻る</button>
        <button class="btn btn-secondary rounded-0 btn-sm px-4" onclick="">保存</button>
        <input type="hidden" name="sbmtype" value="4">
    </div>
</form>