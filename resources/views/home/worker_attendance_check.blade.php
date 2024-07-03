<div class="bg-white mb-3 p-2" style="box-shadow: 5px 5px 5px -5px #464646;">
    <form action="https://cf444722.cloudfree.jp/worker/wat6?kyo=<?= $_GET['kyo'] ?? null ?>" method="get" target="wath">
        @csrf
        <div class="text-center" style="position: relative;">作業班出退勤
            <button class="btn btn-sm btn-info py-0 rounded-0" style="position: absolute; top:0;right:0;" formaction="https://cf444722.cloudfree.jp/worker/print" formtarget="_new">印刷</button>
        </div>

        <input type="text" name="kyo" id="kyo" class="form-control rounded-0 datepicker" placeholder="日付を選択" onchange="submit();" value="<?= $_GET['kyo'] ?? null ?>">
    </form>

    <iframe src="https://cf444722.cloudfree.jp/worker/wat6?kyo=<?= $_GET['kyo'] ?? null ?>" name="wath" style="border:none;width:100%;"></iframe>
</div>