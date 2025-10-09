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

ini_set('display_errors', 1);
error_reporting(E_ALL);

$host = 'localhost';
$db = env('DB_DATABASE') ?: 'cf756484_dms';
$user = env('DB_USERNAME') ?: 'cf444722_root';
$pass = env('DB_PASSWORD') ?: 'U7jC6Xaq';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE   => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES  => false,
];

$current_year = (int)date('Y');
$current_month = (int)date('m');

$year = filter_input(INPUT_POST, 'year', FILTER_VALIDATE_INT)
    ?? filter_input(INPUT_GET, 'year', FILTER_VALIDATE_INT)
    ?? $current_year;

$month = filter_input(INPUT_POST, 'month', FILTER_VALIDATE_INT)
    ?? filter_input(INPUT_GET, 'month', FILTER_VALIDATE_INT)
    ?? $current_month;

if ($month < 1 || $month > 12) {
    $month = $current_month;
}

$selected_worker_id = filter_input(INPUT_POST, 'worker_id', FILTER_VALIDATE_INT)
    ?? filter_input(INPUT_GET, 'worker_id', FILTER_VALIDATE_INT);

$action = filter_input(INPUT_POST, 'action', FILTER_DEFAULT)
    ?? filter_input(INPUT_GET, 'action', FILTER_DEFAULT);

$action = is_string($action) ? trim($action) : null;

$workers = [];
$daily_report_data = [];

