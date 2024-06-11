<?php
$sql = "SELECT * FROM customer_search ";

if (!empty($_GET['ckeyword'])) {
    $sql .= "where keyword Like '%" . $_GET['ckeyword'] . "%' ORDER BY CustomerID ASC";
}
$stmt = $dbh->query($sql);
?>

<form action="" method="get">
    <div class="search_box" style="padding-bottom: 1em;">
        <div class="input-group">
            <input class="form-control rounded-0" type="text" name="keyword" value="<?= $_GET['keyword'] ?? null ?>" placeholder="キーワード">
            <input class="btn btn-sm btn-secondary rounded-0 col-1" type="submit" value="検索">
        </div>
    </div>
</form>
<hr>
<form action="" name="customerlist" method="post">
    @csrf
    <div class="table-wrap">
        <table class="table table-bordered table-sm table-hover">
            <thead style="position: sticky;top:calc(-1em - 1px);">
                <tr class="table-success">
                    <td></td>
                    <td>ID</td>
                    <td>名称</td>
                    <td>住所</td>
                    <td>住所(その他)</td>
                    <td>電話番号</td>
                    <td>メールアドレス</td>
                    <td>備考</td>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($result = $stmt->fetch(PDO::FETCH_BOTH)) {
                    echo "<tr>";
                    echo "<td style='text-align:center;'>";
                    echo "<input class='btns btn btn-secondary rounded-0' style='background-image:url(https://icongr.am/feather/edit.svg?color=ffffff)' type='button' onclick='selided();'>";
                    echo "<input class='btns btn btn-secondary rounded-0' style='margin-right:0!important;background-image:url(https://icongr.am/fontawesome/trash-o.svg?color=ffffff);' type='button' onclick='seliddl();'></td>";
                    echo "</td>";
                    echo "<td style='text-align:center;'>" . $result['CustomerID'] . "</td>";
                    echo "<td>" . $result['name'] . "</td>";
                    echo "<td>" . $result['address1'] . "</td>";
                    echo "<td>" . $result['address2'] . "</td>";
                    echo "<td>" . $result['phone'] . "</td>";
                    echo "<td>" . $result['email'] . "</td>";
                    echo "<td>";
                    if (strlen($result['Remark']) > 25) {
                        echo mb_substr($result['Remark'], 0, 24) . "…" . "</td>";
                    } else {
                        echo $result['Remark'] . "</td>";
                    };
                    echo "</tr>";
                }
                ?>
        </table>
    </div>
    <input type="hidden" name="bizNumber" id="bizNumber">
    <input type="hidden" name="cdel" id="cdel">
    <input type="hidden" name="csedit" id="csedit">
</form>
<script>
    function selided() {
        $('td').click(function(event) {
            document.getElementById('bizNumber').value = $(this).next().text();
            document.getElementById("csedit").value = "csedit";
            document.customerlist.submit();
        })
    }

    function seliddl() {
        if (window.confirm('削除してもよろしいですか?')) { // 確認ダイアログを表示
            $('td').click(function(event) {
                document.getElementById('bizNumber').value = $(this).next().text();
                document.getElementById("cdel").value = "del";
                document.customerlist.submit();
            });

        } else { // 「キャンセル」時の処理
            window.alert('キャンセルされました'); // 警告ダイアログを表示
            return false; // 送信を中止
        }
    }
</script>