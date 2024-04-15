<form action="" method="post" name="f_input">
    @csrf
    <table class="table table-hover table-borderless ctable">
        <tbody>
            <tr>
                <td class="table-success col-sm-2">銀行名<span class="required_item">必須</span></td>
                <td>
                    <input type="text" id="BankName" name="BankName" class="form-control rounded-0 " required>
                </td>
            </tr>
            <tr>
                <td class="table-success col-sm-2">支店名<span class="required_item">必須</span></td>
                <td>
                    <input type="text" id="BankBranch" name="BankBranch" class="form-control rounded-0 " required>
                </td>
            </tr>
            <tr>
                <td class="table-success col-sm-2">口座種類<span class="required_item">必須</span></td>
                <td>
                    <select name="AccountType" id="AccountType" class="form-control rounded-0" required>
                        <option value="普通" selected>普通</option>
                        <option value="当座">当座</option>
                        <option value="総合">総合</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td class="table-success col-sm-2">口座番号<span class="required_item">必須</span></td>
                <td>
                    <input type="text" id="AccountNumber" name="AccountNumber" class="form-control rounded-0 " required>
                </td>
            </tr>
        </tbody>
    </table>
    <div style="width:100%; margin:0 auto;;text-align:center;">
        <button class="btn btn-secondary rounded-0 btn-sm px-4 mb-5" onclick="">保存</button>
        <input type="hidden" name="sbmtype" value="4">
    </div>
</form>