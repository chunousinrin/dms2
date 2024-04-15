<!doctype html>
<html lang="ja">

<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Language" content="ja">
    <meta name="google" content="notranslate">
    <title>勤務時間一覧表</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

    <style>
        @page {
            size: A4;
            margin-right: 16mm;
            margin-left: 14mm;
            margin-top: 18mm;
            margin-bottom: 18mm;
        }

        html,
        body,
        header,
        footer,
        ul,
        li,
        section,
        aside,
        article,
        h1,
        h2,
        h3,
        h4,
        p,
        tr,
        th,
        td,
        input,
        textarea,
        button {
            margin: 0;
            padding: 0;
            font-size: 10pt;
            font-family: 'Noto Sans JP', sans-serif;
            font-weight: normal;
        }

        @media print {
            body {
                -webkit-print-color-adjust: exact;
            }

            .noprint {
                display: none;
            }

        }

        body {
            width: 180mm;
            margin: 0 auto;
        }

        h1 {
            font-size: 15pt;
            margin-bottom: 0.5em;
        }

        .atdc {
            width: 100%;
            border-collapse: collapse;
        }

        .atdc th,
        .atdc td {
            border: 1px solid rgba(0, 0, 0, 0.3);
            padding: 0 0.5em;
            height: 2em;
            line-height: 2em;
        }

        .atdc th:nth-of-type(n+2),
        .atdc td:nth-of-type(n+2) {
            text-align: center;
            width: 23mm;
        }

        .atdc tbody tr:nth-of-type(even) {
            background-color: rgba(0, 0, 0, 0.1);
        }

        .atdc thead tr,
        .atdc tfoot tr {
            border-top: 2px solid black;
            border-bottom: 2px solid black;
            background-color: rgba(0, 0, 0, 0.2)
        }

        .noprint {
            width: 100%;
            margin: 20px auto;
            text-align: center;
        }
    </style>

    <?php

    if (!empty($_GET['creater'])) {
        $userID = " WHERE UserID = " . $_GET['creater'];
    } else {
        $userID = null;
    }
    if (!empty($_GET['creater']) && !empty($_GET['startDate'])) {
        $and = " AND ";
    } elseif (empty($_GET['creater']) && !empty($_GET['startDate'])) {
        $and = " WHERE ";
    } else {
        $and = null;
    }

    if (!empty($_GET['startDate'])) {
        $srcdate = "WorkingDay BETWEEN '" . $_GET['startDate'] . "' AND '" . $_GET['endDate'] . "'";
    } else {
        $srcdate = null;
    }

    $dbh = new PDO('mysql:host=localhost;dbname=dms;charset=utf8', 'root', '');
    $sql = "SELECT working_time.*,users.name FROM working_time LEFT JOIN dms.users ON working_time.UserID=users.id {$userID} {$and} {$srcdate} ORDER BY WorkingDay ASC";
    //$sql = "SELECT * FROM working_time";
    $stmt = $dbh->query($sql);
    $count = $stmt->rowCount();
    $sumhour = 0;
    ?>

    <h1>勤務時間一覧表</h1>

</head>

<body>
    <table class="atdc">
        <thead>
            <tr>
                <th style="text-align: center;">名前</th>
                <th>勤務日</th>
                <th>出勤時間</th>
                <th>時間内退勤</th>
                <th>時間内出勤</th>
                <th>退勤時間</th>
                <th>勤務時間</th>
            </tr>
        </thead>
        <tbody>
            <?php
            while ($result = $stmt->fetch(PDO::FETCH_BOTH)) {
                echo "<tr>
                <td>" . $result['name'] . "</td>
                <td>" . date('m月d日', strtotime($result['WorkingDay']))  . "</td>
                <td>" . $result['AttendanceTime'] . "</td>
                <td>" . $result['OutingTime'] . "</td>
                <td>" . $result['ReentryTime'] . "</td>
                <td>" . $result['LeavingTime'] . "</td>
                <td>" . date('H:i', strtotime($result['WorkingHours'])) . "</td>
                </tr>";
                $sumhour = $sumhour + $result['tm'];
            };
            for ($i = 31; $i > $count; $i--) {
                echo "<tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>";
            }

            ?>
        </tbody>
        <tfoot>
            <tr>
                <td></td>
                <td colspan="2">勤務日数合計</td>
                <td><?= $count ?>日</td>
                <td colspan="2">勤務時間合計</td>
                <td>
                    <?php
                    echo str_pad(floor($sumhour / 3600), 2, 0, STR_PAD_LEFT) . ":" . str_pad(floor(($sumhour / 60) % 60), 2, 0, STR_PAD_LEFT);
                    ?>
                </td>
            </tr>
        </tfoot>

    </table>

    <?php
    $dbh = 0;
    ?>
    <div class="noprint">
        <input type="button" class="btn btn-secondary rounded-0" onclick="window.print()" value="印刷">
        <input class="btn btn-secondary rounded-0 send_input" type="button" name="btn_back" value="閉じる" onclick="window.close()">
    </div>

</body>

</html>