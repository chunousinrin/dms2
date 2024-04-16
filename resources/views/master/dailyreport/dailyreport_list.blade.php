<?php
if (!empty($_POST['limit'])) {
    $limit = $_POST['limit'];
} else {
    $limit = 25;
}

if (!empty($_POST['startDate']) && !empty($_POST['endDate'])) {
    $src1 = ' AND WorkingDay Between "' . $_POST['startDate'] . '" AND "' . $_POST['endDate'] . '"';
} elseif (!empty($_POST['startDate']) && empty($_POST['endDate'])) {
    $src1 = ' AND WorkindDay >= "' . $_POST['startDate'] . '"';
} elseif (!empty($_POST['startDate']) && empty($_POST['endDate'])) {
    $src1 = ' AND WorkingDay <= "' . $_POST['endDate'] . '"';
} else {
    $src1 = null;
};

if (!empty($_POST['industryid'])) {
    $src2 = ' AND ( AmIndustryID = ' . $_POST['industryid'] . ' OR PmIndustryID = ' . $_POST['industryid'] . ')';
} else {
    $src2 = null;
};

if (!empty($_POST['select_user'])) {
    $src3 = ' AND UserID = ' . $_POST['select_user'];
} else {
    $src3 = null;
}

if (!empty($_POST['keyword'])) {
    $src4 = " AND keyword LIKE '%" . $_POST['keyword'] . "%'";
} else {
    $src4 = null;
}

