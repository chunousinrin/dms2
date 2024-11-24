<?php
$worker_group_sql = "SELECT * FROM worker_group";
$worker_group_stmt = $dbh->query($worker_group_sql);
$worker_group = $worker_group_stmt->fetch();
?>

<form action="" method="post" name="eq40form" id="eq40form">
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
                        <label for="StartDay" class="col-sm-2 col-form-label">稼働(予定)期間</label>
                        <div class="col-sm-4">
                            <input type="date" id='StartDay' name='StartDay' class="form-control" value='' onchange="getReserve();">
                        </div>
                        <div class="col-sm-2 text-center">～</div>
                        <div class="col-sm-4">
                            <input type="date" id='EndDate' name='EndDate' class="form-control" value=''>
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="form-group row">
                        <label for="Workplace" class="col-sm-2 col-form-label">現場</label>
                        <div class="col-sm-10">
                            <input type="text" id='Workplace' name='Workplace' class="form-control" value=''>
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="form-group row">
                        <label for="InstructionNumber" class="col-sm-2 col-form-label">指示書番号</label>
                        <div class="col-sm-10">
                            <input type="text" id='InstructionNumber' name='InstructionNumber' class="form-control" value=''>
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="form-group row">
                        <label for="WorkerGroupInUse" class="col-sm-2 col-form-label">利用者</label>
                        <div class="col-sm-10">
                            <select id='WorkerGroupInUse' name='WorkerGroupInUse' class="form-control">
                                <option value="" selected hidden>--作業班を選択--</option>
                                <?php
                                $worker_group_stmt = $dbh->query($worker_group_sql);
                                while ($worker_group = $worker_group_stmt->fetch(PDO::FETCH_BOTH)) {
                                    echo "<option value='" . $worker_group['WorkerGroupID'] . "'>" . $worker_group['WorkerGroupName'] . "</option>";
                                };
                                ?>
                            </select>
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="form-group row">
                        <label for="Remark" class="col-sm-2 col-form-label">備考</label>
                        <div class="col-sm-10">
                            <input type="text" id='Remark' name='Remark' class="form-control" value=''>
                        </div>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
    <div class="btn btn-sm" style="background-color:#8fd19e" id="eqinsert">保存</div>
    <input type="text" name="InputUserID" id="InputUserID" value="<?= $user['id'] ?>">
    <input type="text" name="sbmtype" id="sbmtype" value="">
    <input type="text" name="machineID" id="machineID" value="<?= $_POST['machineID'] ?>">
</form>
<script>
    function getReserve() {
        var selectVal = $("#EquipmentID").val();
        var selectDate = $("#StartDay").val();
        $.getJSON(
            "equipment/eq42", {
                EquipmentID: selectVal,
                StartDay: selectDate,
            },
            function(data, status) {
                for (i in data) {
                    var row = data[i];
                }
                if (row["reservecount"] > 0) {
                    alert("日程が重複しています\n別の日付を選択してください");
                    document.getElementById("StartDay").value = null;
                }
            }
        );
    }

    document.getElementById("eqinsert").addEventListener("click", (e) => {
        document.getElementById("sbmtype").value = 41;
        document.eq40form.submit();
    })
</script>