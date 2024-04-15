<?php

if (!empty($_POST['limit'])) {
    $limit = $_POST['limit'];
} else {
    $limit = 25;
}

if (!empty($_POST['stdate']) && !empty($_POST['eddate'])) {
    $src1 = ' AND TradingDate Between "' . $_POST['stdate'] . '" AND "' . $_POST['eddate'] . '"';
} elseif (!empty($_POST['stdate']) && empty($_POST['eddate'])) {
    $src1 = ' AND TradingDate >= "' . $_POST['stdate'] . '"';
} elseif (empty($_POST['stdate']) && !empty($_POST['eddate'])) {
    $src1 = ' AND TradingDate <= "' . $_POST[' eddate'] . '"';
} else {
    $src1 = null;
};
if (!empty($_POST['keyword'])) {
    $src2 = ' AND keyword LIKE "%' . $_POST['keyword'] . '%"';
} else {
    $src2 = null;
};
if (!empty($_POST['ritype'])) {
    $src3 = ' AND RIType = "' . $_POST['ritype'] . '"';
} else {
    $src3 = null;
};
if (!empty($_POST['doctype'])) {
    $src4 = ' AND DocumentType = "' . $_POST['doctype'] . '"';
} else {
    $src4 = null;
};

?>

<form action="" method="post" name="f_list" id="f_list">
    @csrf
    <div class="search_box">
        <div class="input-group">
            <input class="form-control rounded-0" type="text" name="keyword" value="<?= $_POST['keyword'] ?? null ?>" placeholder="キーワード" onchange="document.f_list.submit();">
            <input class="btn btn-sm btn-secondary rounded-0 col-1" value="検索" onclick="document.f_list.submit();">
        </div>
    </div>
    <details class="accordion">
        <summary>詳細検索</summary>
        <div>
            <table class="table table-sm table-hover table-borderless" style="width: 70%;margin:0!important;">
                <tr>
                    <td>取引日</td>
                    <td style="display: flex;align-items:center">
                        <input type="text" name="stdate" class="form-control rounded-0 datepicker" value="<?= $_POST['stdate'] ?? null ?>">
                        <span style="padding:0 1em;">～</span>
                        <input type="text" name="eddate" class="form-control rounded-0 datepicker" value="<?= $_POST['eddate'] ?? null ?>">
                    </td>
                </tr>
                <tr>
                    <td>受領/発行</td>
                    <td>
                        <select class="form-control rounded-0 iptbx" name="ritype" id="ritype">
                            <?php
                            if (empty($_POST['ritype'])) {
                                echo "<option value='' selected hidden>-- 選択してください --</option>";
                            } else {
                                echo "<option value='" . $_POST['ritype'] . "' selected hidden>" . $_POST['ritype'] . "</option>";
                            }
                            ?>
                            <option value=""></option>
                            <option value="受領">受領</option>
                            <option value="発行">発行</option>

                        </select>
                    </td>
                </tr>
                <tr>
                    <td>書類種類</td>
                    <td>
                        <select class="form-control rounded-0 iptbx" name="doctype" id="doctype">
                            <?php
                            if (empty($_POST['doctype'])) {
                                echo "<option value='' selected hidden>-- 選択してください --</option>";
                            } else {
                                echo "<option value='" . $_POST['doctype'] . "' selected hidden>" . $_POST['doctype'] . "</option>";
                            }
                            ?>
                            <option value=""></option>
                            <option value="1">請求書</option>
                            <option value="2">見積書</option>
                            <option value="3">納品書</option>
                            <option value="4">契約書</option>
                            <option value="5">領収書</option>
                            <option value="6">精算書</option>
                            <option value="7">銀行</option>
                            <option value="8">クレジットカード</option>
                            <option value="9">注文書</option>
                            <option value="10">検収書</option>
                        </select>
                    </td>
                </tr>
            </table>
        </div>
    </details>

    <hr>

    <div style="width:100%;display:flex;">
        <div style="width: 100%;">履歴一覧</div>
        <div style="width: 100%;text-align:right;">
            <span>表示件数</span>
            <select name="limit" onchange="submit()">
                <option value="<?= $limit ?>" selected hidden><?= $limit ?></option>
                <option value="50">50</option>
                <option value="100">100</option>
                <option value="200">200</option>
            </select>
        </div>
    </div>



    <div class="table-wrap">
        <table class="table table-bordered table-sm table-hover" id="table">
            <thead style="position: sticky;top:calc(-1em - 1px);">
                <tr class="table-success">
                    <td></td>
                    <td>取引日</td>
                    <td>保存番号</td>
                    <td>受領/発行</td>
                    <td>書類種類</td>
                    <td>取引先</td>
                    <td>金額</td>
                    <td>備考</td>
                </tr>
            </thead>
            <tbody>

                <?php
                $sql = "SELECT * FROM accountbook_history WHERE 1" . $src1 . $src2 . $src3 . $src4 . " LIMIT " . $limit;
                $stmt = $dbh->query($sql);
                while ($result = $stmt->fetch(PDO::FETCH_BOTH)) { ?>
                    <tr>
                        <td class="text-center" style='white-space:nowrap;'>
                            <a href="./UploadFiles/<?= $result['FileName'] ?>" target="_new" class="btns btn btn-sm btn-secondary rounded-0" style="background-image:url(https://icongr.am/feather/printer.svg?color=ffffff);"></a>
                            <input type="submit" value="" class="btns btn btn-sm btn-secondary rounded-0" style="background-image:url(https://icongr.am/fontawesome/trash-o.svg?color=ffffff);" onclick="dl()">
                        </td>
                        <td><?= $result['TradingDate'] ?></td>
                        <td name="SerialNumber"><?= $result['ErrlNumber'] ?></td>
                        <td><?= $result['RIType'] ?></td>
                        <td><?= $result['TypeName'] ?></td>
                        <td><?= $result['Customer'] ?></td>
                        <td style='text-align:right;'><?= number_format($result['Amount']) ?></td>
                        <td>
                            <?php
                            if (strlen($result['Remark']) > 25) {
                                echo mb_substr($result['Remark'], 0, 24) . "…";
                            } else {
                                echo $result['Remark'];
                            }; ?>
                        </td>
                    </tr>
                <?php }; ?>
            </tbody>
        </table>
    </div>
    <input type="hidden" id="listsql" name="listsql" value="<?= $sql ?>">
    <input type="hidden" id="SerialNumber" name="SerialNumber">
    <input type="hidden" id="sbmtype" name="sbmtype" value="<?= $sbmtype ?>">
</form>