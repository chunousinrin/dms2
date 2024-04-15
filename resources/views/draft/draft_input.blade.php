<?php $draftnum = "10" . time()             ?>

<form action="" method="post" name="f_input">
    @csrf

    <table class="table table-hover table-borderless ctable">
        <tbody>
            <tr>
                <td class="table-success col-sm-2">文書種類<span class="required_item">必須</span></td>
                <td>
                    <select name="DraftTypeId" required class="form-control rounded-0">
                        <option value="" hidden selected>-- 選択してください --</option>
                        <?php
                        $sql = "SELECT * FROM draft_type ORDER BY DraftID ASC";
                        $stmt = $dbh->query($sql);
                        while ($result = $stmt->fetch(PDO::FETCH_BOTH)) {
                            echo '<option value="' . $result['DraftID'] . '">' . $result['DraftName'] . '</option>';
                        };
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td class="table-success col-sm-2">文書番号</td>
                <td>
                    <input type="text" name="SerialNumber" value=<?= $draftnum ?> readonly class="form-control rounded-0 ">
                </td>
            </tr>
            <tr>
                <td class="table-success col-sm-2">起案日<span class="required_item">必須</span></td>
                <td>
                    <input name="CreatedDate" type="text" required class="form-control rounded-0 datepicker">
                </td>
            </tr>
            <tr>
                <td class="table-success col-sm-2">表題<span class="required_item">必須</span></td>
                <td>
                    <input name="TitleName" type="text" required class="form-control rounded-0">
                </td>
            </tr>
            <tr>
                <td class="table-success col-sm-2">内容</td>
                <td>
                    <textarea name="Contents" style="height: 20em;" class="form-control rounded-0"></textarea>
                </td>
            </tr>
            <tr>
                <td class="table-success col-sm-2">レイアウト</td>
                <td>
                    <select name="Layout" class="form-control rounded-0 col-sm-2">
                        <option value="0" selected>1ページ</option>
                        <option value="1">複数ページ</option>
                    </select>
                </td>
            </tr>
            <tr style="display: none;">
                <td class="table-success col-sm-2">添付書類</td>
                <td>
                    <textarea name="Documents" style="height: 10em;" class="form-control rounded-0"></textarea>
                </td>
            </tr>
            <tr style="display: none;">
                <td class="table-success col-sm-2">添付ファイル</td>
                <td>
                    <div class="input-group mb-3">
                        <div class="input-group-append">
                            <span class="input-group-text">１.</span>
                        </div>
                        <div class="custom-file">
                            <input type="file" multiple name="Attachment" class="custom-file-input rounded-0">
                            <label class="custom-file-label rounded-0">ファイルを選択してください</label>
                        </div>
                    </div>


                    <div class="input-group mb-3">
                        <div class="input-group-append">
                            <span class="input-group-text">２.</span>
                        </div>
                        <div class="custom-file">
                            <input type="file" multiple name="Attachment2" class="custom-file-input">
                            <label class="custom-file-label">ファイルを選択してください</label>
                        </div>
                    </div>


                    <div class="input-group mb-3">
                        <div class="input-group-append">
                            <span class="input-group-text">３.</span>
                        </div>
                        <div class="custom-file">
                            <input type="file" multiple name="Attachment3" class="custom-file-input">
                            <label class="custom-file-label">ファイルを選択してください</label>
                        </div>
                    </div>


                    <div class="input-group mb-3">
                        <div class="input-group-append">
                            <span class="input-group-text">４.</span>
                        </div>
                        <div class="custom-file">
                            <input type="file" multiple name="Attachment4" class="custom-file-input">
                            <label class="custom-file-label">ファイルを選択してください</label>
                        </div>
                    </div>


                    <div class="input-group mb-3">
                        <div class="input-group-append">
                            <span class="input-group-text">５.</span>
                        </div>
                        <div class="custom-file">
                            <input type="file" multiple name="Attachment5" class="custom-file-input">
                            <label class="custom-file-label">ファイルを選択してください</label>
                        </div>
                    </div>
                    <span>起案書には記載されません</span>
                </td>
            </tr>
        </tbody>
    </table>


    <input type="hidden" name="UserID" value="<?= $user['id'] ?>" readonly>
    <input type="hidden" name="UserName" value="<?= $user['name'] ?>" readonly>

    <div style="width:100%; margin:0 auto;;text-align:center;">
        <button class="btn btn-secondary rounded-0 btn-sm px-4 mb-5" onclick="">入力内容を確認する</button>
        <input type="hidden" name="sbmtype" value="3">
    </div>
</form>