<?php
$wg_sql = "SELECT * FROM worker_group ORDER BY WorkerGroupID ASC";
$wg_st = $dbh->query($wg_sql); ?>

<form action="" method="post" name="wat2">
    @csrf
    <input type="text" id="shukkinbi" name="shukkinbi" class="fs form-control rounded-0 datepicker text-center" style="padding:1.5em" placeholder="出勤日" value="" required onchange="datecheck()">
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