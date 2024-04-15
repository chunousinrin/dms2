<?php
$errlnum = "14" . time();
?>
<form action="" method="post" name="f_input" enctype="multipart/form-data">
    @csrf
    <table class="table table-hover table-borderless ctable">
        <tbody>
            <tr style="display: none;">
                <td class="table-success col-sm-2">請求番号</td>
                <td>
                    <input type="text" name="UserID" id="UserID" value="<?= $user['id'] ?>">
                    <input type="text" id="SerialNumber" name="SerialNumber" value="<?= $errlnum ?>" readonly class="form-control rounded-0 ">
                </td>
            </tr>
            <tr>
                <td class="table-success col-sm-2">日付<span class="required_item">必須</span></td>
                <td>
                    <input type="text" id="TradingDate" name="TradingDate" required class="form-control rounded-0 datepicker">
                </td>
            </tr>
            <tr>
                <td class="table-success col-sm-2">受領/発行<span class="required_item">必須</span></td>
                <td>
                    <div class="input-group">
                        <select name="RIType" id="RIType" class="form-control rounded-0 col-sm-2">
                            <option value="受領">受領</option>
                            <option value="発行">発行</option>
                        </select>
                    </div>
                </td>
            </tr>
            <tr>
                <td class="table-success col-sm-2">種類<span class="required_item">必須</span></td>
                <td>
                    <?php
                    $type_sql = "SELECT * FROM `accountbook_type` ORDER BY `TypeID` ASC";
                    $type_st = $dbh->query($type_sql);
                    ?>
                    <select id="DocumentType" name="DocumentType" required class="form-control rounded-0 ">
                        <option value="" hidden selected>-- 選択してください --</option>
                        <?php
                        while ($accountbook_type = $type_st->fetch(PDO::FETCH_ASSOC)) {
                            echo '<option value="' . $accountbook_type['TypeID'] . '">' . $accountbook_type['TypeName'] . '</option>';
                        }
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td class="table-success col-sm-2">取引先<span class="required_item">必須</span></td>
                <td>
                    <div class="input-group">
                        <input type="text" name="Customer" id="Customer" list="clist" autocomplete="on" value="<?= $_POST['Customer'] ?? null ?>" placeholder="入力または一覧から選択してください" required class="form-control rounded-0">
                        <datalist id="clist">
                            <?php
                            $sql = "SELECT * FROM( SELECT Customer,COUNT(Customer) as ct FROM accountbook GROUP BY Customer) as test WHERE ct>1";
                            $stmt = $dbh->query($sql);
                            while ($row = $stmt->fetch(PDO::FETCH_BOTH)) {
                                echo "<option value='" . $row['Customer'] . "'></option>";
                            }
                            ?>
                        </datalist>
                    </div>
                </td>
            </tr>
            <tr>
                <td class="table-success col-sm-2">金額<span class="required_item">必須</span></td>
                <td>
                    <input type="number" id="Amount" name="Amount" step="0" required class="form-control rounded-0">
                </td>
            </tr>
            <tr>
                <td class="table-success col-sm-2">備考</td>
                <td>
                    <textarea name="Remark" id="Remark" class="form-control rounded-0" style="height:5em;"></textarea>
                </td>
            </tr>
            <tr>
                <td class="table-success col-sm-2">書類<span class="required_item">必須</span></td>
                <td class="input-group">
                    <div class="custom-file">
                        <input type="file" class="custom-file-input rounded-0" id="FileName" name="FileName">
                        <label class="custom-file-label rounded-0" for="FileName" data-browse="参照">ファイル選択...</label>
                    </div>
                    <div class="input-group-append">
                        <button type="button" class="btn btn-outline-secondary reset rounded-0">取消</button>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
    <div style=" width:100%; margin:0 auto;;text-align:center;">
        <button class="btn btn-secondary rounded-0 btn-sm px-4 mb-5" onclick="">保存</button>
        <input type="hidden" name="sbmtype" value="4">
    </div>
</form>

<style>
    .custom-file {
        overflow: hidden;
    }

    .custom-file-label {
        white-space: nowrap;
    }
</style>