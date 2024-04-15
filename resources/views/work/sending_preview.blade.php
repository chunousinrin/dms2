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

    <title>送付文書</title>
    <style>
        @page {
            size: A4;
            margin: 0;
        }

        * {
            font-family: 'Noto Sans JP', sans-serif;
            font-weight: normal;
            font-size: 11pt;
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
    $dbh = new PDO('mysql:host=localhost;dbname=dms;charset=utf8', 'root', '');
    $kumiaisql = "SELECT * FROM company WHERE BranchId = 1";
    $stkumiai = $dbh->query($kumiaisql);
    $kumiai = $stkumiai->fetch();
    ?>
    @include('edt.wareki')
</head>

<body style="position: relative;">
    <div class="noprint">
        <input class="btn btn-sm btn-secondary rounded-0 px-5" type="button" value="印刷" onclick="window.print()">
        <input class="btn btn-sm btn-secondary rounded-0 px-5" type="button" name="btn_back" value="閉じる" onclick="window.close()">
    </div>
    <div class="wrap">
        <header>
            <div class="hddate">
                <img style="position: absolute;bottom:0.3em;left:0.5em;width:2cm;" src="/images/jforest.svg" alt="">
                <?php //echo wareki(substr($_POST['createdate'], 0, 4)) . substr($_POST['createdate'], 5, 2) . '月' . substr($_POST['createdate'], 8, 2) . '日';
                ?>
            </div>
            <div style="width: 100%;display:flex;">
                <div style="width:40%;height:0;border-bottom:2px solid rgba(2,51,40,1)"></div>
                <div style="width:60%;height:0;border-bottom:2px solid rgba(112,189,41,1)"></div>
            </div>

            <section>
                <table class="address">
                    <tr>
                        <td>
                            <p style="border-bottom: 1px solid black;font-size:12pt;padding-left:0.5em">
                                <?php
                                if (!empty($_POST['clientname'])) {
                                    echo $_POST['companyname'] . "<br>" . $_POST['clientname'] . "　" . $_POST['titleofhonor'];
                                } else {
                                    echo $_POST['companyname'] .  "　" . $_POST['titleofhonor'];
                                }
                                ?>
                            </p>
                        </td>
                        <td style="width: 7%;"></td>
                        <td>
                            <p>中濃森林組合</p>
                            <p style="width:100%;text-align-last:justify;"><?= $kumiai['Address'] ?></p>
                            <p>
                                <?php
                                if ($_POST['staffdisp'] == 1) {
                                    echo "担当者：" . $_POST['username'];
                                }
                                ?>
                            </p>
                        </td>
                    </tr>
                </table>
            </section>

            <h1 style="text-align:center;margin-bottom:2em;font-size:16pt;">
                <?= $_POST['title']; ?>
            </h1>
        </header>

        <main>
            <section style="margin-bottom:5em;">
                <div style="width: 100%;text-align:left;">拝啓</div>
                <div>
                    <?= nl2br($_POST['document']) ?>
                </div>
                <div style="width: 100%;text-align:right;">敬具</div>
            </section>


            <section>
                <div style="width: 100%;text-align:center;margin-bottom:1em;">記</div>
                <div style="width: fit-content;margin:0 auto;">
                    <?php
                    $table = array(
                        array($_POST['InputItems0'], $_POST['InputItems1'], $_POST['InputItems2']),
                        array($_POST['InputItems3'], $_POST['InputItems4'], $_POST['InputItems5']),
                        array($_POST['InputItems6'], $_POST['InputItems7'], $_POST['InputItems8']),
                        array($_POST['InputItems9'], $_POST['InputItems10'], $_POST['InputItems11']),
                        array($_POST['InputItems12'], $_POST['InputItems13'], $_POST['InputItems14']),
                        array($_POST['InputItems15'], $_POST['InputItems16'], $_POST['InputItems17']),
                        array($_POST['InputItems18'], $_POST['InputItems19'], $_POST['InputItems20']),
                        array($_POST['InputItems21'], $_POST['InputItems22'], $_POST['InputItems23']),
                        array($_POST['InputItems24'], $_POST['InputItems25'], $_POST['InputItems26']),
                        array($_POST['InputItems27'], $_POST['InputItems28'], $_POST['InputItems29'])
                    );
                    ?>
                    <table>
                        <?php foreach ($table as $row) : ?>
                            <tr>
                                <td><?= $row[0] ?></td>
                                <td style="padding:0.5em 2em;">
                                    <?php
                                    if (!empty($row[0])) {
                                        echo "・・・";
                                    } ?>
                                </td>
                                <td style='text-align:center;'><?= $row[1] ?></td>
                                <td><?= $row[2] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <div style=" width: 100%;text-align:right;margin-top:1em">以上
                </div>
            </section>
        </main>
        <footer>
            <div style="">　中濃森林組合　<span>https://www.chunousinrin.or.jp</span></div>

            <div style="width: 100%;display:flex;">
                <div style="width:60%;height:0;border-bottom:2px solid rgba(112,189,41,1)"></div>
                <div style="width:40%;height:0;border-bottom:2px solid rgba(2,51,40,1)"></div>
            </div>
            <ul class="office">
                <li>
                    <div>[　本　所　]</div>
                    <div class="branchadd">〒501-3782　岐阜県美濃市長瀬427番8</div>
                    <div class="branchadd">TEL 0575-35-3010　FAX 0575-31-0388</div>
                </li>
                <li>
                    <div>[ 板取川支所 ]</div>
                    <div class="branchadd">〒501-2812　岐阜県関市洞戸市場876-2</div>
                    <div class="branchadd">TEL 0581-58-2156　FAX 0581-58-2490</div>
                </li>
                <li>
                    <div>[ 津保川支所 ]</div>
                    <div class="branchadd">〒501-3601　岐阜県関市上之保145-1</div>
                    <div class="branchadd">TEL 0575-47-2009　FAX 0575-47-2009</div>
                </li>
            </ul>
        </footer>


    </div>
</body>

</html>