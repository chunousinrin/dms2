<form action="" method="post" name="f_list" id="f_list" enctype="multipart/form-data">
    @csrf
    <div class="table-wrap" style="max-height: 100%;">
        <table class="table table-borderless" id="table">

            <?php
            $sql = "SELECT * FROM company WHERE 1 ORDER BY BranchId ASC";
            $stmt = $dbh->query($sql);
            while ($result = $stmt->fetch(PDO::FETCH_BOTH)) { ?>
                <tr>
                    <td style="position: relative;box-shadow: 5px 5px 5px -5px #464646;">
                        <div style="position: absolute;background-color:green;color:#fff;width:1.5em;height:1.5em;border-radius:50%;font-size:1.5em;text-align:center;left:3%;top:3%;line-height:1.5em;"><?= $result['BranchId'] ?></div>
                        <div style="padding: 1em 20%;border:1px solid green">
                            <div class="form-group">
                                <label class="">名称</label>
                                <input type="hidden" name="CurrentBranchId" id="CurrentBranchId" value="<?= $result['BranchId'] ?>">
                                <input type="text" name="CurrentBranchName" id="CurrentBranchName" class="form-control rounded-0" value="<?= $result['BranchName'] ?>">
                            </div>
                            <div class="form-group">
                                <label class="">代表者</label>
                                <input type="text" name="CurrentRepresentative" id="CurrentRepresentative" class="form-control rounded-0" value="<?= $result['Representative'] ?>">
                            </div>
                            <div class="form-group">
                                <label class="">郵便番号</label>
                                <input type="text" name="CurrentPostCode" id="CurrentPostCode" class="form-control rounded-0" value="<?= $result['PostCode'] ?>">
                            </div>
                            <div class="form-group">
                                <label class="">住所</label>
                                <input type="text" name="CurrentAddress" id="CurrentAddress" class="form-control rounded-0" value="<?= $result['Address'] ?>">
                            </div>
                            <div class="input-group">
                                <div class="form-group mr-5">
                                    <label class="">電話番号</label>
                                    <input type="text" name="CurrentPhone" id="CurrentPhone" class="form-control rounded-0" value="<?= $result['Phone'] ?>">
                                    <label class="">FAX番号</label>
                                    <input type="text" name="CurrentFax" id="CurrentFax" class="form-control rounded-0" value="<?= $result['Fax'] ?>">
                                </div>
                                <div class="form-group">
                                    <div class="form-group mr-5">
                                        <label for="" class="mr-3">印章</label><br>
                                        <?php print '<img class="mb-2" alt="印章" src="data:images/png;base64,' . base64_encode($result['SignatureStamp']) . '" style="width:4em;height:auto;opacity: 0.8;">'; ?><br>
                                        <label class="btn btn-sm btn-secondary font-weight-normal rounded-0" for="UpSignatureStamp">印章ファイル</label>
                                    </div>
                                </div>
                            </div>
                            <div class="input-group">
                                <input type="submit" value="更新" class="btn btn-sm px-4 btn-secondary rounded-0 mr-1" onclick="up();">
                                <input type="button" value="削除" class="btn btn-sm px-4 btn-danger rounded-0">
                            </div>
                        </div>
                    </td>
                </tr>


            <?php }; ?>
        </table>

        <input type="hidden" name="SerialNumber" id="SerialNumber">
        <input type="hidden" name="UpBranchName" id="UpBranchName">
        <input type="hidden" name="UpRepresentative" id="UpRepresentative">
        <input type="hidden" name="UpPostCode" id="UpPostCode">
        <input type="hidden" name="UpAddress" id="UpAddress">
        <input type="hidden" name="UpPhone" id="UpPhone">
        <input type="hidden" name="UpFax" id="UpFax">
        <input type="file" name="UpSignatureStamp" id="UpSignatureStamp" accept="image/png" style="display: none;">
        <input type="hidden" name="sbmtype" id="sbmtype">

    </div>
</form>

<script>
    function up() {
        $("#table td").bind("click", function() {
            $tag_tr = $(this).parent()[0]; //クリックした行を取得
            $rowNum = $tag_tr.rowIndex; //行番号を取得

            const uBranchId = document.getElementsByName("CurrentBranchId")[$rowNum].value;
            const uBranchName = document.getElementsByName('CurrentBranchName')[$rowNum].value;
            const uRepresentative = document.getElementsByName('CurrentRepresentative')[$rowNum].value;
            const uPostCode = document.getElementsByName('CurrentPostCode')[$rowNum].value;
            const uAddress = document.getElementsByName('CurrentAddress')[$rowNum].value;
            const uPhone = document.getElementsByName('CurrentPhone')[$rowNum].value;
            const uFax = document.getElementsByName('CurrentFax')[$rowNum].value;

            document.getElementById("SerialNumber").value = uBranchId;

            document.getElementById('UpBranchName').value = uBranchName;
            document.getElementById('UpRepresentative').value = uRepresentative;
            document.getElementById('UpPostCode').value = uPostCode;
            document.getElementById('UpAddress').value = uAddress;
            document.getElementById('UpPhone').value = uPhone;
            document.getElementById('UpFax').value = uFax;

            document.getElementById("sbmtype").value = "9";
        });
    }
</script>