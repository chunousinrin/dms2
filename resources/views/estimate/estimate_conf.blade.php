<form action="" method="post" name="f_conf">
    @csrf
    <table class="table table-hover table-borderless ctable">
        <tbody>
            <tr>
                <td class="table-primary col-sm-2">見積番号</td>
                <td>
                    <div class="form-control rounded-0 ">
                        <?= $_POST['SerialNumber'] ?>
                        <input type="hidden" id="SerialNumber" name="SerialNumber" value=<?= $_POST['SerialNumber'] ?>>
                    </div>
                </td>
            </tr>

            <tr>
                <td class="table-primary col-sm-2">事業分類</td>
                <td>
                    <?php
                    $sql = "SELECT * FROM classication WHERE Id = " . $_POST['classicationId'];
                    $stmt = $dbh->query($sql);
                    $classicationId = $stmt->fetch();
                    ?>
                    <div class="form-control rounded-0 ">
                        <?= $classicationId['Name'] ?>
                        <input type="hidden" id="classicationId" name="classicationId" value=<?= $_POST['classicationId'] ?>>
                    </div>
                </td>
            </tr>

            <tr>
                <td class="table-primary col-sm-2">発行日</td>
                <td>
                    <input type="hidden" name="CreatedDate" value="<?= $_POST['CreatedDate'] ?>">
                    <input type="hidden" name="cddisplay" value="<?= $_POST['cddisplay'] ?>">
                    <div class="input-group">
                        <?php
                        if ($_POST['cddisplay'] == 1) {
                            echo "<div class='form-control rounded-0'>" . $_POST['CreatedDate'] . "</div>";
                        } else {
                            echo "<div class='form-control rounded-0'>" . $_POST['CreatedDate'] . " (非表示)</div>";
                        }
                        ?>
                    </div>
                </td>
            </tr>
            <tr>
                <td class="table-primary col-sm-2">発行者</td>
                <td>
                    <?php
                    $sql2 = "SELECT * FROM company WHERE BranchId = " .  $_POST['Branch'];
                    $stmt2 = $dbh->query($sql2);
                    $shisho = $stmt2->fetch();
                    ?>
                    <div class="form-control rounded-0 ">
                        <?= $shisho['BranchName'] . "　" . $shisho['Representative']; ?>
                        <input type="hidden" name="Branch" value="<?= $_POST['Branch'] ?>">
                        <input type="hidden" name="StaffDisplay" value="<?= $_POST['StaffDisplay'] ?>">
                        <input type="hidden" name="UserID" value=<?= $user['id']; ?>>
                        <input type="hidden" name="UserName" value="<?= $user['name']; ?>">
                    </div>
                    <?php
                    if ($_POST['StaffDisplay'] == 1) {
                        echo "<div class='form-control rounded-0'>" . $user['name'] . "</div>";
                    } else {
                        echo "<div class='form-control rounded-0'>" . $user['name'] . " (非表示)</div>";
                    };
                    ?>
                </td>
            </tr>
        </tbody>
    </table>

    <table class="table table-hover table-borderless ctable">
        <tbody>
            <tr>
                <td class="table-primary col-sm-2">取引先</td>
                <td>
                    <div class="form-control rounded-0 ">
                        <?= $_POST['Customer'] . "　" . $_POST['CustomerAdd'] ?>
                        <input name="Customer" id="Customer" type="hidden" value="<?= $_POST['Customer'] ?>">
                        <input name="CustomerAdd" id="CustomerAdd" type="hidden" value="<?= $_POST['CustomerAdd'] ?>">
                    </div>
                </td>
            </tr>
            <tr>
                <td class="table-primary col-sm-2">事業名</td>
                <td>
                    <div class="form-control rounded-0 ">
                        <?= $_POST['TitleName'] ?>
                        <input type="hidden" id="TitleName" name="TitleName" value="<?= $_POST['TitleName'] ?>">
                    </div>
                </td>
            </tr>
            <tr>
                <td class="table-primary col-sm-2">場所</td>
                <td>
                    <div class="form-control rounded-0 ">
                        <?= $_POST['Location'] ?>
                        <input type="hidden" id="Location" name="Location" value="<?= $_POST['Location'] ?>">
                    </div>
                </td>
            </tr>
            <tr>
                <td class="table-primary col-sm-2">実施日予定日</td>
                <td>
                    <div class="form-control rounded-0 ">
                        <?= $_POST['ScheduledDate'] ?>
                        <input type="hidden" name="ScheduledDate" value="<?= $_POST['ScheduledDate'] ?>">
                    </div>
                </td>
            </tr>
        </tbody>
    </table>

    <table class="table table-hover table-borderless ctable">
        <tbody>
            <tr>
                <td class="table-primary col-sm-2">見積有効期限</td>
                <td>
                    <div class="form-control rounded-0 ">
                        <?= $_POST['EffectiveDate'] ?>
                        <input type="hidden" name="EffectiveDate" value="<?= $_POST['EffectiveDate'] ?>">
                    </div>
                </td>
            </tr>
            <tr>
                <td class="table-primary col-sm-2">見積金額</td>
                <td>
                    <div class="form-control rounded-0 ">
                        <?php
                        if ($_POST['UnitPriceEstimate'] == 1) {
                            echo "<div style='padding:0 0.5em;'>表示</div>";
                        } else {
                            echo "<div style='padding:0 0.5em;'>非表示（単価見積）</div>";
                        }
                        ?>
                        <input type="hidden" name="UnitPriceEstimate" value="<?= $_POST['UnitPriceEstimate'] ?>">
                    </div>
                </td>
            </tr>
            <tr>
                <td class="table-primary col-sm-2">消費税率</td>
                <td>
                    <div class="form-control rounded-0 ">
                        <?php
                        if ($_POST['Tax'] == 1.08) {
                            echo "内税(8%)";
                        } elseif ($_POST['Tax'] == 1.1) {
                            echo "内税(10%)";
                        } elseif ($_POST['Tax'] == 0.1) {
                            echo "10%";
                        } elseif ($_POST['Tax'] == 0.08) {
                            echo "8%";
                        } elseif ($_POST['Tax'] == 0.0) {
                            echo "税抜";
                        }                       ?>
                        <input type="hidden" name="Tax" value="<?= $_POST['Tax'] ?>">
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
    <table class="table table-hover table-borderless ctable">
        <tbody>
            <tr>
                <td class="table-primary col-sm-2">備考</td>
                <td>
                    <div class="form-control rounded-0 ">
                        <?= nl2br($_POST['Remark']) ?>
                        <input type="hidden" name="Remark" value="<?= $_POST['Remark'] ?>">
                    </div>
                </td>
            </tr>
            <tr>
                <td class="table-primary col-sm-2">メモ</td>
                <td>
                    <div class="form-control rounded-0 ">
                        <?= nl2br($_POST['Memo']) ?>
                        <input type="hidden" name="Memo" value="<?= $_POST['Memo'] ?>">
                    </div>
                </td>
            </tr>
        </tbody>
    </table>

    <hr>
    <?php
    $table = array(
        array("0", "1", "2", "3"), //1
        array("4", "5", "6", "7"), //2
        array("8", "9", "10", "11"), //3
        array("12", "13", "14", "15"), //4
        array("16", "17", "18", "19"), //5
        array("20", "21", "22", "23"), //6
        array("24", "25", "26", "27"), //7
        array("28", "29", "30", "31"), //8
        array("32", "33", "34", "35"), //9
        array("36", "37", "38", "39"), //10
        array("40", "41", "42", "43"), //11
        array("44", "45", "46", "47"), //12
        array("48", "49", "50", "51"), //13
        array("52", "53", "54", "55"), //14
        array("56", "57", "58", "59") //, //15
        //array("60", "61", "62", "63") //16非表示
    );
    ?>
    <table class="table table-hover table-bordered table-sm" style="width: 100%;">
        <thead>
            <tr class="table-primary sticky-top">
                <td class="text-center">摘要</td>
                <td class="text-center">数量</td>
                <td class="text-center">単位</td>
                <td class="text-center">単価</td>
                <td class="text-center">合計</td>
            </tr>
        </thead>
        <tbody id="">
            <?php $celnum = (float)-1;
            $estimatesum = 0; ?>
            <?php foreach ($table as $row) : ?>
                <tr>
                    <?php $celnum = $celnum + 1;
                    $suryo = null; ?>
                    <td class="px-1 input-group">
                        <input class="lists form-control rounded-0" type="text" name="<?= 'InputItems' . $celnum; ?>" id="<?= 'InputItems' . $celnum; ?>" value="<?= $_POST['InputItems' . $celnum]; ?>" readonly>
                    </td>
                    <?php $celnum = $celnum + 1; ?>
                    <td class="px-1 col-sm-1">
                        <input class="lists form-control rounded-0 text-right" type="number" step="0.001" name="<?= 'InputItems' . $celnum; ?>" id="<?= 'InputItems' . $celnum; ?>" value="<?= $_POST['InputItems' . $celnum]; ?>" readonly>
                    </td>
                    <?php $celnum = $celnum + 1; ?>
                    <td class="px-1 col-sm-1">
                        <input class="lists form-control rounded-0 text-center" type="text" name="<?= 'InputItems' . $celnum; ?>" id="<?= 'InputItems' . $celnum; ?>" value="<?= $_POST['InputItems' . $celnum]; ?>" readonly>
                    </td>
                    <?php $celnum = $celnum + 1; ?>
                    <td class="px-1 col-sm-1">
                        <input class="lists form-control rounded-0 text-right" type="number" step="0.001" name="<?= 'InputItems' . $celnum; ?>" id="<?= 'InputItems' . $celnum; ?>" value="<?= $_POST['InputItems' . $celnum]; ?>" readonly>
                    </td>
                    <td class="px-1 col-sm-1">
                        <?php
                        if (!empty($_POST['InputItems' . $celnum - 2]) && !empty($_POST['InputItems' . $celnum])) {
                            $suryo = number_format($_POST['InputItems' . $celnum - 2] * $_POST['InputItems' . $celnum], 3);
                            $estimatesum = $estimatesum + ($_POST['InputItems' . $celnum - 2] * $_POST['InputItems' . $celnum]);
                        } elseif (empty($_POST['InputItems' . $celnum - 2]) && !empty($_POST['InputItems' . $celnum])) {
                            $suryo = number_format($_POST['InputItems' . $celnum], 3);
                            $estimatesum = $estimatesum + ($_POST['InputItems' . $celnum]);
                        };
                        ?>
                        <input class="lists form-control rounded-0 text-right" type="text" value="<?= $suryo ?>" readonly>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3" rowspan="3"></td>
                <td class="table-primary">小計</td>
                <td><input class="lists form-control rounded-0 px-1 text-right" type="text" value="<?= number_format($estimatesum, 3) ?>"></td>
            </tr>
            <tr>
                <td class=" table-primary">消費税</td>
                <?php
                if ($_POST['Tax'] == 1.08 or $_POST['Tax'] == 1.1) {
                    $tax = bcsub($estimatesum, bcdiv($estimatesum, $_POST['Tax'], 3), 3);
                    $tax2 = 0;
                } elseif ($_POST['Tax'] == 0.1 or $_POST['Tax'] == 0.08) {
                    $tax = bcmul($estimatesum, $_POST['Tax'], 3);
                    $tax2 = $tax;
                } elseif ($_POST['Tax'] == 0.0) {
                    $tax = 0;
                    $tax2 = 0;
                }
                ?>
                <td><input class="lists form-control rounded-0 px-1 text-right" type="text" value="<?= number_format($tax, 3) ?>">
                    <input type="hidden" name="Tax" value="<?= $_POST['Tax'] ?>">
                </td>
            </tr>
            <tr>
                <td class=" table-primary">合計</td>
                <td><input class="lists form-control rounded-0 px-1 text-right" type="text" value="<?= number_format($estimatesum + $tax2, 3) ?>">
                    <input type="hidden" name="estimatesum" value="<?= $estimatesum ?>">
                </td>
            </tr>
        </tfoot>
    </table>


    <input type="hidden" name="InputItems60" value="<?= $_POST['InputItems60'] ?>">
    <input type="hidden" name="InputItems61" value="<?= $_POST['InputItems61'] ?>">
    <input type="hidden" name="InputItems62" value="<?= $_POST['InputItems62'] ?>">
    <input type="hidden" name="InputItems63" value="<?= $_POST['InputItems63'] ?>">

    <div style="width:100%;text-align:center;" class="pb-5">
        <input class="btn btn-secondary rounded-0 btn-sm px-4" type="button" name="btn_back" value="戻る" onclick="history.back()">
        <input class="btn btn-secondary rounded-0 btn-sm px-4" type="submit" formmethod="post" formaction="estimate/preview" formtarget="_blank" value="プレビュー">
        <input class="btn btn-secondary rounded-0 btn-sm px-4" type="submit" value="保存">
        <input class="btn btn-secondary rounded-0 btn-sm px-4" type="hidden" name="sbmtype" value="4">
    </div>

</form>