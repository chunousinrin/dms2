<?php
if (empty($_POST['limit'])) {
    $limit = 50;
    $setlimit = " LIMIT " . $limit;
} elseif ($limit = "全件") {
    $limit = $_POST['limit'];
    $setlimit = "";
} else {
    $limit = $_POST['limit'];
    $setlimit = " LIMIT " . $limit;
}
?>
<form action="" method="post" name="eq62form" id="eq62form">
    @csrf
    <div class="table-wrap sdw">
        <div style="position: relative; width:100%;display:flex;margin-bottom:0.5em">
            <button class="btn btn-sm" style="background-color:#8fd19e" type="button" onclick="history.back();"><i class="fa-solid fa-angles-left"></i></button>
            <h5 style="position: absolute;top:50%;transform:translateY(-50%);left:2em;"><?= $_POST['MachineName'] ?>　メンテナンス履歴</h5>
            <div style="position: absolute;right:0;top:50%;transform:translateY(-50%)">表示件数
                <select name="limit" id="limit" onchange="submit();">
                    <option value="<?= $limit ?>" selected hidden><?= $limit ?></option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                    <option value="200">200</option>
                    <option value="全件">全件</option>
                </select>
            </div>
        </div>

        <table class="table table-sm table-bordered" id="table">
            <thead>
                <tr class="table-success">
                    <td colspan="2"></td>
                    <td>実施日</td>
                    <td>内容</td>
                    <td>金額</td>
                    <td>備考</td>
                </tr>
            </thead>
            <tbody>
                <?php
                $history_sql = "SELECT * FROM equipment_maintenance WHERE EquipmentID = " . $_POST['machineID'] . $setlimit;
                $history_stmt = $dbh->query($history_sql);
                while ($history = $history_stmt->fetch(PDO::FETCH_BOTH)): ?>
                    <tr>
                        <td style="white-space: nowrap;width:0;"><button class="btn btn-sm" onclick="deletedata();"><i class="fa-solid fa-trash-can"></i></button></td>
                        <td style="white-space: nowrap;width:0;" name="maintenanceID"><?= $history['ID'] ?></td>
                        <td><?= $history['EffectiveDate'] ?></td>
                        <td><?= $history['MaintenanceDetails'] ?></td>
                        <td><?= $history['Cost'] ?></td>
                        <td><?= $history['Remark'] ?></td>
                    </tr>

                <?php endwhile ?>

            </tbody>
        </table>
        <input type="hidden" name="sbmtype" id="sbmtype" value="">
        <input type="hidden" name="MachineName" value="<?= $_POST['MachineName'] ?>">
        <input type="hidden" name="machineID" value="<?= $_POST['machineID'] ?>">
        <input type="hidden" name="deleteID" id="deleteID" value="">
    </div>
</form>

<script>
    function deletedata() {
        if (window.confirm("削除しますか?")) {
            $("#table td").bind("click", function() {
                $tag_tr = $(this).parent()[0]; //クリックした行を取得
                $rowNum = $tag_tr.rowIndex; //行番号を取得
                const el = document.getElementsByName("maintenanceID")[$rowNum - 1].textContent;
                document.getElementById("deleteID").value = el;
                document.getElementById("sbmtype").value = 63;
                document.getElementById("eq62form").submit();
            });
        } else {
            window.alert("キャンセルされました"); // 警告ダイアログを表示
            document.getElementById("sbmtype").value = 62;
            return false; // 送信を中止
        }
    }
</script>