@extends('adminlte::page')

@section('title', '中濃森林組合　-職員勤怠-')

@section('content_header')
<link rel="stylesheet" href="/css/cnu_table.css">
<style>
    .lists tbody tr td {
        text-align: center;
    }

    .srcwrap label,
    .srcwrap input {
        height: 2em;
        line-height: 2em;
    }
</style>
<script>
    window.onload = function() {
        document.getElementById("l99").checked = true;
        document.getElementById("l99-2").checked = true;
    }
</script>

@stop

@section('content')

<form action="" method="get">
    <caption>履歴検索</caption>
    <ul class="srcwrap" style="display:inherit;margin-bottom:0.5em;">
        <li style="width: 100%;display:flex;margin-bottom:0.5em;">
            <label style="color: white;width:6em">勤務日</label>
            <input type="text" name="startDate" id="startDate" style="width: 6em;background-color:white;" class="iptdt" value="<?php if (!empty($_GET['startDate'])) {
                                                                                                                                    echo $_GET['startDate'];
                                                                                                                                } ?>">
            <label for="endDate" style="padding:0 0.5em;width:initial;color:white;">～</label>
            <input type="text" name="endDate" id="endDate" style="width: 6em;background-color:white;" class="iptdt" value="<?php if (!empty($_GET['endDate'])) {
                                                                                                                                echo $_GET['endDate'];
                                                                                                                            } ?>">
        </li>
        <li style="width: 100%;display:flex">
            <label style="color: white;width:6em" for="creater">ユーザー</label>
            <?php
            $dbh = new PDO('mysql:host=localhost;dbname=dms;charset=utf8', 'root', '');
            $sqlusr = "SELECT * FROM users WHERE id <> 1";
            $usrlst = $dbh->query($sqlusr);
            ?>
            <select name="creater" style="width:14em;outline:none;border:none;">
                <?php

                if (!empty($_GET['creater'])) {
                    $ssql = "SELECT * FROM users WHERE id = " . $_GET['creater'];
                    $sstmt = $dbh->query($ssql);
                    $sresult = $sstmt->fetch();
                    echo "<option value='" . $_GET['creater'] . "'>" . $sresult['name'] . "</option>";
                } else {
                    echo "<option value='' disabled selected>-- 選択してください --</option>";
                }
                while ($usr = $usrlst->fetch(PDO::FETCH_BOTH)) {
                    echo "<option value='" . $usr['id'] . "'>" . $usr['name'] . "</option>";
                };
                ?>
            </select>
        </li>
    </ul>
    <input class="btn btn-secondary rounded-0" type="submit" value="検索">
    <input class="btn btn-secondary rounded-0" type="submit" value="印刷" formaction="working_list" formmethod="get" formtarget="_blank">
    <hr>

    <caption>履歴一覧</caption>
</form>



<div class="hstwrap">

    <table class='lists'>
        <thead>
            <tr>
                <th>ID</th>
                <th>UserID</th>
                <th>名前</th>
                <th>出勤日</th>
                <th>出勤時間</th>
                <th>時間内退勤</th>
                <th>時間内出勤</th>
                <th>退勤時間</th>
                <th>勤務時間</th>
            </tr>
        </thead>
        <tbody>
            <?php
            //DB接続
            $dbh = new PDO('mysql:host=localhost;dbname=dms;charset=utf8', 'root', '');

            if (!empty($_GET['startDate']) && !empty($_GET['endDate']) && !empty($_GET['creater'])) {
                $srch = "where UserID = '" . $_GET['creater'] . "' AND WorkingDay Between '" . $_GET['startDate'] . "' and '" . $_GET['endDate'] . "'";
            } elseif (!empty($_GET['startDate']) && !empty($_GET['endDate'])) {
                $srch = "where WorkingDay Between '" . $_GET['startDate'] . "' and '" . $_GET['endDate'] . "'";
            } elseif (!empty($_GET['creater'])) {
                $srch = "where UserID = '" . $_GET['creater'] . "'";
            } else {
                $srch = "";
            }

            $sql = "SELECT working_time.*,users.name FROM working_time left JOIN dms.users ON working_time.UserID=users.id {$srch}";
            $stmt = $dbh->query($sql);

            //複数行表示の場合
            while ($result = $stmt->fetch(PDO::FETCH_BOTH)) {
                echo "<tr>
                <td style='position:inherit;background:none'>" . $result['ID'] . "</td>
                <td>" . $result['UserID'] . "</td>
                <td style='text-align:left;'>" . $result['name'] . "</td>
                <td>" . $result['WorkingDay'] . "</td>
                <td>" . $result['AttendanceTime'] . "</td>
                <td>" . $result['OutingTime'] . "</td>
                <td>" . $result['ReentryTime'] . "</td>
                <td>" . $result['LeavingTime'] . "</td>
                <td>" . date('H:i', strtotime($result['WorkingHours'])) . "</td>
            </tr>";
            };
            ?>
        </tbody>
    </table>
</div>

@stop

@section('js')
<?php
$dbh = 0;
?>
@stop