$attendance_types_map = [
    '出勤' => 0.0,
    '有給' => 0.0,
    '特別休暇' => 0.0,
    '労災' => 0.0
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);

    $stmt_workers = $pdo->query("
SELECT DISTINCT
WorkerNameID,
CONCAT(WorkerName, ' (', WorkerGroupName, ')') AS WorkerDisplay
FROM
worker_attendance_view
WHERE WorkerName IS NOT NULL
ORDER BY
WorkerGroupID, rownum
");
    $workers = $stmt_workers->fetchAll(PDO::FETCH_KEY_PAIR);

    $target_action_is_all = ($action === 'print_output');
    $db_data_all = [];

    if ($target_action_is_all || $selected_worker_id) {
        $where_worker = $selected_worker_id ? "AND WorkerNameID = :worker_id" : "";

        $sql_data = "
SELECT DISTINCT
    AttendanceDay,
    WorkerNameID,
    WorkerName,
    WorkerGroupName,
    AttendanceType,
    AttendanceType2,
    NumberOfDaysWorked
FROM
    worker_attendance_view
WHERE
    YEAR(AttendanceDay) = :year AND MONTH(AttendanceDay) = :month {$where_worker}
ORDER BY
    WorkerNameID, AttendanceDay
";

        $stmt_data = $pdo->prepare($sql_data);
        $params = ['year' => $year, 'month' => $month];
        if ($selected_worker_id) {
            $params['worker_id'] = $selected_worker_id;
        }
        $stmt_data->execute($params);
        $db_data_all = $stmt_data->fetchAll();
    }

    $grouped_data = [];

    foreach ($db_data_all as $row) {
        $wid = $row['WorkerNameID'];
        $date_key = $row['AttendanceDay'];
        $attendance_type1 = $row['AttendanceType'];
        $attendance_type2 = $row['AttendanceType2'];
        $days_worked = (float)$row['NumberOfDaysWorked'];

        if (!isset($grouped_data[$wid])) {
            $grouped_data[$wid] = [
                'WorkerName' => $row['WorkerName'],
                'WorkerGroupName' => $row['WorkerGroupName'],
                'DailyData' => [],
                'TotalAttendance' => $attendance_types_map
            ];
        }

        if (!isset($grouped_data[$wid]['DailyData'][$date_key])) {
            $grouped_data[$wid]['DailyData'][$date_key] = [
                'AttendanceTypes' => [],
                'TotalWorkedDays' => 0.0,
            ];
        }

        if (!empty($attendance_type1)) {
            $grouped_data[$wid]['DailyData'][$date_key]['AttendanceTypes'][] = $attendance_type1;
        }
        if (!empty($attendance_type2)) {
            $grouped_data[$wid]['DailyData'][$date_key]['AttendanceTypes'][] = $attendance_type2;
        }

        $grouped_data[$wid]['DailyData'][$date_key]['TotalWorkedDays'] += $days_worked;


        if ($attendance_type1 === '出勤') {
            if ($attendance_type2 === '半日欠勤' || $attendance_type2 === '半日有給') {
                $grouped_data[$wid]['TotalAttendance']['出勤'] += 0.5;
            } else {
                $grouped_data[$wid]['TotalAttendance']['出勤'] += 1.0;
            }
        }

        if ($attendance_type1 === '一日有給' || $attendance_type2 === '一日有給') {
            $grouped_data[$wid]['TotalAttendance']['有給'] += 1.0;
        } elseif ($attendance_type1 === '半日有給' || $attendance_type2 === '半日有給') {
            $grouped_data[$wid]['TotalAttendance']['有給'] += 0.5;
        }

        if ($attendance_type1 === '特別休暇' || $attendance_type2 === '特別休暇') {
            $grouped_data[$wid]['TotalAttendance']['特別休暇'] += 1.0;
        }

        if ($attendance_type1 === '労災' || $attendance_type2 === '労災') {
            $grouped_data[$wid]['TotalAttendance']['労災'] += $days_worked;
        }
    }


    $days_in_month = cal_days_in_month(CAL_GREGORIAN, $month, $year);

    foreach ($grouped_data as $wid => $worker_info) {
        $final_report = [];
        $daily_db_data = $worker_info['DailyData'];

        $total_days_worked = array_sum($worker_info['TotalAttendance']);

        $worker_name_escaped = htmlspecialchars($worker_info['WorkerName']);
        $group_name_escaped = htmlspecialchars($worker_info['WorkerGroupName']);

        for ($day = 1; $day <= $days_in_month; $day++) {
            $date_str = sprintf('%04d-%02d-%02d', $year, $month, $day);
            $timestamp = strtotime($date_str);
            $day_index = date('w', $timestamp);
            $is_sunday = ($day_index == 0);

            $report_row = [
                'AttendanceDay' => $date_str,
                'WorkerName' => $worker_name_escaped,
                'WorkerGroupName' => $group_name_escaped,
                'IsSunday' => $is_sunday
            ];

            if (isset($daily_db_data[$date_str])) {
                $data = $daily_db_data[$date_str];
                $types_raw = array_unique($data['AttendanceTypes']);
                $types_escaped = array_map('htmlspecialchars', $types_raw);

                $report_row['AttendanceDisplay'] = implode(' - ', $types_escaped);
                $report_row['NumberOfDaysWorked'] = $data['TotalWorkedDays'];
                $report_row['IsEmpty'] = false;
            } else {
                $report_row['AttendanceDisplay'] = '';
                $report_row['NumberOfDaysWorked'] = 0.0;
                $report_row['IsEmpty'] = true;
            }
            $final_report[] = $report_row;
        }

        $worker_info['TotalDaysWorked'] = $total_days_worked;
        $daily_report_data[$wid]['ReportData'] = $final_report;
        $daily_report_data[$wid]['WorkerInfo'] = $worker_info;
    }
} catch (PDOException $e) {
    exit("データベースエラー: " . htmlspecialchars($e->getMessage()));
}


$reports_to_output = [];
if ($action === 'print_output') {
    $reports_to_output = $daily_report_data;
} elseif ($selected_worker_id && isset($daily_report_data[$selected_worker_id])) {
    $reports_to_output = [$selected_worker_id => $daily_report_data[$selected_worker_id]];
}


