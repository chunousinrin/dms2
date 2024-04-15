<form action="" method="post" name="f_input">
    @csrf
    <table class="table table-hover table-borderless ctable">
        <tbody>
            <tr>
                <td class="table-success col-sm-2">事業名<span class="required_item">必須</span></td>
                <td>
                    <input type="text" id="ClassicationName" name="ClassicationName" class="form-control rounded-0 " required>
                </td>
            </tr>
            <tr>
                <td class="table-success col-sm-2">備考</td>
                <td>
                    <input type="text" id="Remark" name="Remark" class="form-control rounded-0 ">
                </td>
            </tr>
        </tbody>
    </table>
    <div style="width:100%; margin:0 auto;;text-align:center;">
        <button class="btn btn-secondary rounded-0 btn-sm px-4 mb-5" onclick="">保存</button>
        <input type="hidden" name="sbmtype" value="4">
    </div>
</form>