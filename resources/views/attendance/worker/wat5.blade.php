<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://code.jquery.com/ui/1.13.3/jquery-ui.js"></script>
    <?php

    use Illuminate\Support\Facades\DB;
    ?>
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

        .nodw input {
            width: 3em;
            text-align: center;
            margin: 0;
            padding: 0;
            outline: none;
            border: none;
            background-color: lightskyblue;
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

            .nodw input {
                background: none;
            }
        }
    </style>
</head>

<body>
    <section class="slctr noprint">
        <?php
        if (empty($_GET['ipt'])) {
            $ipt = "";
            $printlink = "?ipt=prnt";
        } elseif ($_GET['ipt'] === "admin") {
            $ipt = "admin";
            $printlink = "?ipt=admin";
        } else {
            $ipt = "";
            $printlink = "?ipt=prnt";
        }

        if ($ipt == "admin") : ?>
            <div style="position: absolute; top:0;left:0;background-color:chocolate;color:white;width:100%;text-align:center;">管理者モード</div>

        <?php endif ?>
        <?php
        $dbh = new PDO('mysql:host=localhost;dbname=' . env('DB_DATABASE') . ';charset=utf8', env('DB_USERNAME'), env('DB_PASSWORD'));
        $wgmsql = "SELECT count(*) AS wgm FROM worker_group_member";
        $wgmstmt = $dbh->query($wgmsql);
        $wgm = $wgmstmt->fetch();
        $yd = date('Y');
        $md = date('m');
        $week = ["1" => "日", "2" => "月", "3" => "火", "4" => "水", "5" => "木", "6" => "金", "7" => "土"];
        $color = ["1" => "#f5b1aa", "2" => "#fff", "3" => "#fff", "4" => "#fff", "5" => "#fff", "6" => "#fff", "7" => "#fff"];
        ?>
        <form action="" method="post">
            @csrf
            <div class="row g-0">
                <div class="col-2">
                    <select name="nen" id="nen" class="form-select px-1 rounded-0 border-info" required>
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
                    <select name="tuki" id="tuki" class="form-select px-1 rounded-0 border-info" required>
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
                <input type="submit" class="btn btn-info rounded-0 col-2 mr-1" value="表示">
                <input type="button" class="btn btn-info rounded-0 col-2 mr-1" value="印刷" onclick="window.print()">
                <input type="button" class="btn btn-info rounded-0 col-2" value="閉じる" onclick="location.href='../worker<?= $printlink ?>'">
            </div>
        </form>
    </section>
    <?php
    $tuki = $_POST['tuki'] ?? 1;
    $nen = $_POST['nen'] ?? 2024;

    $firstday = strtotime(date('Y-m-d', strtotime($nen . '-' . $tuki . ' first day of this month')));
    $lastday = strtotime(date('Y-m-d', strtotime($nen . '-' . $tuki . ' last day of this month')));

    $todays = (($lastday - $firstday) / (60 * 60 * 24)) + 1;


    $sql = "TRUNCATE TABLE cal_test";
    $res = $dbh->query($sql);

    for ($i = 1; $i < $todays + 1; $i++) {
        $caldate = date('Y-m-d', strtotime($nen . '-' . $tuki . '-' . $i));
        $sql = "INSERT INTO cal_test (CalDate) VALUES (:CalDate)";
        $stmt = $dbh->prepare($sql);
        $params = array(':CalDate' => $caldate);
        $stmt->execute($params);
    }
    ?>
    <?php
    for ($g = 1; $g < $wgm['wgm'] + 1; $g++) { ?>
        <?php
        $wgmnsql = "SELECT * FROM worker_group_member LEFT JOIN worker_group ON worker_group_member.WorkerGroupID=worker_group.WorkerGroupID WHERE worker_group_member.WorkerNameID = " . $g;
        $wgmnstmt = $dbh->query($wgmnsql);
        $wgmn = $wgmnstmt->fetch();
        ?>
        <section>
            <?php
            if (!empty($_POST['tuki'])) : ?>
                <div class="wrap">
                    <div class="mb-2"><?= $wgmn['WorkerGroupName'] . " : " . $wgmn['WorkerName'] ?>　出勤簿</div>
                    <table class="tbl" id="table">
                        <thead>
                            <tr>
                                <td class="text-center">No</td>
                                <td>年月日</td>
                                <td>出欠種類</td>
                                <td></td>
                                <td>日数</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $calsql = "SELECT *,DAYOFWEEK(CalDate) AS wd FROM( SELECT * FROM worker_attendance_view WHERE WorkerNameID = " . $g . ") AS atview RIGHT JOIN cal_test ON atview.AttendanceDay=cal_test.CalDate;";
                            $calstmt = $dbh->query($calsql);
                            $nodw = 0;
                            while ($result = $calstmt->fetch(PDO::FETCH_BOTH)) : ?>
                                <tr style="background-color: <?= $color[$result['wd']] ?>;">
                                    <td class="text-center"><?= $result['calID'] ?></td>
                                    <td style="width: 1px; white-space: nowrap;padding-right:2em"><?= $result['CalDate'] . " (" . $week[$result['wd']] . ")" ?></td>
                                    <?php
                                    if (!empty($result['watID2']) && !empty($result['watID'])) {
                                        $one2tow = " - ";
                                    } else {
                                        $one2tow = '';
                                    } ?>
                                    <td><?= $result['AttendanceType'] . $one2tow . $result['AttendanceType2'] ?></td>
                                    <td style="color:rgba(0,0,0,0)"><?= $result['waID'] ?></td>
                                    <td class="nodw">
                                        <?php if ($ipt == "admin") : ?>
                                            <?php if (!empty($result['NumberOfDaysWorked'])) : ?>
                                                <input onchange="document.getElementById('sqlnodw').value = $(this).val();submitNodw();" class="iptnodw" type="text" value="<?= $result['NumberOfDaysWorked'] ?>">
                                            <?php endif ?>
                                        <?php else : ?>
                                            <?= $result['NumberOfDaysWorked'] ?>
                                        <?php endif ?>
                                    </td>
                                    <?php $nodw += $result['NumberOfDaysWorked'] ?>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                        <?php
                        $vdsql = "SELECT COUNT(*)as vd ,DAYOFWEEK(CalDate) AS wd FROM( SELECT * FROM worker_attendance_view) AS atview RIGHT JOIN cal_test ON atview.AttendanceDay=cal_test.CalDate WHERE WorkerNameID = " . $g . " AND watID2 = 3";
                        $vdstmt = $dbh->query($vdsql);
                        $vd = $vdstmt->fetch();
                        $hvdsql = "SELECT COUNT(*)as hvd ,DAYOFWEEK(CalDate) AS wd FROM( SELECT * FROM worker_attendance_view) AS atview RIGHT JOIN cal_test ON atview.AttendanceDay=cal_test.CalDate WHERE WorkerNameID = " . $g . " AND watID2 = 5";
                        $hvdstmt = $dbh->query($hvdsql);
                        $hvd = $hvdstmt->fetch();
                        $svdsql = "SELECT COUNT(*)as svd ,DAYOFWEEK(CalDate) AS wd FROM( SELECT * FROM worker_attendance_view) AS atview RIGHT JOIN cal_test ON atview.AttendanceDay=cal_test.CalDate WHERE WorkerNameID = " . $g . " AND watID2 = 6";
                        $svdstmt = $dbh->query($svdsql);
                        $svd = $svdstmt->fetch();
                        //$cdsql = "SELECT COUNT(*)as cd ,DAYOFWEEK(CalDate) AS wd FROM( SELECT * FROM worker_attendance_view) AS atview RIGHT JOIN cal_test ON atview.AttendanceDay=cal_test.CalDate WHERE WorkerNameID = " . $g . " AND watID2 = 7";
                        $cdsql = "SELECT SUM(NumberOfDaysWorked)as cd ,DAYOFWEEK(CalDate) AS wd FROM( SELECT * FROM worker_attendance_view) AS atview RIGHT JOIN cal_test ON atview.AttendanceDay=cal_test.CalDate WHERE WorkerNameID = " . $g . " AND watID2 = 7";
                        $cdstmt = $dbh->query($cdsql);
                        $cd = $cdstmt->fetch();
                        if (!empty($cd['cd'])) { //労災
                            $cdd = $cd['cd'];
                        } else {
                            $cdd = 0;
                        };
                        $vdsum = (($vd['vd'] ?? 0)) + (($hvd['hvd'] ?? 0) * 0.5);
                        $nod = $nodw - $vdsum - $cdd;
                        ?>
                        <tfoot>
                            <tr>
                                <td></td>
                                <td></td>
                                <td style="text-align: right;" colspan="2">
                                    出勤：<?= number_format($nod ?? 0, 1) ?>
                                    　有給：<?= number_format($vdsum, 1) ?>
                                    　特休：<?= number_format($svd['svd'] ?? 0, 1) ?>
                                    　労災：<?= number_format($cdd, 1) ?>
                                    　合計：</td>
                                <td><?= number_format($nodw + $svd['svd'] ?? 0, 1) ?></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <div style="page-break-after: always;"></div>
            <?php endif; ?>
        </section>


    <?php } ?>

    <div style="display: none;">
        <iframe name="targetFrame"></iframe>

        <form name="targetForm">
            @csrf
            <input type="text" id="sqlswaid" name="sqlswaid">
            <input type="text" id="sqlnodw" name="sqlnodw">
        </form>
    </div>
    <script>
        $(".nodw").click(function() {
            swaid = $(this).prev().text();
            document.getElementById('sqlswaid').value = swaid;
        });

        function submitNodw() {
            if (window.confirm("選択された情報を削除します")) {
                document.targetForm.target = "targetFrame";
                document.targetForm.method = "post";
                document.targetForm.action = "wat55";
                document.targetForm.submit();
                return false;
            } else {
                // 「キャンセル」時の処理
                window.alert("キャンセルされました"); // 警告ダイアログを表示
                return false; // 送信を中止
            };
        }
    </script>
</body>

</html>