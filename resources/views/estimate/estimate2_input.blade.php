<?php
$estimatenum = "13" . time();
?>
<form action="" method="post" name="f_input">
    @csrf
    <table class="table table-hover table-borderless ctable">
        <tbody>
            <tr>
                <td class="table-success col-sm-2">見積番号</td>
                <td>
                    <input type="text" id="SerialNumber" name="SerialNumber" value=<?= $estimatenum ?> readonly class="form-control rounded-0 ">
                </td>
            </tr>
            <tr>
                <td class="table-success col-sm-2">事業分類<span class="required_item">必須</span></td>
                <td>
                    <select name="classicationId" class="form-control rounded-0">
                        <?php
                        if (!empty($_POST['classicationId'])) {
                            $sql = "SELECT * FROM classication WHERE Id = " . $_POST['classicationId'];
                            $stmt = $dbh->query($sql);
                            $result = $stmt->fetch();
                            echo "<option hidden value='" . $result['Id'] . "'>" . $result['Name'] . "</option>";
                        } else {
                            echo "<option value='' hidden selected>-- 選択してください --</option>";
                        };
                        $sql = "SELECT * FROM classication ORDER BY Id ASC";
                        $stmt = $dbh->query($sql);
                        while ($result = $stmt->fetch(PDO::FETCH_BOTH)) {
                            echo "<option value='" . $result['Id'] . "'>" . $result['Name'] . "</option>";
                        };
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td class="table-success col-sm-2">発行日<span class="required_item">必須</span></td>
                <td>
                    <input type="text" id="CreatedDate" name="CreatedDate" required class="form-control rounded-0 datepicker" value="<?= $_POST['CreatedDate'] ?? null ?>">
                    <?php
                    $cddisplay = $_POST['cddisplay'] ?? null;
                    if ($cddisplay === "1" or is_null($cddisplay)) {
                        $ckd1 = "checked";
                        $ckd2 = "";
                    } else {
                        $ckd1 = "";
                        $ckd2 = "checked";
                    }
                    ?>
                    <div class="btn-group btn-group-toggle mt-1" data-toggle="buttons">
                        <label class='btn btn-outline-secondary btn-sm' for="cddisplay1">
                            <input type="radio" name="cddisplay" id="cddisplay1" value="1" <?= $ckd1 ?>>&nbsp;表示&nbsp;
                        </label>
                        <label class='btn btn-outline-secondary btn-sm' for="cddisplay2">
                            <input type="radio" name="cddisplay" id="cddisplay2" value="0" <?= $ckd2 ?>>非表示
                        </label>
                    </div>
                </td>
            </tr>
            <tr>
                <td class="table-success col-sm-2">発行者</td>
                <td>
                    <?php
                    $companysql = "SELECT * FROM company ORDER BY BranchId ASC";
                    $companylist = $dbh->prepare($companysql);
                    $companylist->execute();
                    ?>
                    <select name="Branch" id="Branch" class="form-control rounded-0">
                        <?php
                        while ($row = $companylist->fetch(PDO::FETCH_ASSOC)) {
                            echo '<option value="' . $row['BranchId'] . '">' . $row['BranchName'] . '</option>';
                        }
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td class="table-success col-sm-2">担当者</td>
                <td>
                    <div class="input-group">
                        <input type=" text" id="UserID" name="UserID" value=<?= $user['id']; ?> readonly class="form-control rounded-0 col-sm-2">
                        <input type="text" id="UserName" name="UserName" value="<?= $user['name']; ?>" readonly class="form-control rounded-0 col-sm-10">
                    </div>

                    <div class="btn-group btn-group-toggle mt-1" data-toggle="buttons">
                        <?php
                        $StaffDisplay = $_POST['StaffDisplay'] ?? null;
                        if ($StaffDisplay === "1" or is_null($StaffDisplay)) {
                            $ckd3 = "checked";
                            $ckd4 = "";
                        } else {
                            $ckd3 = "";
                            $ckd4 = "checked";
                        }
                        ?>
                        <label class="btn btn-outline-secondary btn-sm" for="StaffDisplay1">
                            <input type="radio" name="StaffDisplay" id="StaffDisplay1" value="1" <?= $ckd3 ?>>&nbsp;表示&nbsp;
                        </label>
                        <label class="btn btn-outline-secondary btn-sm" for="StaffDisplay2">
                            <input type="radio" name="StaffDisplay" id="StaffDisplay2" value="0" <?= $ckd4 ?>>非表示
                        </label>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
    <table class="table table-hover table-borderless ctable">
        <tbody>
            <tr>
                <td class="table-success col-sm-2">取引先<span class="required_item">必須</span></td>
                <td>
                    <div class="input-group">
                        <input type="text" name="Customer" id="Customer" list="clist" autocomplete="on" value="<?= $_POST['Customer'] ?? null ?>" placeholder="入力または一覧から選択してください" required class="form-control rounded-0 col-sm-10">
                        <datalist id="clist">
                            <?php
                            $sql = "SELECT * FROM customer ORDER BY CustomerID ASC";
                            $stmt = $dbh->query($sql);
                            while ($row = $stmt->fetch(PDO::FETCH_BOTH)) {
                                echo "<option value='" . $row['name'] . "'></option>";
                            }
                            ?>
                        </datalist>
                        <select name="CustomerAdd" id="CustomerAdd" class="form-control rounded-0 col-sm-2">
                            <option value="御中">御中</option>
                            <option value="様">様</option>
                        </select>
                    </div>
                    <a href="https://dms.chunousinrin.com/customer/reg">新規登録</a>
                </td>
            </tr>
            <tr>
                <td class="table-success col-sm-2">業務名称<span class="required_item">必須</span></td>
                <td>
                    <input type="text" id="TitleName" name="TitleName" required class="form-control rounded-0" value="<?= $_POST['TitleName'] ?? null; ?>">
                </td>
            </tr>
            <tr>
                <td class="table-success col-sm-2">業務場所</td>
                <td>
                    <input type="text" id="Location" name="Location" class="form-control rounded-0" value="<?= $_POST['Location'] ?? null ?>">
                </td>
            </tr>
            <tr>
                <td class="table-success col-sm-2">工種</td>
                <td>
                    <input type="text" id="WorksType" name="WorksType" class="form-control rounded-0" value="<?= $_POST['WorksType'] ?? null ?>">
                </td>
            </tr>
            <tr>
                <td class="table-success col-sm-2">業務期間</td>
                <td>
                    <div class="input-group">
                        <input type="text" id="WorksPeriod1" name="WorksPeriod1" class="datepicker form-control rounded-0" value="<?= $_POST['WorksPeriod1'] ?? null ?>">
                        <span class="col-form-label">～</span>
                        <input type="text" id="WorksPeriod2" name="WorksPeriod2" class="datepicker form-control" value="<?= $_POST['WorksPeriod2'] ?? null ?>">
                    </div>
                </td>
            </tr>
        </tbody>
    </table>

    <table class="table table-hover table-borderless ctable">
        <tbody>
            <tr>
                <td class="table-success col-sm-2">見積有効期限</td>
                <td>
                    <input type="text" id="effectivedate" name="effectivedate" class="datepicker form-control rounded-0" value="<?= $_POST['effectivedate'] ?? null ?>">
                    <span class="col-form-label">未記入の場合、発行日より45日以内</span>
                </td>
            </tr>
            <tr>
                <td class="table-success col-sm-2">消費税率</td>
                <td>
                    <select name="Tax" id="Tax" class="form-control rounded-0 col-sm-3">
                        <?php
                        $tax = $_POST['Tax'] ?? null;
                        if ($tax === "0.1") {
                            echo "<option value='0.1' selected hidden>10%</option>";
                        } elseif ($tax === "0.08") {
                            echo "<option value='0.08' selected hidden>8%</option>";
                        } elseif ($tax === "0") {
                            echo "<option value='0' selected hidden>税抜</option>";
                        }
                        ?>
                        <option value="0.1">10%</option>
                        <option value="0.08">8%</option>
                        <option value="0">税抜</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td class="table-success col-sm-2">見積金額</td>
                <td>
                    <select name="Es2UnitPrice" id="Es2UnitPrice" class="form-control rounded-0 col-sm-3">
                        <?php
                        if (empty($_POST['Es2UnitPrice']) or $_POST['Es2UnitPrice'] === "0") {
                            echo "<option value='0' hidden selected>非表示（単価見積）</option>";
                        } elseif (is_null($_POST['Es2UnitPrice']) or $_POST['Es2UnitPrice'] === "1") {
                            echo "<option value='1' hidden selected>表示</option>";
                        };
                        ?>
                        <option value="1">表示</option>
                        <option value="0">非表示（単価見積）</option>
                    </select>
                </td>
            </tr>
        </tbody>
    </table>

    <table class="table table-hover table-borderless ctable">
        <tbody>
            <tr>
                <td class="table-success col-sm-2">備考</td>
                <td>
                    <textarea id="Remark" name="Remark" class="form-control rounded-0"><?= $_POST['Remark'] ?? null ?></textarea>
                </td>
            </tr>
        </tbody>
    </table>


    <hr>

    <table class="table table-hover table-bordered" style="width: 100%;">
        <thead>
            <tr class="table-success sticky-top">
                <td class="text-center">品名・規格・仕様等</td>
                <td class="text-center">数量</td>
                <td class="text-center">単位</td>
                <td class="text-center">単価</td>
                <td class="text-center">金額</td>
                <td class="text-center">摘要</td>
            </tr>
        </thead>
        <tbody>
            <?php
            $table = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12); ?>
            <?php foreach ($table as $row) : ?>
                <tr>
                    <?php
                    $i = $_POST['smr' . $row] ?? null;
                    echo "<td class='px-1 col-sm-6'><input type='text' class='lists form-control rounded-0' name='smr" . $row . "' value='" . $i . "'></td>";
                    $i = $_POST['qat' . $row] ?? null;
                    echo "<td class='px-1 col-sm-1'><input type='number' class='lists form-control rounded-0' step='0.01' name='qat" . $row . "' id='qat" . $row . "' value='" . $i . "' onchange='amtp" . $row . "()'></td>";
                    $i = $_POST['unt' . $row] ?? null;
                    echo "<td class='px-1 col-sm-1'><input type='text' class='lists form-control rounded-0' name='unt" . $row . "' value='" . $i . "'></td>";
                    $i = $_POST['up' . $row] ?? null;
                    echo "<td class='px-1 col-sm-1'><input type='number' class='lists form-control rounded-0' step='0.01' name='up" . $row . "' id='up" . $row . "' value='" . $i . "' onchange='amtp" . $row . "()'></td>";
                    $i = $_POST['amt' . $row] ?? null;
                    echo "<td class='px-1 col-sm-1'><input pattern='[0-9.-]' type='text' class='lists form-control rounded-0' name='amt" . $row . "' id='amt" . $row . "' value='" . $i . "'></td>";
                    $i = $_POST['rm' . $row] ?? null;
                    echo "<td class='px-1 col-sm-2'><input type='text' class='lists form-control rounded-0' name='rm" . $row . "' value='" . $i . "'></td>";
                    $subtotal[] = $_POST['amt' . $row] ?? null;
                    echo "<script>
                        function amtp" . $row . "() {
                            if (document.getElementById('qat" . $row . "').value?.trim() && document.getElementById('up" . $row . "').value?.trim()) {
                                document.getElementById('amt" . $row . "').value = document.getElementById('up" . $row . "').value * document.getElementById('qat" . $row . "').value;
                            } else {
                                document.getElementById('amt" . $row . "').value = document.getElementById('up" . $row . "').value;
                            }
                        }
                    </script>"
                    ?>
                </tr>
            <?php endforeach; ?>
            <tr class="table-success">
                <td colspan="3">直接作業代</td>
                <td class="text-center"><input class="btn btn-sm px-4 btn-light rounded-0" type="submit" value="小計"></td>
                <td class="es2span">
                    <span>A</span>
                    <input type="text" id="subtotal" name="subtotal" value="<?= array_sum($subtotal) ?? null ?>" class="form-control rounded-0">
                    <?php $total[] = array_sum($subtotal); ?>
                </td>
                <td></td>
            </tr>

            <!-------------------------------- B -------------------------------->
            <?php
            if (!empty($_POST['idqat1'])) {
                $idamt1 = floor(array_sum($subtotal) * ($_POST['idqat1'] / 100) / 1000) * 1000;
                $idamt2 = array_sum($subtotal) + $idamt1;
            } else {
                $idamt1 = null;
            }
            if (!empty($_POST['idqat2'])) {
                $idamt2 = floor((array_sum($subtotal) + $idamt1) * ($_POST['idqat2'] / 100) / 1000) * 1000;
            } else {
                $idamt2 = null;
            }

            $idtotal = array_sum($subtotal) + $idamt1 + $idamt2;
            ?>


            <tr>
                <td><input type="text" name="idsmr1" value="<?= $_POST['idsmr1'] ?? null ?>" class="form-control rounded-0"></td>
                <td class="es2span">
                    <span>B</span>
                    <input type="number" step="0.01" id="idqat1" name="idqat1" value="<?= $_POST['idqat1'] ?? null ?>" class="form-control rounded-0">
                </td>
                <td>% <input type="hidden" id="idunt1" name="idunt1" value="%" class="form-control rounded-0"> </td>
                <td></td>
                <td class="es2span">
                    <span>C</span>
                    <input type="number" step="0.01" id="idamt1" name="idamt1" value="<?= $idamt1 ?? null ?>" class="form-control rounded-0">
                </td>
                <td class="es2span">
                    <input type="text" name="idrmk1" value="<?= $_POST['idrmk1'] ?? null ?>" class="form-control rounded-0">
                    <span>A×B</span>
                </td>
            </tr>
            <tr>
                <td><input type="text" name="idsmr2" value="<?= $_POST['idsmr2'] ?? null ?>" class="form-control rounded-0"></td>
                <td class="es2span">
                    <span>D</span>
                    <input type="number" step="0.01" id="idqat2" name="idqat2" value="<?= $_POST['idqat2'] ?? null ?>" class="form-control rounded-0">
                </td>
                <td>%<input type="hidden" id="idunt2" name="idunt2" value="%" class="form-control rounded-0"></td>
                <td></td>
                <td class="es2span">
                    <span>E</span>
                    <input type="number" step="0.01" id="idamt2" name="idamt2" value="<?= $idamt2 ?? null ?>" class="form-control rounded-0">
                </td>
                <td class="es2span">
                    <input type="text" name="idrmk2" value="<?= $_POST['idrmk2'] ?? null ?>" class="form-control rounded-0" class="form-control rounded-0">
                    <span>(A+C)×D</span>
                </td>
            </tr>
            <tr class="table-success">
                <td colspan="3">工事原価</td>
                <td class="text-center"><input class="btn btn-sm px-4 btn-light rounded-0" type="submit" value="小計" class="btn btn-sm"></td>
                <td class="es2span">
                    <span>F</span>
                    <input style="outline:none;bakground:none;" type="text" name="idtotal" value="<?= $idtotal ?? null ?>" class="form-control rounded-0">
                </td>
                <td class="es2span"><span>A+C+E</span></td>
                <?php $total[] = $idamt1;
                $total[] = $idamt2; ?>
            </tr>

            <!-------------------------------- C -------------------------------->
            <?php
            if (!empty($_POST['otqat1'])) {
                $otamt1 = floor($idtotal * ($_POST['otqat1'] / 100) / 1000) * 1000;
            } else {
                $otamt1 = null;
            }
            $total[] = $otamt1;
            $total[] = $_POST['otamt2'] ?? 0;
            $total[] = $_POST['otamt3'] ?? 0;
            $total[] = $_POST['otamt4'] ?? 0; ?>
            <tr>
                <td>
                    <input type="text" name="otsmr1" value="<?= $_POST['otsmr1'] ?? null ?>" class=" form-control rounded-0">
                </td>
                <td class="es2span">
                    <span>G</span>
                    <input type="number" step="0.01" name="otqat1" value="<?= $_POST['otqat1'] ?? null ?>" class="form-control rounded-0">
                </td>
                <td>%<input type="hidden" name="otunt1" id="otunt1" value="%" class="form-control rounded-0"></td>
                <td></td>
                <td class="es2span"><span>H</span><input type="text" name="otamt1" value="<?= $otamt1 ?? null ?>" class="form-control rounded-0"></td><!-- E -->
                <td class="es2span"><span>F×G</span><input type="text" name="otrmk1" value="<?= $_POST['otrmk1'] ?? null ?>" class="form-control rounded-0"></td><!--<span>F×G</span>-->
            </tr>
            <tr>
                <td><input type="text" name="otsmr2" value="<?= $_POST['otsmr2'] ?? null ?>" class="form-control rounded-0"></td>
                <td class="es2span"><span>I</span><input type="number" step="0.01" name="otqat2" id="otqat2" value="<?= $_POST['otqat2'] ?? null ?>" onchange="otamtp1()" class="form-control rounded-0"></td>
                <td><input type="text" name="otunt2" value="<?= $_POST['otunt2'] ?? null ?>" class="form-control rounded-0"></td>
                <td><input type="number" step="0.01" name="otup2" id="otup2" value="<?= $_POST['otup2'] ?? null ?>" onchange="otamtp1()" class="form-control rounded-0"></td>
                <td><input type="number" step="0.01" name="otamt2" id="otamt2" value="<?= $_POST['otamt2'] ?? null ?>" class="form-control rounded-0"></td><!-- F -->
                <td><input type="text" name="otrmk2" value="<?= $_POST['otrmk2'] ?? null ?>" class="form-control rounded-0"></td>
            </tr>
            <tr>
                <td><input type="text" name="otsmr3" value="<?= $_POST['otsmr3'] ?? null ?>" class="form-control rounded-0"></td>
                <td class="es2span"><span>J</span><input type="number" step="0.01" name="otqat3" id="otqat3" value="<?= $_POST['otqat3'] ?? null ?>" onchange="otamtp2()" class="form-control rounded-0"></td>
                <td><input type="text" name="otunt3" value="<?= $_POST['otunt3'] ?? null ?>" class="form-control rounded-0"></td>
                <td><input type="number" step="0.01" name="otup3" id="otup3" value="<?= $_POST['otup3'] ?? null ?>" onchange="otamtp2()" class="form-control rounded-0"></td>
                <td><input type="number" step="0.01" name="otamt3" id="otamt3" value="<?= $_POST['otamt3'] ?? null ?>" class="form-control rounded-0"></td><!-- F -->
                <td><input type="text" name="otrmk3" value="<?= $_POST['otrmk3'] ?? null ?>" class="form-control rounded-0"></td>
            </tr>
            <tr>
                <td><input type="text" name="otsmr4" value="<?= $_POST['otsmr4'] ?? null ?>" class="form-control rounded-0"></td>
                <td class="es2span"><span>K</span><input type="number" step="0.01" name="otqat4" id="otqat4" value="<?= $_POST['otqat4'] ?? null ?>" onchange="otamtp3()" class="form-control rounded-0"></td>
                <td><input type="text" name="otunt4" value="<?= $_POST['otunt4'] ?? null ?>" class="form-control rounded-0"></td>
                <td><input type="number" step="0.01" name="otup4" id="otup4" value="<?= $_POST['otup4'] ?? null ?>" onchange="otamtp3()" class="form-control rounded-0"></td>
                <td><input type="number" step="0.01" name="otamt4" id="otamt4" value="<?= $_POST['otamt4'] ?? null ?>" class="form-control rounded-0"></td><!-- F -->
                <td><input type="text" name="otrmk4" value="<?= $_POST['otrmk4'] ?? null ?>" class="form-control rounded-0"></td>
            </tr>
            <tr class="table-success">
                <td colspan="3">合計</td>
                <td class="text-center"><input class="btn btn-sm px-4 btn-light rounded-0" type="submit" value="小計"></td>
                <td class="es2span"><span>L</span><input type="text" name="ottotal" value="<?= array_sum($total) ?? 0 ?>" class="form-control rounded-0"></td>
                <td class="es2span"><span>F+H+I+J+K</span></td>
            </tr>
        </tbody>
    </table>

    <div style="margin:0 auro;padding:10px 0;text-align:center;">
        <button class="btn btn-sm btn-secondary rounded-0 px-4 mb-5" type="submit" name="btn_confirm" value="入力内容を確認する" formaction="/estimate2/preview" formtarget="blank">入力内容を確認する</button>
        <button class="btn btn-sm btn-secondary rounded-0 px-4 mb-5" type="button" name="saved" onclick="es2save();">保存</button>
    </div>
    <input type="text" id="sbmtype" name="sbmtype" value="8">
</form>
<script>
    function es2save() {
        document.getElementById('sbmtype').value = "12";
        document.f_input.submit();
    }
</script>