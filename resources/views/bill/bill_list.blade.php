<?php

if (!empty($_POST['limit'])) {
    $limit = $_POST['limit'];
} else {
    $limit = 25;
}

if (!empty($_POST['dateoder'])) {
    $od = $_POST['dateoder'];
} else {
    $od = " ORDER BY CreatedDate DESC";
}

if (!empty($_POST['keyword'])) {
    $src1 = ' AND keyword LIKE "%' . $_POST['keyword'] . '%"';
} else {
    $src1 = null;
}

if (!empty($_POST['startDate']) && !empty($_POST['endDate'])) {
    $src2 = ' AND CreatedDate Between "' . $_POST['startDate'] . '" AND "' . $_POST['endDate'] . '"';
} elseif (!empty($_POST['startDate']) && empty($_POST['endDate'])) {
    $src2 = ' AND CreatedDate >= "' . $_POST['startDate'] . '"';
} elseif (empty($_POST['startDate']) && !empty($_POST['endDate'])) {
    $src2 = ' AND CreatedDate <= "' . $_POST['endDate'] . '"';
} else {
    $src2 = null;
}

if (!empty($_POST['classicationId'])) {
    $src3 = ' AND classicationId = ' . $_POST['classicationId'];
} else {
    $src3 = null;
}

if (!empty($_POST['creater'])) {
    $src4 = ' AND userID = "' . $_POST['creater'] . '"';
} else {
    $src4 = null;
}

if (!empty($_POST['unpaid'])) {
    $unpaid = $_POST['unpaid'];
} else {
    $unpaid = '0';
}

if (!empty($_POST['startpayment']) && !empty($_POST['endpayment'])) {
    $src5 = ' AND PaymentDate Between "' . $_POST['startpayment'] . '" AND "' . $_POST['endpayment'] . '"';
} elseif (!empty($_POST['startpayment']) && empty($_POST['endpayment'])) {
    $src5 = ' AND PaymentDate >= "' . $_POST['startpayment'] . '"';
} elseif (empty($_POST['startpayment']) && !empty($_POST['endpayment'])) {
    $src5 = ' AND PaymentDate Between "1" AND "' . $_POST['endpayment'] . '"';
} elseif ($unpaid == 'on') {
    $src5 = ' AND PaymentDate = ""';
} else {
    $src5 = null;
}

