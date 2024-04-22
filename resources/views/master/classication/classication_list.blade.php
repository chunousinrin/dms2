<?php
$dbh = new PDO('mysql:host=localhost;dbname=cf756484_dms;charset=utf8', 'cf756484_root', 'AgVj4jDXzK');
$sql = "SELECT * FROM classication";
$stmt = $dbh->query($sql); ?>
<form action="" method="post" name="f_list" id="f_list">
    @csrf
    <div class="table-wrap" style="max-height: 100%;">
        <table class="table table-sm table-responsive-sm table-hover table-borderless ctable" id="table">
            <tbody>
                <?php while ($result = $stmt->fetch(PDO::FETCH_BOTH)) { ?>
                    <tr>
                        <td class="col-1 table-success text-center" name="CurrentID" id="CurrentID"><?= $result['Id'] ?></td>
                        <td class="col-3">
                            <input type="text" name="CurrentName" id="CurrentName" class="form-control rounded-0" value="<?= $result['Name'] ?>" ?>
                        </td>
                        <td class="col-6">
                            <input type="text" name="CurrentRemark" id="CurrentRemark" class="form-control rounded-0" placeholder="備考" value="<?= $result['Remark'] ?>" ?>
                        </td>
                        <td class="text-right">
                            <button class="btn btn-sm btn-secondary rounded-0 px-4" onclick="up();">更新</button>
                            <button class="btn btn-sm btn-danger rounded-0 px-4" onclick="dlt();">削除</button>
                        </td>
                    </tr>
                <?php };
                $dbh = 0;
                ?>
            </tbody>
        </table>
        <input type="hidden" name="UpdateID" id="UpdateID">
        <input type="hidden" name="UpdateName" id="UpdateName">
        <input type="hidden" name="UpdateRemark" id="UpdateRemark">
        <input type="hidden" name="sbmtype" id="sbmtype">
    </div>
</form>

<script>
    function up() {
        if (window.confirm("入力された内容で更新します")) {
            $("#table td").bind("click", function() {
                $tag_tr = $(this).parent()[0];
                $rowNum = $tag_tr.rowIndex;
                const el = document.getElementsByName("CurrentName")[$rowNum].value;
                document.getElementById("UpdateName").value = el;
                const dl = document.getElementsByName("CurrentID")[$rowNum].textContent;
                document.getElementById("UpdateID").value = dl;
                const rm = document.getElementsByName("CurrentRemark")[$rowNum].value;
                document.getElementById("UpdateRemark").value = rm;
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
                $rowNum = $tag_tr.rowIndex;
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