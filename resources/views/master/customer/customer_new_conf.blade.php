<form method="post" name="customeredit">
    @csrf

    <table class="etable table table-borderless table-hover">
        <tr>
            <td class="table-success">名称</td>
            <td>
                <input class="form-control rounded-0" readonly type="text" name="cname" value="<?= $_POST['cname'] ?>">
            </td>
        </tr>
        <tr>
            <td class="table-success">郵便番号</td>
            <td>
                <input class="form-control rounded-0" readonly type="text" name="zip01" value="<?= $_POST['zip01'] ?>">
            </td>
        </tr>
        <tr>
            <td class="table-success">住所</td>
            <td>
                <input class="form-control rounded-0" readonly type="text" name="addr11" value="<?= $_POST['addr11'] ?>">
            </td>
        </tr>
        <tr>
            <td class="table-success">住所(その他)</td>
            <td>
                <input class="form-control rounded-0" readonly type="text" name="addr12" value="<?= $_POST['addr12'] ?>">
            </td>
        </tr>
        <tr>
            <td class="table-success">電話番号</td>
            <td>
                <input class="form-control rounded-0" readonly type="text" name="cphone" value="<?= $_POST['cphone'] ?>">
            </td>
        </tr>
        <tr>
            <td class="table-success">メールアドレス</td>
            <td>
                <input class="form-control rounded-0" readonly type="text" name="cemail" value="<?= $_POST['cemail'] ?>">
            </td>
        </tr>
        <tr>
            <td class="table-success">備考</td>
            <td>
                <input class="form-control rounded-0" readonly type="text" name="cremark" value="<?= $_POST['cremark'] ?>">
            </td>
        </tr>
    </table>

    <div style="width:100%;text-align:center;padding:1em 0;">
        <input class="btn btn-secondary rounded-0 btn-sm px-4" type="button" name="btn_back" value="戻る" onclick="history.back()">
        <button type="submit" class="btn btn-secondary rounded-0 btn-sm px-4">確認</button>
        <input type="hidden" name="newsave" id="newsave" value="newsave">

    </div>
</form>