?>
<form action="" method="post" name="f_list" id="f_list">
    @csrf
    <div class="search_box">
        <div class="input-group">
            <input class="form-control rounded-0" type="text" name="keyword" value="<?= $_POST['keyword'] ?? null ?>" placeholder="キーワード">
            <input type="submit" class="btn btn-sm btn-secondary rounded-0 col-1" value="検索" onclick="search_click();">
        </div>
    </div>
    <details class="accordion">
        <summary>詳細検索</summary>
        <div>
            <table class="table table-sm table-hover table-borderless" style="width: 70%;margin:0!important;">
                <tr>
                    <td>作成日</td>
                    <td style="display: flex;align-items:center">
                        <input type="text" name="startDate" class="form-control rounded-0 datepicker" value="<?= $_POST['startDate'] ?? null ?>">
                        <span style="padding:0 1em;">～</span>
                        <input type="text" name="endDate" class="form-control rounded-0 datepicker" value="<?= $_POST['endDate'] ?? null ?>">
                    </td>
                </tr>
                <tr>
                    <td>分類</td>
                    <td>
                        <select class="form-control rounded-0 iptbx" name="classicationId">
                            <?php
                            if (!empty($_POST['classicationId'])) {
                                $typeid = $_POST['classicationId'];
                                $typesql = "SELECT * FROM classication WHERE Id = {$typeid}";
                                $sttype = $dbh->query($typesql);
                                $typelist = $sttype->fetch();

                                echo "<option value='" . $_POST['classicationId'] . "' hidden selected>" . $typelist['Name'] . "</option>";
                            } else {
                                echo "<option value='' hidden selected>-- 選択してください --</option>";
                            }

                            $drafttype = "SELECT * FROM classication ORDER by Id asc";
                            $stdrafttype = $dbh->query($drafttype);
                            while ($dtype = $stdrafttype->fetch(PDO::FETCH_BOTH)) {
                                echo '<option value="' . $dtype['Id'] . '">' . $dtype['Name'] . '</option>';
                            };
                            echo "<option value=''></option>";
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>作成者</td>
                    <td>
                        <select class="form-control rounded-0" name="creater">
                            <?php
                            if (!empty($_POST['creater'])) {
                                $userid = $_POST['creater'];
                                $usersql = "SELECT * FROM users WHERE id = {$userid}";
                                $stuser = $dbh->query($usersql);
                                $username = $stuser->fetch();
                                echo "<option value='" . $username['id'] . "' hidden selected>" . $username['name'] . "</option>";
                            } else {
                                echo "<option value='' hidden selected>-- 選択してください --</option>";
                            }

                            $getuser = "SELECT * FROM users WHERE used = 1 ORDER BY id";
                            $stuserlist = $dbh->query($getuser);
                            while ($userlist = $stuserlist->fetch(PDO::FETCH_BOTH)) {
                                echo '<option value="' . $userlist['id'] . '">' . $userlist['name'] . '</option>';
                            };
                            ?>
                            <option value=""></option>
                        </select>


                    </td>
                </tr>
                <tr>
                    <td>入金日</td>
                    <td style="display: flex;align-items:center">
                        <input type="text" name="startpayment" class="form-control rounded-0 datepicker" value="<?= $_POST['startpayment'] ?? null ?>">
                        <span style="padding:0 1em;">～</span>
                        <input type="text" name="endpayment" class="form-control rounded-0 datepicker" value="<?= $_POST['endpayment'] ?? null ?>">
                    </td>
                </tr>
                <tr>
                    <td>未入金</td>
                    <td style="vertical-align: middle;">
                        <?php
                        if ($unpaid == '0') {
                            echo "<input name='unpaid' id='unpaid' style='outline:none;' type='checkbox' onclick='ckapay()'>";
                        } else {
                            echo "<input name='unpaid' id='unpaid' style='outline:none;' type='checkbox' onclick='ckapay()' checked>";
                        }
                        ?>
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

    <div class="table-wrap">
        <table class="table table-bordered table-sm table-hover" id="table">
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
                    <td>請求番号</td>
                    <td>作成者</td>
                    <td>顧客名</td>
                    <td>事業名</td>
                    <td>場所</td>
                    <td>請求金額</td>
                    <td>入金日</td>
                </tr>
            </thead>
            <tbody>
                <?php
                $sum_price = 0;
                $sql = "SELECT * FROM bill_history WHERE 1" . $src1 . $src2 . $src3 . $src5 . $od . " LIMIT " . $limit;
                $stmt = $dbh->query($sql);
                $sum_price = 0;
                while ($result = $stmt->fetch(PDO::FETCH_BOTH)) { ?>
                    <tr>
                        <td style='text-align:center;'>
                            <input type="submit" value="" class="btns btn btn-sm btn-secondary rounded-0" style="background-image:url(https://icongr.am/feather/printer.svg?color=ffffff);" onclick="pr()">
                            <input type="submit" value="送" class="btns btn btn-sm btn-secondary rounded-0" onclick="sd()">
                            <input type="submit" value="" class="btns btn btn-sm btn-secondary rounded-0" style="background-image:url(https://icongr.am/fontawesome/trash-o.svg?color=ffffff);" onclick="dl()">
                        </td>
                        <td class='sellist'><?= $result['CreatedDate'] ?></td>
                        <td class='sellist' name="SerialNumber"><?= $result['BillNumber'] ?></td>
                        <td class='sellist'><?= $result['UserName'] ?></td>
                        <td class='sellist'><?= $result['Customer'] ?></td>
                        <td class='sellist'><?= $result['BizName'] ?></td>
                        <td class='sellist'><?= $result['Location'] ?></td>
                        <td class='sellist' style='text-align:right;'><?= number_format($result['price']) ?></td>
                        <?php $sum_price = $sum_price + $result['price']; ?>
                        <td><?= $result['PaymentDate'] ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <input type="hidden" value="<?= $sql ?>" name="billlist">
    <input type="hidden" id="SerialNumber" name="SerialNumber">
    <input type="hidden" id="sbmtype" name="sbmtype" value="<?= $sbmtype ?>">
</form>