?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($year); ?>年<?php echo htmlspecialchars($month); ?>月度 日報</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <style>
        /* 画面表示用スタイル */
        body {
            font-family: 'Hiragino Kaku Gothic Pro', 'Meiryo', sans-serif;
            margin: 0;
            background-color: rgba(2, 51, 40, 0.2);
            /* ヘッダーの高さ分、コンテンツ全体を下にずらす */
            padding-top: 100px;
        }

        /* 固定ヘッダーのスタイル */
        header {
            position: fixed;
            /* 画面に固定 */
            top: 0;
            /* 上端に配置 */
            left: 0;
            /* 左端に配置 */
            width: 100%;
            /* 幅を画面全体に */
            z-index: 100;
            /* 他の要素の上に表示 */
            margin: 0;
            background-color: white;
            border-bottom: 2px solid #000;
            padding: 10px 0 10px 0;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        /* レポートコンテナ内のh1（レポートタイトル）は画面で非表示 */
        .report-container h1 {
            display: none;
        }

        /* --- Flexbox 適用箇所 --- */
        .selector-box {
            display: flex;
            justify-content: center;
            /* フォーム全体を中央揃え */
            flex-direction: column;
            /* フォームの中のグループを縦に並べる（既存の構造を維持） */
            padding: 5px 20% 10px 20%;
            border: none;
            background-color: #fff;
        }

        .selector-group {
            /* 変更: 年月とボタンを横並びにする */
            display: flex;
            align-items: center;
            /* フォームの年/月/一括印刷ボタンのグループ */
            margin-bottom: 10px;
            /* 中央揃え */
            justify-content: center;
        }

        .worker-select-group {
            /* 変更: 従業員選択/個別表示ボタンのグループ */
            display: flex;
            align-items: center;
            margin-top: 10px;
            /* 中央揃え */
            justify-content: center;
        }

        /* --- Flexbox 適用箇所 終 --- */


        /* 選択/ボタン要素のスタイルをブラウザデフォルトに戻す（残っていたmargin-rightのみ維持） */
        .selector-box label,
        .selector-box select,
        .selector-box button {
            margin-right: 10px;

        }

        /* 個別ボタンの margin-left のみ残す */
        .print-dialog-btn {
            margin-left: 20px;
            margin-right: 10px;
            /* .selector-box button のスタイルを継承 */
        }

        /* 一括印刷ボタンと個別表示ボタンの間のスペースを維持 */
        .print-btn {
            margin-right: 10px;
        }


        /* 印刷用ヘッダー (print_outputアクション時に表示) */
        .print-header-display {
            text-align: center;
            font-size: 1.5em;
            font-weight: bold;
            display: none;
            /* 画面表示時は非表示 */
        }

        /* 🌟 画面表示時に、ヘッダー直下の最初のレポートコンテナにマージンを追加 */
        body>.report-container:first-of-type {
            margin-top: 50px;
            /* 既存の20pxから増量 */
        }

        .report-container {
            width: 210mm;
            min-height: 297mm;
            margin: 20px auto;
            padding: 15mm;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            background-color: #fff;
            border: 1px solid #ccc;
        }

        /* 🌟 従業員情報の表示を強調 */
        .report-worker-info {
            margin: 5px 0 10px 0;
            font-size: 1.1em;
            font-weight: bold;
            /* 名前を強調 */
        }


        /* テーブルの縦線を削除し、横線のみ残す */
        table {
            width: 100%;
            border-collapse: collapse;
            border: none;
            /* 🌟 画面表示時もテーブルレイアウトを固定 */
            table-layout: fixed;
        }

        th,
        td {
            border-top: none;
            border-left: none;
            border-right: none;
            border-bottom: 1px solid #000;
            padding: 8px;
            font-size: 10pt;
        }

        /* 🌟 画面表示時にもカラム幅を設定 */
        .report-container thead th:nth-child(1),
        .report-container tbody td:nth-child(1),
        .report-container tfoot td:nth-child(1) {
            width: 20%;
        }

        .report-container thead th:nth-child(2),
        .report-container tbody td:nth-child(2),
        .report-container tfoot td:nth-child(2) {
            width: 70%;
            text-align: left;
            /* 出欠種類は左寄せ */
        }

        .report-container thead th:nth-child(3),
        .report-container tbody td:nth-child(3),
        .report-container tfoot td:nth-child(3) {
            width: 10%;
            text-align: right;
            /* 日数列を右寄せに */
        }

        /* thは背景色なし、左寄せ、フォントウェイトをノーマルに */
        th {
            background-color: transparent;
            text-align: left;
            font-weight: normal;
        }

        /* theadの最終行に太い下線を追加 */
        .report-container thead tr:last-child th {
            border-bottom: 2px solid #000 !important;
        }

        /* tbodyの最終行の罫線は太線に戻す */
        .report-container tbody tr:last-child td {
            border-bottom: 2px solid #000 !important;
        }

        /* tfootの罫線を調整 (1行に集約) */
        .report-container tfoot tr:first-child td {
            border-top: 2px solid #000 !important;
            border-bottom: none !important;
            padding: 10px 8px;
            /* 上下左右パディングを調整 */
            text-align: right !important;
        }

        /* カテゴリ別合計のFlexbox設定 (画面表示時) */
        .category-totals {
            display: flex;
            justify-content: flex-end;
            /* 右端に寄せる */
            align-items: center;
            width: 100%;
            /* td全体を使用 */
        }

        .category-totals span {
            /* 各カテゴリの合計 */
            margin-left: 20px;
            white-space: nowrap;
            /* 折り返し禁止 */
        }

        /* 総合計は太字で強調 */
        .grand-total-style {
            font-weight: bold;
        }

        /* 出欠種類のtdは左寄せを維持 */
        .text-left {
            text-align: left;
        }

        /* 日曜日のスタイル */
        .sunday-highlight {
            background-color: #f5b1aa;
            color: #000;
        }

        /* データなしメッセージのスタイル */
        .no-data-message {
            text-align: center;
            margin-top: 50px;
        }

        /* --- 印刷用スタイル --- */

        @page {
            /* 印刷ダイアログでマージンを制御できるよう、CSSでは最小限に設定または削除 */
            size: A4 portrait;
        }


        @media print {

            /* 1. 非表示にする要素 */
            .selector-box,
            .print-btn,
            .print-dialog-btn,
            hr,
            body>h1,
            body>p,
            header {
                display: none !important;
                /* 印刷時は固定ヘッダーを非表示 */
            }

            /* bodyのpaddingを上下左右10mmに設定 */
            body {
                padding: 5mm 10mm 0 10mm !important;
            }

            /* print-header-display は印刷時に表示に戻す */
            .print-header-display {
                display: block !important;
                margin-bottom: 10mm;
                /* タイトルと最初のレポートの間にスペースを追加 */
            }

            /* レポートコンテナ内のh1 は印刷時も非表示にする */
            .report-container h1 {
                display: none !important;
                margin-top: 0;
                margin-bottom: 0;
            }

            /* 2. レポートコンテナの表示設定 */
            .report-container {
                display: block !important;
                width: 100% !important;
                min-height: auto !important;
                margin: 0 auto !important;
                /* bodyのpaddingを適用するため、レポートコンテナのマージンは0 */
                padding: 0 !important;
                box-shadow: none !important;
                background-color: #fff !important;
                border: none !important;
                page-break-after: always;
                /* レポートごとに改ページ */
                max-width: 210mm;
            }

            /* 3. レポート内の要素（pタグ含む）は表示に戻す */
            .report-container .report-worker-info {
                display: block !important;
                margin: 5mm 0 5px 0 !important;
                /* 上下左右のマージンをmm単位で設定 (印刷用) */
                font-weight: bold;
                /* 印刷時も強調を維持 */
            }

            /* 4. テーブルのレイアウトとフォントサイズ調整 */
            table {
                width: 100%;
                table-layout: fixed;
                font-size: 8.5pt;
                border-collapse: collapse;
                border: none;
            }

            th,
            td {
                border-left: none !important;
                border-right: none !important;
                border-top: none !important;
                border-bottom: 1px solid #000 !important;
                padding: 4px;
                word-break: break-word;
                text-align: left !important;
                /* 印刷時、すべてのセルをデフォルトで左寄せに */
            }

            /* 日数列（3列目）のみを印刷時も右寄せに */
            .report-container tbody td:nth-child(3) {
                text-align: right !important;
            }

            .report-container thead th:nth-child(3) {
                text-align: right !important;
            }


            /* thを印刷時も左寄せ、フォントウェイトをノーマルに設定 */
            .report-container thead th {
                text-align: left !important;
                /* 日付ヘッダー（1列目）と出欠種類ヘッダー（2列目）を左寄せに */
                font-weight: normal !important;
            }

            /* 出欠種類（2列目）のデータ部分を左寄せに上書き */
            .report-container tbody td:nth-child(2) {
                text-align: left !important;
            }


            /* 印刷時もtheadの最終行とtbodyの最終行に太い下線を追加 */
            .report-container thead tr:last-child th {
                border-bottom: 2px solid #000 !important;
            }

            .report-container tbody tr:last-child td {
                border-bottom: 2px solid #000 !important;
            }

            /* tfootの罫線を太線に (1行に集約) */
            .report-container tfoot tr:first-child td {
                border-top: 2px solid #000 !important;
                border-bottom: none !important;
                padding: 6px 4px !important;
            }

            /* カテゴリ別合計の表示調整 (印刷用はFlexboxを解除し、インラインで表示) */
            .category-totals {
                display: block !important;
                /* Flexboxを解除 */
                text-align: right !important;
                /* td全体を右寄せに */
                font-size: 9pt !important;
                padding-left: 0 !important;
                white-space: normal !important;
                /* 折り返しを許可 */
            }

            .category-totals span {
                /* 各カテゴリを横並びにするための調整 */
                display: inline-block;
                margin-right: 10px;
                /* 要素間のスペース */
                font-size: 8.5pt !important;
                /* カテゴリ合計のフォントサイズ調整 */
                margin-left: 0 !important;
                /* 画面表示時のマージンをリセット */
            }

            .grand-total-style {
                /* 印刷時はinline-blockで横並びに */
                display: inline-block;
                font-size: 9pt !important;
                margin-left: 15px !important;
                font-weight: bold !important;
            }


            /* カラム幅の比率を調整 (日付, 出欠種類, 日数の3カラム構成) */
            .report-container thead th:nth-child(1),
            .report-container tbody td:nth-child(1),
            .report-container tfoot td:nth-child(1) {
                width: 20%;
            }

            .report-container thead th:nth-child(2),
            .report-container tbody td:nth-child(2),
            .report-container tfoot td:nth-child(2) {
                width: 70%;
            }

            .report-container thead th:nth-child(3),
            .report-container tbody td:nth-child(3),
            .report-container tfoot td:nth-child(3) {
                width: 10%;
            }

            /* 5. 背景色を強制 (日曜日の強調) */
            .sunday-highlight {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
                background-color: #f5b1aa !important;
                color: #000 !important;
            }
        }
    </style>
</head>

<body>
    <header>
        <?php /* <h1>従業員別 日別日報</h1> */ ?>

        <div class="selector-box">
            <form method="post" action="">
                @csrf
                <div class="selector-group">
                    <select name="year" id="year" class="form-select rounded-0" style="width: 8em;">
                        <?php for ($y = $current_year; $y >= $current_year - 5; $y--): ?>
                            <option value="<?php echo $y; ?>" <?php echo ($y == $year) ? 'selected' : ''; ?>><?php echo $y; ?></option>
                        <?php endfor; ?>
                    </select>
                    <label for="year">年</label>

                    <select name="month" id="month" class="form-select rounded-0" style="width: 8em;">
                        <?php for ($m = 1; $m <= 12; $m++): ?>
                            <option value="<?php echo $m; ?>" <?php echo ($m == $month) ? 'selected' : ''; ?>><?php echo sprintf('%02d', $m); ?></option>
                        <?php endfor; ?>
                    </select>
                    <label for="month">月</label>

                    <button type="submit" name="action" value="print_output" class="print-btn btn btn-secondary rounded-0 m-0 me-1 px-5">表示</button>

                    <?php if (!empty($reports_to_output)): ?>
                        <button type="button" onclick="window.print()" class="print-dialog-btn btn btn-secondary rounded-0 m-0 me-1 px-5">印刷</button>
                    <?php endif; ?>

                    <input type="button" class="btn btn-secondary rounded-0 m-0 px-5" value="閉じる" onclick="location.href='../worker<?= $printlink ?>'">

                </div>
                <hr>
                <div class="worker-select-group">
                    <label for="worker_id">従業員名 (個別表示):</label>
                    <select name="worker_id" id="worker_id" class="form-select rounded-0 w-25">
                        <option value="">-- 全員選択 (印刷用) --</option>
                        <?php
                        foreach ($workers as $id => $name_group) {
                            $selected = ($id == $selected_worker_id) ? 'selected' : '';
                            echo "<option value=\"{$id}\" {$selected}>" . htmlspecialchars($name_group) . "</option>";
                        }
                        ?>
                    </select>

                    <button type="submit" name="action" value="show_report" class="btn btn-secondary rounded-0 m-0 px-5">個別表示</button>
                </div>
            </form>
        </div>

        <?php if ($action === 'print_output' && !empty($reports_to_output)): ?>
            <h1 class="print-header-display">
                <?php echo htmlspecialchars($year); ?>年<?php echo htmlspecialchars($month); ?>月度 全従事者日報 (印刷用)
            </h1>
        <?php endif; ?>
    </header>

    <?php if (empty($reports_to_output)): ?>
        <p class="no-data-message">
            <?php
            if ($action === 'print_output') {
                echo htmlspecialchars("該当月にデータがある従業員がいません。");
            } elseif ($selected_worker_id) {
                echo htmlspecialchars("選択された従業員のデータがありません。");
            }
            ?>
        </p>
    <?php else: ?>
        <?php
        $day_of_week_ja = ['日', '月', '火', '水', '木', '金', '土'];

        foreach ($reports_to_output as $wid => $report_data_set):

            $report_data = $report_data_set['ReportData'];
            $worker_info = $report_data_set['WorkerInfo'];

            $worker_name = $worker_info['WorkerName'];
            $group_name = $worker_info['WorkerGroupName'];
            $total_days_worked = $worker_info['TotalDaysWorked'];
            $total_attendance = $worker_info['TotalAttendance'];
        ?>
            <div class="report-container">
                <p class="report-worker-info">
                    <?php echo $group_name; ?>：<?php echo $worker_name; ?>　出勤簿
                </p>

                <table>
                    <thead>
                        <tr>
                            <th>年月日</th>
                            <th class="text-left">出欠種類</th>
                            <th style="text-align: right!important;">日数</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($report_data as $data): ?>
                            <?php
                            $timestamp = strtotime($data['AttendanceDay']);
                            $date_part = date('Y-m-d', $timestamp);
                            $day_index = date('w', $timestamp);
                            $display_date = $date_part . ' (' . $day_of_week_ja[$day_index] . ')';

                            $row_class = $data['IsSunday'] ? 'sunday-highlight' : '';
                            ?>
                            <tr class="<?php echo $row_class; ?>">

                                <td><?php echo $display_date; ?></td>

                                <td class="text-left">
                                    <?php
                                    echo $data['AttendanceDisplay'];
                                    ?>
                                </td>

                                <td style="text-align: right!important;">
                                    <?php
                                    if (!empty($data['AttendanceDisplay'])) {
                                        echo number_format($data['NumberOfDaysWorked'], 1);
                                    }
                                    ?>
                                </td>

                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <?php
                        $total_attendance = $worker_info['TotalAttendance'];
                        ?>

                        <tr>
                            <td colspan="3" class="">
                                <?php
                                $output = "";
                                foreach (['出勤', '有給', '特別休暇', '労災'] as $key) {
                                    $value = number_format($total_attendance[$key], 1);
                                    $output .= "<span style='margin-right:1em;'>{$key}: {$value}</span>";
                                }
                                echo $output;
                                ?>

                                <span class="grand-total-style">
                                    合計: <?php echo number_format($total_days_worked, 1); ?>
                                </span>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>

</body>

</html>