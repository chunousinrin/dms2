<?php
$sql = "SELECT bill.*,classication.Name FROM bill LEFT JOIN classication ON bill.classicationId=classication.Id WHERE BillNumber = '" . $_POST['SerialNumber'] . "'";
$stmt = $dbh->query($sql);
$result = $stmt->fetch();

$sql3 = "SELECT sum( IF( (Quantity <> 0) AND(UnitPrice <> 0), Quantity * UnitPrice, IF( (UnitPrice <> 0) AND(Quantity = 0), UnitPrice, NULL ) )) AS price, Tax FROM bill WHERE BillNumber = {$_POST['SerialNumber']} GROUP BY Tax;";
$stmt3 = $dbh->query($sql3);
$subtotal = $stmt3->fetch();
if ($subtotal['Tax'] == 1.1 | $subtotal['Tax'] == 1.08) {
    $sumprice = $subtotal['price'];
} elseif ($subtotal['Tax'] == 0.1 | $subtotal['Tax'] == 0.08) {
    $sumprice = floor($subtotal['price'] * (1 + $subtotal['Tax']));
} else {
    $sumprice = 0;
}
?>
<form action="" method="post" name="f_list">
    @csrf
    <div class="tabs">
        <input id="tab1" type="radio" name="doctype">
        <label class="doctype py-1" for="tab1">概要</label>

        <input id="tab2" type="radio" name="doctype" checked>
        <label class="doctype py-1" for="tab2">入金 / 備考</label>

        <input id="tab3" type="radio" name="doctype">
        <label class="doctype py-1" for="tab3">明細</label>

        <!--tab1-->
        <div class="tab_content" id="tab1_content">
            <table class="table table-hover table-borderless ctable">
                <tbody>
                    <tr>
                        <td class="table-success col-sm-2">請求番号</td>
                        <td class="bg-white">
                            <?= $result['BillNumber'] ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="table-success col-sm-2">事業分類</td>
                        <td class="bg-white">
                            <?php
                            $sql = "SELECT * FROM classication WHERE Id = " . $result['classicationId'];
                            $stmt = $dbh->query($sql);
                            $bclass = $stmt->fetch();
                            ?>
                            <?= $bclass['Name'] ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="table-success col-sm-2">発行日</td>
                        <td class="bg-white">
                            <?php
                            if ($result['CDDisplay'] == 1) {
                                echo $result['CreatedDate'];
                            } else {
                                echo $result['CreatedDate'] . " (非表示)";
                            }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="table-success col-sm-2">発行者</td>
                        <td class="bg-white">
                            <?php
                            $sql2 = "SELECT * FROM company WHERE BranchId = " .  $result['Branch'];
                            $stmt2 = $dbh->query($sql2);
                            $shisho = $stmt2->fetch();
                            ?>
                            <?= $shisho['BranchName'] . "　" . $shisho['Representative']; ?><br>
                            <?php
                            if ($result['StaffDisplay'] == 1) {
                                echo $result['UserName'];
                            } else {
                                echo $result['UserName'] . " (非表示)";
                            };
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="table-success col-sm-2">請求金額</td>
                        <td class="bg-white">
                            <?= number_format($sumprice) ?>
                        </td>
                    </tr>
                </tbody>
            </table>
            <hr>
            <table class="table table-hover table-borderless ctable">
                <tbody>
                    <tr>
                        <td class="table-success col-sm-2">取引先</td>
                        <td class="bg-white">
                            <?= $result['Customer'] . "　" . $result['CustomerAdd'] ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="table-success col-sm-2">事業名</td>
                        <td class="bg-white">
                            <?= $result['BizName'] ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="table-success col-sm-2">場所</td>
                        <td class="bg-white">
                            <?= $result['Location'] ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="table-success col-sm-2">実施日</td>
                        <td class="bg-white">
                            <?php echo $result['CompletionDate'];
                            if (!empty($result['CompletionDate2'])) {
                                echo "　～　" .  $result['CompletionDate'];
                            }
                            ?>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <!--tab2-->
        <div class="tab_content" id="tab2_content">
            <?php
            $sql = "SELECT bill.*,classication.Name FROM bill LEFT JOIN classication ON bill.classicationId=classication.Id WHERE BillNumber = '" . $_POST['SerialNumber'] . "'";
            $stmt = $dbh->query($sql);
            ?>

            <table class="table table-hover table-borderless ctable">
                <tbody>
                    <tr>
                        <td class="table-success col-sm-2">支払期日</td>
                        <td class="bg-white">
                            <?= $result['PaymentDueDate'] ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="table-success col-sm-2">記載振込先</td>
                        <td class="bg-white">
                            <?php
                            $banksql = "SELECT BankID,concat_ws(Char(9),BankName,BankBranch,AccountType,AccountNumber)as banks FROM bank WHERE BankID={$result['BankID1']} ORDER BY BankID ASC;";
                            $stbank1 = $dbh->query($banksql);
                            $bank1 = $stbank1->fetch();
                            ?>
                            １.<?= $bank1['banks'] ?><br>

                            <?php
                            $banksql = "SELECT BankID,concat_ws(Char(9),BankName,BankBranch,AccountType,AccountNumber)as banks FROM bank WHERE BankID={$result['BankID2']} ORDER BY BankID ASC;";
                            $stbank2 = $dbh->query($banksql);
                            $bank2 = $stbank2->fetch();
                            ?>
                            ２.<?= $bank2['banks'] ?><br>

                            <?php
                            $banksql = "SELECT BankID,concat_ws(Char(9),BankName,BankBranch,AccountType,AccountNumber)as banks FROM bank WHERE BankID={$result['BankID3']} ORDER BY BankID ASC;";
                            $stbank3 = $dbh->query($banksql);
                            $bank3 = $stbank3->fetch();
                            ?>
                            ３.<?= $bank3['banks'] ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="table-success col-sm-2">消費税率</td>
                        <td class="bg-white">
                            <?php
                            if ($result['Tax'] == 1.08) {
                                echo "内税(8%)";
                            } elseif ($result['Tax'] == 1.1) {
                                echo "内税(10%)";
                            } elseif ($result['Tax'] == 0.1) {
                                echo "10%";
                            } elseif ($result['Tax'] == 0.08) {
                                echo "8%";
                            }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="table-success col-sm-2">入金日<span class="required_item">更新可</span></td>
                        <td class="bg-white">
                            <input type="text" name="PaymentDate" class="datepicker form-control rounded-0" value="<?= $result['PaymentDate'] ?>">
                        </td>
                    </tr>
                </tbody>
            </table>
            <hr>
            <table class="table table-hover table-borderless ctable">
                <tbody>
                    <tr>
                        <td class="table-success col-sm-2">備考</td>
                        <td class="bg-white">
                            <?= nl2br($result['Remark']) ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="table-success col-sm-2">メモ<span class="required_item">更新可</span></td>
                        <td class="bg-white">
                            <textarea name="Memo" class="form-control rounded-0" rows="5"><?= ($result['Memo']) ?></textarea>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <!--tab3-->
        <div class="tab_content" id="tab3_content">
            <?php
            $detail_sql = "SELECT bill.*,classication.Name FROM bill LEFT JOIN classication ON bill.classicationId=classication.Id WHERE BillNumber = '" . $_POST['SerialNumber'] . "'";
            $detail_stmt = $dbh->query($detail_sql);
            ?>
            <table class="table table-sm table-hover table-bordered">
                <thead>
                    <tr class="table-success sticky-top">
                        <td class="text-center">摘要</td>
                        <td class="text-center">数量</td>
                        <td class="text-center">単位</td>
                        <td class="text-center">単価</td>
                        <td class="text-center">金額</td>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $subtotal = 0;
                    while ($detail = $detail_stmt->fetch(PDO::FETCH_BOTH)) { ?>
                        <tr>
                            <td class="bg-white px-2">
                                <?= $detail['Summary'] ?>&nbsp;
                            </td>
                            <td class="bg-white text-center col-sm-1">
                                <?php
                                if (!empty($detail['Quantity'])) {
                                    echo number_format($detail['Quantity']);
                                }
                                ?>
                            </td>
                            <td class="bg-white text-center col-sm-1">
                                <?= $detail['Unit'] ?>
                            </td>
                            <td class="bg-white text-right pr-2 col-sm-1">
                                <?php
                                if (!empty($detail['UnitPrice'])) {
                                    echo number_format($detail['UnitPrice']);
                                } ?>
                            </td>
                            <td class="bg-white text-right pr-2 col-sm-2">
                                <?php
                                if (!empty($detail['Quantity']) && !empty($detail['UnitPrice'])) {
                                    echo number_format($detail['Quantity'] * $detail['UnitPrice']);
                                    $subtotal = $subtotal + $detail['Quantity'] * $detail['UnitPrice'];
                                } elseif (empty($detail['Quantity']) && !empty($detail['UnitPrice'])) {
                                    echo number_format($detail['UnitPrice']);
                                    $subtotal = $subtotal + $detail['UnitPrice'];
                                }
                                ?>
                            </td>
                        </tr>
                    <?php }; ?>
                </tbody>
                <tfoot>
                    <?php
                    if ($result['Tax'] == 1.08 or $result['Tax'] == 1.1) {
                        $tax = bcsub($subtotal, bcdiv($subtotal, $result['Tax'], 3), 3);
                        $taxtitle = "内消費税";
                        $tax3 = 0;
                    } elseif ($result['Tax'] == 0.1 or $result['Tax'] == 0.08) {
                        $tax = bcmul($subtotal, $result['Tax'], 3);
                        $taxtitle = "消費税";
                        $tax3 = $tax;
                    }
                    if (bcsub($tax, bcsub($tax, 0, 0), 3) === "0.000") {
                        $tax2 = number_format($tax);
                    } else {
                        $tax2 = number_format($tax, 3);
                    }
                    ?>
                    <tr>
                        <td colspan="3" rowspan="3"></td>
                        <td class="table-success text-center">小計</td>
                        <td class="bg-white text-right pr-2"><?= number_format($subtotal ?? 0) ?></td>
                    </tr>
                    <tr>
                        <td class="table-success text-center">
                            <?php
                            if ($result['Tax'] == 0.08 | $result['Tax'] == 0.1) {
                                echo $taxtitle . "(" . $result['Tax'] * 100 . ")%";
                                $tax = $subtotal * $result['Tax'];
                            } elseif ($result['Tax'] == 1.08 | $result['Tax'] == 1.1) {
                                echo $taxtitle . "(" . ($result['Tax']  * 100) - 100  . ")%";
                            } ?>
                        </td>
                        <td class="bg-white text-right pr-2"><?= $tax2 ?></td>
                    </tr>
                    <tr>
                        <td class="table-success text-center">合計</td>
                        <td class="bg-white text-right pr-2"><?= number_format($subtotal +  $tax3) ?></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
    <input type="hidden" name="SerialNumber" value="<?= $_POST['SerialNumber'] ?>">
    <input type="hidden" name="sbmtype" value="9">

    <div style="width:100%;text-align:center;" class="pb-5">
        <input class="btn btn-secondary rounded-0 btn-sm px-4" type="button" name="btn_back" value="戻る" onclick="history.back()">
        <input class="btn btn-sm btn-secondary rounded-0 px-4" type="submit" value="請求書" formtarget="_blank" formaction="/bill/repreview">
        <input class="btn btn-sm btn-secondary rounded-0 px-4" type="submit" value="納品書" formtarget="_blank" formaction="/bill/deliveryslip/repreview">
        <button class="btn btn-secondary rounded-0 btn-sm px-4 " onclick="bprudt();">更新</button>
    </div>
</form>