<?php
$billnum = "12" . time();
?>
<form action="" method="post" name="f_input">
    @csrf
    <table class="table table-hover table-borderless ctable">
        <tbody>
            <tr>
                <td class="table-success col-2">請求番号</td>
                <td class="col-10">
                    <input type="text" id="SerialNumber" name="SerialNumber" value=<?= $billnum ?> readonly class="form-control rounded-0 ">
                </td>
            </tr>
            <tr>
                <td class="table-success col-2">事業分類<span class="required_item">必須</span></td>
                <td>
                    <?php
                    $classicationId = "SELECT * FROM `classication` ORDER BY `Id` ASC";
                    $blist = $dbh->prepare($classicationId);
                    $blist->execute();
                    ?>
                    <select id="classicationId" name="classicationId" required class="form-control rounded-0 ">
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
                <td class="table-success col-2">発行日<span class="required_item">必須</span></td>
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
                <td class="table-success col-2">発行者</td>
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
                <td class="table-success col-2">担当者</td>
                <td>
                    <div class="input-group">
                        <input type=" text" id="UserID" name="UserID" value=<?= $user['id']; ?> readonly class="form-control rounded-0 col-2">
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
                <td class="table-success col-2">取引先<span class="required_item">必須</span></td>
                <td>
                    <div class="input-group">
                        <input type="text" name="Customer" id="Customer" list="clist" autocomplete="on" value="<?= $_POST['Customer'] ?? null ?>" placeholder="入力または一覧から選択してください" required class="form-control rounded-0 col-sm-10">
                        <datalist id="clist">
                            <?php
                            $sql = "SELECT customer FROM bill GROUP BY customer;";
                            $stmt = $dbh->query($sql);
                            while ($row = $stmt->fetch(PDO::FETCH_BOTH)) {
                                echo "<option value='" . $row['customer'] . "'></option>";
                            }
                            ?>
                        </datalist>
                        <select name="CustomerAdd" id="CustomerAdd" class="form-control rounded-0 col-2">
                            <option value="御中">御中</option>
                            <option value="様">様</option>
                        </select>
                    </div>
                </td>
            </tr>
            <tr>
                <td class="table-success col-2">事業名<span class="required_item">必須</span></td>
                <td>
                    <input type="text" id="TitleName" name="TitleName" required class="form-control rounded-0">
                </td>
            </tr>
            <tr>
                <td class="table-success col-2">場所</td>
                <td>
                    <input type="text" id="Location" name="Location" class="form-control rounded-0">
                </td>
            </tr>
            <tr>
                <td class="table-success col-2">実施日</td>
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
                <td class="table-success col-2">支払期日</td>
                <td>
                    <input type="text" id="PaymentDueDate" name="PaymentDueDate" class="datepicker form-control rounded-0">
                    <span class="col-form-label">未記入の場合、発行日より45日以内</span>
                </td>
            </tr>
            <tr>
                <td class="table-success col-2">記載振込先<span class="required_item">必須</span></td>
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
                <td class="table-success col-2">消費税率</td>
                <td>
                    <select name="Tax" id="Tax" class="form-control rounded-0 col-2">
                        <option value="0.1" selected>10%</option>
                        <option value="0.08">8%</option>
                        <option value="1.1">内税(10%)</option>
                        <option value="1.08">内税(8%)</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td class="table-success col-2">入金日</td>
                <td>
                    <input type="text" id="PaymentDate" name="PaymentDate" class="datepicker form-control rounded-0">
                </td>
            </tr>
        </tbody>
    </table>

    <table class="table table-hover table-borderless ctable">
        <tbody>
            <tr>
                <td class="table-success col-2">備考</td>
                <td>
                    <textarea id="Remark" name="Remark" class="form-control rounded-0"></textarea>
                </td>
            </tr>
            <tr>
                <td class="table-success col-2">メモ</td>
                <td>
                    <textarea id="Memo" name="Memo" class="form-control rounded-0"></textarea>
                    <span class="col-form-label">この項目は印刷されません</span>
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
        array("56", "57", "58", "59"), //15
        array("60", "61", "62", "63") //16非表示
    );

    ?>
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
            <?php $celnum = (float)-1; ?>
            <?php foreach ($table as $row) : ?>
                <tr>
                    <?php $celnum = $celnum + 1; ?>
                    <td class="px-1 input-group">
                        <img class="px-1" src="https://icongr.am/clarity/bars.svg?size=30&color=currentColor" alt="line">
                        <input class="lists form-control rounded-0" type="text" name="<?= 'InputItems' . $celnum; ?>" id="<?= 'InputItems' . $celnum; ?>">
                    </td>
                    <?php $celnum = $celnum + 1; ?>
                    <td class="px-1 col-2">
                        <input class="lists form-control rounded-0" type="number" step="0.001" name="<?= 'InputItems' . $celnum; ?>" id="<?= 'InputItems' . $celnum; ?>">
                    </td>
                    <?php $celnum = $celnum + 1; ?>
                    <td class="px-1 col-2">
                        <input class="lists form-control rounded-0" type="text" name="<?= 'InputItems' . $celnum; ?>" id="<?= 'InputItems' . $celnum; ?>">
                    </td>
                    <?php $celnum = $celnum + 1; ?>
                    <td class="px-1 col-2">
                        <input class="lists form-control rounded-0" type="number" step="0.001" name="<?= 'InputItems' . $celnum; ?>" id="<?= 'InputItems' . $celnum; ?>">
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div style="width:100%; margin:0 auto;;text-align:center;">
        <button class="btn btn-secondary rounded-0 btn-sm px-4 mb-5" onclick="">入力内容を確認する</button>
        <input type="hidden" name="sbmtype" value="3">
    </div>
</form>