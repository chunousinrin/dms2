<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>

    <title>Document</title>

    <style>
        @page {
            size: A4;
            margin: 0;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background-color: rgba(2, 51, 40, 0.2);
            width: 100%;
            -webkit-print-color-adjust: exact;
            color-adjust: exact;
            position: relative;
        }

        .slctr {
            width: 100%;
            box-sizing: border-box;
            text-align: center;
            background-color: #fff;
            padding: 2em 0;
            position: sticky;
            top: 0;
            left: 0;
            border-bottom: 3px solid #444444;
        }

        .wrap {
            width: 210mm;
            height: 297mm;
            box-sizing: border-box;
            background-color: white;
            margin: 3em auto;
            padding: 15mm;
            box-shadow: 0px 0px 15px -5px #777777;
        }

        .row {
            width: 50%;
            margin: 0 auto;
        }

        .tbl {
            width: 100%;
            margin: 0 auto;
            border-collapse: collapse;
            font-size: 10pt;
            color: #444444;
        }

        .tbl thead tr {
            border-bottom: 2px solid #444444;
        }

        .tbl tbody tr {
            border-bottom: 1px solid #444444;
        }

        .tbl tfoot tr {
            border-top: 2px solid #444444;
        }

        .tbl tbody tr td,
        .tbl tfoot tr td {
            padding: 0.35em 0;
        }

        .text-center {
            text-align: center;
        }

        @media screen and (max-width:800px) {
            .wrap {
                width: 100%;
                height: 100%;
                margin: 1em auto;
                padding: 1em;
                box-shadow: none;
            }

            .row {
                width: 100%;
            }
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
</head>

<body>
    <section class="slctr noprint">
        <?php
        $dbh = new PDO('mysql:host=localhost;dbname=' . env('DB_DATABASE') . ';charset=utf8', env('DB_USERNAME'), env('DB_PASSWORD'));
        $yd = date('Y');
        $md = date('m');
        $week = ["1" => "日", "2" => "月", "3" => "火", "4" => "水", "5" => "木", "6" => "金", "7" => "土"];
        $color = ["1" => "#f5b1aa", "2" => "#fff", "3" => "#fff", "4" => "#fff", "5" => "#fff", "6" => "#fff", "7" => "#fff"];
        ?>
        <form action="" method="post">
            @csrf
            <div class="row g-0">
                <div class="col-3">
                    <select name="nen" id="nen" class="form-select px-1 rounded-0 border-primary" required>
                        <option value="<?= $yd - 5 ?>"><?= $yd - 5 ?></option>
                        <option value="<?= $yd - 4 ?>"><?= $yd - 4 ?></option>
                        <option value="<?= $yd - 3 ?>"><?= $yd - 3 ?></option>
                        <option value="<?= $yd - 2 ?>"><?= $yd - 2 ?></option>
                        <option value="<?= $yd - 1 ?>"><?= $yd - 1 ?></option>
                        <option value="<?= $_POST['nen'] ?? $yd ?>" selected><?= $_POST['nen'] ?? $yd ?></option>
                        <option value="<?= $yd + 1 ?>"><?= $yd + 1 ?></option>
                        <option value="<?= $yd + 2 ?>"><?= $yd + 2 ?></option>
                        <option value="<?= $yd + 3 ?>"><?= $yd + 3 ?></option>
                        <option value="<?= $yd + 4 ?>"><?= $yd + 4 ?></option>
                        <option value="<?= $yd + 5 ?>"><?= $yd + 5 ?></option>
                    </select>
                </div>
                <label class="col-1 col-form-label px-1">年</label>
                <div class="col-2">
                    <select name="tuki" id="tuki" class="form-select px-1 rounded-0 border-primary" required>
                        <option value="<?= $_POST['tuki'] ?? number_format($md) ?>" hidden selected><?= $_POST['tuki'] ?? number_format($md) ?></option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <option value="10">10</option>
                        <option value="11">11</option>
                        <option value="12">12</option>
                    </select>
                </div>
                <label class="col-1 col-form-label px-1">月</label>
                <div class="col-5">
                    <select name="member" id="member" class="form-select px-1 rounded-0 border-primary" required autofocus onchange="submit()">
                        <option value="" disabled selected>氏名を選択</option>
                        <?php
                        $membersql = "SELECT * FROM worker_group_member";
                        $memberstmt = $dbh->query($membersql);
                        while ($member = $memberstmt->fetch(PDO::FETCH_BOTH)) : ?>
                            <option value="<?= $member['WorkerNameID'] ?>"><?= $member['WorkerName'] ?></option>
                        <?php endwhile ?>
                    </select>
                </div>
            </div>
            <div class="row my-2 justify-content-around">
                <input type="button" class="btn btn-primary rounded-0 col-3" value="印刷" onclick="window.print()">
                <input type="button" class="btn btn-primary rounded-0 col-3" value="閉じる" onclick="location.href='../worker'">
            </div>

        </form>
    </section>
    <section>
        <?php
        $tuki = $_POST['tuki'] ?? 1;
        $nen = $_POST['nen'] ?? 2024;

        $firstday = strtotime(date('Y-m-d', strtotime($nen . '-' . $tuki . ' first day of this month')));
        $lastday = strtotime(date('Y-m-d', strtotime($nen . '-' . $tuki . ' last day of this month')));

        $todays = (($lastday - $firstday) / (60 * 60 * 24)) + 1;


        if (!empty($_POST['member'])) : ?>
            <div class="wrap">
                <table class="tbl">
                    <thead>
                        <tr>
                            <td class="text-center">No</td>
                            <td>年月日</td>
                            <td>氏名</td>
                            <td>出欠種類</td>
                            <td>日数</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "TRUNCATE TABLE cal_test";
                        $res = $dbh->query($sql);

                        for ($i = 1; $i < $todays + 1; $i++) {
                            $caldate = date('Y-m-d', strtotime($nen . '-' . $tuki . '-' . $i));
                            $sql = "INSERT INTO cal_test (CalDate) VALUES (:CalDate)";
                            $stmt = $dbh->prepare($sql);
                            $params = array(':CalDate' => $caldate);
                            $stmt->execute($params);
                        }

                        $calsql = "SELECT *,DAYOFWEEK(CalDate) AS wd FROM( SELECT * FROM worker_attendance_view WHERE WorkerNameID = " . $_POST['member'] . ") AS atview RIGHT JOIN cal_test ON atview.AttendanceDay=cal_test.CalDate;";
                        $calstmt = $dbh->query($calsql);
                        $nodw = 0;
                        while ($result = $calstmt->fetch(PDO::FETCH_BOTH)) : ?>
                            <tr style="background-color: <?= $color[$result['wd']] ?>;">
                                <td class="text-center"><?= $result['calID'] ?></td>
                                <td style="width: 1px; white-space: nowrap;padding-right:2em"><?= $result['CalDate'] . " (" . $week[$result['wd']] . ")" ?></td>
                                <td><?= $result['WorkerName'] ?></td>
                                <?php
                                if (!empty($result['watID2']) && !empty($result['watID'])) {
                                    $one2tow = " - ";
                                } else {
                                    $one2tow = '';
                                } ?>
                                <td><?= $result['AttendanceType'] . $one2tow . $result['AttendanceType2'] ?></td>
                                <td><?= $result['NumberOfDaysWorked'] ?></td>
                                <?php $nodw += $result['NumberOfDaysWorked'] ?>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td></td>
                            <td>合計</td>
                            <td></td>
                            <td></td>
                            <td><?= number_format($nodw ?? 0, 1) ?></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        <?php endif; ?>
    </section>
</body>

</html>