<?php $billnum = "12" . time();
$e2bsql = "SELECT * FROM estimate WHERE EstimateNumber = " . $_POST['SerialNumber'];
$ste2b = $dbh->query($e2bsql);
$e2b = $ste2b->fetch();
//var_dump($_POST)
?>

<form action="/bill/conf" method="post">
    @csrf
    <table class="table table-hover table-borderless ctable">
        <tbody>
            <tr>
                <td class="table-success col-sm-2">請求番号</td>
                <td>
                    <input type="text" id="SerialNumber" name="SerialNumber" value="<?= $billnum ?>" readonly class="form-control rounded-0 ">
                </td>
            </tr>
            <tr>
                <td class="table-success col-sm-2">事業分類<span class="required_item">必須</span></td>
                <td>
                    <?php
                    $classicationId = "SELECT * FROM `classication` ORDER BY `Id` ASC";
                    $blist = $dbh->prepare($classicationId);
                    $blist->execute();
                    ?>
                    <select id="classicationId" name="classicationId" onchange="creg()" required class="form-control rounded-0 ">
                        <option value="" hidden selected>-- 選択してください --</option>
                        <?php
                        while ($row = $blist->fetch(PDO::FETCH_ASSOC)) {
                            echo '<option value="' . $row['Id'] . '">' . $row['Name'] . '</option>';
                        }
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td class="table-success col-sm-2">発行日<span class="required_item">必須</span></td>
                <td>
                    <input type="text" id="CreatedDate" name="CreatedDate" required class="form-control rounded-0 datepicker">

                    <div class="btn-group btn-group-toggle mt-1" data-toggle="buttons">
                        <label class="btn btn-outline-secondary active btn-sm">
                            <input type="radio" name="cddisplay" id="cddisplay1" value="1" autocomplete="off" checked>&nbsp;表示&nbsp;
                        </label>
                        <label class="btn btn-outline-secondary btn-sm">
                            <input type="radio" name="cddisplay" id="cddisplay2" value="0" autocomplete="off">非表示
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
                        <label class="btn btn-outline-secondary active btn-sm">
                            <input type="radio" name="StaffDisplay" id="StaffDisplay1" value="1" autocomplete="off" checked>&nbsp;表示&nbsp;
                        </label>
                        <label class="btn btn-outline-secondary btn-sm">
                            <input type="radio" name="StaffDisplay" id="StaffDisplay2" value="0" autocomplete="off">非表示
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
                        <input type="text" name="Customer" id="Customer" list="clist" autocomplete="on" value="<?= $e2b['Customer'] ?? null ?>" placeholder="入力または一覧から選択してください" required class="form-control rounded-0 col-sm-10">
                        <datalist id="clist">
                            <?php
                            $sql = "SELECT customer FROM bill GROUP BY customer;";
                            $stmt = $dbh->query($sql);
                            while ($row = $stmt->fetch(PDO::FETCH_BOTH)) {
                                echo "<option value='" . $row['customer'] . "'></option>";
                            }
                            ?>
                        </datalist>
                        <select name="CustomerAdd" id="CustomerAdd" class="form-control rounded-0 col-sm-2">
                            <option value="<?= $e2b['CustomerAdd'] ?>" selected hidden><?= $e2b['CustomerAdd'] ?></option>
                            <option value="御中">御中</option>
                            <option value="様">様</option>
                        </select>
                    </div>
                </td>
            </tr>
            <tr>
                <td class="table-success col-sm-2">事業名<span class="required_item">必須</span></td>
                <td>
                    <input type="text" id="TitleName" name="TitleName" required class="form-control rounded-0" value="<?= $e2b['EstimateName'] ?>">
                </td>
            </tr>
            <tr>
                <td class="table-success col-sm-2">場所</td>
                <td>
                    <input type="text" id="Location" name="Location" class="form-control rounded-0" value="<?= $e2b['Location'] ?>">
                </td>
            </tr>
            <tr>
                <td class="table-success col-sm-2">実施日</td>
                <td>
                    <div class="input-group">
                        <input type="text" id="CompletionDate" name="CompletionDate" class="datepicker form-control rounded-0">
                        <span class="col-form-label">～</span>
                        <input type="text" id="CompletionDate2" name="CompletionDate2" class="datepicker form-control">
                    </div>
                </td>
            </tr>
        </tbody>
    </table>


    <table class="table table-hover table-borderless ctable">
        <tbody>
            <tr>
                <td class="table-success col-sm-2">支払期日</td>
                <td>
                    <input type="text" id="PaymentDueDate" name="PaymentDueDate" class="datepicker form-control rounded-0">
                    <span class="col-form-label">未記入の場合、発行日より45日以内</span>
                </td>
            </tr>
            <tr>
                <td class="table-success col-sm-2">記載振込先<span class="required_item">必須</span></td>
                <td>
                    <div class="input-group mb-1">
                        <span class="col-form-label">１.</span>
                        <select name="BankID1" id="BankID1" required class="form-control rounded-0">
                            <?php
                            $banksql = "SELECT BankID,concat_ws(Char(9),BankName,BankBranch,AccountType,AccountNumber)as banks FROM bank WHERE BankID=1 ORDER BY BankID ASC;";
                            $stbank1 = $dbh->query($banksql);
                            $bank = $stbank1->fetch();
                            echo "<option selected hidden value='" . $bank['BankID'] . "'>" . $bank['banks'] . "</option>";

                            $banksql = "SELECT BankID,concat_ws(Char(9),BankName,BankBranch,AccountType,AccountNumber)as banks FROM bank ORDER BY BankID ASC;";
                            $stbank = $dbh->query($banksql);
                            while ($bank = $stbank->fetch(PDO::FETCH_BOTH)) {
                                echo "<option value='" . $bank['BankID'] . "'>" . $bank['banks'] . "</option>";
                            };
                            ?>
                            <option value=""></option>
                        </select>
                    </div>
                    <div class="input-group mb-1">
                        <span class="col-form-label">２.</span>

                        <select name="BankID2" id="BankID2" required class="form-control rounded-0">
                            <?php
                            $banksql = "SELECT BankID,concat_ws(Char(9),BankName,BankBranch,AccountType,AccountNumber)as banks FROM bank WHERE BankID=2 ORDER BY BankID ASC;";
                            $stbank2 = $dbh->query($banksql);
                            $bank = $stbank2->fetch();
                            echo "<option selected hidden value='" . $bank['BankID'] . "'>" . $bank['banks'] . "</option>";

                            $banksql = "SELECT BankID,concat_ws(Char(9),BankName,BankBranch,AccountType,AccountNumber)as banks FROM bank ORDER BY BankID ASC;";
                            $stbank = $dbh->query($banksql);
                            while ($bank = $stbank->fetch(PDO::FETCH_BOTH)) {
                                echo "<option value='" . $bank['BankID'] . "'>" . $bank['banks'] . "</option>";
                            };
                            ?>
                            <option value=""></option>
                        </select>
                    </div>

                    <div class="input-group">
                        <span class="col-form-label">３.</span>
                        <select name="BankID3" id="BankID3" required class="form-control rounded-0">
                            <?php
                            $banksql = "SELECT BankID,concat_ws(Char(9),BankName,BankBranch,AccountType,AccountNumber)as banks FROM bank WHERE BankID=3 ORDER BY BankID ASC;";
                            $stbank3 = $dbh->query($banksql);
                            $bank = $stbank3->fetch();
                            echo "<option selected hidden value='" . $bank['BankID'] . "'>" . $bank['banks'] . "</option>";

                            $banksql = "SELECT BankID,concat_ws(Char(9),BankName,BankBranch,AccountType,AccountNumber)as banks FROM bank ORDER BY BankID ASC;";
                            $stbank = $dbh->query($banksql);
                            while ($bank = $stbank->fetch(PDO::FETCH_BOTH)) {
                                echo "<option value='" . $bank['BankID'] . "'>" . $bank['banks'] . "</option>";
                            };
                            ?>
                            <option value=""></option>
                        </select>
                    </div>
                </td>
            </tr>
            <tr>
                <td class="table-success col-sm-2">消費税率</td>
                <td>
                    <select name="Tax" id="Tax" class="form-control rounded-0 col-sm-2">
                        <?php
                        if ($e2b['Tax'] === "0.10") {
                            $taxtype = "10%";
                            $tax = "0.1";
                        } elseif ($e2b['Tax'] === "0.08") {
                            $taxtype = "8%";
                            $tax = "0.08";
                        } elseif ($e2b['Tax'] === "1.10") {
                            $taxtype = "内税(10%)";
                            $tax = "1.1";
                        } elseif ($e2b['Tax'] === "1.08") {
                            $taxtype = "内税(8%)";
                            $tax = "1.08";
                        }
                        ?>
                        <option value="<?= $tax ?>" selected hidden><?= $taxtype ?></option>
                        <option value="0.1">10%</option>
                        <option value="0.08">8%</option>
                        <option value="1.1">内税(10%)</option>
                        <option value="1.08">内税(8%)</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td class="table-success col-sm-2">入金日</td>
                <td>
                    <input type="text" id="PaymentDate" name="PaymentDate" class="datepicker form-control rounded-0">
                </td>
            </tr>
        </tbody>
    </table>

    <table class="table table-hover table-borderless ctable">
        <tbody>
            <tr>
                <td class="table-success col-sm-2">備考</td>
                <td>
                    <textarea id="Remark" name="Remark" class="form-control rounded-0"><?= $e2b['Remark'] ?></textarea>
                </td>
            </tr>
            <tr>
                <td class="table-success col-sm-2">メモ</td>
                <td>
                    <textarea id="Memo" name="Memo" class="form-control rounded-0"><?= "見積番号：" . $_POST['SerialNumber'] ?><?= $e2b['Memo'] ?></textarea>
                    <span class="col-form-label">この項目は印刷されません</span>
                </td>
            </tr>
        </tbody>
    </table>

    <hr>

    <table class="table table-hover table-bordered" style="width: 100%;">
        <thead>
            <tr class="table-success sticky-top">
                <td class="text-center">摘要</td>
                <td class="text-center">数量</td>
                <td class="text-center">単位</td>
                <td class="text-center">単価</td>
            </tr>
        </thead>
        <tbody id="items">
            <?php
            $cel = (float)-1;
            $e2bsql = "SELECT * FROM estimate WHERE EstimateNumber = " . $_POST['SerialNumber'];
            $ste2b = $dbh->query($e2bsql);
            while ($result = $ste2b->fetch(PDO::FETCH_ASSOC)) : ?>
                <tr>
                    <?php $cel = $cel + 1; ?>
                    <td class="px-1 input-group">
                        <img class="px-1" src="https://icongr.am/clarity/bars.svg?size=30&color=currentColor" alt="line">
                        <input class="lists form-control rounded-0" type="text" name="<?= 'InputItems' . $cel; ?>" id="<?= 'InputItems' . $cel; ?>" value="<?= $result['Summary'] ?>">
                    </td>
                    <?php $cel = $cel + 1; ?>
                    <td class="px-1 col-sm-2">
                        <input class="lists form-control rounded-0" type="number" step="0.001" name="<?= 'InputItems' . $cel; ?>" id="<?= 'InputItems' . $cel; ?>" value="<?= $result['Quantity'] ?>">
                    </td>
                    <?php $cel = $cel + 1; ?>
                    <td class="px-1 col-sm-2">
                        <input class="lists form-control rounded-0" type="text" name="<?= 'InputItems' . $cel; ?>" id="<?= 'InputItems' . $cel; ?>" value="<?= $result['Unit'] ?>">
                    </td>
                    <?php $cel = $cel + 1; ?>
                    <td class="px-1 col-sm-2">
                        <input class="lists form-control rounded-0" type="number" step="0.001" name="<?= 'InputItems' . $cel; ?>" id="<?= 'InputItems' . $cel; ?>" value="<?= $result['UnitPrice'] ?>">
                    </td>
                </tr>
            <?php endwhile  ?>
            <tr>
                <td><input class='lists' type='text' name='InputItems60' id='InputItems60' value=''></td>
                <td><input class='lists' type='text' name='InputItems61' id='InputItems61' value=''></td>
                <td><input class='lists' type='text' name='InputItems62' id='InputItems63' value=''></td>
                <td><input class='lists' type='text' name='InputItems63' id='InputItems63' value=''></td>
            </tr>
        </tbody>

    </table>

    <div style="width:100%; margin:0 auto;padding:10px 0;text-align:center;">
        <button class="btn btn-secondary rounded-0" type="submit" name="btn_confirm" formaction="/bill">入力内容を確認する</button>
        <input type="hidden" name="sbmtype" id="sbmtype" value="3">
    </div>
</form>