<?php
$sqlcnt = "SELECT COUNT(*)as cnt FROM estimate_history";
$stsqlcnt = $dbh->query($sqlcnt);
$estcnt = $stsqlcnt->fetch();


if (!empty($_GET['limit'])) {
    $limit = $_GET['limit'];
} else {
    $limit = 25;
}

if (!empty($_GET['dateoder'])) {
    $od = $_GET['dateoder'];
} else {
    $od = " ORDER BY CreatedDate DESC";
}

if (!empty($_GET['keyword'])) {
    $srch0 = "keyword LIKE '%" . $_GET['keyword'] . "%'";
} else {
    $srch0 = null;
}

if (!empty($_GET['startDate']) && !empty($_GET['endDate'])) {
    $srch1 = "CreatedDate Between '" . $_GET['startDate'] . "' AND '" . $_GET['endDate'] . "'";
} elseif (!empty($_GET['startDate']) && empty($_GET['endDate'])) {
    $srch1 = "CreatedDate >= '" . $_GET['startDate'] . "'";
} elseif (empty($_GET['startDate']) && !empty($_GET['endDate'])) {
    $srch1 = "CreatedDate <= '" . $_GET['endDate'] . "'";
} else {
    $srch1 = null;
}

if (!empty($_GET['dclass'])) {
    $srch2 = "classicationId = " . $_GET['dclass'];
} else {
    $srch2 = null;
}

if (!empty($_GET['creater'])) {
    $srch3 = "userID = '" . $_GET['creater'] . "'";
} else {
    $srch3 = null;
}

if (!empty($srch0) && !empty($srch1) && !empty($srch2) && !empty($srch3)) { //0+1+2+3
    $srch = $srch0 . " and " . $srch1 . " and " . $srch2 . " and " . $srch3 . $od . " LIMIT " . $limit;
} elseif (!empty($srch0) && empty($srch1) && !empty($srch2) && !empty($srch3)) { //0+2+3
    $srch = $srch0 . " and " . $srch2 . " and " . $srch3 . $od . " LIMIT " . $limit;
} elseif (!empty($srch0) && !empty($srch1) && empty($srch2) && !empty($srch3)) { //0+1+3
    $srch = $srch0 . " and " . $srch1 . " and " . $srch3 . $od . " LIMIT " . $limit;
} elseif (!empty($srch0) && !empty($srch1) && !empty($srch2) && empty($srch3)) { //0+1+2
    $srch = $srch0 . " and " . $srch1 . " and " . $srch2 . $od . " LIMIT " . $limit;
} elseif (empty($srch0) && !empty($srch1) && !empty($srch2) && !empty($srch3)) { //1+2+3
    $srch = $srch1 . " and " . $srch2 . " and " . $srch3 . $od . " LIMIT " . $limit;
} elseif (!empty($srch0) && !empty($srch1) && empty($srch2) && empty($srch3)) { //0+1
    $srch = $srch0 . " and " . $srch1 . $od . " LIMIT " . $limit;
} elseif (!empty($srch0) && empty($srch1) && !empty($srch2) && empty($srch3)) { //0+2
    $srch = $srch0 . " and " . $srch2 . $od . " LIMIT " . $limit;
} elseif (!empty($srch0) && empty($srch1) && empty($srch2) && !empty($srch3)) { //0+3
    $srch = $srch0 . " and " . $srch3 . $od . " LIMIT " . $limit;
} elseif (empty($srch0) && !empty($srch1) && !empty($srch2) && empty($srch3)) { //1+2
    $srch = $srch1 . " and " . $srch2 . $od . " LIMIT " . $limit;
} elseif (empty($srch0) && !empty($srch1) && empty($srch2) && !empty($srch3)) { //1+3
    $srch = $srch1 . " and " . $srch3 . $od . " LIMIT " . $limit;
} elseif (empty($srch0) && empty($srch1) && !empty($srch2) && !empty($srch3)) { //2+3
    $srch = $srch2 . " and " . $srch3 . $od . " LIMIT " . $limit;
} elseif (!empty($srch0) && empty($srch1) && empty($srch2) && empty($srch3)) { //0
    $srch = $srch0 . $od . " LIMIT " . $limit;
} elseif (empty($srch0) && !empty($srch1) && empty($srch2) && empty($srch3)) { //1
    $srch = $srch1 . $od . " LIMIT " . $limit;
} elseif (empty($srch0) && empty($srch1) && !empty($srch2) && empty($srch3)) { //2
    $srch = $srch2 . $od . " LIMIT " . $limit;
} elseif (empty($srch0) && empty($srch1) && empty($srch2) && !empty($srch3)) { //3
    $srch = $srch3 . $od . " LIMIT " . $limit;
} else {
    $srch = "1" . $od . " LIMIT " . $limit;
}

?>
<div class="search_box">
    <div class="input-group">
        <input class="form-control rounded-0" type="text" name="keyword" value="<?= $_GET['keyword'] ?? null ?>" placeholder="キーワード">
        <input class="btn btn-sm btn-secondary rounded-0 col-1" type="submit" value="検索">
    </div>
