<form action="" method="post" name="eq50form" id="eq50form">
    @csrf
    <table class="table">
        <tbody>
            <tr>
                <td>
                    <div class="form-group row">
                        <label for="EquipmentID" class="col-sm-2 col-form-label">重機</label>
                        <input type="hidden" id='EquipmentID' name='EquipmentID' class="form-control" value='<?= $_POST['machineID'] ?>' readonly>
                        <div class="col-sm-10">
                            <input type="text" id='MachineName' name='MachineName' class="form-control" value='<?= $_POST['MachineName'] ?>' readonly>
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="form-group row">
                        <label for="RefuelDate" class="col-sm-2 col-form-label">給油日</label>
                        <div class="col-sm-10">
                            <input type="text" id='RefuelDate' name='RefuelDate' class="datepicker form-control" value='' required>
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="form-group row">
                        <label for="FuelVolume" class="col-sm-2 col-form-label">給油量(ℓ)</label>
                        <div class="col-sm-10">
                            <input type="number" step="1" id='FuelVolume' name='FuelVolume' class="form-control" value='' required>
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="form-group row">
                        <label for="GasStation" class="col-sm-2 col-form-label">スタンド名</label>
                        <div class="col-sm-10">
                            <input type="text" id='GasStation' name='GasStation' class="form-control" value='' required list="gas">
                            <datalist id="gas">
                                <?php
                                $gs_sql = "SELECT GasStation FROM equipment_refuel GROUP BY GasStation;";
                                $gs_stmt = $dbh->query($gs_sql);
                                while ($gs = $gs_stmt->fetch(PDO::FETCH_BOTH)) {
                                    echo "<option value='" . $gs['GasStation'] . "'>";
                                }
                                ?>
                            </datalist>
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="form-group row">
                        <label for="FuelingLocations" class="col-sm-2 col-form-label">給油場所</label>
                        <div class="col-sm-10">
                            <input type="text" id='FuelingLocations' name='FuelingLocations' class="form-control" value='' required>
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
    <div class="btn btn-sm px-4" style="background-color:#8fd19e" id="equpdate">保存</div>
    <input type="hidden" name="InputUserID" id="InputUserID" value="<?= $user['id'] ?>">
    <input type="hidden" name="sbmtype" id="sbmtype" value="">
    <input type="hidden" name="machineID" id="machineID" value="<?= $_POST['machineID'] ?>">

</form>

<script>
    document.getElementById("equpdate").addEventListener("click", (e) => {
        document.getElementById("sbmtype").value = 51;
        document.eq50form.submit();
    })
</script>