@extends('adminlte::page')

@section('title', '中濃森林組合　-見積書-')

@section('content_header')

<?php $billnum = "12" . time()             ?>

<?php

use Illuminate\Support\Facades\Auth;

$user = Auth::user();
$dbh = new PDO('mysql:host=localhost;dbname=dms;charset=utf8', 'root', '');
$e2bsql = "SELECT * FROM estimate WHERE EstimateNumber = " . $_POST['SerialNumber'];
$ste2b = $dbh->query($e2bsql);
$e2b = $ste2b->fetch();
var_dump($_POST)
?>

<h1>見積書　→　請求書</h1>
@stop

@section('content')

<form action="/bill/conf" method="post">
    @csrf
    <ul class="lst">
        <li></li>
        <li>
            <div class="lbl">
                <label for="bclass">事業分類<span class="hissu">必須</span></label>
            </div>
            <div class="ipt">
                <select id="bclass" name="bclass" onchange="creg()" required>
                    <?php
                    $chsql = "SELECT * FROM classication WHERE Id = " . $e2b['classicationId'];
                    $stch = $dbh->query($chsql);
                    $ch = $stch->fetch();
                    echo "<option value='" . $ch['Id'] . "' hidden selected>" . $ch['Name'] . "</option>";
                    $csql = "SELECT * FROM classication ORDER BY Id ASC";
                    $stc = $dbh->query($csql);
                    while ($classication = $stc->fetch(PDO::FETCH_BOTH)) {
                        echo "<option value='" . $classication['Id'] . "'>" . $classication['Name'] . "</option>";
                    };
                    ?>
                </select>
            </div>
        </li>
        <li>
            <div class="lbl">
                <label for="uname">作成者</label>
            </div>
            <div class="ipt" style="display:flex">
                <input style="width:3em;outline:none;border:1px solid rgba(112, 189, 41, 1);border-right:none;text-align:center" type="text" id="b00x1" name="uid" value=<?= $e2b['UserID']; ?> readonly>
                <input style="width:100%;outline:none;border:1px solid rgba(112, 189, 41, 1);border-left:none;" type="text" id="b00x2" name="uname" value="<?= $e2b['UserName']; ?>" readonly>
            </div>
        </li>

        <li>
            <div class="lbl">
                <label for="b01">発行日<span class="hissu">必須</span></label>
            </div>
            <div class="ipt">
                <input type="text" id="b01" name="bill_day" value="<?= $e2b['CreatedDate'] ?>" required class="iptdt">
                <label for="b16x1">表示</label>
                <?php
                if ($e2b['CDDisplay'] == 1) {
                    echo "<input type='radio' id='b01x1' name='cddisplay' value='1' checked>";
                    echo "<label for='b16x2'>非表示</label>";
                    echo "<input type='radio' id='b01x2' name='cddisplay' value='0'>";
                } else {
                    echo "<input type='radio' id='b01x1' name='cddisplay' value='1'>";
                    echo "<label for='b16x2'>非表示</label>";
                    echo "<input type='radio' id='b01x2' name='cddisplay' value='0' checked>";
                }
                ?>
            </div>
        </li>
        <li>
            <div class="lbl">
                <label for="bill_shisho">発行者</label>
            </div>
            <div class="ipt">
                <div>
                    <?php
                    if ($e2b['Branch'] == 1) {
                        echo "<input type='radio' id='b02x1' name='bill_shisho' value='1' checked>";
                        echo "<label for='b02x1'>美濃本所</label>";
                        echo "</div><div>";
                        echo "<input type='radio' id='b02x2' name='bill_shisho' value='2'>";
                        echo "<label for='b02x2'>津保川支所</label>";
                    } elseif ($e2b['Branch'] == 2) {
                        echo "<input type='radio' id='b02x1' name='bill_shisho' value='1'>";
                        echo "<label for='b02x1'>美濃本所</label>";
                        echo "</div><div>";
                        echo "<input type='radio' id='b02x2' name='bill_shisho' value='2' checked>";
                        echo "<label for='b02x2'>津保川支所</label>";
                    }
                    ?>
                </div>
            </div>
        </li>
        <li>
            <div class="lbl">
                <label for="tanto">担当者</label>
            </div>
            <div class="ipt">
                <div>
                    <?php
                    if ($e2b['StaffDisplay'] == 1) {
                        echo "<input type='radio' id='b00x3' name='tanto' value='1' checked>";
                        echo "<label for='b00x3'>表示</label>";
                        echo "</div><div>";
                        echo "<input type='radio' id='b00x4' name='tanto' value='2'>";
                        echo "<label for='b00x4'>非表示</label>";
                    } elseif ($e2b['StaffDisplay'] == 2) {
                        echo "<input type='radio' id='b00x3' name='tanto' value='1'>";
                        echo "<label for='b00x3'>表示</label>";
                        echo "</div><div>";
                        echo "<input type='radio' id='b00x4' name='tanto' value='2' checked>";
                        echo "<label for='b00x4'>非表示</label>";
                    }
                    ?>
                </div>
            </div>
        </li>
        <li>
            <div class="lbl">
                <label for="b03">請求番号</label>
            </div>
            <div class="ipt">
                <input type="text" id="b03" name="bill_num" value=<?= $billnum ?> readonly>
            </div>
        </li>
        <li>
            <div class="lbl">
                <label for="b04">事業名<span class="hissu">必須</span></label>
            </div>
            <div class="ipt">
                <input type="text" id="b04" name="bill_bizname" value="<?= $e2b['EstimateName'] ?>" required>
            </div>
        </li>
        <li>
            <div class="lbl">
                <label for="bill_cstmr_unreg">取引先(未登録)</label>
            </div>
            <div class="ipt">
                <input type="text" id="b05" name="bill_cstmr_unreg" onchange="uncreg()" value="<?= $e2b['Customer'] ?>">
            </div>
        </li>
        <li>
            <div class="lbl">
                <label for="bill_cstmr_reg">取引先(登録済)</label>
            </div>
            <div class="ipt">
                <?php
                $pdo = new PDO('mysql:host=localhost;dbname=dms;charset=utf8', 'root', '');
                $sql = "SELECT * FROM customer ORDER BY CustomerID ASC";
                $stmh = $pdo->prepare($sql);
                $stmh->execute();
                ?>
                <select id="b06" name="bill_cstmr_reg" onchange="creg()">
                    <option value="" disabled selected>-- 選択してください --</option>
                    <?php
                    while ($row = $stmh->fetch(PDO::FETCH_ASSOC)) {
                        echo '<option value="' . $row['CustomerID'] . '">' . $row['name'] . '</option>';
                    }
                    $pdo = null;
                    ?>
                </select>
                <a href="https://dms.chunousinrin.com/customer/reg">新規登録</a>
            </div>
        </li>
        <li style="display: none;">
            <label for="">取引先</label>
            <input type="text" id="b07x1" name="bill_cstmrid" value="<?= $e2b['CustomerID'] ?>">
            <input type="text" id="b07x2" name="bill_cstmr" value="<?= $e2b['Customer'] ?>" required>
        </li>
        <li>
            <div class="lbl">
                <label for="bill_atena">敬称</label>
            </div>
            <div class="ipt">
                <select name="bill_atena" id="b08">
                    <?php
                    echo "<option value=" . $e2b['CustomerAdd'] . " hidden selected>" . $e2b['CustomerAdd'] . "</option>";
                    ?>
                    <option value="御中">御中</option>
                    <option value="様">様</option>
                </select>
            </div>
        </li>
        <li>
            <div class="lbl">
                <label for="bill_lctn">場所</label>
            </div>
            <div class="ipt">
                <input type="text" id="b09" name="bill_lctn" value="<?= $e2b['Location'] ?>">
            </div>
        </li>
        <li>
            <div class="lbl">
                <label for="">実施日</label>
            </div>
            <div class="ipt" style="display:flex;">
                <input type="text" id="b10" name="bill_cmpday" class="iptdt">
                <label style="padding:0 2em;height:2em;line-height:2em;" for="">～</label>
                <input type="text" id="b10x2" name="bill_cmpday2" class="iptdt">
            </div>
        </li>

        <li style="">
            <div class="lbl">
                <label for="">記載振込先<span class="hissu">必須</span></label>
            </div>

            <div class="ipt">
                <div class="ipt" style="display:flex;margin-bottom:1em"> １.&nbsp;
                    <select name="bill_bankid1" id="bill_bankid1" required>
                        <?php
                        $dbh = new PDO('mysql:host=localhost;dbname=dms;charset=utf8', 'root', '');
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
                    </select>
                </div>
                <div class="ipt" style="display:flex;margin-bottom:1em"> ２.&nbsp;
                    <select name="bill_bankid2" id="bill_bankid2" required>
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
                    </select>
                </div>
                <div class="ipt" style="display:flex;margin-bottom:1em"> ３.&nbsp;
                    <select name="bill_bankid3" id="bill_bankid3" required>
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
                    </select>
                </div>
            </div>
        </li>


        <li>
            <div class="lbl">
                <label for="">支払期日</label>
            </div>
            <div class="ipt">
                <input type="text" id="b11" name="bill_pay_due" class="iptdt"><br>
                <span>未記入の場合、発行日より45日以内</span>
            </div>
        </li>
        <li>
            <div class="lbl">
                <label for="">入金日</label>
            </div>
            <div class="ipt">
                <input type="text" id="b12" name="bill_payment" class="iptdt">
            </div>
        </li>
        <li>
            <div class="lbl">
                <label for="">消費税率</label>
            </div>
            <div class="ipt">
                <div>
                    <?php
                    if ($e2b['Tax'] == 0.10) {
                        echo "<input type='radio' id='b13x1' name='bill_tax' value='0.1' checked>";
                        echo "<label for='b13x1'>10%</label>";
                        echo "</div><div>";
                        echo "<input type='radio' id='b13x2' name='bill_tax' value='0.08'>";
                        echo "<label for='b13x2'>8%</label>";
                    } elseif ($e2b['Tax'] == 0.08) {
                        echo "<input type='radio' id='b13x1' name='bill_tax' value='0.1'>";
                        echo "<label for='b13x1'>10%</label>";
                        echo "</div><div>";
                        echo "<input type='radio' id='b13x2' name='bill_tax' value='0.08' checked>";
                        echo "<label for='b13x2'>8%</label>";
                    }
                    ?>
                </div>
            </div>
        </li>
        <li>
            <div class="lbl">
                <label for="">備考</label>
            </div>
            <div class="ipt">
                <?php
                echo "<textarea id='b14' rows='5' style='height:10em;' name='bill_remark'>" . $e2b['Remark'] . "</textarea>";
                ?>
            </div>
        </li>
        <li>
            <div class="lbl">
                <label for="">メモ</label>
            </div>
            <div class="ipt">
                <?php
                echo "<textarea id='b15' rows='5' style='height:10em;' name='bill_memo'>" . "見積番号：" . $e2b['EstimateNumber'] . "\n" . $e2b['Memo'] . "</textarea>";
                ?>
                <br><span>この項目は印刷されません</span>
            </div>
        </li>
    </ul>

    <hr>

    <div class="msipt">
        <table>
            <thead>
                <tr>
                    <th></th>
                    <th>摘要</th>
                    <th>数量</th>
                    <th>単位</th>
                    <th>単価</th>
                </tr>
            </thead>
            <tbody id="items">
                <?php
                $cel = 0;
                $e2bsql = "SELECT * FROM estimate WHERE EstimateNumber = " . $_POST['SerialNumber'];
                $ste2b = $dbh->query($e2bsql);
                while ($result = $ste2b->fetch(PDO::FETCH_ASSOC)) {
                    echo "<tr>";
                    echo "<td class='line'></td>";
                    $cel = $cel;
                    echo "<td><input class='lists' type='text' name='blipt" . $cel . "' id='blipt" . $cel . "' value='" . $result['Summary'] . "'></td>";
                    $cel = $cel + 1;
                    echo "<td><input class='lists' type='text' name='blipt" . $cel . "' id='blipt" . $cel . "' value='" . $result['Quantity'] . "'></td>";
                    $cel = $cel + 1;
                    echo "<td><input class='lists' type='text' name='blipt" . $cel . "' id='blipt" . $cel . "' value='" . $result['Unit'] . "'></td>";
                    $cel = $cel + 1;
                    echo "<td><input class='lists' type='text' name='blipt" . $cel . "' id='blipt" . $cel . "' value='" . $result['UnitPrice'] . "'></td>";
                    $cel = $cel + 1;
                    echo "</tr>";
                };
                ?>
                <tr>
                    <td><input class='lists' type='text' name='blipt60' id='blipt60' value=''></td>
                    <td><input class='lists' type='text' name='blipt61' id='blipt61' value=''></td>
                    <td><input class='lists' type='text' name='blipt62' id='blipt63' value=''></td>
                    <td><input class='lists' type='text' name='blipt63' id='blipt63' value=''></td>
                </tr>
            </tbody>

        </table>
    </div>
    <div style="width:100%; margin:0 auto;padding:10px 0;text-align:center;">
        <button class="btn btn-secondary rounded-0" type="submit" name="btn_confirm" value="入力内容を確認する">入力内容を確認する</button>
    </div>
</form>
@stop

@section('js')

@stop