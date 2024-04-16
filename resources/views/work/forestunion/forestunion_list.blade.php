<style>
    .table th,
    .table td {
        white-space: nowrap;
        font-weight: normal !important;
    }
</style>
<form action="" method="post" name="f_list" id="f_list">
    @csrf
    <div class="search_box">
        <div class="input-group">
            <input class="form-control rounded-0" type="text" name="keyword" value="<?= $_POST['keyword'] ?? null ?>" placeholder="キーワード">
            <input class="btn btn-sm btn-secondary rounded-0 col-1" type="submit" value="検索" formtarget="_self" formaction="/forestunion">
        </div>
    </div>
    <?php
    if (!empty($_POST['limit'])) {
        $limit = $_POST['limit'];
    } else {
        $limit = 50;
    }

    if (!empty($_POST['keyword'])) {
        $src1 = " AND keyword LIKE '%" . $_POST['keyword'] . "%'";
    } else {
        $src1 = null;
    }
    ?>
    <details class="accordion">
        <summary>詳細検索</summary>
        <div>
            <table class="table table-sm table-hover table-borderless" style="width: 70%;margin:0!important;">
                <tr>
                    <td>加入期間</td>
                    <td style="display: flex;align-items:center" colspan="3">
                        <input type="text" name="startDate" class="form-control rounded-0 datepicker" value="<?= $_POST['startDate'] ?? null ?>">
                        <span style="padding:0 1em;">～</span>
                        <input type="text" name="endDate" class="form-control rounded-0 datepicker" value="<?= $_POST['endDate'] ?? null ?>">
                        <?php
                        if (!empty($_POST['startDate']) && !empty($_POST['endDate'])) {
                            $src2 = " AND 加入年月日 Between '" . $_POST['startDate'] . "' AND '" . $_POST['endDate'] . "'";
                        } elseif (!empty($_POST['startDate']) && empty($_POST['endDate'])) {
                            $src2 = " AND 加入年月日 >= '" . $_POST['startDate'] . "'";
                        } elseif (empty($_POST['startDate']) && !empty($_POST['endDate'])) {
                            $src2 = " AND 加入年月日 <= '" . $_POST['endDate'] . "'";
                        } else {
                            $src2 = null;
                        }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>地区</td>
                    <td>
                        <select name="AreaID" id="AreaID" class="form-control rounded-0 ">
                            <?php
                            if (!empty($_POST['AreaID'])) :
                                $areaid = " AND AreaID = " . $_POST['AreaID'];
                                $src3 = " AND 地区コード = " . $_POST['AreaID'];
                                $areasql = "SELECT * FROM area WHERE AreaID = " . $_POST['AreaID'];
                                $areast = $dbh->query($areasql);
                                $area = $areast->fetch(); ?>
                                <option value="<?= $area['AreaID'] ?>" hidden selected><?= $area['AreaName'] ?></option>
                            <?php else :
                                $areaid = null;
                                $src3 = null; ?>
                                <option value=""></option>
                            <?php endif ?>
                            <?php
                            $areasql = "SELECT * FROM area ORDER BY AreaID ASC";
                            $areast = $dbh->query($areasql);
                            while ($area = $areast->fetch(PDO::FETCH_BOTH)) : ?>
                                <option value="<?= $area['AreaID'] ?>"><?= $area['AreaName'] ?></option>
                            <?php endwhile ?>
                            <option value=""></option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>字</td>
                    <td>
                        <select name="SubAreaID" id="SubAreaID" class="form-control rounded-0 ">
                            <?php
                            if (!empty($_POST['SubAreaID'])) :
                                $src4 = " AND 字コード = " . $_POST['SubAreaID'];
                                $subareasql = "SELECT * FROM sub_area WHERE 1" . $areaid . " AND SubAreaID = " . $_POST['SubAreaID'];
                                $subareast = $dbh->query($subareasql);
                                $subarea = $subareast->fetch(); ?>
                                <option value="<?= $subarea['SubAreaID'] ?>" hidden selected><?= $subarea['SubAreaName'] ?></option>
                            <?php else :
                                $src4 = null; ?>
                                <option value=""></option>
                            <?php endif ?>
                            <?php
                            $subareasql = "SELECT * FROM sub_area WHERE 1" . $areaid;
                            $subareast = $dbh->query($subareasql);
                            while ($subarea = $subareast->fetch(PDO::FETCH_BOTH)) : ?>
                                <option value="<?= $subarea['SubAreaID'] ?>"><?= $subarea['SubAreaName'] ?></option>
                            <?php endwhile ?>
                            <option value=""></option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>組合員区分</td>
                    <td>
                        <select name="MembershipClassification" id="MembershipClassification" class="form-control rounded-0 ">
                            <option value="<?= $_POST['MembershipClassification'] ?? null ?>" hidden selected>
                                <?php
                                $mc = $_POST['MembershipClassification'] ?? null;
                                if (is_null($mc)) {
                                    echo null;
                                    $src5 = null;
                                } elseif ($mc === "0") {
                                    echo "その他";
                                    $src5 = " AND 組合員区分コード = '0'";
                                } elseif ($mc === "1") {
                                    echo "組合員";
                                    $src5 = " AND 組合員区分コード = '1'";
                                } elseif ($mc === "2") {
                                    echo "準組合員";
                                    $src5 = " AND 組合員区分コード = '2'";
                                } else {
                                    echo null;
                                    $src5 = null;
                                }
                                ?>
                            </option>
                            <option value="1">組合員</option>
                            <option value="2">準組合員</option>
                            <option value="0">その他</option>
                        </select>
                    </td>
                </tr>
            </table>
        </div>
    </details>
    <hr>

    <div class="input-group mb-2">
        <?php
        $membersql = "SELECT COUNT(*) as member FROM `union_members` WHERE 脱退年月日 IS null;";
        $memberst = $dbh->query($membersql);
        $member = $memberst->fetch();
        ?>
        <span class="col-form-label col-sm-2">組合員数：<?= number_format($member['member']) ?>名</span>
        <label class="col-form-label font-weight-normal col-sm-9 text-right">表示件数</label>
        <select name="limit" class="form-control rounded-0 col-sm-1" onchange="submit()">
            <option value="<?= $limit ?>" selected hidden><?= $limit ?></option>
            <option value="50">50</option>
            <option value="100">100</option>
            <option value="250">250</option>
            <option value="500">500</option>
            <option value="1000">1000</option>
        </select>
    </div>

    <div class="table-wrap table-responsive">
        <table class="table table-bordered table-sm table-hover table-striped" id="table">
            <thead class="table-success" style="position: sticky;top:calc(-1em - 1px);">
                <tr>
                    <th>組合員番号</th>
                    <th>フリガナ</th>
                    <th>氏名1</th>
                    <th>氏名2</th>
                    <th>郵便番号</th>
                    <th>住所1</th>
                    <th>住所2</th>
                    <th>職業</th>
                    <th>性別</th>
                    <th>生年月日</th>
                    <th>電話番号</th>
                    <th>組合員区分</th>
                    <th>源泉税区分</th>
                    <th>加入年月日</th>
                    <th>地区</th>
                    <th>字</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $forestunionsql = "SELECT * FROM union_members_list WHERE 脱退年月日 IS NULL " . $src1 . $src2 . $src3 . $src4 . $src5 . " LIMIT " . $limit;
                $forestunionst = $dbh->query($forestunionsql);

                while ($forestunion = $forestunionst->fetch(PDO::FETCH_BOTH)) : ?>
                    <tr>
                        <td><?= $forestunion['組合員番号'] ?></th>
                        <td><?= $forestunion['フリガナ'] ?></th>
                        <td><?= $forestunion['氏名1'] ?></th>
                        <td><?= $forestunion['氏名2'] ?></th>
                        <td><?= $forestunion['郵便番号'] ?></th>
                        <td><?= $forestunion['住所1'] ?></th>
                        <td><?= $forestunion['住所2'] ?></th>
                        <td><?= $forestunion['職業'] ?></th>
                        <td><?= $forestunion['性別'] ?></th>
                        <td><?= $forestunion['生年月日'] ?></th>
                        <td><?= $forestunion['電話番号'] ?></th>
                        <td><?= $forestunion['組合員区分'] ?></th>
                        <td><?= $forestunion['源泉税区分'] ?></th>
                        <td><?= $forestunion['加入年月日'] ?></th>
                        <td><?= $forestunion['地区名'] ?></th>
                        <td><?= $forestunion['字名'] ?></th>
                    </tr>
                <?php endwhile; ?>
            </tbody>
            <tfoot>
                <?php
                $cntsql = "SELECT count(*) as cnt FROM union_members_list WHERE 脱退年月日 IS NULL " . $src1 . $src2 . $src3 . $src4 . $src5 . " LIMIT " . $limit;
                $cntst = $dbh->query($cntsql);
                $cnt = $cntst->fetch();
                ?>
                <tr>
                    <td colspan="16"><?= number_format($cnt['cnt'] ?? 0) ?>名</td>
                </tr>
            </tfoot>
        </table>
    </div>
</form>