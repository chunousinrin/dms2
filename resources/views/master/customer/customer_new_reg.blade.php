<form method="post" name="customeredit">
    @csrf

    <table class="etable table table-borderless table-hover">
        <tr>
            <td class="table-success">名称</td>
            <td>
                <input class="form-control rounded-0" type="text" name="cname" id="cname" required>
            </td>
        </tr>
        <tr>
            <td class="table-success">郵便番号</td>
            <td>
                <input class="form-control rounded-0" type="text" name="zip01" maxlength="8" onKeyUp="AjaxZip3.zip2addr(this,'','addr11','addr11');">
            </td>
        </tr>
        <tr>
            <td class="table-success">住所</td>
            <td>
                <input class="form-control rounded-0" type="text" name="addr11" id="addr11">
            </td>
        </tr>
        <tr>
            <td class="table-success">住所(その他)</td>
            <td>
                <input class="form-control rounded-0" type="text" name="addr12" id="addr12">
            </td>
        </tr>
        <tr>
            <td class="table-success">電話番号</td>
            <td>
                <input class="form-control rounded-0" type="text" name="cphone" id="cphone">
            </td>
        </tr>
        <tr>
            <td class="table-success">メールアドレス</td>
            <td>
                <input class="form-control rounded-0" type="email" name="cemail" id="cemail">
            </td>
        </tr>
        <tr>
            <td class="table-success">備考</td>
            <td>
                <textarea class="form-control rounded-0" name="cremark" id="cremark" style="height:10em;" rows="5"></textarea>
            </td>
        </tr>
    </table>




    <div style="width:100%;text-align:center;padding:1em 0;">
        <input class="btn btn-secondary rounded-0 btn-sm px-4" type="button" name="btn_back" value="戻る" onclick="history.back()">
        <button type="submit" class="btn btn-secondary rounded-0 btn-sm px-4">確認</button>
        <input type="hidden" name="newconf" id="newconf" value="newconf">
    </div>
</form>