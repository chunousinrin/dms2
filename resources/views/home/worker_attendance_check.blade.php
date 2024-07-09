<?php

use Illuminate\Support\Facades\Auth;

$user = Auth::user();
?>
<div class="bg-white mb-3 p-2" style="box-shadow: 5px 5px 5px -5px #464646;">
    <form action="https://cf444722.cloudfree.jp/worker/wat6?kyo=<?= $_GET['kyo'] ?? null ?>" method="get" target="wath">
        @csrf
        <div class="d-flex">
            <div class="flex-grow-1 text-center">作業班出退勤</div>
            <?php
            if ($user['authtype'] == 1) : ?>
                <button class="btn btn-sm btn-info rounded-0 py-0" formaction="/worker" formtarget="_new" name="ipt" value="admin">入力</button>
            <?php endif ?>
            <button class="btn btn-sm btn-info rounded-0 py-0" formaction="/worker/print" formtarget="_new" name="ipt" value="prnt">印刷</button>
        </div>
        <input type="text" name="kyo" id="kyo" class="form-control rounded-0 datepicker" placeholder="日付を選択" onchange="submit();" value="<?= $_GET['kyo'] ?? null ?>">
    </form>

    <iframe src="https://cf444722.cloudfree.jp/worker/wat6?kyo=<?= $_GET['kyo'] ?? null ?>" name="wath" style="border:none;width:100%;"></iframe>
</div>