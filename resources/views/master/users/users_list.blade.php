<?php
$sql = "SELECT * FROM users ORDER BY id ASC";
$stmt = $dbh->query($sql); ?>
<form action="" method="post" name="f_list" id="f_list">
    @csrf
    <div class="table-wrap" style="max-height: 100%!important;">
        <table class="table table-responsive-sm table-sm table-hover table-borderless bg-white ctable" id="table">
            <thead>
                <tr class="table-success">
                    <td></td>
                    <td>名前</td>
                    <td class="text-center">印章</td>
                    <td>Email</td>
                    <td>部署</td>
                    <td>所属</td>
                    <td>役職</td>
                    <td>使用中</td>
                    <td>種類</td>
                    <td></td>
                </tr>
            </thead>
            <tbody>
                <?php while ($result = $stmt->fetch(PDO::FETCH_BOTH)) { ?>
                    <tr>
                        <td class="table-success text-center" name="CurrentID" id="CurrentID"><?= $result['id'] ?></td>
                        <td class="col-2"><input type="text" name="name" id="name" class="form-control rounded-0" value="<?= $result['name'] ?>"></td>
                        <td class="text-center"><?php echo '<img style="opacity:0.8;bottom:0;width:auto;height:calc(2.25rem + 2px);" src="data:image/svg+xml;base64,' . base64_encode($result['stamp']) . '" >'; ?></td>
                        <td class="col-3"><input type="text" name="email" id="email" class="form-control rounded-0" value="<?= $result['email'] ?>"></td>
                        <td class="col-1"><input type="text" name="department" id="department" class="form-control rounded-0" value="<?= $result['department'] ?>"></td>
                        <td class="col-1"><input type="text" name="section" id="section" class="form-control rounded-0" value="<?= $result['section'] ?>"></td>
                        <td class="col-1"><input type="text" name="position" id="position" class="form-control rounded-0" value="<?= $result['position'] ?>"></td>
                        <td class="" style="white-space: nowrap;">
                            <?php
                            if ($result['used'] == "0") {
                                $sld1 = null;
                                $sld2 = "checked";
                            } else {
                                $sld1 = "checked";
                                $sld2 = null;
                            }
                            ?>
                            <div class="btn-group btn-group-toggle mt-1" data-toggle="buttons">
                                <label class="btn btn-outline-info btn-sm rounded-0 font-weight-normal">
                                    <input type="radio" name="used" id="used1" value="1" <?= $sld1 ?>>&nbsp;表示&nbsp;
                                </label>
                                <label class="btn btn-outline-info btn-sm rounded-0 font-weight-normal">
                                    <input type="radio" name="used" id="used2" value="0" <?= $sld2 ?>>非表示
                                </label>
                            </div>
                        </td>
                        <td class="" style="white-space: nowrap;">
                            <?php
                            if ($result['authtype'] == "0") {
                                $sld3 = null;
                                $sld4 = "checked";
                            } else {
                                $sld3 = "checked";
                                $sld4 = null;
                            }
                            ?>
                            <div class="btn-group btn-group-toggle mt-1" data-toggle="buttons">
                                <label class="btn btn-outline-info btn-sm rounded-0 font-weight-normal">
                                    <input type="radio" name="authtype" id="authtype1" value="1" <?= $sld3 ?>>&nbsp;管理者&nbsp;
                                </label>
                                <label class="btn btn-outline-info btn-sm rounded-0 font-weight-normal">
                                    <input type="radio" name="authtype" id="authtype2" value="0" <?= $sld4 ?>>一般
                                </label>
                            </div>
                        </td>
                        <td class="text-right" style="white-space: nowrap;">
                            <button class="btn btn-sm btn-secondary rounded-0 px-4" onclick="up();">更新</button>
                            <button class="btn btn-sm btn-danger rounded-0 px-4" onclick="dlt();">削除</button>
                        </td>
                    </tr>
                <?php }; ?>
            </tbody>
        </table>
        <input type="hidden" name="UpdateID" id="UpdateID">
        <input type="hidden" name="UpdateName" id="UpdateName">
        <input type="hidden" name="UpdateEmail" id="UpdateEmail">
        <input type="hidden" name="UpdateDepartment" id="UpdateDepartment">
        <input type="hidden" name="UpdateSection" id="UpdateSection">
        <input type="hidden" name="UpdatePosition" id="UpdatePosition">
        <input type="hidden" name="UpdateUsed" id="UpdateUsed" placeholder="used">
        <input type="hidden" name="UpdateAuthtype" id="UpdateAuthtype" placeholder="authtype">
        <input type="hidden" name="sbmtype" id="sbmtype">
    </div>
</form>

<script>
    function up() {
        if (window.confirm("入力された内容で更新します")) {
            $("#table td").bind("click", function() {
                $tag_tr = $(this).parent()[0];
                $rowNum = $tag_tr.rowIndex - 1;
                const udid = document.getElementsByName("CurrentID")[$rowNum].textContent;
                document.getElementById("UpdateID").value = udid;
                document.getElementById("UpdateName").value = document.getElementsByName("name")[$rowNum].value;
                document.getElementById("UpdateEmail").value = document.getElementsByName("email")[$rowNum].value;
                document.getElementById("UpdateDepartment").value = document.getElementsByName("department")[$rowNum].value;
                document.getElementById("UpdateSection").value = document.getElementsByName("section")[$rowNum].value;
                document.getElementById("UpdatePosition").value = document.getElementsByName("position")[$rowNum].value;
                document.getElementById("UpdateUsed").value = $('input[name="used"]:checked').val();
                document.getElementById('UpdateAuthtype').value = $('input[name="authtype"]:checked').val();
                document.getElementById("sbmtype").value = "9";
                document.f_list.submit();
            });
        } else {
            // 「キャンセル」時の処理
            window.alert("キャンセルされました"); // 警告ダイアログを表示
            return false; // 送信を中止
        }
    }

    function dlt() {
        if (window.confirm("選択された情報を削除します")) {
            $("#table td").bind("click", function() {
                $tag_tr = $(this).parent()[0];
                $rowNum = $tag_tr.rowIndex - 1;
                const udid = document.getElementsByName("CurrentID")[$rowNum].textContent;
                document.getElementById("UpdateID").value = udid;
                document.getElementById("sbmtype").value = "5";
                document.f_list.submit();
            });
        } else {
            // 「キャンセル」時の処理
            window.alert("キャンセルされました"); // 警告ダイアログを表示
            return false; // 送信を中止
        }
    }
</script>