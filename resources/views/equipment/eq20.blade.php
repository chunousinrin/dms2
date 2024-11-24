<?php

if (!empty($_POST['machineID'])) {
    $machineID = $_POST['machineID'];
} else {
    $machineID = $_GET['machineID'];
}
$machine_sql = "SELECT * FROM view_equipment_list WHERE ID = " . $machineID;
$machine_stmt = $dbh->query($machine_sql);

$reserve_sql =
    "SELECT equipment_usage_history.*,worker_group.WorkerGroupName,view_equipment_list.MachineName FROM `equipment_usage_history` left JOIN worker_group ON equipment_usage_history.WorkerGroupInUse=worker_group.WorkerGroupID LEFT JOIN view_equipment_list ON equipment_usage_history.EquipmentID=view_equipment_list.ID WHERE equipment_usage_history.EndDate>=CURDATE() AND equipment_usage_history.EquipmentID = " . $machineID;
$reserve_stmt = $dbh->query($reserve_sql);

$refuel_sql = "SELECT * FROM equipment_refuel WHERE EquipmentID = " . $machineID;
$refuel_stmt = $dbh->query($refuel_sql);

$maintenance_sql = "SELECT * FROM equipment_maintenance WHERE EquipmentID = " . $machineID;
$maintenance_stmt = $dbh->query($maintenance_sql);
?>

<style>
    .sdw {
        box-shadow: 5px 5px 5px -5px #464646;
    }
</style>


