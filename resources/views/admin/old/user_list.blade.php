@extends('adminlte::page')

@section('title', '中濃森林組合　-ユーザー管理-')

@section('content_header')
<link rel="stylesheet" href="/css/cnu_table.css">
<script>
    window.onload = function() {
        document.getElementById("l99").checked = true;
        document.getElementById("l99-1").checked = true;
    }
</script>
<style>
    .lists tbody tr td {
        cursor: pointer;
        cursor: hand;
    }
</style>
<?php
$dbh = new PDO('mysql:host=localhost;dbname=dms;charset=utf8', 'root', '');
$sql = "SELECT * FROM users WHERE used = 1 ORDER BY id ASC";
$stmt = $dbh->query($sql);
?>
<h1 style="width: 100%;position:relative;">ユーザー管理
    <a style="top:0;right:0;position:absolute;" class="btn btn-secondary rounded-0" href="/bill/input">新規登録</a>
</h1>
@stop

@section('content')
<div class="hstwrap">

    <table class='lists'>
        <thead>
            <tr>
                <th>id</th>
                <th>名前</th>
                <th>部署</th>
                <th>所属</th>
                <th>役職</th>
            </tr>
        </thead>
        <tbody>
            <?php
            while ($result = $stmt->fetch(PDO::FETCH_BOTH)) {
                echo "<tr>";
                echo "<td id='userid' style='position:inherit;background:none;'>" . $result['id'] . "</td>";
                echo "<td>" . $result['name'] . "</td>";
                echo "<td>" . $result['department'] . "</td>";
                echo "<td>" . $result['section'] . "</td>";
                echo "<td>" . $result['position'] . "</td>";
                echo "</tr>";
            };
            ?>
        </tbody>
    </table>
</div>
@stop

@section('js')
<script>
    $('td').click(function(event) {
        const lid = $(this).parent().find('#userid').text()
        location.href = "/admin/user_edit?id=" + lid;
    });
</script>
<?php
$dbh = 0;
?>
@stop