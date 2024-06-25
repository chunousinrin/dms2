<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

    <title>請求書</title>
    <style>
        @page {
            size: A4;
            margin: 0;
        }

        * {
            margin: 0;
            padding: 0;
            font-size: 10pt;
            font-family: 'Noto Sans JP', sans-serif;
            font-weight: normal;
            color: black;
        }

        body,
        h1,
        ul,
        li,
        p {
            margin: 0;
            padding: 0;
        }

        body {
            background-color: rgba(2, 51, 40, 0.2);
            width: 100%;
            -webkit-print-color-adjust: exact;
            color-adjust: exact;
        }

        .wrap {
            width: 210mm;
            height: 297mm;
            box-sizing: border-box;
            background-color: white;
            margin: 3em auto;
            padding: 15mm;
            box-shadow: 0px 0px 15px -5px #777777;
            position: relative;
        }

        .hddate {
            height: 2em;
            line-height: 2em;
            text-align: right;
            padding-right: 0.5em;
            position: relative;
        }

        .address {
            border-collapse: collapse;
            width: 100%;
            margin: 5em 0;
        }

        .address tr td {
            vertical-align: top;
        }

        .address tr td:first-child {
            width: 63%;
        }

        .address tr td:last-child {
            width: 30%;
        }

        footer {
            position: absolute;
            width: calc(210mm - 30mm);
            bottom: 5em;
        }

        .office {
            list-style-type: none;
            display: flex;
        }

        .office li {
            width: 30%;
        }

        .office li:nth-child(2) {
            margin: 0 5%;
        }

        .office li div {
            font-size: 8.5pt;
        }

        .branchadd {
            width: 100%;
            text-align-last: justify;
        }

        .billhead {
            display: flex;
            margin-bottom: 3mm;
        }


        .billhead ul {
            list-style-type: none;
        }

        .billhead ul:first-child {
            width: 50%;
            margin-right: 10%
        }

        .billhead ul:last-child {
            width: 40%;
        }

        .otln {
            border-bottom: 1px solid silver;
            margin-bottom: 2mm;
            position: relative;
        }

        .otln span {
            width: 25mm;
            font-weight: bold;
            padding-left: 2mm;
            position: absolute;
            top: 50%;
            left: 0%;
            transform: translateY(-50%);
        }

        .otln div {
            margin-left: 26mm
        }

        .kumiai {
            position: relative;
            padding-left: 2mm;
        }

        .insho {
            position: absolute;
            top: 0;
            right: 2mm;
            width: 19mm;
            opacity: 0.65;
        }

        .summary {
            width: 100%;
            margin: 0 auto;
            border-collapse: collapse;
            border-spacing: 0;
        }

        .summary tr th,
        .summary tr td {
            border: 1px solid silver;
            height: 23pt;
            line-height: 23pt;
            padding: 0 1%;
        }

        .summary tbody tr td:first-child {
            line-height: 1em;
        }

        .summary tr th {
            background-color: rgba(112, 189, 41, 0.5) !important;
        }

        .summary tr td:nth-of-type(n+2):nth-of-type(-n+4) {
            text-align: center;
        }

        .summary tr td:last-child {
            text-align: right;
        }


        .billfoot {
            width: 180mm;
            display: flex;
        }

        .billfoot div {
            border: 1px solid silver;
        }

        .billfoot div:first-child {
            width: 30mm;
            background-color: rgba(112, 189, 41, 0.5) !important;
        }

        .billfoot div:last-child {
            border-left: none;
            width: 150mm;
            display: flex;
            position: relative;
        }

        .billfoot ul {
            list-style-type: none;
            padding: 0 5mm 0 2mm;
        }


        .billfoot div:last-child img {
            position: absolute;
            top: 0;
            bottom: 0;
            right: 2mm;
            height: 10mm;
            margin: auto;
        }

        .noprint {
            width: 100%;
            height: 4em;
            line-height: 4em;
            position: sticky;
            top: 0;
            left: 0;
            text-align: center;
            background-color: white;
            border-bottom: 3px solid lightseagreen;
            backdrop-filter: blur(1px);
            z-index: 1;
        }

        @media print {
            body {
                background: none;
            }

            .wrap {
                box-shadow: none;
                margin: 0 auto;
            }

            .noprint {
                display: none;
            }
        }
    </style>

    <?php
    $dbh = new PDO('mysql:host=localhost;dbname=' . env('DB_DATABASE') . ';charset=utf8', env('DB_USERNAME'), env('DB_PASSWORD'));
    ///////////////////////// 履歴抽出 /////////////////////////
    $sql = "SELECT *, IF( (Quantity <> 0) AND (UnitPrice <> 0), Quantity * UnitPrice, IF((UnitPrice <> 0 ) AND (Quantity = 0), UnitPrice, null) ) as bills FROM `bill` WHERE BillNumber = " . $_POST['SerialNumber'];
    $stmt = $dbh->query($sql);
    $result = $stmt->fetch();

    ///////////////////////// 支所表示 /////////////////////////
    $sql2 = "SELECT * FROM company WHERE BranchId = " . $result['Branch'];
    $stmt2 = $dbh->query($sql2);
    $shisho = $stmt2->fetch();

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
    @include('edt.wareki')