</div>
<details class="accordion">
    <summary>詳細検索</summary>
    <div>
        <table class="table table-sm table-hover table-borderless" style="width: 70%;margin:0!important;">
            <tr>
                <td>作成期間</td>
                <td style="display: flex;align-items:center">
                    <input type="text" name="startDate" class="form-control rounded-0 iptdt" value="<?= $_GET['startDate'] ?? null ?>">
                    <span style="padding:0 1em;">～</span>
                    <input type="text" name="endDate" class="form-control rounded-0 iptdt" value="<?= $_GET['endDate'] ?? null ?>">
                </td>
            </tr>
            <tr>
                <td>分類</td>
                <td>
                    <select class="form-control rounded-0 iptbx" name="dclass">
                        <?php
                        if (!empty($_GET['dclass'])) {
                            $typeid = $_GET['dclass'];
                            $typesql = "SELECT * FROM classication WHERE Id = {$typeid}";
                            $sttype = $dbh->query($typesql);
                            $typelist = $sttype->fetch();

                            echo "<option value='" . $_GET['dclass'] . "' hidden selected>" . $typelist['Name'] . "</option>";
                        } else {
                            echo "<option value='' disabled selected>-- 選択してください --</option>";
                        }

                        $drafttype = "SELECT * FROM classication ORDER by Id asc";
                        $stdrafttype = $dbh->query($drafttype);
                        while ($dtype = $stdrafttype->fetch(PDO::FETCH_BOTH)) {
                            echo '<option value="' . $dtype['Id'] . '">' . $dtype['Name'] . '</option>';
                        };
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>作成者</td>
                <td>
                    <select class="form-control rounded-0" name="creater">
                        <?php
                        if (!empty($_GET['creater'])) {
                            $userid = $_GET['creater'];
                            $usersql = "SELECT * FROM users WHERE id = {$userid}";
                            $stuser = $dbh->query($usersql);
                            $username = $stuser->fetch();
                            echo "<option value='" . $username['id'] . "' hidden selected>" . $username['name'] . "</option>";
                        } else {
                            echo "<option value='' disabled selected>-- 選択してください --</option>";
                        }

                        $getuser = "SELECT * FROM users WHERE used = 1 ORDER BY id";
                        $stuserlist = $dbh->query($getuser);
                        while ($userlist = $stuserlist->fetch(PDO::FETCH_BOTH)) {
                            echo '<option value="' . $userlist['id'] . '">' . $userlist['name'] . '</option>';
                        };
                        ?>
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
            <option value="<?= $estcnt['cnt'] ?>">全件</option>
        </select>
    </div>
</div>


<div class="table-wrap">
    <table class="table table-bordered table-sm table-hover">
        <thead style="position: sticky;top:calc(-1em - 1px);">
            <tr class="table-success">
                <td></td>
                <td>
                    <div class="table-th">
                        作成日
                        <div>
                            <a class="asc" onclick="dateasc()"></a>
                            <a class="desc" onclick="datedesc()"></a>
                            <input type="hidden" id="dateoder" name="dateoder" value="<?= $od ?>">
                        </div>
                    </div>
                </td>
                <td>見積番号</td>
                <td>作成者</td>
                <td>顧客名</td>
                <td>事業名</td>
                <td>場所</td>
                <td>見積金額</td>
            </tr>
        </thead>
        <tbody>
            <?php
            $sum_price = 0;
            $sql = "SELECT * FROM eshistory WHERE $srch";
            $stmt = $dbh->query($sql);
            $sum_price = 0;
            while ($result = $stmt->fetch(PDO::FETCH_BOTH)) {
                echo "<tr>";
                echo "<td style='text-align:center;'>";
                if (substr($result['EstimateNumber'], 0, 2) == 13) {
                    echo "<a class='btns btn btn-secondary rounded-0' style='background-image:url(https://icongr.am/feather/printer.svg?&color=ffffff);' target='_blank' href='/estimate2/redisplay?EstimateNumber=" . $result['EstimateNumber'] . "'></a>";
                    echo "<span class='btns btn btn-secondary rounded-0' type='button' style='background:none;border:none;'></span>";
                    echo "<a class='btns btn btn-secondary rounded-0' href='/sending?&number=" . $result['EstimateNumber'] . "'>送</a>";
                    echo "<input class='btns btn btn-secondary rounded-0' style='margin-right:0!important;background-image:url(https://icongr.am/fontawesome/trash-o.svg?color=ffffff);' type='button' onclick='bizdelete();'></td>";
                } else {
                    echo "<a class='btns btn btn-secondary rounded-0' style='background-image:url(https://icongr.am/feather/printer.svg?&color=ffffff);' target='_blank' href='/estimate/redisplay?price=" . $result['price'] . "&EstimateNumber=" . $result['EstimateNumber'] . "'></a>";
                    echo "<a class='btns btn btn-secondary rounded-0' href='/estimate/e2b?&EstimateNumber=" . $result['EstimateNumber'] . "'>請</a>";
                    echo "<a class='btns btn btn-secondary rounded-0' href='/sending?&number=" . $result['EstimateNumber'] . "'>送</a>";
                    echo "<input class='btns btn btn-secondary rounded-0' style='margin-right:0!important;background-image:url(https://icongr.am/fontawesome/trash-o.svg?color=ffffff);' type='button' onclick='bizdelete();'></td>";
                }
                echo "<td class='selE'>" . $result['CreatedDate'] . "</td>";
                echo "<td id='EstiNum' class='selE'>" . $result['EstimateNumber'] . "</td>";
                echo "<td class='selE'>" . $result['UserName'] . "</td>";
                echo "<td class='selE'>" . $result['Customer'] . "</td>";
                echo "<td class='selE'>" . $result['EstimateName'] . "</td>";
                echo "<td class='selE'>" . $result['Location'] . "</td>";
                echo "<td id='EstiPrice' class='selE' style='text-align:right;'>" . number_format($result['price']) . "</td>";
                $sum_price = $sum_price + $result['price'];
                echo "</tr>";
            }
            ?>
    </table>
</div>