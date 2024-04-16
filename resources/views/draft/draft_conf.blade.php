<form action="" method="post" name="f_input">
    @csrf

    <table class="table table-hover table-borderless ctable">
        <tbody>
            <tr>
                <td class="table-success col-sm-2">文書種類</td>
                <td>
                    <?php
                    $sql = "SELECT * FROM draft_type WHERE DraftID = " . $_POST['DraftTypeId'];
                    $stmt = $dbh->query($sql);
                    $result = $stmt->fetch();
                    echo $result['DraftName'];
                    ?>
                    <input type="hidden" name="DraftTypeId" value="<?= $_POST['DraftTypeId'] ?>">
                </td>
            </tr>
            <tr>
                <td class="table-success col-sm-2">文書番号</td>
                <td>
                    <?= $_POST['SerialNumber'] ?>
                    <input type="hidden" name="SerialNumber" value="<?= $_POST['SerialNumber'] ?>">
                </td>
            </tr>
            <tr>
                <td class="table-success col-sm-2">起案日</td>
                <td>
                    <?= $_POST['CreatedDate'] ?>
                    <input type="hidden" name="CreatedDate" value="<?= $_POST['CreatedDate'] ?>">
                </td>
            </tr>
            <tr>
                <td class="table-success col-sm-2">表題</td>
                <td>
                    <?= $_POST['TitleName'] ?>
                    <input type="hidden" name="TitleName" value="<?= $_POST['TitleName'] ?>">
                </td>
            </tr>
            <tr>
                <td class="table-success col-sm-2">内容</td>
                <td>
                    <?= nl2br($_POST['Contents']) ?>
                    <input type="hidden" name="Contents" value="<?= $_POST['Contents'] ?>">
                </td>
            </tr>
            <tr>
                <td class="table-success col-sm-2">レイアウト</td>
                <td>
                    <?php
                    if (empty($_POST['Layout'])) {
                        echo "1ページ";
                    } else {
                        echo "複数ページ";
                    }
                    ?>
                    <input type="hidden" name="Layout" value="<?= $_POST['Layout'] ?>">
                </td>
            </tr>
        </tbody>
    </table>
    <input type="hidden" name="UserID" value="<?= $_POST['UserID'] ?>">
    <input type="hidden" name="UserName" value="<?= $_POST['UserName'] ?>">

    <div style="width:100%;text-align:center;" class="pb-5">
        <input class="btn btn-secondary rounded-0 btn-sm px-4" type="button" name="btn_back" value="戻る" onclick="history.back()">
        <input class="btn btn-secondary rounded-0 btn-sm px-4" type="submit" formmethod="post" formaction="draft/preview" formtarget="_blank" value="プレビュー">
        <input class="btn btn-secondary rounded-0 btn-sm px-4" type="submit" name="save" value="保存">
        <input type="hidden" name="sbmtype" value="4">
    </div>
</form>