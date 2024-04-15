<style>
    .drstitle {
        width: 100%;
        text-align: left;
        position: relative;
    }

    .drstitle div {
        position: absolute;
        top: 0;
        bottom: 0;
        right: 0;
        display: flex;
        height: 1.3em;
        line-height: 1.3em;
    }

    .drstitle div a {
        margin-left: 1em;
    }

    .drswrap {
        background-color: #8fd19e;
        width: 80%;
        margin: 0 auto;
    }

    .drswrap h3 {
        width: 80%;
        padding: 0.5em;
        margin: 0 auto;
    }

    .inner {
        width: 80%;
        margin: 0 auto;
        padding-bottom: 2em;
    }

    .weatherbutton {
        list-style-type: none;
        margin: 0;
        padding: 0.5em;
        padding-left: 2em;
        display: flex;
        width: 100%;
        background-color: #ffffff;
        box-sizing: border-box;
    }

    .weatherbutton li {
        width: 2em;
        margin-right: 2em;
    }

    .weather {
        display: block;
        background: none;
        background-position: center;
        background-repeat: no-repeat;
        background-size: contain;
        height: 2em;
        border: none;
        outline: none;
        transition: all 0.2s 0s ease;
        margin: 0;
        padding: 0;
    }

    .weather:hover {
        background-color: #8fd19e;
        border-bottom: #8fd19e 3px solid;
    }

    .tgl {
        display: none;
    }

    .tgl:checked+.weather {
        border-bottom: #8fd19e 3px solid;
    }
</style>

<form action="" method="post" name="f_list" id="f_list">
    @csrf
    <div style="width:100%;padding:0 0 2em 0;">

        <div class="drswrap">
            <h3>勤務日</h3>
            <div class="inner">
                <div style="padding:0.5em;background-color:#ffffff;">
                    <input type="hidden" name="UserID" value="<?= $user['id'] ?>">
                    <input name="WorkingDay" type="text" class="datepicker" required style="height:2em;line-height:2em;width:100%;border:none;outline: 1px solid #8fd19e;">
                </div>
            </div>
        </div>

        <div class="drswrap" style="margin-top:2em;">
            <h3>ＡＭ</h3>
            <div class="inner">
                <ul class="weatherbutton">
                    <li>
                        <input type="radio" name="Weather1" id="amsun" class="tgl" value="1">
                        <label for="amsun" class="weather" style="background-image: url(https://icongr.am/jam/sun.svg?size=16&color=000000);"></label>
                    </li>
                    <li>
                        <input type="radio" name="Weather1" id="amcloud" class="tgl" value="2">
                        <label for="amcloud" class="weather" style="background-image: url(https://icongr.am/feather/cloud.svg?size=16&color=000000);"></label>
                    </li>
                    <li>
                        <input type="radio" name="Weather1" id="amrain" class="tgl" value="3">
                        <label for="amrain" class="weather" style="background-image: url(https://icongr.am/feather/cloud-drizzle.svg?size=16&color=000000);"></label>
                    </li>
                    <li>
                        <input type="radio" name="Weather1" id="amthunder" class="tgl" value="4">
                        <label for="amthunder" class="weather" style="background-image: url(https://icongr.am/feather/cloud-lightning.svg?size=16&color=000000);"></label>
                    </li>
                    <li>
                        <input type="radio" name="Weather1" id="amsnow" class="tgl" value="5">
                        <label for="amsnow" class="weather" style="background-image: url(https://icongr.am/material/snowflake.svg?size=16&color=000000);"></label>
                    </li>
                </ul>
                <div style="margin-top:1em;padding:0.5em;background-color:#ffffff;">
                    <select name="AmIndustry" style="height:2em;line-height:2em;width:100%;border:none;outline: 1px solid #8fd19e;" required>
                        <option value="" disabled selected style='display:none;'>業種を選択してください</option>
                        <?php
                        $sql = "SELECT * FROM drs_industries ORDER BY ID ASC";
                        $stmt = $dbh->query($sql);
                        while ($result = $stmt->fetch(PDO::FETCH_BOTH)) {
                            echo "<option value='" . $result['ID'] . "'>" . $result['Industry'] . "</option>";
                        };
                        ?>
                    </select>
                </div>
                <div style="margin-top:1em;padding:0.5em;background-color:#ffffff;">
                    <textarea name="AmRemark" id="" placeholder="摘要" style="width:100%;height:10em;border:none;outline: 1px solid #8fd19e;"></textarea>
                </div>
            </div>
        </div>

        <div class="drswrap" style="margin-top:2em;">
            <h3>ＰＭ</h3>
            <div class="inner">
                <ul class="weatherbutton">
                    <li>
                        <input type="radio" name="Weather2" id="pmsun" class="tgl" value="1">
                        <label for="pmsun" class="weather" style="background-image: url(https://icongr.am/jam/sun.svg?size=16&color=000000);"></label>
                    </li>
                    <li>
                        <input type="radio" name="Weather2" id="pmcloud" class="tgl" value="2">
                        <label for="pmcloud" class="weather" style="background-image: url(https://icongr.am/feather/cloud.svg?size=16&color=000000);"></label>
                    </li>
                    <li>
                        <input type="radio" name="Weather2" id="pmrain" class="tgl" value="3">
                        <label for="pmrain" class="weather" style="background-image: url(https://icongr.am/feather/cloud-drizzle.svg?size=16&color=000000);"></label>
                    </li>
                    <li>
                        <input type="radio" name="Weather2" id="pmthunder" class="tgl" value="4">
                        <label for="pmthunder" class="weather" style="background-image: url(https://icongr.am/feather/cloud-lightning.svg?size=16&color=000000);"></label>
                    </li>
                    <li>
                        <input type="radio" name="Weather2" id="pmsnow" class="tgl" value="5">
                        <label for="pmsnow" class="weather" style="background-image: url(https://icongr.am/material/snowflake.svg?size=16&color=000000);"></label>
                    </li>
                </ul>
                <div style="margin-top:1em;padding:0.5em;background-color:#ffffff;">
                    <select name="PmIndustry" style="height:2em;line-height:2em;width:100%;border:none;outline: 1px solid #8fd19e;" required>
                        <option value="" disabled selected style='display:none;'>業種を選択してください</option>
                        <?php
                        $sql = "SELECT * FROM drs_industries ORDER BY ID ASC";
                        $stmt = $dbh->query($sql);
                        while ($result = $stmt->fetch(PDO::FETCH_BOTH)) {
                            echo "<option value='" . $result['ID'] . "'>" . $result['Industry'] . "</option>";
                        };
                        ?>
                    </select>
                </div>
                <div style="margin-top:1em;padding:0.5em;background-color:#ffffff;">
                    <textarea name="PmRemark" id="" placeholder="摘要" style="width:100%;height:10em;border:none;outline: 1px solid #8fd19e;"></textarea>
                </div>
            </div>
        </div>

        <div class="drswrap" style="margin-top:2em;">
            <h3>備考</h3>
            <div class="inner">
                <div style="padding:0.5em;background-color:#ffffff;">
                    <textarea name="Remark" id="" placeholder="備考" style="width:100%;height:10em;border:none;outline: 1px solid #8fd19e;"></textarea>
                </div>
            </div>
        </div>
    </div>

    <div style="width:100%; margin:0 auto;;text-align:center;">
        <button class="btn btn-secondary rounded-0 btn-sm px-4 mb-5" onclick="">保存</button>
        <input type="hidden" id="sbmtype" name="sbmtype" value="4">
    </div>

</form>