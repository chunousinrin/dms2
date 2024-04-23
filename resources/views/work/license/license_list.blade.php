<?php
if (!empty($_GET['limit'])) {
    $limit = $_GET['limit'];
} else {
    $limit = 25;
}
?>

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
            $sql = "SELECT * FROM license_history WHERE $srch";
            $stmt = $dbh->query($sql);
            $sum_price = 0;
            while ($result = $stmt->fetch(PDO::FETCH_BOTH)) {
                if ($result['validity'] == '期限切') {
                    echo "<tr id='selid' style='background-color:rgba(255,0,0,0.3);'>";
                } else {
                    echo "<tr id='selid'>";
                };

                echo
                "<td name='validity' id='validity' style='text-align:center;'>" . $result['validity'] . "</td>" .
                    "<td style='text-align:center;' id='licenseid'>" . $result['LicenseID'] . "</td>" .
                    "<td style='text-align:center;'>" . $result['lmt'] . "</td>" .
                    "<td style='text-align:center;'>" . $result['ReferenceNumber'] . "</td>" .
                    "<td style='text-align:center;'>" . $result['BranchNumber'] . "</td>" .
                    "<td>" . $result['FacilityName'] . "</td>" .
                    "<td>" . $result['ForestReserve'] . "</td>" .
                    "<td>" . $result['Location'] . "</td>" .
                    "<td style='text-align:right;'>" . $result['Stock'] . "</td>" .
                    "<td>" . $result['Applicant'] . "</td>" .
                    "<td>" . $result['Contact'] . "</td>" .
                    "<td style='text-align:right;'>" . $result['PermittedArea'] . "</td>" .
                    "<td style='text-align:center;'>" . $result['ApplicationDate'] . "</td>" .
                    "<td style='text-align:center;'>" . $result['PermitDate'] . "</td>" .
                    "<td style='text-align:center;'>" . $result['InstructionNumber'] . "</td>" .
                    "<td style='text-align:center;'>" . $result['LicensedStartDate'] . "</td>" .
                    "<td style='text-align:center;'>" . $result['LicensedEndDate'] . "</td>" .
                    "<td style='text-align:center;'>" . $result['Completed'] . "</td>" .
                    "<td>" . $result['DeforestationDate'] . "</td>" .
                    "<td>" . $result['PlantingDate'] . "</td>" .
                    "<td>" . $result['SubmissionDate'] . "</td>" .
                    "<td>" . $result['StartDate'] . "</td>" .
                    "<td>" . $result['CompletionDate'] . "</td>" .
                    "<td style='max-height:100px'>" . $result['Remark'] . "</td>" .
                    "</tr>";
            }
            ?>
    </table>
    </form>
</div>