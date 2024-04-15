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
    $estimatesum = 0;

    use Illuminate\Support\Facades\Auth;

    $user = Auth::user();
    $dbh = new PDO('mysql:host=localhost;dbname=dms;charset=utf8', 'root', '');
    $sql = "SELECT * FROM company WHERE BranchId = " . $_POST['Branch'];
    $stmt = $dbh->query($sql);
    $shisho = $stmt->fetch();
    ?>
    @include('edt.wareki')
</head>

<body style="position: relative;">
    <div class="noprint">
        <input class="btn btn-sm btn-secondary rounded-0 px-5" type="button" value="印刷" onclick="window.print()">
        <input class="btn btn-sm btn-secondary rounded-0 px-5" type="button" name="btn_back" value="閉じる" onclick="window.close()">
    </div>
    <div class="wrap">
        <header class="billhead">
            <ul>
                <li>
                    <h2 style="font-size: 13pt;font-weight:bold;text-align:justify;text-align-last:justify;padding:0 30mm;border-bottom:3px double black;margin-bottom:5mm;">御見積書</h2>
                    <h3 style="font-size: 13pt;border-bottom:1px solid black;padding-left: 2mm;">
                        <?php echo $_POST['Customer'] . "　" . $_POST['CustomerAdd']; ?>
                    </h3>
                    <div style="margin-bottom: 5mm;padding-left: 2mm;">下記のとおり、御見積申し上げます。</div>
                    <div class="otln">
                        <span>
                            <?php
                            if ($_POST['classicationId'] == 15) {
                                echo "件名";
                            } else {
                                echo "事業名";
                            }
                            ?>
                        </span>
                        <div><?php echo $_POST['TitleName']; ?></div>
                    </div>
                    <div class="otln">
                        <span>
                            <?php
                            if ($_POST['classicationId'] == 15) {
                                echo "納入場所";
                            } else {
                                echo "場所";
                            }
                            ?>
                        </span>
                        <div><?php echo $_POST['Location'] . "&nbsp;"; ?></div>
                    </div>
                    <div class="otln"><span>実施予定日</span>
                        <div>
                            <?php if (!empty($_POST['ScheduledDate'])) {
                                echo wareki(substr($_POST['ScheduledDate'], 0, 4)) . substr($_POST['ScheduledDate'], 5, 2) . '月' . substr($_POST['ScheduledDate'], 8) . '日';
                            } else {
                                echo "&nbsp;";
                            }
                            ?>
                        </div>
                    </div>

                    <div class="otln" style="margin-bottom: 5mm;"><span>見積有効期限</span>
                        <div>
                            <?php if (empty($_POST['EffectiveDate'])) {
                                echo "発行日より45日以内";
                            } else {
                                echo wareki(substr($_POST['EffectiveDate'], 0, 4)) . substr($_POST['EffectiveDate'], 5, 2) . '月' . substr($_POST['EffectiveDate'], 8) . '日';
                            }
                            ?>
                        </div>
                    </div>

                    <div style="font-size: 13pt;font-weight:800;border-bottom:2px solid black;padding-left: 2mm;">
                        <span style="display:inline-block;width:25mm;font-size:11pt;">御見積金額</span>
                        <?php
                        if ($_POST['UnitPriceEstimate'] == 1) {
                            if ($_POST['Tax'] == 0.08 | $_POST['Tax'] == 0.1) {
                                $sum = floor($_POST['estimatesum'] * (1 + $_POST['Tax']));
                            } elseif ($_POST['Tax'] == 1.08 | $_POST['Tax'] == 1.1) {
                                $sum = floor($_POST['estimatesum']);
                            } elseif ($_POST['Tax'] == 0.0) {
                                $sum = floor($_POST['estimatesum']);
                            }
                            echo "￥" . number_format($sum) . " -";
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
                        <div><?php echo $_POST['SerialNumber']; ?></div>
                    </div>
                    <div class="otln" style="margin-bottom: 5mm;"><span>発行日</span>
                        <div>
                            <?php
                            if ($_POST['cddisplay'] == 1) {
                                echo wareki(substr($_POST['CreatedDate'], 0, 4)) . substr($_POST['CreatedDate'], 5, 2) . '月' . substr($_POST['CreatedDate'], 8) . '日';
                            } else {
                                echo "　　年　　月　　日";
                            };
                            ?>
                        </div>
                    </div>
                    <div class="kumiai">
                        <h4 style="font-size: 13pt;margin-bottom:2mm;"><?php echo $shisho['BranchName']; ?><br><?php echo $shisho['Representative']; ?></h4>
                        <?php print '<img class="insho" alt="印章" src="data:images/png;base64,' . base64_encode($shisho['SignatureStamp']) . '" >'; ?>
                        <div style="margin-bottom: 2mm;">登録番号：T4200005007974</div>
                        <div>〒<?php echo $shisho['PostCode']; ?></div>
                        <div><?php echo $shisho['Address']; ?></div>
                        <div>Tel.<?php echo $shisho['Phone']; ?></div>
                        <div>Fax.<?php echo $shisho['Fax']; ?></div>
                        <?php

                        if ($_POST['StaffDisplay'] == 1) {
                            echo "担当者：" . $_POST['UserName'];
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
                        <th style="width: 50%;text-align:justify;text-align-last:justify;padding:0 30mm">
                            <?php
                            if ($_POST['classicationId'] == 15) {
                                echo "品名";
                            } else {
                                echo "摘要";
                            }
                            ?>
                        </th>
                        <th style="width: 12.5%;text-align:center;">数量</th>
                        <th style="width: 12.5%;text-align:center;">単位</th>
                        <th style="width: 12.5%;text-align:center;">単価</th>
                        <th style="width: 12.5%;text-align:center;">金額</th>
                    </tr>
                </thead>
                <tbody class="billlist">
                    <?php
                    $table = array(
                        array($_POST['InputItems0'], $_POST['InputItems1'], $_POST['InputItems2'], $_POST['InputItems3']),
                        array($_POST['InputItems4'], $_POST['InputItems5'], $_POST['InputItems6'], $_POST['InputItems7']),
                        array($_POST['InputItems8'], $_POST['InputItems9'], $_POST['InputItems10'], $_POST['InputItems11']),
                        array($_POST['InputItems12'], $_POST['InputItems13'], $_POST['InputItems14'], $_POST['InputItems15']),
                        array($_POST['InputItems16'], $_POST['InputItems17'], $_POST['InputItems18'], $_POST['InputItems19']),
                        array($_POST['InputItems20'], $_POST['InputItems21'], $_POST['InputItems22'], $_POST['InputItems23']),
                        array($_POST['InputItems24'], $_POST['InputItems25'], $_POST['InputItems26'], $_POST['InputItems27']),
                        array($_POST['InputItems28'], $_POST['InputItems29'], $_POST['InputItems30'], $_POST['InputItems31']),
                        array($_POST['InputItems32'], $_POST['InputItems33'], $_POST['InputItems34'], $_POST['InputItems35']),
                        array($_POST['InputItems36'], $_POST['InputItems37'], $_POST['InputItems38'], $_POST['InputItems39']),
                        array($_POST['InputItems40'], $_POST['InputItems41'], $_POST['InputItems42'], $_POST['InputItems43']),
                        array($_POST['InputItems44'], $_POST['InputItems45'], $_POST['InputItems46'], $_POST['InputItems47']),
                        array($_POST['InputItems48'], $_POST['InputItems49'], $_POST['InputItems50'], $_POST['InputItems51']),
                        array($_POST['InputItems52'], $_POST['InputItems53'], $_POST['InputItems54'], $_POST['InputItems55']),
                        array($_POST['InputItems56'], $_POST['InputItems57'], $_POST['InputItems58'], $_POST['InputItems59'])
                    );
                    $num = 0;
                    ?>
                    <?php foreach ($table as $row) : ?>
                        <tr>
                            <td style="position: relative;">
                                <?php
                                echo $row[0];
                                if ($_POST['Tax'] === "0.08" | $_POST['Tax'] === "1.08") {
                                    if (!empty($row[0])) {
                                        echo "<p style='position:absolute;top:0.3em;right:0.3em;font-size:10pt;'>*</p>";
                                    }
                                }
                                ?>
                            </td>
                            <td>
                                <?php
                                if (empty($row[1])) {
                                    echo "";
                                } else {
                                    if ($row[1] - $row[1] === 0) {
                                        echo number_format($row[1], 0);
                                    } else {
                                        echo $row[1];
                                    }
                                }
                                ?>
                            </td>
                            <td><?= $row[2] ?></td>
                            <td>
                                <?php
                                if (empty($row[3])) {
                                    echo "";
                                } else {
                                    if ($row[3] - $row[3] === 0) {
                                        echo number_format($row[3], 0);
                                    } else {
                                        echo $row[3];
                                    }
                                }
                                ?>
                            </td>
                            <td>
                                <?php
                                if (!empty($row[1]) && !empty($row[3])) {
                                    $price = bcmul($row[1], $row[3], 3);
                                } elseif (empty($row[1]) && !empty($row[3])) {
                                    $price = $row[3];
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
                                $num = $num + $price;
                                ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
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
                    if ($_POST['Tax'] == 1.08 or $_POST['Tax'] == 1.1) {
                        $tax = bcsub($num, bcdiv($num, $_POST['Tax'], 3), 3);
                        $tax2 = 0;
                        $taxtitle = "(内消費税)";
                    } elseif ($_POST['Tax'] == 0.1 or $_POST['Tax'] == 0.08) {
                        $tax = bcmul($num, $_POST['Tax'], 3);
                        $tax2 = $tax;
                        $taxtitle = "消費税";
                    } elseif ($_POST['Tax'] == 0.0) {
                        $tax = 0;
                        $tax2 = 0;
                        $taxtitle = "";
                    }
                    ?>
                    <tr>
                        <td colspan="2" rowspan="3" style="border:none;vertical-align:top;">
                            <div style="height:2em;line-height:2em;">備考：
                                <?php
                                if ($_POST['Tax'] == 0.0) {
                                    echo "消費税抜きの価格となります。";
                                } elseif ($_POST['Tax'] === "1.08" or $_POST['Tax'] === "0.08") {
                                    echo "*は軽減税率対象です。";
                                }
                                ?>
                            </div>
                            <?php echo "<div style='max-height:0;line-height:1em;'>" . ($_POST['Remark']) . "</div>" ?>
                        </td>
                        <th>10%対象</th>
                        <td style="text-align: right;">
                            <?php
                            if ($_POST['Tax'] === "1.1" or $_POST['Tax'] === "0.1") {
                                if (bcsub(bcmul($num, $_POST['Tax'], 3), bcmul($num, $_POST['Tax'], 0), 3) === "0.000") {
                                    echo number_format($num, 0);
                                } else {
                                    echo number_format($num, 3);
                                }
                            }
                            ?>
                        </td>
                        <td style="text-align: right;position:relative;">
                            <div style='font-size:6px;position:absolute;top:5px;left:0;line-height:6px'><?= $taxtitle ?></div>
                            <div style='font-size:7pt'>
                                <?php
                                if ($_POST['Tax'] === "1.1" or $_POST['Tax'] === "0.1") {
                                    if (bcsub($tax, bcsub($tax, 0, 0), 3) === "0.000") {
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
                            if ($_POST['Tax'] === "1.08" or $_POST['Tax'] === "0.08") {
                                if (bcsub(bcmul($num, $_POST['Tax'], 3), bcmul($num, $_POST['Tax'], 0), 3) === "0.000") {
                                    echo number_format($num);
                                } else {
                                    echo number_format($num, 3);
                                }
                            }
                            ?>
                        </td>
                        <td style="text-align: right;position:relative;">
                            <div style='font-size:6px;position:absolute;top:5px;left:0;line-height:6px'><?= $taxtitle ?></div>
                            <div style='font-size:7pt'>
                                <?php
                                if ($_POST['Tax'] === "1.08" or $_POST['Tax'] === "0.08") {
                                    if (bcsub($tax, bcsub($tax, 0, 0), 3) === "0.000") {
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
                            if ($_POST['Tax'] === "0.0") {
                                if (bcsub(bcadd((float)$_POST['estimatesum'], 0, 3), bcadd((float)$_POST['estimatesum'], 0, 0), 3) == 0.00) {
                                    echo number_format($num, 0);;
                                } else {
                                    echo number_format($num, 3);
                                }
                            } elseif (bcsub(bcmul($num, $_POST['Tax'], 3), bcmul($num, $_POST['Tax'], 0), 3) == "0.000") {
                                echo number_format($num, 0);
                            } else {
                                echo number_format($num, 3);
                            }
                            ?>
                        </td>
                        <td style="text-align: right;position:relative;font-size:7px;">
                            <div style="font-size:6px;position:absolute;top:5px;left:0;line-height:6px"><?= $taxtitle ?></div>
                            <div style="font-size: 7pt;">
                                <?php
                                if ($_POST['Tax'] == 0.0) {
                                    echo "";
                                } elseif (bcsub($tax, bcsub($tax, 0, 0), 3) === "0.000") {
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
        </footer>
    </div>
</body>

</html>