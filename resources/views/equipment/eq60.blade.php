<form action="" method="post" name="eq60form" id="eq60form">
    @csrf
    <table class="table">
        <tbody>
            <tr>
                <td>
                    <div class="form-group row">
                        <label for="EquipmentID" class="col-sm-2 col-form-label">重機</label>
                        <div class="col-sm-1">
                            <input type="text" id='EquipmentID' name='EquipmentID' class="form-control" value='<?= $_POST['machineID'] ?>' readonly>
                        </div>
                        <div class="col-sm-9">
                            <input type="text" id='MachineName' name='MachineName' class="form-control" value='<?= $_POST['MachineName'] ?>' readonly>
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="form-group row">
                        <label for="EffectiveDate" class="col-sm-2 col-form-label">実施日</label>
                        <div class="col-sm-10">
                            <input type="date" id='EffectiveDate' name='EffectiveDate' class="form-control" value='' required>
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="form-group row">
                        <label for="MaintenanceDetails" class="col-sm-2 col-form-label">メンテナンス内容</label>
                        <div class="col-sm-10">
                            <textarea name="MaintenanceDetails" id="MaintenanceDetails" class="form-control"></textarea>
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="form-group row">
                        <label for="Cost" class="col-sm-2 col-form-label">費用</label>
                        <div class="col-sm-10">
                            <input type="text" id='Cost' name='Cost' class="form-control" value=''>
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="form-group row">
                        <label for="Remark" class="col-sm-2 col-form-label">備考</label>
                        <div class="col-sm-10">
                            <textarea id='Remark' name='Remark' class="form-control"></textarea>
                        </div>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
    <div class="btn btn-sm" style="background-color:#8fd19e" id="equpdate">保存</div>
    <input type="text" name="InputUserID" id="InputUserID" value="<?= $user['id'] ?>">
    <input type="text" name="sbmtype" id="sbmtype" value="">
    <input type="text" name="machineID" id="machineID" value="<?= $_POST['machineID'] ?>">

</form>

<script>
    document.getElementById("equpdate").addEventListener("click", (e) => {
        document.getElementById("sbmtype").value = 61;
        document.eq60form.submit();
    })
</script>