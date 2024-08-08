<?php
$wg_sql = "SELECT * FROM worker_group ORDER BY WorkerGroupID ASC";
$wg_st = $dbh->query($wg_sql);
if (empty($_GET['ipt'])) {
    $dtc = ' onchange="datecheck();"';
    $ipt = "";
    $printlink = "?ipt=prnt";
} elseif ($_GET['ipt'] === "admin") {
    $dtc = "";
    $ipt = "admin";
    $printlink = "?ipt=admin";
} else {
    $dtc = ' onchange="datecheck();"';
    $ipt = "";
    $printlink = "?ipt=prnt";
}

?>
<form action="<?= $printlink ?>" method="post" name="wat2">
    @csrf
    <input type="text" id="shukkinbi" name="shukkinbi" class="fs form-control rounded-0 datepicker text-center" style="padding:1.5em" placeholder="出勤日を選択 &#xf073;" value="" required <?= $dtc ?> readonly="readonly" autofocus>
    <section>
        <?php $opn = 0;
        while ($result = $wg_st->fetch(PDO::FETCH_BOTH)) :
            $opn = $opn + 1 ?>
            <input type="radio" class="btn-check" name="options" id="option<?= $opn; ?>" value="<?= $result['WorkerGroupID'] ?>" onclick="sbmtcheck();">
            <label class="wgname" for="option<?= $opn; ?>"><?= $result['WorkerGroupName'] ?></label>
        <?php endwhile; ?>
    </section>
    <input type="text" name="sbmtype" id="sbmtype" value="2" hidden>
</form>

<a style="text-decoration: none;border: 0.3em solid rgba(32, 178, 170, 1);background-color: rgba(32, 178, 170, 0.5);padding:0.5em;position:absolute;top:1%;right:1%;color:#000;text-align:center;" href="../worker/print<?= $printlink ?>"><span>出勤表<br>印刷</span></a>

<?php
if ($ipt == "admin") : ?>
    <div style="position: absolute; bottom:0;left:0;background-color:chocolate;color:white;width:100%;text-align:center;">管理者モード</div>

<?php endif ?>