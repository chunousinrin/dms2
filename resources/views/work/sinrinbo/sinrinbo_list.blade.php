<?php
if (empty($_POST['nendo'])) {
    $nendo = '令和5年森林簿';
} else {
    $nendo = $_POST['nendo'] . '森林簿';
}

if (!empty($_POST['limit'])) {
    $limit = $_POST['limit'];
} else {
    $limit = "100";
}
?>
<style>
    .table th,
    .table td {
        white-space: nowrap;
        font-weight: normal !important;
        border-right: 1px solid silver !important;
        padding-left: 1em;
        padding-right: 1em;
    }
</style>
<form action="" method="post" name="f_list" id="f_list">
    @csrf
    <div class="table-success border border-success" style="padding:1em;padding-right:15%">
        <div class="mb-3">森林情報検索</div>
        <div class="form-group row">
            <label for="nendo" class="col-sm-1 col-form-label font-weight-normal">年度</label>
            <div class="col-sm-11">
                <select name="nendo" id="nendo" class="form-control rounded-0" required onchange="submit()">
                    <?php if (!empty($_POST['nendo'])) : ?>
                        <option selected hidden value="<?= $_POST['nendo'] ?>"><?= $_POST['nendo'] ?></option>
                    <?php endif; ?>
                    <option value="令和5年">令和5年</option>
                    <option value="令和4年">令和4年</option>
                    <option value="令和3年">令和3年</option>
                </select>

            </div>
        </div>

        <div class="form-group row">
            <label for="shichoson" class="col-sm-1 col-form-label font-weight-normal">市町村</label>
            <div class="col-sm-3">
                <select name="shichoson" id="shichoson" class="form-control rounded-0">
                    <option value=""></option>

                    <?php if (!empty($_POST['shichoson'])) : ?>
                        <?php $shichoson_sql = "SELECT * FROM old_code WHERE 1 AND Code = " . $_POST['shichoson'];
                        $shichoson_st = $dbh->query($shichoson_sql);
                        $shichoson = $shichoson_st->fetch();
                        $src1 = " AND 市町村 = " . $_POST['shichoson'] ?>
                        <option selected hidden value="<?= $shichoson['Code'] ?>"><?= $shichoson['Cities'] ?></option>
                    <?php else :
                        $src1 = null; ?>
                        <option selected hidden value="">-- 選択してください --</option>
                    <?php endif ?>

                    <?php $shichoson_sql = "SELECT * FROM old_code WHERE 1"; ?>
                    <?php $shichoson_st = $dbh->query($shichoson_sql);
                    while ($shichoson = $shichoson_st->fetch(PDO::FETCH_BOTH)) : ?>
                        <option value="<?= $shichoson['Code'] ?>"><?= $shichoson['Cities'] ?></option>
                    <?php endwhile ?>
                </select>
            </div>

            <label for="oaza" class="col-sm-1 col-form-label font-weight-normal">大字</label>
            <div class="col-sm-3">
                <select name="oaza" id="oaza" class="form-control rounded-0">
                    <option value=""></option>
                    <?php if (!empty($_POST['oaza'])) :
                        $src2 = " AND 大字 = '" . $_POST['oaza'] . "'"; ?>
                        <option selected hidden value="<?= $_POST['oaza'] ?>"><?= $_POST['oaza'] ?></option>
                    <?php else :
                        $src2 = null; ?>
                        <option selected hidden value="">-- 選択してください --</option>
                    <?php endif;
                    $oaza_sql = "SELECT `大字` FROM {$nendo} WHERE 1 {$src1} GROUP BY `大字`";
                    $oaza_st = $dbh->query($oaza_sql);
                    while ($oaza = $oaza_st->fetch(PDO::FETCH_BOTH)) : ?>
                        <option value="<?= $oaza['大字'] ?>"><?= $oaza['大字'] ?></option>
                    <?php endwhile ?>
                </select>
            </div>

            <label for="aza" class="col-sm-1 col-form-label font-weight-normal">字</label>
            <div class="col-sm-3">
                <select name="aza" id="aza" class="form-control rounded-0">
                    <?php if (!empty($_POST['aza'])) :
                        $src3 = " AND `字` = '" . $_POST['aza'] . "'"; ?>
                        <option selected hidden value="<?= $_POST['aza'] ?>"><?= $_POST['aza'] ?></option>
                    <?php else :
                        $src3 = null; ?>
                        <option selected hidden value="">-- 選択してください --</option>
                    <?php endif;
                    $aza_sql = "SELECT `字` FROM {$nendo} WHERE 1 {$src2} GROUP BY `字`";
                    $aza_st = $dbh->query($aza_sql);
                    while ($aza = $aza_st->fetch(PDO::FETCH_BOTH)) : ?>
                        <option value="<?= $aza['字'] ?>"><?= $aza['字'] ?></option>
                    <?php endwhile ?>
                    <option value=""></option>
                </select>
            </div>
        </div>

        <div class="form-group row">
            <label for="shoyusha" class="col-sm-1 col-form-label font-weight-normal">所有者</label>
            <div class="col-sm-11">
                <input type="text" name="shoyusha" id="shoyusha" class="form-control rounded-0" value="<?= $_POST['shoyusha'] ?? null ?>" placeholder="所有者">
                <?php if (!empty($_POST['shoyusha'])) :
                    $src4 = " AND 現に所有者番号 LIKE '%" . $_POST['shoyusha'] . "%'"; ?>
                <?php else :
                    $src4 = null;
                endif ?>
            </div>
        </div>

        <div class="form-group row mb-0">
            <label for="shoyusha" class="col-sm-1 col-form-label font-weight-normal">林小班</label>
            <div class="input-group col-sm-11">
                <input type="text" name="rinpan1" id="rinpan1" class="form-control rounded-0 mr-1" placeholder="林班" value="<?= $_POST['rinpan1'] ?? null ?>">
                <select name="junrinpan1" id="junrinpan1" class="form-control rounded-0 mr-1">
                    <option selected hidden value="">林小班</option>
                    <?php
                    if (!empty($_POST['junrinpan1'])) :
                        $junrinpan1_sql = "SELECT * FROM `junrinpan` WHERE 1 AND 準林班ID = '" . $_POST['junrinpan1'] . "' ORDER BY `準林班ID` ASC";
                        $junrinpan1_st = $dbh->query($junrinpan1_sql);
                        $junrinpan1 = $junrinpan1_st->fetch(); ?>
                        <option selected hidden value="<?= $junrinpan1['準林班ID'] ?>"><?= $junrinpan1['準林班'] ?></option>
                    <?php endif;
                    $junrinpan1_sql = "SELECT * FROM `junrinpan` WHERE 1 ORDER BY `準林班ID` ASC";
                    $junrinpan1_st = $dbh->query($junrinpan1_sql);
                    while ($junrinpan1 = $junrinpan1_st->fetch(PDO::FETCH_BOTH)) : ?>
                        <option value="<?= $junrinpan1['準林班ID'] ?>"><?= $junrinpan1['準林班'] ?></option>
                    <?php endwhile ?>
                </select>
                <input type="text" name="shohan1" id="shohan1" class="form-control rounded-0 mr-1" placeholder="小班" value="<?= $_POST['shohan1'] ?? null ?>">
                <input type="text" name="edaban1" id="edaban1" class="form-control rounded-0" placeholder="枝番" value="<?= $_POST['edaban1'] ?? null ?>">

                <label for="shoyusha" class="col-form-label font-weight-normal px-3">～</label>

                <input type="text" name="rinpan2" id="rinpan2" class="form-control rounded-0 mr-1" placeholder="林班" value="<?= $_POST['rinpan2'] ?? null ?>">
                <select name="junrinpan2" id="junrinpan2" class="form-control rounded-0 mr-1">
                    <option selected hidden value="">林小班</option>
                    <?php
                    if (!empty($_POST['junrinpan2'])) :
                        $junrinpan2_sql = "SELECT * FROM `junrinpan` WHERE 1 AND 準林班ID = '" . $_POST['junrinpan2'] . "' ORDER BY `準林班ID` ASC";
                        $junrinpan2_st = $dbh->query($junrinpan2_sql);
                        $junrinpan2 = $junrinpan2_st->fetch(); ?>
                        <option selected hidden value="<?= $junrinpan2['準林班ID'] ?>"><?= $junrinpan2['準林班'] ?></option>
                    <?php endif;
                    $junrinpan2_sql = "SELECT * FROM `junrinpan` WHERE 1 ORDER BY `準林班ID` ASC";
                    $junrinpan2_st = $dbh->query($junrinpan2_sql);
                    while ($junrinpan2 = $junrinpan2_st->fetch(PDO::FETCH_BOTH)) : ?>
                        <option value="<?= $junrinpan2['準林班ID'] ?>"><?= $junrinpan2['準林班'] ?></option>
                    <?php endwhile ?>
                </select>
                <input type="text" name="shohan2" id="shohan2" class="form-control rounded-0 mr-1" placeholder="小班" value="<?= $_POST['shohan2'] ?? null ?>">
                <input type="text" name="edaban2" id="edaban2" class="form-control rounded-0" placeholder="枝番" value="<?= $_POST['edaban2'] ?? null ?>">
            </div>
        </div>
    </div>
    <?php
    if (!empty($_POST['rinpan1']) && !empty($_POST['rinpan2'])) {
        $src5 = " AND 林班 BETWEEN " . $_POST['rinpan1'] . " AND " . $_POST['rinpan2'];
    } elseif (!empty($_POST['rinpan1']) && empty($_POST['rinpan2'])) {
        $src5 = " AND 林班 >= " . $_POST['rinpan1'];
    } elseif (empty($_POST['rinpan1']) && !empty($_POST['rinpan2'])) {
        $src5 = " AND 林班 <= " . $_POST['rinpan2'];
    } else {
        $src5 = null;
    }

    if (!empty($_POST['junrinpan1']) && !empty($_POST['junrinpan2'])) {
        $src6 = " AND junrinpan.準林班ID BETWEEN " . $_POST['junrinpan1'] . " AND " . $_POST['junrinpan2'];
    } elseif (!empty($_POST['junrinpan1']) && empty($_POST['junrinpan2'])) {
        $src6 = " AND junrinpan.準林班ID >= " . $_POST['junrinpan1'];
    } elseif (empty($_POST['junrinpan1']) && !empty($_POST['junrinpan2'])) {
        $src6 = " AND junrinpan.準林班ID <= " . $_POST['junrinpan2'];
    } else {
        $src6 = null;
    }

    if (!empty($_POST['shohan1']) && !empty($_POST['shohan2'])) {
        $src7 = " AND 小班 BETWEEN " . $_POST['shohan1'] . " AND " . $_POST['shohan2'];
    } elseif (!empty($_POST['shohan1']) && empty($_POST['shohan2'])) {
        $src7 = " AND 小班 >= " . $_POST['shohan1'];
    } elseif (empty($_POST['shohan1']) && !empty($_POST['shohan2'])) {
        $src7 = " AND 小班 <= " . $_POST['shohan2'];
    } else {
        $src7 = null;
    }

    if (!empty($_POST['edaban1']) && !empty($_POST['edaban2'])) {
        $src8 = " AND 枝番 BETWEEN " . $_POST['edaban1'] . " AND " . $_POST['edaban2'];
    } elseif (!empty($_POST['edaban1']) && empty($_POST['edaban2'])) {
        $src8 = " AND 枝番 >= " . $_POST['edaban1'];
    } elseif (empty($_POST['edaban1']) && !empty($_POST['edaban2'])) {
        $src8 = " AND 枝番 <= " . $_POST['edaban2'];
    } else {
        $src8 = null;
    }
    ?>

    <div class="input-group pt-2">
        <input type="submit" class="btn btn-sm btn-secondary rounded-0 col-1" value="検索">
        <input type="button" class="btn btn-sm btn-secondary rounded-0 mx-1 col-1" value="リセット" onclick="rst(); ">
        <button type="submit" class="btn btn-sm btn-secondary rounded-0 col-1" onclick="document.getElementById('types').value='export';" formaction="/sinrinbo/export">CSV出力</button>
        <span class="form-control col-8 bg-transparent border-0"></span>
        <button class="btn btn-sm btn-secondary rounded-0 col-1" onclick="document.getElementById('types').value=''">終了</button>
        <input type="hidden" name="types" id="types" value="list">
    </div>

    <hr>

    <div class="input-group mb-2">
        <label class="col-form-label font-weight-normal col-sm-11 text-right">表示件数</label>
        <select name="limit" class="form-control rounded-0 col-sm-1" onchange="submit()">
            <option value="<?= $limit ?>" selected hidden><?= $limit ?></option>
            <option value="50">50</option>
            <option value="100">100</option>
            <option value="250">250</option>
            <option value="500">500</option>
            <option value="1000">1000</option>
        </select>
    </div>


    <div class="table-responsive border border-success" style="width: 100%;max-height:65vh;">
        <table class="table table-borderless table-sm table-hover table-striped" id="table">
            <thead class="table-success" style="position: sticky;top:-1px;">
                <tr>
                    <th>年度</th>
                    <th>計画区</th>
                    <th>県事務所</th>
                    <th>新市町村</th>
                    <th>市町村</th>
                    <th>林班</th>
                    <th>準林班</th>
                    <th>小班</th>
                    <th>枝番</th>
                    <th>対象外</th>
                    <th>大字</th>
                    <th>字</th>
                    <th>地番</th>
                    <th>合併</th>
                    <th>現に所有者住所</th>
                    <th>現に所有者番号</th>
                    <th>現に所有者共有有無</th>
                    <th>林地所有者住所</th>
                    <th>林地所有者番号</th>
                    <th>林地所有者共有有無</th>
                    <th>林地更新年月日</th>
                    <th>登記所有者住所</th>
                    <th>所有規模</th>
                    <th>在不在</th>
                    <th>立木所有形態</th>
                    <th>林地所有形態</th>
                    <th>分収林</th>
                    <th>面積</th>
                    <th>施業方法</th>
                    <th>第1層区分</th>
                    <th>第1林種</th>
                    <th>第1針広別</th>
                    <th>第1樹種</th>
                    <th>第1歩合</th>
                    <th>第1林齢</th>
                    <th>第1齢級</th>
                    <th>第1面積</th>
                    <th>第1材積表</th>
                    <th>第1材積計算樹種</th>
                    <!--<th>第1ＨＡ材積</th>-->
                    <th>第1蓄積</th>
                    <th>第2層区分</th>
                    <th>第2林種</th>
                    <th>第2針広別</th>
                    <th>第2樹種</th>
                    <th>第2歩合</th>
                    <th>第2林齢</th>
                    <th>第2齢級</th>
                    <th>第2面積</th>
                    <th>第2蓄積</th>
                    <th>第3林種</th>
                    <th>第3針広別</th>
                    <th>第3樹種</th>
                    <th>第3歩合</th>
                    <th>第3林齢</th>
                    <th>第3齢級</th>
                    <th>第3面積</th>
                    <th>第3蓄積</th>
                    <th>制普別</th>
                    <th>保安林1</th>
                    <th>保安林2</th>
                    <th>保安林3</th>
                    <th>伐採方法</th>
                    <th>自然公園法</th>
                    <th>砂防法</th>
                    <th>岐阜県自然環境保全条例</th>
                    <th>急傾斜地法</th>
                    <th>岐阜県立自然公園条例</th>
                    <th>鳥獣害防止森林区域</th>
                    <th>標準伐期齢</th>
                    <th>施業履歴</th>
                    <th>林道距離現在</th>
                    <th>標高</th>
                    <th>傾斜</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sinrinbosql = "SELECT {$nendo}.*,old_code.Cities AS n市町村,new_code.Cities AS o市町村,junrinpan.準林班 AS j林班 FROM {$nendo}";
                $sinrinbosql = $sinrinbosql . " LEFT JOIN old_code ON {$nendo}.市町村 = old_code.Code";
                $sinrinbosql = $sinrinbosql . " LEFT JOIN new_code ON {$nendo}.新市町村 = new_code.Code";
                $sinrinbosql = $sinrinbosql . " LEFT JOIN junrinpan ON {$nendo}.準林班 = junrinpan.準林班ID";
                $sinrinbosql = $sinrinbosql . " WHERE 1 " . $src1 . $src2 . $src3 . $src4 . $src5 . $src6 . $src7 . $src8 . " ORDER BY `SID` ASC ";
                $sinrinboviewsql = $sinrinbosql . " LIMIT " . $limit;
                $stsinrinbo = $dbh->query($sinrinboviewsql);

                while ($sinrinbo = $stsinrinbo->fetch(PDO::FETCH_BOTH)) : ?>
                    <tr>
                        <td><?= $sinrinbo['年度'] ?></td>
                        <td><?= $sinrinbo['計画区'] ?></td>
                        <td><?= $sinrinbo['県事務所'] ?></td>
                        <td><?= $sinrinbo['n市町村'] ?></td>
                        <td><?= $sinrinbo['o市町村'] ?></td>
                        <td><?= $sinrinbo['林班'] ?></td>
                        <td><?= $sinrinbo['j林班'] ?></td>
                        <td><?= $sinrinbo['小班'] ?></td>
                        <td><?= $sinrinbo['枝番'] ?></td>
                        <td><?= $sinrinbo['対象外'] ?></td>
                        <td><?= $sinrinbo['大字'] ?></td>
                        <td><?= $sinrinbo['字'] ?></td>
                        <td><?= $sinrinbo['地番'] ?></td>
                        <td><?= $sinrinbo['合併'] ?></td>
                        <td><?= $sinrinbo['現に所有者住所'] ?></td>
                        <td><?= $sinrinbo['現に所有者番号'] ?></td>
                        <td><?= $sinrinbo['現に所有者共有有無'] ?></td>
                        <td><?= $sinrinbo['林地所有者住所'] ?></td>
                        <td><?= $sinrinbo['林地所有者番号'] ?></td>
                        <td><?= $sinrinbo['林地所有者共有有無'] ?></td>
                        <td><?= $sinrinbo['林地更新年月日'] ?></td>
                        <td><?= $sinrinbo['登記所有者住所'] ?></td>
                        <td><?= $sinrinbo['所有規模'] ?></td>
                        <td><?= $sinrinbo['在不在'] ?></td>
                        <td><?= $sinrinbo['立木所有形態'] ?></td>
                        <td><?= $sinrinbo['林地所有形態'] ?></td>
                        <td><?= $sinrinbo['分収林'] ?></td>
                        <td><?= $sinrinbo['面積'] ?></td>
                        <td><?= $sinrinbo['施業方法'] ?></td>
                        <td><?= $sinrinbo['第1層区分'] ?></td>
                        <td><?= $sinrinbo['第1林種'] ?></td>
                        <td><?= $sinrinbo['第1針広別'] ?></td>
                        <td><?= $sinrinbo['第1樹種'] ?></td>
                        <td><?= $sinrinbo['第1歩合'] ?></td>
                        <td><?= $sinrinbo['第1林齢'] ?></td>
                        <td><?= $sinrinbo['第1齢級'] ?></td>
                        <td><?= $sinrinbo['第1面積'] ?></td>
                        <td><?= $sinrinbo['第1材積表'] ?></td>
                        <td><?= $sinrinbo['第1材積計算樹種'] ?></td>
                        <!--<td><$sinrinbo['第1ＨＡ材積'] ?></td>-->
                        <td><?= $sinrinbo['第1蓄積'] ?></td>
                        <td><?= $sinrinbo['第2層区分'] ?></td>
                        <td><?= $sinrinbo['第2林種'] ?></td>
                        <td><?= $sinrinbo['第2針広別'] ?></td>
                        <td><?= $sinrinbo['第2樹種'] ?></td>
                        <td><?= $sinrinbo['第2歩合'] ?></td>
                        <td><?= $sinrinbo['第2林齢'] ?></td>
                        <td><?= $sinrinbo['第2齢級'] ?></td>
                        <td><?= $sinrinbo['第2面積'] ?></td>
                        <td><?= $sinrinbo['第2蓄積'] ?></td>
                        <td><?= $sinrinbo['第3林種'] ?></td>
                        <td><?= $sinrinbo['第3針広別'] ?></td>
                        <td><?= $sinrinbo['第3樹種'] ?></td>
                        <td><?= $sinrinbo['第3歩合'] ?></td>
                        <td><?= $sinrinbo['第3林齢'] ?></td>
                        <td><?= $sinrinbo['第3齢級'] ?></td>
                        <td><?= $sinrinbo['第3面積'] ?></td>
                        <td><?= $sinrinbo['第3蓄積'] ?></td>
                        <td><?= $sinrinbo['制普別'] ?></td>
                        <td><?= $sinrinbo['保安林1'] ?></td>
                        <td><?= $sinrinbo['保安林2'] ?></td>
                        <td><?= $sinrinbo['保安林3'] ?></td>
                        <td><?= $sinrinbo['伐採方法'] ?></td>
                        <td><?= $sinrinbo['自然公園法'] ?></td>
                        <td><?= $sinrinbo['砂防法'] ?></td>
                        <td><?= $sinrinbo['岐阜県自然環境保全条例'] ?></td>
                        <td><?= $sinrinbo['急傾斜地法'] ?></td>
                        <td><?= $sinrinbo['岐阜県立自然公園条例'] ?></td>
                        <td><?= $sinrinbo['鳥獣害防止森林区域'] ?></td>
                        <td><?= $sinrinbo['標準伐期齢'] ?></td>
                        <td><?= $sinrinbo['施業履歴'] ?></td>
                        <td><?= $sinrinbo['林道距離現在'] ?></td>
                        <td><?= $sinrinbo['標高'] ?></td>
                        <td><?= $sinrinbo['傾斜'] ?></td>
                    </tr>
                <?php endwhile ?>
            </tbody>
        </table>
    </div>
    <input name="csvsql" type="hidden" value="<?= $sinrinbosql ?? null ?>">
</form>

<script>
    function rst() {
        document.getElementById("shichoson").value = "";
        document.getElementById("oaza").value = "";
        document.getElementById("aza").value = "";
        document.getElementById("shoyusha").value = "";
        document.getElementById("rinpan1").value = "";
        document.getElementById("junrinpan1").value = "";
        document.getElementById("shohan1").value = "";
        document.getElementById("edaban1").value = "";
        document.getElementById("rinpan2").value = "";
        document.getElementById("junrinpan2").value = "";
        document.getElementById("shohan2").value = "";
        document.getElementById("edaban2").value = "";
        document.f_list.submit();
    }
</script>