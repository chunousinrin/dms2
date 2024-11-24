<?php
$machine_list_sql = "SELECT * FROM view_equipment_list";
$machine_list_stmt = $dbh->query($machine_list_sql);

$reserve_sql = "SELECT equipment_usage_history.*,worker_group.WorkerGroupName,view_equipment_list.MachineName FROM `equipment_usage_history` left JOIN worker_group ON equipment_usage_history.WorkerGroupInUse=worker_group.WorkerGroupID LEFT JOIN view_equipment_list ON equipment_usage_history.EquipmentID=view_equipment_list.ID WHERE equipment_usage_history.EndDate>=CURDATE()";
$reserve_stmt = $dbh->query($reserve_sql);
?>

<div style="width: 100%;padding:1em;" class="table-responsive sdw bg-white">
    <h5>重機一覧</h5>
    <table class="table table-bordered table-sm table-hover" id="table10">
        <thead>
            <tr class="table-success">
                <td>ID</td>
                <td>MachineName</td>
                <td>Ownership</td>
                <td>Manufacturer</td>
                <td>BaseMachine</td>
            </tr>
        </thead>
        <tbody>
            <?php while ($machine_list = $machine_list_stmt->fetch(PDO::FETCH_BOTH)): ?>
                <tr>
                    <td name="machineID"><?= $machine_list['ID'] ?></td>
                    <td><?= $machine_list['MachineName'] ?></td>
                    <td><?= $machine_list['Ownership'] ?></td>
                    <td><?= $machine_list['Manufacturer'] ?></td>
                    <td><?= $machine_list['BaseMachine'] ?></td>
                </tr>
            <?php endwhile ?>
        </tbody>
    </table>
</div>



<div style="width: 100%; height:40vh; padding:1em;" class="table-responsive sdw bg-white mt-5">
    <h5>稼働(予約)状況</h5>
    <table class="table table-bordered table-sm table-hover">
        <thead>
            <tr class="table-success">
                <td>重機名称</td>
                <td>利用期間</td>
                <td>使用者</td>
                <td>指示書番号</td>
                <td>現場</td>
            </tr>
        </thead>
        <tbody id="usage">
            <?php
            while ($reserve = $reserve_stmt->fetch(PDO::FETCH_BOTH)) : ?>
                <tr>
                    <td><?= $reserve["MachineName"] ?></td>
                    <td class="text-center"><?= $reserve["StartDay"] ?>　～　<?= $reserve["EndDate"] ?></td>
                    <td><?= $reserve["WorkerGroupName"] ?></td>
                    <td><?= $reserve["InstructionNumber"] ?></td>
                    <td><?= $reserve["Workplace"] ?></td>
                </tr>
            <?php endwhile ?>
        </tbody>
    </table>
</div>

<form action="" method="post" id="sb_machine" name="sb_machine">
    @csrf
    <input type="hidden" name="machineID" id="machineID">
    <input type="hidden" name="sbmtype" id="sbmtype" value="20">
</form>