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
    $dbh = new PDO('mysql:host=localhost;dbname=cf756484_dms;charset=utf8', 'cf756484_root', 'AgVj4jDXzK');
    $sql = "SELECT * FROM company WHERE BranchId =" . $_POST['Branch'];
    $stmt = $dbh->query($sql);
    $shisho = $stmt->fetch();

    $table = array(
        array($_POST['smr1'], $_POST['qat1'], $_POST['unt1'], $_POST['up1'], $_POST['amt1'], $_POST['rm1']),
        array($_POST['smr2'], $_POST['qat2'], $_POST['unt2'], $_POST['up2'], $_POST['amt2'], $_POST['rm2']),
        array($_POST['smr3'], $_POST['qat3'], $_POST['unt3'], $_POST['up3'], $_POST['amt3'], $_POST['rm3']),
        array($_POST['smr4'], $_POST['qat4'], $_POST['unt4'], $_POST['up4'], $_POST['amt4'], $_POST['rm4']),
        array($_POST['smr5'], $_POST['qat5'], $_POST['unt5'], $_POST['up5'], $_POST['amt5'], $_POST['rm5']),
        array($_POST['smr6'], $_POST['qat6'], $_POST['unt6'], $_POST['up6'], $_POST['amt6'], $_POST['rm6']),
        array($_POST['smr7'], $_POST['qat7'], $_POST['unt7'], $_POST['up7'], $_POST['amt7'], $_POST['rm7']),
        array($_POST['smr8'], $_POST['qat8'], $_POST['unt8'], $_POST['up8'], $_POST['amt8'], $_POST['rm8']),
        array($_POST['smr9'], $_POST['qat9'], $_POST['unt9'], $_POST['up9'], $_POST['amt9'], $_POST['rm9']),
        array($_POST['smr10'], $_POST['qat10'], $_POST['unt10'], $_POST['up10'], $_POST['amt10'], $_POST['rm10']),
        array($_POST['smr11'], $_POST['qat11'], $_POST['unt11'], $_POST['up11'], $_POST['amt11'], $_POST['rm11']),
        array($_POST['smr12'], $_POST['qat12'], $_POST['unt12'], $_POST['up12'], $_POST['amt12'], $_POST['rm12'])
    );


    $amtsum[] = $_POST['amt1'];
    $amtsum[] = $_POST['amt2'];
    $amtsum[] = $_POST['amt3'];
    $amtsum[] = $_POST['amt4'];
    $amtsum[] = $_POST['amt5'];
    $amtsum[] = $_POST['amt6'];
    $amtsum[] = $_POST['amt7'];
    $amtsum[] = $_POST['amt8'];
    $amtsum[] = $_POST['amt9'];
    $amtsum[] = $_POST['amt10'];
    $amtsum[] = $_POST['amt11'];
    $amtsum[] = $_POST['amt12'];

    $idsum[] = $_POST['idamt1'];
    $idsum[] = $_POST['idamt2'];

    $otsum[] = $_POST['otamt1'];
    $otsum[] = $_POST['otamt2'];
    $otsum[] = $_POST['otamt3'];
    $otsum[] = $_POST['otamt4'];

    ?>
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
                                echo "業務名称";
                            }
                            ?>
                        </span>
                        <div>
                            <?php
                            if (!empty($_POST['es2bizname'])) {
                                echo $_POST['es2bizname'];
                            } else {
                                echo "&nbsp;";
                            } ?>
                        </div>
                    </div>
                    <div class="otln">
                        <span>
                            <?php
                            if ($_POST['classicationId'] == 15) {
                                echo "納入場所";
                            } else {
                                echo "業務場所";
                            }
                            ?>
                        </span>
                        <div>
                            <?php
                            if (!empty($_POST['es2location'])) {
                                echo $_POST['es2location'];
                            } else {
                                echo "&nbsp;";
                            } ?>
                        </div>
                    </div>
                    <div class="otln"><span>工種</span>
                        <div>
                            <?php if (!empty($_POST['es2workstype'])) {
                                echo $_POST['es2workstype'];
                            } else {
                                echo "&nbsp;";
                            }
                            ?>
                        </div>
                    </div>

                    <div class="otln"><span>業務期間</span>
                        <div>
                            <?php if (empty($_POST['es2worksperiodx1']) && empty($_POST['es2worksperiodx2'])) {
                                echo "&nbsp;";
                            } else if (!empty($_POST['es2worksperiodx1']) && empty($_POST['es2worksperiodx2'])) {
                                echo wareki(substr($_POST['es2worksperiodx1'], 0, 4)) . substr($_POST['es2worksperiodx1'], 5, 2) . '月' . substr($_POST['es2worksperiodx1'], 8) . '日';
                            } elseif (!empty($_POST['es2worksperiodx1']) && !empty($_POST['es2worksperiodx2'])) {
                                echo wareki(substr($_POST['es2worksperiodx1'], 0, 4)) . substr($_POST['es2worksperiodx1'], 5, 2) . '月' . substr($_POST['es2worksperiodx1'], 8) . '日～' . wareki(substr($_POST['es2worksperiodx2'], 0, 4)) . substr($_POST['es2worksperiodx2'], 5, 2) . '月' . substr($_POST['es2worksperiodx2'], 8) . "日";
                            }
                            ?>
                        </div>
                    </div>
                    <div style="font-size: 13pt;font-weight:800;border-bottom:2px solid black;padding-left: 2mm;">
                        <span style="display:inline-block;width:25mm;font-size:11pt;">御見積金額</span>
                        <?php
                        if ($_POST['Es2UnitPrice'] == 1) {
                            echo "￥" . number_format(array_sum($amtsum) + array_sum($idsum) + array_sum($otsum)) . " - <span style='font-size:8pt;'>(消費税別)</span>";
                        } else {
                            echo " - 単価見積 - ";
                        }
                        ?>
                    </div>
                    <div style="padding-left: 2mm;">
                        <?php if (empty($_POST['EffectiveDate'])) {
                            echo "見積有効期限：ご請求日より45日以内";
                        } else {
                            echo "見積有効期限：" . wareki(substr($_POST['EffectiveDate'], 0, 4)) . substr($_POST['EffectiveDate'], 5, 2) . '月' . substr($_POST['EffectiveDate'], 8, 2) . '日';
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
                        <th style="width: 40%;text-align:justify;text-align-last:justify;padding:0 10mm">
                            <?php
                            if ($_POST['classicationId'] == 15) {
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
                    <?php foreach ($table as $row) : ?>
                        <tr>
                            <?php foreach ($row as $cel) : ?>
                                <?php
                                echo '<td>';
                                if (is_numeric($cel)) {
                                    if ($cel - floor($cel) != 0) {
                                        echo number_format($cel, 2);
                                    } else {
                                        echo number_format($cel);
                                    }
                                } else {
                                    echo $cel;
                                }
                                echo '</td>';
                                ?>
                            <?php endforeach; ?>
                        </tr>
                    <?php endforeach; ?>
                    <tr>
                        <td>直接作業代小計</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td><?= number_format(array_sum($amtsum)) ?? 0 ?></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td><?= $_POST['idsmr1'] ?? null ?></td>
                        <td><?= $_POST['idqat1'] ?? null ?></td>
                        <td><?= $_POST['idunt1'] ?? null ?></td>
                        <td></td>
                        <td>
                            <?php if (!empty($_POST['idamt1'])) {
                                echo number_format($_POST['idamt1']);
                            } ?>
                        </td>
                        <td><?= $_POST['idrmk1'] ?? null ?></td>
                    </tr>
                    <tr>
                        <td><?= $_POST['idsmr2'] ?? null ?></td>
                        <td><?= $_POST['idqat2'] ?? null ?></td>
                        <td><?= $_POST['idunt2'] ?? null ?></td>
                        <td></td>
                        <td>
                            <?php if (!empty($_POST['idamt2'])) {
                                echo number_format($_POST['idamt2']);
                            } ?>
                        <td><?= $_POST['idrmk2'] ?? null ?></td>
                    </tr>
                    <tr>
                        <td>工事原価</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td><?= number_format(array_sum($amtsum) + array_sum($idsum)) ?? 0 ?></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td><?= $_POST['otsmr1'] ?? null ?></td>
                        <td><?= $_POST['otqat1'] ?? null ?></td>
                        <td><?= $_POST['otunt1'] ?? null ?></td>
                        <td></td>
                        <td>
                            <?php if (!empty($_POST['otamt1'])) {
                                echo number_format($_POST['otamt1']);
                            } ?>
                        </td>
                        <td><?= $_POST['otrmk1'] ?? null ?></td>
                    </tr>
                    <tr>
                        <td><?= $_POST['otsmr2'] ?? null ?></td>
                        <td><?= $_POST['otqat2'] ?? null ?></td>
                        <td><?= $_POST['otunt2'] ?? null ?></td>
                        <td><?= $_POST['otup2'] ?? null ?></td>
                        <td>
                            <?php
                            if (!empty($_POST['otamt2'])) {
                                echo number_format($_POST['otamt2']);
                            }
                            ?>
                        </td>
                        <td><?= $_POST['otrmk2'] ?? null ?></td>
                    </tr>
                    <tr>
                        <td><?= $_POST['otsmr3'] ?? null ?></td>
                        <td><?= $_POST['otqat3'] ?? null ?></td>
                        <td><?= $_POST['otunt3'] ?? null ?></td>
                        <td><?= $_POST['otup3'] ?? null ?></td>
                        <td>
                            <?php
                            if (!empty($_POST['otamt3'])) {
                                echo number_format($_POST['otamt3']);
                            }
                            ?>
                        </td>
                        <td><?= $_POST['otrmk3'] ?? null ?></td>
                    </tr>
                    <tr>
                        <td><?= $_POST['otsmr4'] ?? null ?></td>
                        <td><?= $_POST['otqat4'] ?? null ?></td>
                        <td><?= $_POST['otunt4'] ?? null ?></td>
                        <td><?= $_POST['otup4'] ?? null ?></td>
                        <td>
                            <?php
                            if (!empty($_POST['otamt4'])) {
                                echo number_format($_POST['otamt4']);
                            }
                            ?>
                        </td>
                        <td><?= $_POST['otrmk4'] ?? null ?></td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="2" style="border:none;padding-top:1.2em;">
                            <div style="line-height:100%;">備考：</div>
                        </td>
                        <th colspan="2" style="padding:0 10mm ;text-align-last:justify;">合計</th>
                        <td style="padding:0 0.5%;text-align:right;"><?= number_format(array_sum($amtsum) + array_sum($idsum) + array_sum($otsum)) ?? 0; ?></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td rowspan="3" colspan="6" style="vertical-align: top;height:100%;line-height:100%;border:none;padding-top:0.5em;">
                            <?= nl2br($_POST['es2remark'] ?? null) ?>
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