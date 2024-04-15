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


@stop

@section('content')
<?php
if (!empty($_POST['btn_confirm'])) {
    $types = $_POST['btn_confirm'];
} else {
    $types = '表示';
}

$dbh = new PDO('mysql:host=localhost;dbname=dms;charset=utf8', 'root', '');
$sql = "SELECT * FROM users WHERE id = {$_GET['id']}";
$stmt = $dbh->query($sql);
$result = $stmt->fetch();
?>

<?php
if ($types == '保存') {

    $sql = "UPDATE users SET id = :userid,
    name = :username,
    department = :department,
    section = :section,
    position = :position,
     WHERE id = :userid";
    $stmt = $dbh->prepare($sql);
    $params = array(
        ':userid' => $_POST['userid'],
        ':username' => $_POST['username'],
        ':department' => $_POST['department'],
        ':section' => $_POST['section'],
        ':position' => $_POST['position'],
    );
    $stmt->execute($params);

    echo "<div>保存しました</div>
    <a class='btn btn-secondary rounded-0' href='/admin/user_list'>ユーザー管理トップ</a>
    <a class='btn btn-secondary rounded-0' href='/'>Home</a>";
} elseif ($types == '表示') {
?>

    <form action="" method="post">
        @csrf
        <ul class="lst">
            <li>
            </li>
            <li>
                <div class="lbl">
                    <label for="">id</label>
                </div>
                <div class="ipt">
                    <input readonly style="outline: none;background:none" type="text" name="userid" value="<?= $result['id'] ?>">
                </div>
            </li>
            <li>
                <div class="lbl">
                    <label for="">名前</label>
                </div>
                <div class="ipt">
                    <input type="text" name="username" value="<?= $result['name'] ?>" required>
                </div>
            </li>
            <li>
                <div class="lbl">
                    <label for="">部署</label>
                </div>
                <div class="ipt">
                    <input type="text" name="department" value="<?= $result['department'] ?>">
                </div>
            </li>
            <li>
                <div class="lbl">
                    <label for="">所属</label>
                </div>
                <div class="ipt">
                    <input type="text" name="section" value="<?= $result['section'] ?>">
                </div>
            </li>
            <li>
                <div class="lbl">
                    <label for="">役職</label>
                </div>
                <div class="ipt">
                    <input type="text" name="position" value="<?= $result['position'] ?>">
                </div>
            </li>
        </ul>

        <div style="width:100%; margin:0 auto;padding:10px 0;text-align:center;">
            <input class="btn btn-secondary rounded-0 send_input" type="button" name="btn_back" value="戻る" onclick="history.back()">
            <input class="btn btn-secondary rounded-0" type="submit" name="btn_confirm" value="保存">
        </div>
    </form>
<?php
}
?>

@stop

@section('js')
<?php
$dbh = 0;
?>

@stop