</head>

<body style="position: relative;">
    <div class="noprint">
        <input class="btn btn-sm btn-secondary rounded-0 px-5" type="button" value="印刷" onclick="window.print()">
        <input class="btn btn-sm btn-secondary rounded-0 px-5" type="button" name="btn_back" value="閉じる" onclick="window.close()">
        <!--<input class="btn btn-secondary rounded-0" type="submit" name="btn_submit" value="送信">-->
    </div>
    <div class="wrap">
        <header class="billhead">
            <ul>
                <li>
                    <h2 style="font-size: 13pt;font-weight:bold;text-align:justify;text-align-last:justify;padding:0 30mm;border-bottom:3px double black;margin-bottom:5mm;">御請求書</h2>
                    <h3 style="font-size: 13pt;border-bottom:1px solid black;padding-left: 2mm;">
                        <?php echo $result['Customer'] . "　" . $result['CustomerAdd']; ?>
                    </h3>
                    <div style="margin-bottom: 5mm;padding-left: 2mm;">下記のとおり、ご請求申し上げます。</div>
                    <div class="otln">
                        <span>
                            <?php
                            if ($result['classicationId'] == 15) {
                                echo "件名";
                            } else {
                                echo "事業名";
                            }
                            ?>
                        </span>
                        <div><?php echo $result['BizName']; ?></div>
                    </div>
                    <div class="otln">
                        <span>
                            <?php
                            if ($result['classicationId'] == 15) {
                                echo "納入場所";
                            } else {
                                echo "場所";
                            }
                            ?>
                        </span>
                        <div><?php echo $result['Location'] . "&nbsp;" ?></div>
                    </div>
                    <?php
                    if ($result['classicationId'] == 15) {
                        echo "<div class='otln' style='margin-bottom: 5mm;border:none;'><span></span><div>　</div></div>";
                    } else {
                        echo "<div class='otln' style='margin-bottom: 5mm;'>"
                            . "<span>実施日</span>"
                            . "<div>";
                        if (!empty($result['CompletionDate'])) {
                            echo wareki(substr($result['CompletionDate'], 0, 4)) . substr($result['CompletionDate'], 5, 2) . '月' . substr($result['CompletionDate'], 8, 2) . '日';
                        }
                        if (!empty($result['CompletionDate2'])) {
                            echo " ～ " . wareki(substr($result['CompletionDate2'], 0, 4)) . substr($result['CompletionDate2'], 5, 2) . '月' . substr($result['CompletionDate2'], 8, 2) . '日';
                        }
                        echo "&nbsp;";
                        echo "</div></div>";
                    }
                    ?>
                    <div style="font-size: 13pt;font-weight:800;border-bottom:2px solid black;padding-left: 2mm;">
                        <span style="display:inline-block;width:25mm;font-size:11pt;">合計金額</span>
                        <?php echo "￥" . number_format($sumprice) . " -"; ?>
                    </div>
                    <div style="padding-left: 2mm;">
                        <?php if (empty($result['PaymentDueDate'])) {
                            echo "お支払期日：ご請求日より45日以内";
                        } else {
                            echo "お支払期日：" . wareki(substr($result['PaymentDueDate'], 0, 4)) . substr($result['PaymentDueDate'], 5, 2) . '月' . substr($result['PaymentDueDate'], 8, 2) . '日';
                        }
                        ?>
                    </div>
                </li>
            </ul>

            <ul>
                <li>
                    <div class="otln"><span>請求番号</span>
                        <div><?php echo $result['BillNumber']; ?></div>
                    </div>
                    <div class="otln" style="margin-bottom: 5mm;"><span>発行日</span>
                        <div>
                            <?php
                            if ($result['CDDisplay'] == 1) {
                                echo wareki(substr($result['CreatedDate'], 0, 4)) . substr($result['CreatedDate'], 5, 2) . '月' . substr($result['CreatedDate'], 8, 2) . '日';
                            } else {
                                echo "　　年　　月　　日";
                            } ?>
                        </div>
                    </div>
                    <div class="kumiai">
                        <h4 style="font-size: 13pt;margin-bottom:2mm;"><?php echo $shisho['BranchName']; ?><br><?php echo $shisho['Representative']; ?></h4>
                        <?php print '<img class="insho" alt="印章" src="data:images/png;base64,' . base64_encode($shisho['SignatureStamp']) . '" >'; ?>
                        <div style="margin-bottom: 2mm;">登録番号：<?= $shisho['InvoiceNo'] ?></div>
                        <div>〒<?php echo $shisho['PostCode']; ?></div>
                        <div><?php echo $shisho['Address']; ?></div>
                        <div>Tel.<?php echo $shisho['Phone']; ?></div>
                        <div>Fax.<?php echo $shisho['Fax']; ?></div>
                        <?php
                        if ($result['StaffDisplay'] == 1) {
                            echo "担当者：" . $result['UserName'];
                        };
                        ?>
                    </div>
                </li>
            </ul>
        </header>
        <main>
            <table class="summary">
                <thead>
                    <tr>
                        <th style='width: 50%;text-align:justify;text-align-last:justify;padding:0 30mm'>
                            <?php
                            $stmt = $dbh->query($sql);
                            if ($result['classicationId'] == 15) {
                                echo "品名";
                            } else {
                                echo "摘要";
                            }
                            ?>
                        </th>
                        <th style='width: 12.5%;text-align:center;'>数量</th>
                        <th style='width: 12.5%;text-align:center;'>単位</th>
                        <th style='width: 12.5%;text-align:center;'>単価</th>
                        <th style='width: 12.5%;text-align:center;'>金額</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sum_price = 0;
                    while ($result = $stmt->fetch(PDO::FETCH_BOTH)) {
                    ?>
                        <tr>
                            <td style='position:relative;'>
                                <?php
                                echo $result['Summary'];
                                if ($result['Tax'] == 0.08 | $result['Tax'] == 1.08) {
                                    if (!empty($result['Summary'])) {
                                        echo "<p style='position:absolute;top:0.3em;right:0.3em;font-size:10pt;'>*</p>";
                                    }
                                }
                                ?>
                            </td>
                            <td>
                                <?php
                                if (empty($result['Quantity'])) {
                                    echo "";
                                } else {
                                    if ($result['Quantity'] - $result['Quantity'] === 0) {
                                        echo number_format($result['Quantity'], 0);
                                    } else {
                                        echo $result['Quantity'];
                                    }
                                }
                                ?>
                            </td>
                            <td><?= $result['Unit'] ?></td>
                            <td>
                                <?php
                                if (empty($result['UnitPrice'])) {
                                    echo "";
                                } else {
                                    if ($result['UnitPrice'] - $result['UnitPrice'] === 0) {
                                        echo number_format($result['UnitPrice'], 0);
                                    } else {
                                        echo $result['UnitPrice'];
                                    }
                                }
                                ?>
                            </td>
                            <td>
                                <?php
                                if (!empty($result['Quantity']) && !empty($result['UnitPrice'])) {
                                    $price = bcmul($result['Quantity'], $result['UnitPrice'], 3);
                                } elseif (empty($result['Quantity']) && !empty($result['UnitPrice'])) {
                                    $price = $result['UnitPrice'];
                                } else {
                                    $price = null;
                                }
                                if (empty($price)) {
                                    echo "";
                                } elseif (bcsub($price, floor($price), 3) === "0.000") {
                                    echo number_format($price);
                                } else {
                                    echo number_format($price, 3);
                                }
                                $sum_price = $sum_price + $result['bills']; ?>
                            </td>
                        </tr>
                    <?php }
                    $stmt = $dbh->query($sql);
                    $result = $stmt->fetch();
                    ?>

                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                </tbody>
                <tfoot>
                    <?php
                    if ($result['Tax'] == 1.08 or $result['Tax'] == 1.1) {
                        $tax = bcsub($sum_price, bcdiv($sum_price, $result['Tax'], 3), 3);
                        $taxtitle = "(内消費税)";
                    } elseif ($result['Tax'] == 0.1 or $result['Tax'] == 0.08) {
                        $tax = bcmul($sum_price, $result['Tax'], 3);
                        $taxtitle = "消費税";
                    }
                    ?>
                    <tr>
                        <td colspan="2" rowspan="3" style="border:none;vertical-align:top;">
                            <div style="height:2em;line-height:2em;">備考：
                                <?php if ($result['Tax'] == 0.08 or $result['Tax'] == 1.08) {
                                    echo "*は軽減税率対象です。";
                                } ?>
                            </div>
                            <?php echo "<div style='line-height:1em;max-height:0;'>" . ($result['Remark']) . "</div>" ?>
                        </td>
                        <th>10%対象</th>
                        <td style="text-align: right;">
                            <?php
                            if ($result['Tax'] == 1.1 or $result['Tax'] == 0.1) {
                                if (bcsub(bcadd($sum_price, 0, 3), bcadd($sum_price, 0, 0), 3) == 0.000) {
                                    echo number_format($sum_price);
                                } else {
                                    echo number_format($sum_price, 3);
                                }
                            }
                            ?>
                        </td>
                        <td style="text-align: right;position:relative;">
                            <div style='font-size:6px;position:absolute;top:5px;left:0;line-height:6px'><?= $taxtitle ?></div>
                            <div style='font-size:7pt'>
                                <?php
                                if ($result['Tax'] == 1.1 or $result['Tax'] == 0.1) {
                                    if (bcsub(bcadd($tax, 0, 3), bcadd($tax, 0, 0), 3) == 0.000) {
                                        echo number_format($tax);
                                    } else {
                                        echo number_format($tax, 3);
                                    }
                                }
                                ?>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th>8%対象</th>
                        <td style="text-align: right;">
                            <?php
                            if ($result['Tax'] == 1.08 or $result['Tax'] == 0.08) {
                                if (bcsub(bcadd($sum_price, 0, 3), bcadd($sum_price, 0, 0), 3) == 0.000) {
                                    echo number_format($sum_price);
                                } else {
                                    echo number_format($sum_price, 3);
                                }
                            }
                            ?>
                        </td>
                        <td style="text-align: right;position:relative;">
                            <div style='font-size:6px;position:absolute;top:5px;left:0;line-height:6px'><?= $taxtitle ?></div>
                            <div style='font-size:7pt'>
                                <?php
                                if ($result['Tax'] == 1.08 or $result['Tax'] == 0.08) {
                                    if (bcsub(bcadd($tax, 0, 3), bcadd($tax, 0, 0), 3) == 0.000) {
                                        echo number_format($tax);
                                    } else {
                                        echo number_format($tax, 3);
                                    }
                                }
                                ?>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th>合計</th>
                        <td style="text-align: right;">
                            <?php
                            if (bcsub(bcadd($sum_price, 0, 3), bcadd($sum_price, 0, 0), 3) == 0.000) {
                                echo number_format($sum_price);
                            } else {
                                echo number_format($sum_price, 3);
                            }
                            ?>
                        </td>
                        <td style="text-align: right;position:relative;font-size:7px;">
                            <div style="font-size:6px;position:absolute;top:5px;left:0;line-height:6px"><?= $taxtitle ?></div>
                            <div style="font-size: 7pt;">
                                <?php
                                if (bcsub(bcadd($tax, 0, 3), bcadd($tax, 0, 0), 3) == 0.000) {
                                    echo number_format($tax);
                                } else {
                                    echo number_format($tax, 3);
                                }
                                ?>
                            </div>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </main>
        <footer class="billfoot">
            <div style="display:flex;align-items:center;"><span style="padding-left:2mm;">振込口座</span></div>
            <div>
                <?php
                $bank1sql = "SELECT * FROM bank WHERE BankID={$result['BankID1']}";
                $stbank1 = $dbh->query($bank1sql);
                $bank1 = $stbank1->fetch();
                $bank2sql = "SELECT * FROM bank WHERE BankID={$result['BankID2']}";
                $stbank2 = $dbh->query($bank2sql);
                $bank2 = $stbank2->fetch();
                $bank3sql = "SELECT * FROM bank WHERE BankID={$result['BankID3']}";
                $stbank3 = $dbh->query($bank3sql);
                $bank3 = $stbank3->fetch();
                ?>
                <ul>
                    <li><?= $bank1['BankName'] ?></li>
                    <li><?= $bank2['BankName'] ?></li>
                    <li><?= $bank3['BankName'] ?></li>
                </ul>
                <ul>
                    <li><?= $bank1['BankBranch'] ?></li>
                    <li><?= $bank2['BankBranch'] ?></li>
                    <li><?= $bank3['BankBranch'] ?></li>
                </ul>
                <ul>
                    <li><?= $bank1['AccountType'] ?></li>
                    <li><?= $bank2['AccountType'] ?></li>
                    <li><?= $bank3['AccountType'] ?></li>
                </ul>
                <ul>
                    <li><?= $bank1['AccountNumber'] ?></li>
                    <li><?= $bank2['AccountNumber'] ?></li>
                    <li><?= $bank3['AccountNumber'] ?></li>
                </ul>
                <?php
                $jfsql = "SELECT * FROM conf_jforestlogo WHERE 1";
                $jfst = $dbh->query($jfsql);
                $jforest = $jfst->fetch();
                $company_sql = "SELECT * FROM company WHERE BranchId = 1";
                $company_st = $dbh->query($company_sql);
                $company = $company_st->fetch();
                ?>
                <div style="width: 103px;border:none;position:absolute;right:2mm;top:50%;transform:translateY(-50%);display:block;box-sizing:border-box">
                    <?php print '<img style="width:100%;height:auto;position: relative !important;right:0;" src="data:image/svg+xml;base64,' . base64_encode($jforest['JforestColor']) . '" >'; ?>
                    <span style="display: block;width:100%;background-color:#70bd29;color:white;font-size:6pt;text-align-last:justify;padding:0 2em;margin-top:0.5em;"><?= $company['BranchName'] ?></span>
                    <!--<img src="/images/head_logo.svg" alt="">-->
                </div>
            </div>
        </footer>
    </div>
</body>

</html>