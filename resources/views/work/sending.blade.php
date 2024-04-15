<?php
$sqlnumber = $_POST['SerialNumber'];
$shrui = substr($sqlnumber, 0, 2);
if ($shrui == 12) {
    $sql = "SELECT BillNumber,Customer,UserName FROM bill WHERE BillNumber = {$sqlnumber}";
} elseif ($shrui == 11) {
    $sql = "SELECT EstimateNumber,Customer,UserName FROM estimate WHERE EstimateNumber = {$sqlnumber}";
} elseif ($shrui == 13) {
    $sql = "SELECT Es2Number,Customer,UserName From estimate2 WHERE Es2Number = {$sqlnumber}";
}
$stmt = $dbh->query($sql);
$sending = $stmt->fetch();
?>

<form action="sending/preview" method="post">
    @csrf
    <table class="table table-hover table-borderless ctable">
        <tbody>
            <tr>
                <td class="table-success col-sm-2">発行日<span class="required_item">必須</span></td>
                <td>
                    <input type="text" name="createdate" required class="form-control rounded-0 datepicker">
                </td>
            </tr>
            <tr>
                <td class="table-success col-sm-2">送付先<span class="required_item">必須</span></td>
                <td>
                    <div class="input-group">
                        <input type="text" name="companyname" value="<?= $sending['Customer'] ?>" class="form-control rounded-0 col-sm-10">
                        <select name="titleofhonor" id="" required class="form-control rounded-0 col-sm-2">
                            <option value=" 様">様</option>
                            <option value="御中">御中</option>
                        </select>
                    </div>
                </td>
            </tr>
            <tr>
                <td class="table-success col-sm-2">送付先担当者名等</td>
                <td>
                    <input type="text" name="clientname" class="form-control rounded-0">
                </td>
            </tr>
            <tr>
                <td class="table-success col-sm-2">担当者</td>
                <td>
                    <div class="input-group">
                        <input type=" text" id="uid" name="uid" value=<?= $user['id']; ?> readonly class="form-control rounded-0 col-sm-2">
                        <input type="text" id="username" name="username" value="<?= $user['name']; ?>" readonly class="form-control rounded-0 col-sm-10">
                    </div>

                    <div class="btn-group btn-group-toggle mt-1" data-toggle="buttons">
                        <label class="btn btn-outline-secondary active btn-sm">
                            <input type="radio" name="staffdisp" id="staffdisp1" value="1" autocomplete="off" checked>&nbsp;表示&nbsp;
                        </label>
                        <label class="btn btn-outline-secondary btn-sm">
                            <input type="radio" name="staffdisp" id="staffdisp2" value="2" autocomplete="off">非表示
                        </label>
                    </div>
                </td>
            </tr>
            <tr>
                <td class="table-success col-sm-2">文書タイトル<span class="required_item">必須</span></td>
                <td>
                    <input type="text" name="title" value="文書送付のご案内" class="form-control rounded-0 ">
                </td>
            </tr>
            <tr>
                <td class="table-success col-sm-2">本文</td>
                <td>
                    <textarea name="document" class="form-control rounded-0" rows="5">
時下ますますご清栄のこととお慶び申し上げます。
平素より格別のご高配を賜り、厚く御礼申し上げます。
さて、下記の通り書類を送付いたしますので、ご査収くださいますようお願い申し上げます。
            </textarea>

                </td>
            </tr>
        </tbody>
    </table>

    <?php
    $table = array(
        array("0", "1", "2"),
        array("3", "4", "5"),
        array("6", "7", "8"),
        array("9", "10", "11"),
        array("12", "13", "14"),
        array("15", "16", "17"),
        array("18", "19", "20"),
        array("21", "22", "23"),
        array("24", "25", "26"),
        array("27", "28", "29"),
        array("30", "31", "32")
    )
    ?>
    <table class="table table-sm table-hover table-bordered">
        <thead>
            <tr class="table-success sticky-top">
                <td class="text-center">添付書類名</td>
                <td class="text-center">数量</td>
                <td class="text-center">単位</td>
            </tr>
        </thead>
        <tbody id="items">
            <?php $cel = -1; ?>
            <?php foreach ($table as $row) : ?>
                <tr>
                    <?php $cel = $cel + 1; ?>
                    <?php echo '<td class="px-1 input-group"><img class="px-1" src="https://icongr.am/clarity/bars.svg?size=30&color=currentColor" alt=""><input class="lists form-control rounded-0" type="text" name="InputItems' . $cel . '" id="InputItems' . $cel . '"></td>'; ?>
                    <?php $cel = $cel + 1; ?>
                    <?php echo '<td class="px-1 col-sm-2"><input class="lists form-control rounded-0" type="text" name="InputItems' . $cel . '" id="InputItems' . $cel . '"></td>'; ?>
                    <?php $cel = $cel + 1; ?>
                    <?php echo '<td class="px-1 col-sm-2"><input class="lists form-control rounded-0" type="text" name="InputItems' . $cel . '" id="InputItems' . $cel . '"></td>'; ?>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div style="width:100%; margin:0 auto;padding:10px 0;text-align:center;">
        <input class="btn btn-sm btn-secondary rounded-0 px-5" type="submit" value="印刷" formtarget="_blank" formaction="sending/preview">
    </div>
</form>