<?php
//未閲覧の場合
$sql = "SELECT * FROM draft_history WHERE DraftNumber = " . $_POST['SerialNumber'];
$stmt = $dbh->query($sql);
$result = $stmt->fetch();

$sql3 = "SELECT COUNT(*)AS cnt FROM draft_history WHERE DraftNumber = " . $_POST['SerialNumber'] . " AND BrowseUserID = 2";
$stmt3 = $dbh->query($sql3);
$browse = $stmt3->fetch();
if (!empty($browse['cnt'])) {
    echo "<div style='position:absolute;background-color:#ec6d71;color:#fff;font-weight:bolder;border-radius:50%;top:15%;right:1%;height:80px;width:80px;line-height:80px;text-align:center;z-index:1;'>閲覧済</div>";
};
?>

<form action="" method="post" name="f_list" id="f_list">
    @csrf

    <table class="table table-hover table-borderless ctable">
        <tbody>
            <tr>
                <td class="table-success col-sm-2">文書種類</td>
                <td class="bg-white">
                    <?= $result['DraftName'] ?>
                    <input type="hidden" name="DraftTypeId" value="<?= $result['DraftTypeId'] ?>">
                </td>
            </tr>
            <tr>
                <td class="table-success col-sm-2">文書番号</td>
                <td class="bg-white">
                    <?= $result['DraftNumber'] ?>
                    <input type="hidden" name="SerialNumber" value="<?= $result['DraftNumber'] ?>">
                </td>
            </tr>
            <tr>
                <td class="table-success col-sm-2">起案日</td>
                <td class="bg-white">
                    <?= $result['CreatedDate'] ?>
                    <input type="hidden" name="CreatedDate" value="<?= $result['CreatedDate'] ?>">
                </td>
            </tr>
            <tr>
                <td class="table-success col-sm-2">起案者</td>
                <td class="bg-white">
                    <?= $result['userID'] ?>　｜　<?= $result['userName'] ?>
                    <input type="hidden" name="userID" value="<?= $result['userID'] ?>">
                    <input type="hidden" name="userName" value="<?= $result['userName'] ?>">
                </td>
            </tr>
            <tr>
                <td class="table-success col-sm-2">表題</td>
                <td class="bg-white">
                    <?= $result['Title'] ?>
                    <input type="hidden" name="Title" value="<?= $result['Title'] ?>">
                </td>
            </tr>
            <tr>
                <td class="table-success col-sm-2">内容</td>
                <td class="bg-white">
                    <?= nl2br($result['Contents']) ?>
                    <input type="hidden" name="Contents" value="<?= $result['Contents'] ?>">
                </td>
            </tr>
        </tbody>
    </table>
    <input type="hidden" name="Layout" value="<?= $result['Multiplepage'] ?>">

</form>
<hr>
<form action="" method="post" name="f_comment" id="f_comment">
    @csrf
    <table class="table table-hover table-borderless ctable">
        <tbody>
            <tr>
                <td class="table-success col-sm-2">コメント</td>
                <td class="bg-white">
                    <?= nl2br($result['Comment']) ?>
                    <textarea class="form-control rounded-0" style="height:10em" name="Comment"></textarea>
                    <button class="btn btn-secondary rounded-0 btn-sm px-4 mt-1">保存</button>
                    <input type="hidden" name="sbmtype" value="10">
                    <input type="hidden" name="SerialNumber" value="<?= $result['DraftNumber'] ?>">
                </td>
            </tr>
        </tbody>
    </table>
</form>

<div style="width:100%; text-align:center;padding:10px 0;">
    <input class="btn btn-secondary rounded-0 btn-sm px-4" type="submit" form="f_list" formmethod="post" formaction="draft/repreview" formtarget="_blank" value="プレビュー">
    <?php
    if (empty($browse['cnt'])) {
        echo "<input class='btn btn-secondary rounded-0 btn-sm px-4' type='submit' form='f_comment' formmethod='post' value='閲覧'>";
    };
    ?>
</div>

<div class="pt-5 pb-5">
    <table class="table table-hover table-sm mb-0 border">
        <tr class="">
            <td class="table-success">閲覧者</td>
        </tr>
        <tr>
            <td class="p-2 bg-white">
                <?php
                $browsed_sql = "SELECT draft_browsed.DraftNumber,draft_browsed.BrowseUserID,users.stamp FROM draft_browsed LEFT JOIN users ON users.id=draft_browsed.BrowseUserID WHERE DraftNumber='{$result['DraftNumber']}' GROUP BY DraftNumber,BrowseUserID,stamp ORDER BY BrowseUserID ASC";
                $browsed_stmt = $dbh->query($browsed_sql);
                foreach ($browsed_stmt as $row) {
                    if (!empty($row['stamp'])) {
                        print '<img style="" width="30mm" height="30mm" src="data:image/svg+xml;base64,' . base64_encode($row['stamp']) . '" >';
                    }
                };
                ?>
            </td>
        </tr>
    </table>
</div>