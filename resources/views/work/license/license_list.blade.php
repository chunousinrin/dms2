<?php
if (!empty($_POST['limit'])) {
    $limit = $_POST['limit'];
} else {
    $limit = 25;
};

if (!empty($_POST['keyword'])) {
    $src1 = ' AND keyword LIKE "%' . $_POST['keyword'] . '%"';
} else {
    $src1 = null;
};

if (!empty($_POST['startDate']) && !empty($_POST['endDate'])) {
    $src2 = ' AND ApplicationDate Between "' . $_POST['startDate'] . '" AND "' . $_POST['endDate'] . '"';
} elseif (!empty($_POST['startDate']) && empty($_POST['endDate'])) {
    $src2 = ' AND ApplicationDate >= "' . $_POST['startDate'] . '"';
} elseif (empty($_POST['startDate']) && !empty($_POST['endDate'])) {
    $src2 = ' AND ApplicationDate <= "' . $_POST['endDate'] . '"';
} else {
    $src2 = null;
};

if (!empty($_POST['ForestReserve'])) {
    $src3 = ' AND ForestReserve LIKE "%' . $_POST['ForestReserve'] . '%"';
} else {
    $src3 = null;
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
                    <td>申請期間</td>
                    <td style="display: flex;align-items:center">
                        <input type="text" name="startDate" class="form-control rounded-0 datepicker" value="<?= $_POST['startDate'] ?? null ?>">
                        <span style="padding:0 1em;">～</span>
                        <input type="text" name="endDate" class="form-control rounded-0 datepicker" value="<?= $_POST['endDate'] ?? null ?>">
                    </td>
                </tr>
                <tr>
                    <td>保安林種</td>
                    <td style="display: flex;align-items:center">
                        <input type="text" name="ForestReserve" id="ForestReserve" list="clist" autocomplete="on" value="<?= $_POST['ForestReserve'] ?? null ?>" placeholder="入力または一覧から選択してください" class="form-control rounded-0">
                        <datalist id="clist">
                            <?php
                            $sql = "SELECT ForestReserve FROM license_history GROUP BY ForestReserve;";
                            $stmt = $dbh->query($sql);
                            while ($row = $stmt->fetch(PDO::FETCH_BOTH)) {
                                echo "<option value='" . $row['ForestReserve'] . "'></option>";
                            }
                            ?>
                        </datalist>
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
        <table class="table table-bordered table-sm table-hover">
            <thead style="position: sticky;top:calc(-1em - 1px);">
                <tr class="table-success">
                    <td></td>
                    <td>
                        <div class="table-th">
                            ID
                            <div>
                                <a class="asc" onclick="lcidasc()"></a>
                                <a class="desc" onclick="lciddesc()"></a>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="table-th">
                            残日数
                            <div>
                                <a class="asc" onclick="lmtasc()"></a>
                                <a class="desc" onclick="lmtdesc()"></a>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="table-th">
                            整理番号
                            <div>
                                <a class="asc" onclick="rfnumasc()"></a>
                                <a class="desc" onclick="rfnumdesc()"></a>
                            </div>
                        </div>
                    </td>
                    <td>枝番</td>
                    <td>施設名称</td>
                    <td>保安林種</td>
                    <td>森林所在地</td>
                    <td>筆数</td>
                    <td>申請者</td>
                    <td>連絡先</td>
                    <td>許可面積</td>
                    <td>
                        <div class="table-th">
                            申請年月日
                            <div>
                                <a class="asc" onclick="apdateasc()"></a>
                                <a class="desc" onclick="apdatedesc()"></a>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="table-th">
                            許可年月日
                            <div>
                                <a class="asc" onclick="pmdateasc()"></a>
                                <a class="desc" onclick="pmdatedesc()"></a>
                            </div>
                        </div>
                    </td>
                    <td>指令番号</td>
                    <td>
                        <div class="table-th">
                            許可始期
                            <div>
                                <a class="asc" onclick="lsdateasc()"></a>
                                <a class="desc" onclick="lsdatedesc()"></a>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="table-th">
                            許可終期
                            <div>
                                <a class="asc" onclick="ledateasc()"></a>
                                <a class="desc" onclick="ledatedesc()"></a>
                            </div>
                        </div>
                    </td>
                    <td>完了</td>
                    <td>
                        <div class="table-th">
                            皆伐完了日
                            <div>
                                <a class="asc" onclick="dfdateasc()"></a>
                                <a class="desc" onclick="dfdatedesc()"></a>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="table-th">
                            植栽完了日
                            <div>
                                <a class="asc" onclick="pldateasc()"></a>
                                <a class="desc" onclick="pldatedesc()"></a>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="table-th">
                            提出日
                            <div>
                                <a class="asc" onclick="sbmdateasc()"></a>
                                <a class="desc" onclick="sbmdatedesc()"></a>
                            </div>
                        </div>
                    </td>
                    <td>着手日

                    </td>
                    <td>完了日</td>
                    <td>備考</td>
                    <input type="hidden" id="dateoder" name="dateoder" value="<?= $od ?? null ?>">
                </tr>
            </thead>
            <tbody>
                <?php
                $sum_price = 0;
                $sql = "SELECT * FROM license_history WHERE 1 " . $src1 . $src2 . $src3 . "LIMIT " . $limit;
                $stmt = $dbh->query($sql);
                $sum_price = 0;
                while ($result = $stmt->fetch(PDO::FETCH_BOTH)) : ?>
                    <?php
                    if ($result['validity'] == '期限切') {
                        $limited = "style='background-color:rgba(255,0,0,0.3);'";
                    } else {
                        $limited = null;
                    };
                    ?>
                    <tr id="selid" <?= $limited ?>>
                        <td name='validity' id='validity' class="text-center"><?= $result['validity'] ?></td>
                        <td class="text-center" id='licenseid'><?= $result['LicenseID'] ?></td>
                        <td class="text-center"><?= $result['lmt'] ?></td>
                        <td class="text-center"><?= $result['ReferenceNumber'] ?></td>
                        <td class="text-center"><?= $result['BranchNumber'] ?></td>
                        <td><?= $result['FacilityName'] ?></td>
                        <td><?= $result['ForestReserve'] ?></td>
                        <td><?= $result['Location'] ?></td>
                        <td class="text-right"><?= $result['Stock'] ?></td>
                        <td><?= $result['Applicant'] ?></td>
                        <td><?= $result['Contact'] ?></td>
                        <td class="text-right"><?= $result['PermittedArea'] ?></td>
                        <td class="text-center"><?= $result['ApplicationDate'] ?></td>
                        <td class="text-center"><?= $result['PermitDate'] ?></td>
                        <td class="text-center"><?= $result['InstructionNumber'] ?></td>
                        <td class="text-center"><?= $result['LicensedStartDate'] ?></td>
                        <td class="text-center"><?= $result['LicensedEndDate'] ?></td>
                        <td class="text-center"><?= $result['Completed'] ?></td>
                        <td><?= $result['DeforestationDate'] ?></td>
                        <td><?= $result['PlantingDate'] ?></td>
                        <td><?= $result['SubmissionDate'] ?></td>
                        <td><?= $result['StartDate'] ?></td>
                        <td><?= $result['CompletionDate'] ?></td>
                        <td><?= $result['Remark'] ?></td>
                    </tr>
                <?php endwhile; ?>
        </table>
    </div>
    <input type="hidden" id="sbmtype" name="sbmtype" value="<?= $sbmtype ?>">
</form>