?>
<form action="" method="post" name="f_list" id="f_list">
    @csrf
    <div class="search_box">
        <div class="input-group">
            <input class="form-control rounded-0" type="text" name="keyword" value="<?= $_POST['keyword'] ?? null ?>" placeholder="キーワード" onchange="document.f_list.submit();">
            <button class="btn btn-sm btn-secondary rounded-0 col-1" onclick="document.f_list.submit();">検索</button>
        </div>
    </div>
    <details class="accordion">
        <summary>詳細検索</summary>
        <div>
            <table class="table table-sm table-hover table-borderless" style="width: 70%;margin:0!important;">
                <tr>
                    <td>勤務日</td>
                    <td style="display: flex;align-items:center">
                        <input type="text" name="startDate" class="form-control rounded-0 datepicker" value="<?= $_POST['startDate'] ?? null ?>">
                        <span style="padding:0 1em;">～</span>
                        <input type="text" name="endDate" class="form-control rounded-0 datepicker" value="<?= $_POST['endDate'] ?? null ?>">
                    </td>
                </tr>
                <tr>
                    <td>業務分類</td>
                    <td>
                        <select class="form-control rounded-0 iptbx" name="industryid">
                            <?php
                            if (!empty($_POST['industryid'])) {
                                $industry_sql = "SELECT * FROM drs_industries WHERE ID = " . $_POST['industryid'];
                                $industry_stmt = $dbh->query($industry_sql);
                                $industry = $industry_stmt->fetch();
                                echo "<option value='" . $industry['ID'] . "' selected hidden>" . $industry['Industry'] . "</option>";
                            } else {
                                echo "<option value='' selected hidden>-- 選択してください --</option>";
                                $industry_sql = "SELECT * FROM drs_industries ORDER BY ID ASC";
                                $industry_stmt = $dbh->query($industry_sql);
                            };
                            $industry_sql = "SELECT * FROM drs_industries ORDER BY ID ASC";
                            $industry_stmt = $dbh->query($industry_sql);
                            while ($industry = $industry_stmt->fetch(PDO::FETCH_BOTH)) { ?>
                                <option value="<?= $industry['ID'] ?>"><?= $industry['Industry'] ?></option>
                            <?php } ?>
                            <option value=""></option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>勤務者</td>
                    <td>
                        <select class="form-control rounded-0" name="select_user">

                            <?php
                            if (!empty($_POST['select_user'])) {
                                $user_sql = "SELECT * FROM users WHERE id = " . $_POST['select_user'];
                                $user_stmt = $dbh->query($user_sql);
                                $user = $user_stmt->fetch();
                                echo "<option value='" . $user['id'] . "' selected hidden>" . $user['name'] . "</option>";
                            } else {
                                echo "<option value='' selected hidden>-- 選択してください --</option>";
                                $user_sql = "SELECT * FROM users ORDER BY id ASC";
                                $user_stmt = $dbh->query($user_sql);
                            }
                            $user_sql = "SELECT * FROM users ORDER BY id ASC";
                            $user_stmt = $dbh->query($user_sql);
                            while ($user = $user_stmt->fetch(PDO::FETCH_BOTH)) { ?>
                                <option value="<?= $user['id'] ?>"><?= $user['name'] ?></option>
                            <?php }; ?>
                            <option value=""></option>
                        </select>
                    </td>
                </tr>
            </table>

        </div>
    </details>

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

    <?php
    $sql = "SELECT * FROM drs_history WHERE 1" . $src1 . $src2 . $src3 . $src4 . " COLLATE utf8_general_ci LIMIT " . $limit;
    $stmt = $dbh->query($sql);
    ?>
    <div class="table-wrap" style="max-height: 100%;">

        <table class="table table-responsive-sm table-sm table-hover table-borderless bg-white ctable" id="table">
            <thead>
                <tr class="table-success">
                    <td></td>
                    <td class="text-left">勤務日</td>
                    <td class="text-left">氏名</td>
                    <td class="text-left">午前業種</td>
                    <td class="text-left">午前摘要</td>
                    <td class="text-left">午後業種</td>
                    <td class="text-left">午後摘要</td>
                    <td class="text-left">天気</td>
                    <td class="text-left">備考</td>
                    <td></td>
                </tr>
            </thead>
            <tbody>
                <?php while ($result = $stmt->fetch(PDO::FETCH_BOTH)) { ?>
                    <tr class="">
                        <td class="table-success text-center" name="CurrentID" id="CurrentID"><?= $result['No'] ?></td>
                        <td class=""><?= $result['WorkingDay'] ?></td>
                        <td class=""><?= $result['UserName'] ?></td>
                        <td class=""><?= $result['AmIndustry'] ?></td>
                        <td class=""><?= $result['AmRemark'] ?></td>
                        <td class=""><?= $result['PmIndustry'] ?></td>
                        <td class=""><?= $result['PmRemark'] ?></td>
                        <?php
                        if (!empty($result['PmWeather'])) {
                            $weather = $result['AmWeather'] . " - " . $result['PmWeather'];
                        } else {
                            $weather = $result['AmWeather'];
                        }
                        ?>
                        <td class=""><?= $weather ?></td>
                        <td><?= $result['Remark'] ?></td>
                        <td class="text-right" style="white-space: nowrap;">
                            <button class="btn btn-sm btn-secondary rounded-0 px-4" onclick="up();">編集</button>
                            <button class="btn btn-sm btn-danger rounded-0 px-4">削除</button>
                        </td>
                        </td>
                    </tr>
                <?php };
                $dbh = 0;
                ?>
            </tbody>
        </table>
    </div>
    <input type="hidden" name="UpdateID" id="UpdateID">
    <input type="hidden" name="sbmtype" id="sbmtype">
</form>

<script>
    function up() {
        $("#table td").bind("click", function() {
            $tag_tr = $(this).parent()[0];
            $rowNum = $tag_tr.rowIndex - 1;
            const udid = document.getElementsByName("CurrentID")[$rowNum].textContent;
            document.getElementById("UpdateID").value = udid;
            document.getElementById("sbmtype").value = "2";
            document.f_list.submit();
        });
    }

    function dlt() {
        if (window.confirm("選択された情報を削除します")) {
            $("#table td").bind("click", function() {
                $tag_tr = $(this).parent()[0];
                $rowNum = $tag_tr.rowIndex - 1;
                const udid = document.getElementsByName("CurrentID")[$rowNum].textContent;
                document.getElementById("BankID").value = udid;
                document.getElementById("sbmtype").value = "5";
                document.f_list.submit();
            });
        } else {
            // 「キャンセル」時の処理
            window.alert("キャンセルされました"); // 警告ダイアログを表示
            return false; // 送信を中止
        }
    }
</script>