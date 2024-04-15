<?php
$sql = "SELECT * FROM bank ORDER BY BankID ASC";
$stmt = $dbh->query($sql); ?>
<form action="" method="post" name="f_list" id="f_list">
    @csrf
    <div class="table-wrap" style="max-height: 100%;">
        <table class="table table-responsive-sm table-sm table-hover table-borderless bg-white ctable" id="table">
            <thead>
                <tr class="table-success">
                    <td></td>
                    <td>銀行名</td>
                    <td>支店名</td>
                    <td>種類</td>
                    <td>口座番号</td>
                    <td></td>
                </tr>
            </thead>
            <tbody>
                <?php while ($result = $stmt->fetch(PDO::FETCH_BOTH)) { ?>
                    <tr>
                        <td class="col-1 table-success text-center" name="CurrentID" id="CurrentID"><?= $result['BankID'] ?></td>
                        <td class="col-4"><input type="text" name="CurrentName" id="CurrentName" class="form-control rounded-0" value="<?= $result['BankName'] ?>" ?></td>
                        <td class="col-2"><input type="text" name="CurrentBranch" id="CurrentBranch" class="form-control rounded-0" value="<?= $result['BankBranch'] ?>" ?></td>
                        <td class="col-2"><input type="text" name="CurrentAccountType" id="CurrentAccountType" class="form-control rounded-0" value="<?= $result['AccountType'] ?>" ?></td>
                        <td class=""><input type="text" name="CurrentAccountNumber" id="CurrentAccountNumber" class="form-control rounded-0" value="<?= $result['AccountNumber'] ?>" ?></td>
                        <td class="text-right" style="white-space: nowrap;">
                            <button class="btn btn-sm btn-secondary rounded-0 px-4" onclick="up();">更新</button>
                            <button class="btn btn-sm btn-danger rounded-0 px-4" onclick="dlt();">削除</button>
                        </td>
                    </tr>
                <?php };
                $dbh = 0;
                ?>
            </tbody>
        </table>
        <input type="hidden" name="BankID" id="BankID">
        <input type="hidden" name="BankName" id="BankName">
        <input type="hidden" name="BankBranch" id="BankBranch">
        <input type="hidden" name="AccountType" id="AccountType">
        <input type="hidden" name="AccountNumber" id="AccountNumber">
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
                document.getElementById("BankID").value = udid;
                const udname = document.getElementsByName("CurrentName")[$rowNum].value;
                document.getElementById("BankName").value = udname;
                const udbranch = document.getElementsByName("CurrentBranch")[$rowNum].value;
                document.getElementById("BankBranch").value = udbranch;
                const udatype = document.getElementsByName("CurrentAccountType")[$rowNum].value;
                document.getElementById("AccountType").value = udatype;
                const udanumber = document.getElementsByName("CurrentAccountNumber")[$rowNum].value;
                document.getElementById("AccountNumber").value = udanumber;
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
                document.getElementById("BankID").value = udid;
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