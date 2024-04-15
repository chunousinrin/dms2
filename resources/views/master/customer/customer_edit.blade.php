<?php
$sql = "SELECT * FROM customer WHERE CustomerID = " . $_POST['bizNumber'];
$stmt = $dbh->query($sql);
$result = $stmt->fetch();
?>
</style>
<form method="post" name="customeredit">
    @csrf
    <table class="etable table table-borderless table-hover">
        <tr>
            <td class="table-success">名称</td>
            <td>
                <input type="hidden" name="CustomerID" id="CustomerID" value="<?= $result['CustomerID'] ?>">
                <input class="form-control rounded-0" type="text" name="cname" id="cname" value="<?= $result['name'] ?>" required>
            </td>
        </tr>
        <tr>
            <td class="table-success">郵便番号</td>
            <td>
                <input class="form-control rounded-0" type="text" name="zip01" maxlength="8" value="<?= $result['post_code'] ?>" onKeyUp="AjaxZip3.zip2addr(this,'','addr11','addr11');">
            </td>
        </tr>
        <tr>
            <td class="table-success">住所</td>
            <td>
                <input class="form-control rounded-0" type="text" name="addr11" id="addr11" value="<?= $result['address1'] ?>">
            </td>
        </tr>
        <tr>
            <td class="table-success">住所(その他)</td>
            <td>
                <input class="form-control rounded-0" type="text" name="addr12" id="addr12" value="<?= $result['address2'] ?>">
            </td>
        </tr>
        <tr>
            <td class="table-success">電話番号</td>
            <td>
                <input class="form-control rounded-0" type="text" name="cphone" id="cphone" value="<?= $result['phone'] ?>">
            </td>
        </tr>
        <tr>
            <td class="table-success">メールアドレス</td>
            <td>
                <input class="form-control rounded-0" type="email" name="cemail" id="cemail" value="<?= $result['email'] ?>">
            </td>
        </tr>
        <tr>
            <td class="table-success">備考</td>
            <td>
                <textarea class="form-control rounded-0" name="cremark" id="cremark" rows="5"><?= $result['Remark'] ?></textarea>
            </td>
        </tr>
    </table>
    <div style="margin: 1em auto;text-align:center;">
        <input class="btn btn-secondary rounded-0 btn-sm px-4" type="button" name="btn_back" value="戻る" onclick="history.back()" style="padding-left:1em;padding-right:1em;">
        <button type="submit" class="btn btn-secondary rounded-0 btn-sm px-4">保存</button>
        <input type="hidden" name="editsave" id="editsave" value="editsave">
    </div>
</form>