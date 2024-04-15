@extends('adminlte::page')
@section('title', 'Dashboard')

@section('content_header')
<link rel="stylesheet" href="/css/cnu_home.css">
<script>
    window.onload = function() {
        document.getElementById("l1").checked = true;
    }
</script>
<?php
$dbh = new PDO('mysql:host=localhost;dbname=cfdms;charset=utf8', 'root', '');
?>
@stop

@section('content')
<!--勤怠管理＠include('attendance.attendance')-->

<hr>
<ul class="homecnt">
    <li class="homeitem odr1">
        <h5 class="mtitle">トピックス</h5>
        <div>
            <ul class="hometp">
                <li><span>2023/10/05</span>稟議書の長文印刷に対応しました。</li>
                <li><span>2023/08/23</span>税抜き金額での見積書作成に対応しました。</li>
                <li><span>2023/07/26</span>業務日報機能を追加しました。</li>
                <li><span>2023/07/25</span>請求書作成時の振込先を選択式にしました。</li>
                <li><span>2023/06/29</span>保存済み請求書、見積書から送付文書作成機能を追加しました。</li>
                <li><span>2023/06/06</span>保存済み見積書からの請求書作成に対応しました。</li>
                <li><span>2023/05/11</span>見積書の金額非表示(単価見積)に対応しました。</li>
                <li><span>2023/04/04</span>サイトを公開しました。</li>
            </ul>
        </div>
    </li>
    <li class="homeitem odr2">
        <h5 class="mtitle">許可期限&nbsp;<span style="font-weight:normal;font-size: 0.9rem;color:rgba(0,0,0,1);">期限まで60日以内を表示しています</span></h5>
        <div style="height:calc(100% - 2em);overflow-y:auto;border: 1px solid silver;">
            <table class="hometb">
                <thead>
                    <tr>
                        <th>残日数</th>
                        <th>名称</th>
                        <th>期限日</th>
                        <th>着手届</th>
                        <th>完了届</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT * FROM license_history WHERE lmt BETWEEN 0 AND 60";
                    $stmt = $dbh->query($sql);
                    while ($result = $stmt->fetch(PDO::FETCH_BOTH)) {
                        echo "<tr>";
                        echo "<td style='text-align:center;'>" . $result['lmt'] . "</td>";
                        echo "<td style='white-space:nowrap;'>" . $result['FacilityName'] . "</td>";
                        echo "<td style='text-align:center;'>" . $result['LicensedEndDate'] . "</td>";
                        echo "<td style='text-align:center;'>" . $result['StartDate'] . "</td>";
                        echo "<td style='text-align:center;'>" . $result['CompletionDate'] . "</td>";
                        echo "</tr>";
                    };

                    ?>
                </tbody>
            </table>
        </div>
    </li>
    <li class="homeitem odrlast">
        <h5 class="mtitle">カレンダー</h5>
        <div style="height:calc(100% - 2em)">
            <?php
            include('calender.php');
            ?>
        </div>
    </li>
    <li class="homeitem odr3">
        <h5 class="mtitle">最新の投稿</h5>
        <div style="height:calc(100% - 2em);overflow:auto;border: 1px solid silver;">
            <table class="hometb">
                <thead>
                    <tr>
                        <th>作成日</th>
                        <th>種類</th>
                        <th>作成者</th>
                        <th>タイトル</th>
                        <th>金額</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT * FROM all_document";
                    $stmt = $dbh->query($sql);
                    while ($docs = $stmt->fetch(PDO::FETCH_BOTH)) {
                        echo "<tr>";
                        echo "<td style='text-align:center;'>" . $docs['CreatedDate'] . "</td>";
                        echo "<td style='text-align:center;'>" . $docs['DocType'] . "</td>";
                        echo "<td style=''>" . $docs['UserName'] . "</td>";
                        echo "<td style=''>" . $docs['Title'] . "</td>";
                        echo "<td style='text-align:right;'>";
                        if (!empty($docs['price'])) {
                            echo number_format($docs['price']) . "</td>";
                        }
                        echo "</tr>";
                    };

                    ?>
                </tbody>
            </table>
        </div>

    </li>
</ul>

@yield('content')

@stop

@section('js')
<?php
$dbh = 0;
?>
@stop