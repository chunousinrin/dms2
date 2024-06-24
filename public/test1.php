<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <div class="wrap">
        <section>
            <?php
            $dbh = new PDO('mysql:host=localhost;dbname=cf756484_dms;charset=utf8', 'cf756484_root', 'AgVj4jDXzK');
            $yd = date('Y');
            $md = date('m');
            $week = ["1" => "日", "2" => "月", "3" => "火", "4" => "水", "5" => "木", "6" => "金", "7" => "土"];

            ?>
            <form action="" method="post" class="noprint">
                <select name="nen" id="nen" required>
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
                </select>年
                <select name="tuki" id="tuki" required>
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
                </select>月
                <select name="member" id="member" required>
                    <option value="" disabled selected>氏名を選択してください</option>
                    <?php
                    $membersql = "SELECT * FROM worker_group_member";
                    $memberstmt = $dbh->query($membersql);
                    while ($member = $memberstmt->fetch(PDO::FETCH_BOTH)) : ?>
                        <option value="<?= $member['WorkerNameID'] ?>"><?= $member['WorkerName'] ?></option>
                    <?php endwhile ?>
                </select>
                <input type="submit" value="submit">
            </form>
        </section>
        <section>
            <style>
                @page {
                    size: A4;
                    margin: 0;
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
                }


                .table {
                    width: 100%;
                    margin: 0 auto;
                    border-collapse: collapse;
                    font-size: 10pt;
                    color: #444444;
                }

                .table thead tr {
                    border-bottom: 2px solid #444444;
                }

                .table tbody tr {
                    border-bottom: 1px solid #444444;
                }

                .table tbody tr td {
                    padding: 0.2em 0;
                    ;
                }

                @media print {
                    body {}

                    .noprint {
                        display: none;
                    }
                }
            </style>
            <?php
            $tuki = $_POST['tuki'] ?? 1;
            $nen = $_POST['nen'] ?? 2024;

            $firstday = strtotime(date('Y-m-d', strtotime($nen . '-' . $tuki . ' first day of this month')));
            $lastday = strtotime(date('Y-m-d', strtotime($nen . '-' . $tuki . ' last day of this month')));

            $todays = (($lastday - $firstday) / (60 * 60 * 24)) + 1;


            if (!empty($_POST['member'])) : ?>
                <table class="table">
                    <thead>
                        <tr>
                            <td>ID</td>
                            <td>Date</td>
                            <td>NameID</td>
                            <td>Name</td>
                            <td>TypeID</td>
                            <td>Type</td>
                            <td>日数</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "TRUNCATE TABLE cal_Test";
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
                        while ($result = $calstmt->fetch(PDO::FETCH_BOTH)) : ?>
                            <tr>
                                <td><?= $result['calID'] ?></td>
                                <td><?= $result['CalDate'] . " (" . $week[$result['wd']] . ")" ?></td>
                                <td><?= $result['WorkerNameID'] ?></td>
                                <td><?= $result['WorkerName'] ?></td>
                                <td><?= $result['watID'] ?></td>
                                <td><?= $result['AttendanceType'] ?></td>
                                <td></td>
                            </tr>
                    <?php endwhile;
                    endif; ?>
                    </tbody>
                </table>
        </section>
    </div>
</body>

</html>