<?php
$machine_sql = "SELECT * FROM view_equipment_list WHERE ID = " . $_POST['machineID'];
$machine_stmt = $dbh->query($machine_sql);
$machine = $machine_stmt->fetch();

?>
<form action="" method="post" name="eq30form" id="eq30form">
    @csrf
    <table class="table">
        <tbody>
            <tr>
                <td>
                    <div class="form-group row">
                        <label for="staticEmail" class="col-sm-2 col-form-label">ID</label>
                        <div class="col-sm-10">
                            <input type="text" id='ID' name='ID' class="form-control" value='<?= $machine['ID'] ?>'>
                        </div>
                    </div>
                </td>
            </tr>


            <tr>
                <td>
                    <div class="form-group row">
                        <label for="staticEmail" class="col-sm-2 col-form-label">CategoryName</label>
                        <div class="col-sm-2">
                            <input id='CategoryID' name='CategoryID' class="form-control" value='<?= $machine['CategoryID'] ?>'>
                        </div>
                        <div class="col-sm-8">
                            <select name="CategoryName" id="CategoryName" class="form-control">
                                <option value="">--カテゴリーを選択--</option>
                                <?php
                                $category_sql = "SELECT * FROM equipment_category WHERE ";
                                if (!empty($machine['CategoryID'])) {
                                    $category_stmt = $dbh->query($category_sql . "ID = " . $machine['CategoryID']);
                                    $category = $category_stmt->fetch();
                                    echo "<option selected hidden value='" . $category['ID'] . "'>" . $category['CategoryName'] . "</option>";
                                }
                                $category_stmt = $dbh->query($category_sql . "1");
                                while ($category = $category_stmt->fetch(PDO::FETCH_BOTH)) {
                                    echo "<option value='" . $category['ID'] . "'>" . $category['CategoryName'] . "</option>";
                                } ?>
                            </select>
                        </div>
                    </div>
                </td>
            </tr>


            <tr>
                <td>
                    <div class="form-group row">
                        <label for="staticEmail" class="col-sm-2 col-form-label">MachineName</label>
                        <div class="col-sm-10">
                            <input id='MachineName' name='MachineName' class="form-control" value='<?= $machine['MachineName'] ?>'>
                        </div>
                    </div>
                </td>
            </tr>

            <tr>
                <td>
                    <div class="form-group row">
                        <label for="staticEmail" class="col-sm-2 col-form-label">Ownership</label>
                        <div class="col-sm-10">
                            <input id='Ownership' name='Ownership' class="form-control" value='<?= $machine['Ownership'] ?>'>
                        </div>
                    </div>
                </td>
            </tr>

            <tr>
                <td>
                    <div class="form-group row">
                        <label for="staticEmail" class="col-sm-2 col-form-label">Manufacturer</label>
                        <div class="col-sm-10">
                            <input id='Manufacturer' name='Manufacturer' class="form-control" value='<?= $machine['Manufacturer'] ?>'>
                        </div>
                    </div>
                </td>
            </tr>

            <tr>
                <td>
                    <div class="form-group row">
                        <label for="staticEmail" class="col-sm-2 col-form-label">BaseMachine</label>
                        <div class="col-sm-10">
                            <input id='BaseMachine' name='BaseMachine' class="form-control" value='<?= $machine['BaseMachine'] ?>'>
                        </div>
                    </div>
                </td>
            </tr>


            <tr>
                <td>
                    <div class="form-group row">
                        <label for="staticEmail" class="col-sm-2 col-form-label">Standard</label>
                        <div class="col-sm-10">
                            <input type="text" id='Standard' name='Standard' class="form-control" value='<?= $machine['Standard'] ?>'>
                        </div>
                    </div>
                </td>
            </tr>


            <tr>
                <td>
                    <div class="form-group row">
                        <label for="staticEmail" class="col-sm-2 col-form-label">Equipment1</label>
                        <div class="col-sm-2">
                            <input type="text" id='EquipmentID1' name='EquipmentID1' class="form-control" value='<?= $machine['EquipmentID1'] ?>'>
                        </div>
                        <div class="col-sm-8">
                            <select name="ModelNumber" id="ModelNumber" class="form-control">
                                <option value="">--装備を選択--</option>

                                <?php
                                $equipment_sql = "SELECT * FROM equipment_classification WHERE ";
                                if (!empty($machine['EquipmentID1'])) {
                                    $equipment_stmt = $dbh->query($equipment_sql . "ID = " . $machine['EquipmentID1']);
                                    $equipment = $equipment_stmt->fetch();
                                    echo "<option selected hidden value='" . $equipment['ID'] . "'>" . $equipment['ModelNumber'] . "</option>";
                                };

                                $equipment_stmt = $dbh->query($equipment_sql . "1");
                                while ($equipment = $equipment_stmt->fetch(PDO::FETCH_BOTH)) {
                                    echo "<option value='" . $equipment['ID'] . "'>" . $equipment['ModelNumber'] . "</option>";
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
                        <label for="staticEmail" class="col-sm-2 col-form-label">Equipment2</label>
                        <div class="col-sm-2">
                            <input id='EquipmentID2' name='EquipmentID2' class="form-control" value='<?= $machine['EquipmentID2'] ?>'>
                        </div>
                        <div class="col-sm-8">
                            <select name="ModelNumber2" id="ModelNumber2" class="form-control">
                                <option value="">--装備を選択--</option>
                                <?php
                                $equipment_sql = "SELECT * FROM equipment_classification WHERE ";
                                if (!empty($machine['EquipmentID2'])) {
                                    $equipment_stmt = $dbh->query($equipment_sql . "ID = " . $machine['EquipmentID2']);
                                    $equipment = $equipment_stmt->fetch();
                                    echo "<option selected hidden value='" . $equipment['ID'] . "'>" . $equipment['ModelNumber'] . "</option>";
                                };

                                $equipment_stmt = $dbh->query($equipment_sql . "1");
                                while ($equipment = $equipment_stmt->fetch(PDO::FETCH_BOTH)) {
                                    echo "<option value='" . $equipment['ID'] . "'>" . $equipment['ModelNumber'] . "</option>";
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
                        <label for="staticEmail" class="col-sm-2 col-form-label">Introduction</label>
                        <div class="col-sm-10">
                            <input type="date" id='Introduction' name='Introduction' class="form-control" value='<?= $machine['Introduction'] ?>'>
                        </div>
                    </div>
                </td>
            </tr>

            <tr>
                <td>
                    <div class="form-group row">
                        <label for="staticEmail" class="col-sm-2 col-form-label">ReturnDate</label>
                        <div class="col-sm-10">
                            <input type="date" id='ReturnDate' name='ReturnDate' class="form-control" value='<?= $machine['ReturnDate'] ?>'>
                        </div>
                    </div>
                </td>
            </tr>

            <tr>
                <td>
                    <div class="form-group row">
                        <label for="staticEmail" class="col-sm-2 col-form-label">Superintendent</label>
                        <div class="col-sm-10">
                            <select name="Superintendent" id="Superintendent" class="form-control">
                                <option value="">--班名を選択--</option>
                                <?php
                                $wgoup_sql = "SELECT * FROM worker_group WHERE ";
                                if (!empty($machine['Superintendent'])) {
                                    $wgoup_stmt = $dbh->query($wgoup_sql . "WorkerGroupID = " . $machine['Superintendent']);
                                    $wgoup = $wgoup_stmt->fetch();
                                    echo "<option selected hidden value='" . $wgoup['WorkerGroupID'] . "'>" . $wgoup['WorkerGroupName'] . "</option>";
                                };

                                $wgoup_stmt = $dbh->query($wgoup_sql . "1");
                                while ($wgoup = $wgoup_stmt->fetch(PDO::FETCH_BOTH)) {
                                    echo "<option value='" . $wgoup['WorkerGroupID'] . "'>" . $wgoup['WorkerGroupName'] . "</option>";
                                };
                                ?>
                            </select>
                        </div>
                    </div>
                </td>
            </tr>



        </tbody>
    </table>
    <div class="btn btn-sm" style="background-color:#8fd19e" id="eqlist">一覧</div>
    <div class="btn btn-sm" style="background-color:#8fd19e" id="equpdate">更新</div>
    <div class="btn btn-sm" style="background-color:#8fd19e" id="eqdelete">削除</div>
    <input type="text" name="sbmtype" id="sbmtype" value="">
    <input type="text" name="machineID" id="machineID" value="<?= $_POST['machineID'] ?>">
</form>
<script>
    document.getElementById("CategoryName").addEventListener("change", (e) => {
        document.getElementById("CategoryID").value = document.getElementById("CategoryName").value;
    })
    document.getElementById("ModelNumber").addEventListener("change", (e) => {
        document.getElementById("EquipmentID1").value = document.getElementById("ModelNumber").value;
    })
    document.getElementById("ModelNumber2").addEventListener("change", (e) => {
        document.getElementById("EquipmentID2").value = document.getElementById("ModelNumber2").value;
    })
    document.getElementById("eqlist").addEventListener("click", (e) => {
        document.getElementById("sbmtype").value = 1;
        document.eq30form.submit();
    })
    document.getElementById("equpdate").addEventListener("click", (e) => {
        document.getElementById("sbmtype").value = 31;
        document.eq30form.submit();
    })
    document.getElementById("eqdelete").addEventListener("click", (e) => {
        document.getElementById("sbmtype").value = 32;
        document.eq30form.submit();
    })
</script>