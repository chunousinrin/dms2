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
    <style>
        * {
            font-size: 10pt;
        }

        @page {
            size: A4 landscape;
            margin-top: 15mm;
            margin-left: 15mm;
            margin-right: 10mm;
            margin-bottom: 10mm;
        }

        body {
            background-color: lightgray;
            margin: 0;
        }

        .prwrap {
            background-color: white;
            width: 297mm;
            margin: 2em auto;
            padding-top: 15mm;
            padding-right: 10mm;
            padding-bottom: 10mm;
            padding-left: 15mm;
            box-sizing: border-box;
            box-shadow: 1px 1px 5px 1px rgba(85, 85, 85, 0.7);
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
        }


        @media print {
            body {
                width: 272mm;
                height: 185mm;
                background: none;
            }

            .prwrap {
                padding: 0;
                margin: 0;
                box-shadow: none;
            }

            .noprint {
                display: none;
            }

        }
    </style>
    <title>従業員勤怠管理</title>
</head>

<body style="position: relative;">
    <div class="noprint">
        <input class="btn btn-secondary rounded-0 px-5" type="button" name="btn_back" value="戻る" onclick="window.close()">
        <input class="btn btn-secondary rounded-0 px-5" type="button" value="印刷" onclick="window.print()">
    </div>
    <div class="prwrap">
        <table class="table table-sm table-striped">
            <thead>
                <tr>
                    <td colspan="7">
                        <h2>勤務履歴一覧表</h2>
                    </td>
                </tr>
                <tr class="table-success">
                    <td class="col-sm-1">勤務日</td>
                    <td class="col-sm-2">氏名</td>
                    <td class="col-sm-1">出勤時間</td>
                    <td class="col-sm-1">時間内退勤</td>
                    <td class="col-sm-1">時間内出勤</td>
                    <td class="col-sm-1">退勤時間</td>
                    <td class="col-sm-5">備考</td>
                </tr>
            </thead>
            <tbody>
                <?php
                $dbh = new PDO('mysql:host=localhost;dbname=dms;charset=utf8', 'root', '');
                $sql = $_POST['atlist'];
                $stmt = $dbh->query($sql);
                while ($atd = $stmt->fetch(PDO::FETCH_BOTH)) : ?>
                    <tr>
                        <td><?= $atd['WorkingDay'] ?></td>
                        <td><?= $atd['name'] ?></td>
                        <td><?= $atd['AttendanceTime'] ?></td>
                        <td><?= $atd['OutingTime'] ?></td>
                        <td><?= $atd['ReentryTime'] ?></td>
                        <td><?= $atd['LeavingTime'] ?></td>
                        <td><?= $atd['Remark'] ?></td>
                    </tr>
                <?php endwhile ?>
            </tbody>
        </table>
    </div>
</body>

</html>