<form action="" method="post" id="eq20form" name="eq20form">
    @csrf
    <input type="text" name="machineID" id="machineID" value="<?= $machineID ?>" hidden>
    <div class="sdw p-3 bg-white">
        <h5 style="position: relative;">重機情報
            <div style="position: absolute;top:50%;right:0;transform: translateY(-50%);">
                <div id="eq30" class="btn btn-sm" style="background-color:#8fd19e"><i class="fa-solid fa-pen-to-square"></i> 編集</div>
            </div>
        </h5>
        <table class="table mb-0 machinelist">
            <?php $machine = $machine_stmt->fetch();
            ?>
            <tbody>
                <tr style="border-top: 1px solid silver;">
                    <td class="table-success">ID</td>
                    <td><?= $machine['ID'] ?></td>
                    <td class="table-success">管理者</td>
                    <td><?= $machine['Superintendent'] ?></td>
                </tr>
                <tr>
                    <td class="table-success">名称</td>
                    <td><?= $machine['MachineName'] ?></td>
                    <input type="hidden" name="MachineName" id="MachineName" value="<?= $machine['MachineName'] ?>">
                    <td class="table-success">メーカー</td>
                    <td><?= $machine['Manufacturer'] ?></td>
                </tr>
                <tr>
                    <td class="table-success">カテゴリー</td>
                    <td><?= $machine['CategoryName'] ?></td>
                    <td class="table-success">所有権</td>
                    <td><?= $machine['Ownership'] ?></td>
                </tr>
                <tr>
                    <td class="table-success">ベースマシン</td>
                    <td><?= $machine['BaseMachine'] ?></td>
                    <td class="table-success">規格</td>
                    <td><?= $machine['Standard'] ?></td>
                </tr>
                <tr>
                    <td class="table-success">装備1</td>
                    <td><?= $machine['ModelNumber'] ?></td>
                    <td class="table-success">装備2</td>
                    <td><?= $machine['ModelNumber2'] ?></td>
                </tr>
                <tr>
                    <td class="table-success">導入年月日</td>
                    <td><?= $machine['Introduction'] ?></td>
                    <td class="table-success">返却年月日</td>
                    <td><?= $machine['ReturnDate'] ?></td>
                </tr>
            </tbody>
        </table>
    </div>

    <hr>

    <div class="sdw p-3 bg-white">
        <h5 style="position: relative;">稼働(予定)状況
            <div style="position: absolute;top:50%;right:0;transform: translateY(-50%);">
                <div id="eq40" class="btn btn-sm" style="background-color:#8fd19e"><i class="fa-solid fa-plus"></i> 追加</div>
                |
                <div id="eq43" class="btn btn-sm" style="background-color:#8fd19e"><i class="fa-solid fa-list"></i> 履歴</div>
            </div>
        </h5>
        <table style="width: 100%;" class="table table-bordered table-sm mb-0">
            <tdead>
                <tr class="table-success">
                    <td>利用期間</td>
                    <td>使用者</td>
                    <td>指示書番号</td>
                    <td>現場</td>
                </tr>
            </tdead>
            <tbody>
                <?php
                while ($reserve = $reserve_stmt->fetch(PDO::FETCH_BOTH)) : ?>
                    <tr>
                        <td><?= $reserve["StartDay"] ?>　～　<?= $reserve["EndDate"] ?></td>
                        <td><?= $reserve["WorkerGroupName"] ?></td>
                        <td><?= $reserve["InstructionNumber"] ?></td>
                        <td><?= $reserve["Workplace"] ?></td>
                    </tr>
                <?php endwhile ?>
            </tbody>
        </table>
    </div>

    <hr>

    <div class="sdw p-3 bg-white">
        <h5 style="position: relative;">給油
            <div style="position: absolute;top:50%;right:0;transform: translateY(-50%);">
                <div id="eq50" class="btn btn-sm" style="background-color:#8fd19e"><i class="fa-solid fa-plus"></i> 追加</div>
                |
                <div id="eq52" class="btn btn-sm" style="background-color:#8fd19e"><i class="fa-solid fa-list"></i> 履歴</div>
            </div>
        </h5>
        <table style="width: 100%;" class="table table-bordered table-sm mb-0">
            <tdead>
                <tr class="table-success">
                    <td>給油日</td>
                    <td>スタンド名</td>
                    <td>給油量(ℓ)</td>
                    <td>給油場所</td>
                    <td>備考</td>
                </tr>
            </tdead>
            <tbody>
                <?php
                while ($refuel = $refuel_stmt->fetch(PDO::FETCH_BOTH)) : ?>
                    <tr>
                        <td><?= $refuel["RefuelDate"] ?></td>
                        <td><?= $refuel["GasStation"] ?></td>
                        <td><?= $refuel["FuelVolume"] ?></td>
                        <td><?= $refuel["FuelingLocations"] ?></td>
                        <td><?= $refuel["Remark"] ?></td>
                    </tr>
                <?php endwhile ?>
            </tbody>
        </table>
    </div>

    <hr>

    <div class="sdw p-3 bg-white">
        <h5 style="position: relative;">メンテナンス
            <div style="position: absolute;top:50%;right:0;transform: translateY(-50%);">
                <div id="eq60" class="btn btn-sm" style="background-color:#8fd19e"><i class="fa-solid fa-plus"></i> 追加</div>
                |
                <div id="eq62" class="btn btn-sm" style="background-color:#8fd19e"><i class="fa-solid fa-list"></i> 履歴</div>
            </div>
        </h5>
        <table style="width: 100%;" class="table table-bordered table-sm mb-0">
            <tdead>
                <tr class="table-success">
                    <td>実施日</td>
                    <td>内容</td>
                    <td>金額</td>
                    <td>備考</td>
                </tr>
            </tdead>
            <tbody>
                <?php
                while ($maintenance = $maintenance_stmt->fetch(PDO::FETCH_BOTH)) : ?>
                    <tr>
                        <td><?= $maintenance["EffectiveDate"] ?></td>
                        <td><?= $maintenance["MaintenanceDetails"] ?></td>
                        <td><?= $maintenance["Cost"] ?></td>
                        <td><?= $maintenance["Remark"] ?></td>
                    </tr>
                <?php endwhile ?>
            </tbody>
        </table>
    </div>

    <input type="hidden" name="sbmtype" id="sbmtype" value="">
</form>

<script>
    document.getElementById("eq30").addEventListener("click", (e) => {
        document.getElementById("sbmtype").value = 30;
        document.eq20form.submit();
    })
    document.getElementById("eq40").addEventListener("click", (e) => {
        document.getElementById("sbmtype").value = 40;
        document.eq20form.submit();
    })
    document.getElementById("eq43").addEventListener("click", (e) => {
        document.getElementById("sbmtype").value = 43;
        document.eq20form.submit();
    })
    document.getElementById("eq50").addEventListener("click", (e) => {
        document.getElementById("sbmtype").value = 50;
        document.eq20form.submit();
    })
    document.getElementById("eq52").addEventListener("click", (e) => {
        document.getElementById("sbmtype").value = 52;
        document.eq20form.submit();
    })
    document.getElementById("eq60").addEventListener("click", (e) => {
        document.getElementById("sbmtype").value = 60;
        document.eq20form.submit();
    })
    document.getElementById("eq62").addEventListener("click", (e) => {
        document.getElementById("sbmtype").value = 62;
        document.eq20form.submit();
    })
</script>