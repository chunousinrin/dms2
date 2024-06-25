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

    <title>見積書</title>
    <style>
        @page {
            size: A4;
            margin: 0;
        }

        * {
            margin: 0;
            padding: 0;
            font-size: 9pt;
            font-family: 'Noto Sans JP', sans-serif;
            font-weight: normal;
            color: black;
        }

        body,
        h1,
        ul,
        li,
        p,
        br {
            margin: 0;
            padding: 0;
        }

        br {
            height: 0;
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
            width: 20mm;
            font-weight: bold;
            padding-left: 2mm;
            position: absolute;
            top: 50%;
            left: 0%;
            transform: translateY(-50%);
        }

        .otln div {
            margin-left: 21mm
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
            height: 20pt;
            line-height: 20pt;
            padding: 0 1%;
        }

        .summary tbody tr td:first-child {
            line-height: 1em;
        }

        .summary tr th {
            background-color: rgba(112, 189, 41, 0.5) !important;
        }

        .summary tr td:nth-of-type(n+2):nth-of-type(-n+3) {
            text-align: center;
        }

        .summary tr td:nth-of-type(n+4):nth-of-type(-n+5) {
            text-align: right;
            padding: 0 0.5%;
        }

        .summary tr td:last-child {
            text-align: left;
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

    @include('edt.wareki')
    <?php
    $dbh = new PDO('mysql:host=localhost;dbname=' . env('DB_DATABASE') . ';charset=utf8', env('DB_USERNAME'), env('DB_PASSWORD'));
    ///////////////////////// 履歴全体抽出 /////////////////////////
    $es2smrsql = "SELECT * FROM estimate2 LEFT JOIN company ON estimate2.Branch = company.BranchId WHERE Es2Number =" . $_POST['SerialNumber'];
    $stes2smr = $dbh->query($es2smrsql);
    $es2smr = $stes2smr->fetch(); //単発表示
    $memo = $es2smr['NB'];

    ///////////////////////// 履歴合計抽出 /////////////////////////
    $es2ttlsql = "SELECT SUM(estimate2.Amount) AS Amount FROM estimate2 WHERE Es2Number=" . $_POST['SerialNumber'] . " && Summary not IN('工事原価' , '直接作業代小計');";
    $stes2ttl = $dbh->query($es2ttlsql);
    $es2ttl = $stes2ttl->fetch(); //単発表示

    ?>
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
                    <h2 style="font-size: 13pt;font-weight:bold;text-align:justify;text-align-last:justify;padding:0 30mm;border-bottom:3px double black;margin-bottom:5mm;">御見積書</h2>
                    <h3 style="font-size: 13pt;border-bottom:1px solid black;padding-left: 2mm;">
                        <?php echo $es2smr['Customer'] . "　" . $es2smr['CustomerAdd']; ?>
                    </h3>
                    <div style="margin-bottom: 5mm;padding-left: 2mm;">下記のとおり、御見積申し上げます。</div>
                    <div class="otln">
                        <span>
                            <?php
                            if ($es2smr['classicationId'] == 15) {
                                echo "件名";
                            } else {
                                echo "業務名称";
                            }
                            ?>
                        </span>
                        <div>
                            <?php
                            if (!empty($es2smr['Es2BizName'])) {
                                echo $es2smr['Es2BizName'];
                            } else {
                                echo "&nbsp;";
                            } ?>
                        </div>
                    </div>
                    <div class="otln">
                        <span>
                            <?php
                            if ($es2smr['classicationId'] == 15) {
                                echo "納入場所";
                            } else {
                                echo "業務場所";
                            }
                            ?>
                        </span>
                        <div>
                            <?php
                            if (!empty($es2smr['Es2Location'])) {
                                echo $es2smr['Es2Location'];
                            } else {
                                echo "&nbsp;";
                            } ?>
                        </div>
                    </div>
                    <div class="otln"><span>工種</span>
                        <div>
                            <?php if (!empty($es2smr['WorksType'])) {
                                echo $es2smr['WorksType'];
                            } else {
                                echo "&nbsp;";
                            }
                            ?>
                        </div>
                    </div>

                    <div class="otln" style="margin-bottom: 5mm;"><span>業務期間</span>
                        <div>
                            <?php if (empty($es2smr['WorksPeriod1']) && empty($es2smr['WorksPeriod2'])) {
                                echo "&nbsp;";
                            } else if (!empty($es2smr['WorksPeriod1']) && empty($es2smr['WorksPeriod2'])) {
                                echo wareki(substr($es2smr['WorksPeriod1'], 0, 4)) . substr($es2smr['WorksPeriod1'], 5, 2) . '月' . substr($es2smr['WorksPeriod1'], 8) . '日';
                            } elseif (!empty($es2smr['WorksPeriod1']) && !empty($es2smr['WorksPeriod2'])) {
                                echo wareki(substr($es2smr['WorksPeriod1'], 0, 4)) . substr($es2smr['WorksPeriod1'], 5, 2) . '月' . substr($es2smr['WorksPeriod1'], 8) . '日～' . wareki(substr($es2smr['WorksPeriod2'], 0, 4)) . substr($es2smr['WorksPeriod2'], 5, 2) . '月' . substr($es2smr['WorksPeriod2'], 8) . "日";
                            }
                            ?>
                        </div>
                    </div>

                    <div style="font-size: 13pt;font-weight:800;border-bottom:2px solid black;padding-left: 2mm;">
                        <span style="display:inline-block;width:25mm;font-size:11pt;">御見積金額</span>
                        <?php
                        if ($es2smr['Es2UnitPrice'] == 1) {
                            echo "￥" . number_format($es2ttl['Amount']) . " - <span style='font-size:8pt;'>(消費税別)</span>";
                        } else {
                            echo " - 単価見積 - ";
                        }
                        ?>
                    </div>

                </li>
            </ul>

            <ul>
                <li>
                    <div class="otln"><span>見積番号</span>
                        <div><?php echo $es2smr['Es2Number']; ?></div>
                    </div>
                    <div class="otln" style="margin-bottom: 5mm;"><span>発行日</span>
                        <div>
                            <?php
                            if ($es2smr['CDDisplay'] == 1) {
                                echo wareki(substr($es2smr['CreatedDate'], 0, 4)) . substr($es2smr['CreatedDate'], 5, 2) . '月' . substr($es2smr['CreatedDate'], 8) . '日';
                            } else {
                                echo "　　年　　月　　日";
                            }
                            ?>
                        </div>
                    </div>
                    <div class="kumiai">
                        <h4 style="font-size: 13pt;margin-bottom:2mm;"><?php echo $es2smr['BranchName']; ?><br><?php echo $es2smr['Representative']; ?></h4>
                        <?php print '<img class="insho" alt="印章" src="data:images/png;base64,' . base64_encode($es2smr['SignatureStamp']) . '" >'; ?>
                        <div style="margin-bottom: 2mm;">登録番号：<?= $shisho['InvoiceNo'] ?></div>
                        <div>〒<?php echo $es2smr['PostCode']; ?></div>
                        <div><?php echo $es2smr['Address']; ?></div>
                        <div>Tel.<?php echo $es2smr['Phone']; ?></div>
                        <div>Fax.<?php echo $es2smr['Fax']; ?></div>
                        <?php

                        if ($es2smr['StaffDisplay'] == 1) {
                            echo "担当者：" . $es2smr['UserName'];
                        }
                        ?>
                    </div>
                </li>
            </ul>
        </header>

        <main>
            <table class="summary">
                <thead>
                    <tr>
                        <th style="width: 40%;text-align:justify;text-align-last:justify;padding:0 10mm">
                            <?php
                            if ($es2smr['classicationId'] == 15) {
                                echo "品名";
                            } else {
                                echo "品名・規格・仕様等";
                            }
                            ?>
                        </th>
                        <th style="width: 10%;text-align:center;">数量</th>
                        <th style="width: 10%;text-align:center;">単位</th>
                        <th style="width: 10%;text-align:center;">単価</th>
                        <th style="width: 10%;text-align:center;">金額</th>
                        <th style="width: 20%;text-align:center;">摘要</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $stes2smr = $dbh->query($es2smrsql);
                    while ($es2smr = $stes2smr->fetch(PDO::FETCH_BOTH)) {
                        echo "<tr>";
                        echo "<td>" . $es2smr['Summary'] . "</td>";

                        if (empty($es2smr['Quantity'])) {
                            echo "<td></td>";
                        } else if ($es2smr['Quantity'] - floor($es2smr['Quantity']) != 0) {
                            echo "<td>" . number_format($es2smr['Quantity'], 2) . "</td>";
                        } else {
                            echo "<td>" . number_format($es2smr['Quantity']) . "</td>";
                        }

                        echo "<td>" . $es2smr['Unit'] . "</td>";
                        if (empty($es2smr['UnitPrice'])) {
                            echo "<td></td>";
                        } else {
                            echo "<td>" . number_format($es2smr['UnitPrice']) . "</td>";
                        }
                        if (empty($es2smr['Amount'])) {
                            echo "<td></td>";
                        } else {
                            echo "<td>" . number_format($es2smr['Amount']) . "</td>";
                        }
                        echo "<td>" . $es2smr['Remark'] . "</td>";
                        echo "</tr>";
                    }; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="2" style="border:none;padding-top:1.2em;">
                            <div style="line-height:100%;">備考：</div>
                        </td>
                        <th colspan="2" style="padding:0 10mm ;text-align-last:justify;">合計</th>
                        <td style="padding:0 0.5%;text-align:right;"><?= number_format($es2ttl['Amount']); ?></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td rowspan="3" colspan="6" style="vertical-align: top;height:100%;line-height:100%;border:none;padding-top:0.5em;">
                            <?= nl2br($memo ?? null); ?>
                        </td>
                    </tr>
                    <tr></tr>
                    <tr></tr>
                </tfoot>
            </table>

        </main>
        <footer class="billfoot">
        </footer>
    </div>
</body>

</html>