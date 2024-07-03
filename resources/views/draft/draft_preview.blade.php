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

    @include('edt.wareki')

    <style>
        @page {
            size: A4;
            margin: 10mm 15mm;
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
            padding: 10mm 15mm;
            box-shadow: 0px 0px 15px -5px #777777;
            position: relative;
        }

        .horizon {
            margin: 0 auto;
            height: 0;
            width: 100%;
            border: 1.5px solid #000;
        }

        .note {
            background-color: #fff;
            background-image: url(/images/underline.svg);
            background-size: 2em;
            background-repeat: repeat;
            line-height: 2em;
            padding: 0 1em;
            text-align: justify;
            text-align-last: left;
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
                width: 100%;
                height: 100%;
                margin: 0 auto;
                padding: 0;
            }

            .noprint {
                display: none;
            }
        }
    </style>
    <?php
    $dbh = new PDO('mysql:host=localhost;dbname=' . env('DB_DATABASE') . ';charset=utf8', env('DB_USERNAME'), env('DB_PASSWORD'));
    $sql = "SELECT * FROM draft_type WHERE DraftID = " . $_POST['DraftTypeId'];
    $stmt = $dbh->query($sql);
    $result = $stmt->fetch();

    $sql2 = "SELECT * FROM users WHERE id = " . $_POST['UserID'];
    $stmt2 = $dbh->query($sql2);
    $user = $stmt2->fetch();
    ?>
    <title><?= $result['DraftName'] ?></title>

</head>

<body style="position: relative;">
    <div class="noprint">
        <input class="btn btn-sm btn-secondary rounded-0 px-5" type="button" value="印刷" onclick="window.print()">
        <input class="btn btn-sm btn-secondary rounded-0 px-5" type="button" name="btn_back" value="閉じる" onclick="window.close()">
    </div>

    <div class="wrap">
        <header>
            <div style="position: relative;width:100%;height:2em;">
                <div style="position: absolute;top:0;left:0;">No.<?= $_POST['SerialNumber'] ?></div>
                <div style="position: absolute;top:0;right:0;">
                    <?php echo wareki(substr($_POST['CreatedDate'], 0, 4)) . substr($_POST['CreatedDate'], 5, 2) . '月' . substr($_POST['CreatedDate'], 8, 2) . '日'; ?>
                </div>
            </div>

            <h1 style="width:100%;margin: 0 auto;padding:0 35%;text-align-last:justify;margin-bottom:5px;"><?= $result['DraftName'] ?></h1>

            <div style="position: relative;height:3em;margin-bottom:5px;">
                <div style="display: flex;position:absolute;top:0;right:5px;">起案者｜
                    <div><?= $user['department'] . "&nbsp;" . $user['section'] . "&nbsp;" . $user['position'] ?><br><?= $user['name'] ?></div>
                    <?php print '<img style="position:absolute;right:0;opacity:0.8;bottom:0;" class="insho" alt="印鑑" width="30mm" height="30mm" src="data:image/svg+xml;base64,' . base64_encode($user['stamp']) . '" >'; ?>
                </div>
            </div>

            <div class="horizon" style="margin: 0;"></div>

            <div style="width: 100%;display:flex;">
                <div style="width:7%;line-height:2.5em;padding:0 1%;text-align-last:justify;">表題</div>
                <div style="width:93%;line-height:2.5em;padding:0 5px;font-size:1.2rem;padding:0 1em;">
                    <?= $_POST['TitleName'] ?>
                </div>
            </div>

            <div class="horizon"></div>
        </header>
        <main>
            <div style="width: 100%;display:flex;height:162mm;overflow:hidden;">
                <div style="width:7%;line-height:2.5em;padding:0 1%;text-align-last:justify;">内容</div>
                <div style="width:93%;height:100%;" class="note">
                    <?php
                    if (empty($_POST['Layout'])) {
                        echo nl2br($_POST['Contents']);
                    } else {
                        echo "別紙参照";
                    }
                    ?>
                </div>
            </div>

            <div class="horizon"></div>

            <div style="width: 100%;display:flex;height:5em;padding:1% 0;">
                <div style="width:7%;padding:0 1%;text-align-last:justify;text-align:justify;">添付書類</div>
                <div style="width:93%;padding:0.5em 5px;">
                    <!--nl2br($_POST['Documents'])-->
                </div>
            </div>

            <div class="horizon"></div>

            <div style="width: 100%;display:flex;height:9em;padding:1% 0;">
                <div style="width:7%;padding:0 1%;text-align-last:justify;">ｺﾒﾝﾄ</div>
                <div style="width:93%;padding:0 1em;"></div>
            </div>

            <div style="width: 100%;display:flex;height:6em;border:1px solid silver;">
                <div style="height:6em;line-height:2.8em;padding:0 0.2em;text-align-last:justify;border-right:1px solid silver;">決<br>裁</div>
                <div style="width:25%;line-height:2.5em;padding:0;text-align-last:justify; border-right:1px solid silver;display:flex;">
                    <div style="width:50%;padding:0 0.5em;text-align-last:left;border-right:1px dotted silver;">組合長</div>
                    <div style="width:50%;padding:0 0.5em;text-align-last:left;">専務</div>
                </div>
                <div style="width:7%;line-height:2.5em;padding:0 1%;text-align-last:justify;">閲覧</div>
                <div style="padding: 0.5em;">
                </div>
            </div>

            <div style="width: 100%;position:relative;height:1.5em;display:none;">
                <div style="position: absolute;left:5px;top:0;">決裁日｜令和05年 月 日</div>
                <div style="position: absolute;right:5px;top:0;">保存期間｜令和05年 月 日</div>
            </div>
        </main>
    </div>

    <?php
    if (empty($_POST['Layout'])) {
        echo "<div style='display:none;'>";
    } else {
        echo '<div style="break-after: page;"></div>';
        echo "<div class='wrap' style='height:100%'>";
    }
    echo "<div class='note'>";
    echo nl2br($_POST['Contents']);
    echo "</div>";
    ?> ?>
    </div>

</body>

</html>