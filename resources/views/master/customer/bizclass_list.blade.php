@extends('adminlte::page')

@section('title', '中濃森林組合　-マスタ管理-')

@section('content_header')

<link rel="stylesheet" href="/css/cnu_table.css">
<script src="https://ajaxzip3.github.io/ajaxzip3.js"></script>

<script>
    window.onload = function() {
        document.getElementById("l4").checked = true;
        document.getElementById("l4-1").checked = true;
    }

    function selided() {
        $('td').click(function(event) {
            document.getElementById('bizNumber').value = $(this).prev().prev().prev().text();
            document.getElementById("cedit").value = "edit";
            document.customerlist.submit();
        })
    }

    function seliddl() {
        if (window.confirm('削除してもよろしいですか?')) { // 確認ダイアログを表示
            $('td').click(function(event) {
                document.getElementById('bizNumber').value = $(this).prev().prev().prev().text();
                document.getElementById("cdel").value = "del";
                document.customerlist.submit();
            });

        } else { // 「キャンセル」時の処理
            window.alert('キャンセルされました'); // 警告ダイアログを表示
            return false; // 送信を中止
        }
    }

    function edsave() {
        document.getElementById("csave").value = "save";
        document.customeredit.submit();
    }
</script>
<style>
    .history_search {
        width: 100%;
        box-shadow: 2px 2px 3px rgba(0, 0, 0, 0.2);
        border: 1px solid silver;
        background-color: rgba(112, 189, 41, 0.3);
        padding: 1%;
        overflow: hidden;
    }

    .searchbox {
        display: inline-block;
        position: relative;
        width: 100%;
    }

    .searchbox::before {
        content: "";
        width: 16px;
        height: 16px;
        background: url(/images/search.svg) no-repeat center center / auto 100%;
        display: inline-block;
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        right: 5px;
    }

    .searchbox input {
        padding: 0.5%;
        width: 100%;
    }
</style>
<?php
//var_dump($_POST);
$dbh = new PDO('mysql:host=localhost;dbname=cfdms;charset=utf8', 'root', '');
?>
<h1 style="width: 100%;position:relative;">顧客管理
    <a href="customer/reg" class='btn btn-secondary rounded-0' style="margin-bottom: 1em;position:absolute;right:0;top:0;">新規登録</a>
</h1>

@stop

@section('content')
<?php
$page_flag = 0;

if (!empty($_POST['cedit'])) {
    $page_flag = 1;
} elseif (!empty($_POST['csave'])) {
    $page_flag = 2;
} elseif (!empty($_POST['cdel'])) {
    $page_flag = 3;
} else {
    $page_flag = 4;
}
?>

<?php if ($page_flag === 1) : ?>
    <?php
    $sql = "select * from customer where CustomerID = " . $_POST['bizNumber'];
    $stmt = $dbh->query($sql);
    $result = $stmt->fetch();
    ?>
    <caption>業務分類修正</caption>
    <form method="post" name="customeredit">
        @csrf
        <table class="tbl">
            <tr>
                <th style="width: 20%;">名称<span class="hissu">必須</span></th>
                <td><input type="hidden" name="CustomerID" id="CustomerID" value="<?= $result['CustomerID'] ?>">
                    <input class="iptbx" type="text" name="cname" id="cname" value="<?= $result['name'] ?>" required>
                </td>
            </tr>
            <tr>
                <th>郵便番号</th>
                <td>
                    <input class="iptbx" type="text" name="zip01" maxlength="8" value="<?= $result['post_code'] ?>" onKeyUp="AjaxZip3.zip2addr(this,'','addr11','addr11');">
                </td>
            </tr>
            <tr>
                <th>住所</th>
                <td>
                    <input class="iptbx" type="text" name="addr11" id="addr11" value="<?= $result['address1'] ?>">
                </td>
            </tr>
            <tr>
                <th>住所(その他)</th>
                <td>
                    <input class="iptbx" type="text" name="addr12" id="addr12" value="<?= $result['address2'] ?>">
                </td>
            </tr>
            <tr>
                <th>電話番号</th>
                <td>
                    <input class="iptbx" type="text" name="cphone" id="cphone" value="<?= $result['phone'] ?>">
                </td>
            </tr>
            <tr>
                <th>メールアドレス</th>
                <td>
                    <input class="iptbx" type="email" name="cemail" id="cemail" value="<?= $result['email'] ?>">
                </td>
            </tr>
            <tr>
                <th>備考</th>
                <td>
                    <textarea class="iptbx" name="cremark" id="cremark" cols="10" rows="5"><?= $result['Remark'] ?></textarea>
                </td>
            </tr>
        </table>
        <div style="width:100%;text-align:center;padding:1em 0;">
            <input class="btn btn-secondary rounded-0 send_input" type="button" name="btn_back" value="戻る" onclick="history.back()">
            <button class="btn btn-secondary rounded-0" onclick="edsave();">保存</button>
        </div>
        <input type="hidden" name="csave" id="csave">
    </form>
<?php elseif ($page_flag === 2) :
    try {
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //PDOのエラーレポートを表示

        $stmt = $dbh->prepare('UPDATE customer SET 
        name = :name,
        post_code = :post_code,
        address1 = :address1,
        address2 = :address2,
        phone = :phone,
        email = :email,
        Remark = :Remark
        WHERE CustomerID = :CustomerID
        ');

        $stmt->execute(
            array(
                ':name' => $_POST['cname'],
                ':post_code' => $_POST['zip01'],
                ':address1' => $_POST['addr11'],
                ':address2' => $_POST['addr12'],
                ':phone' => $_POST['cphone'],
                ':email' => $_POST['cemail'],
                ':Remark' => $_POST['cremark'],
                ':CustomerID' => $_POST['CustomerID']
            )
        );
    } catch (PDOException $e) {
        exit('データベースに接続できませんでした。' . $e->getMessage());
    }

?>
    <p>保存した</p>
    <a class="btn btn-secondary rounded-0" href="/customer">顧客管理トップ</a>
    <a class="btn btn-secondary rounded-0" href="/">Home</a>


<?php elseif ($page_flag === 3) :
    $sql = "DELETE FROM customer WHERE CustomerID = " . $_POST['bizNumber'];
    $stmt = $dbh->query($sql);
    $del = $stmt->fetch();
?>
    <p>削除完了</p>

    <a class="btn btn-secondary rounded-0" href="/customer">顧客管理トップ</a>
    <a class="btn btn-secondary rounded-0" href="/">Home</a>

<?php else :
    $sql = "SELECT * FROM classication ";

    if (!empty($_GET['keyword'])) {
        $sql .= "where Name Like '%" . $_GET['keyword'] . "%' ORDER BY Id ASC";
    }
    $stmt = $dbh->query($sql);
?>
    <form action="" method="get">
        <div class="history_search">
            <caption>検索</caption>
            <div class="searchbox">
                <input type="text" name="keyword" class="iptbx">
            </div><br>
            <input type="submit" value="検索" class="btn btn-secondary rounded-0" style="width: 100%;margin-top:1em;">
        </div>
        <hr>
    </form>

    <caption>業務分類一覧</caption>

    <div style="max-height:70vh;overflow-y:auto;box-shadow: 2px 2px 3px rgba(0, 0, 0, 0.2);">
        <form action="" name="customerlist" method="post">
            @csrf
            <?php
            echo "<table class='disp'>";
            echo "<thead><tr><th>ID</th><th>名称</th></tr></thead>";
            echo "<tbody>";
            //複数行表示の場合
            while ($result = $stmt->fetch(PDO::FETCH_BOTH)) {
                echo "\t<tr><td style='width:0;white-space: nowrap;text-align:center;'>" . $result['Id'] . "</td>\n";
                echo "\t\t<td style=''>" . $result['Name'] . "</td>\n";
               echo "\t<td style='text-align:right;;width:0;white-space: nowrap;'>";
                echo "<input class='histbtn btn btn-secondary rounded-0' style='background-image:url(/images/edit.svg)' onclick='selided();'>&nbsp;";
                echo "<input class='histbtn btn btn-secondary rounded-0' style='background-image:url(/images/trush.svg)' onclick='seliddl();'>";
                echo "</td>";
                echo "\t</tr>";
            };
            echo "</tbody>";
            echo "</table>";
            //接続終了処理
            $dbh = 0;
            ?>
    </div>
    <input type="hidden" name="bizNumber" id="bizNumber">
    <input type="hidden" name="cdel" id="cdel">
    <input type="hidden" name="cedit" id="cedit">
    </form>

<?php endif; ?>


@stop

@section('js')

@stop