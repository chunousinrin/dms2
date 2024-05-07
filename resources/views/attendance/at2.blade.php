        <?php
        $atcheck_sql = "SELECT count(*)as iptcheck FROM attendance WHERE UserID='" . $_POST['UserID'] . "' AND WorkingDay = '" . date("Y/m/d") . "'";
        $atcheck_st = $dbh->query($atcheck_sql);
        $atcheck = $atcheck_st->fetch();

        $at_sql = "SELECT * FROM attendance WHERE UserID='" . $_POST['UserID'] . "' AND WorkingDay = '" . date("Y/m/d") . "'";
        $at_st = $dbh->query($at_sql);
        $entered = $at_st->fetch();
        ?>
        <section id="second">
            <a href="/attendance" class="backbtn">戻る</a>
            <div class="clock">
                <div>
                    <h1 id="rtca" style="font-size:max(15px, min(3rem,3rem));font-size: clamp(15px, 3rem, 3rem);border-bottom:1px solid black;"></h1>
                    <h1 style="font-size:max(8px, min(1.5rem,1.5rem));font-size: clamp(8px, 1.5rem, 1.5rem);"><?= date("m/d D") ?></h1>
                </div>
            </div>
            <div class="timecard">
                <div class="timecard_inner">
                    <?php
                    if ($atcheck['iptcheck'] > 0) {
                        $sbmtype = "3";/*更新*/
                    } else {
                        $sbmtype = "4";/*新規*/
                    }
                    ?>
                    <h4>
                        <?= $_POST['UserName'] ?? null ?>
                    </h4>
                    <form action="" method="post" name="form2" id="form2">
                        @csrf
                        <div class="btnbox">
                            <label for="AttendanceTime" onclick="Attendance();">出勤時間<br><?= $entered['AttendanceTime'] ?? null ?>
                                <input type="time" step="1" name="AttendanceTime" id="AttendanceTime" value="<?= $entered['AttendanceTime'] ?? null ?>" hidden>
                            </label>
                            <label for="OutingTime" onclick="Outing();">時間内退勤<br><?= $entered['OutingTime'] ?? null ?>
                                <input type="time" step="1" name="OutingTime" id="OutingTime" value="<?= $entered['OutingTime'] ?? null ?>" hidden>
                            </label>
                            <label for="ReentryTime" onclick="Reentry();">時間内出勤<br><?= $entered['ReentryTime'] ?? null ?>
                                <input type="time" step="1" name="ReentryTime" id="ReentryTime" value="<?= $entered['ReentryTime'] ?? null ?>" hidden>
                            </label>
                            <label for="LeavingTime" onclick="Leaving();">退勤時間<br><?= $entered['LeavingTime'] ?? null ?>
                                <input type="time" step="1" name="LeavingTime" id="LeavingTime" value="<?= $entered['LeavingTime'] ?? null ?>" hidden>
                            </label>
                            <input type="text" name="sbmtype" id="sbmtype" value="<?= $sbmtype ?? 2 ?>" hidden>
                            <input type="text" name="UserID" id="UserID" value="<?= $_POST['UserID'] ?? null ?>" hidden>
                            <input type="datetime" name="WorkingDay" id="WorkingDay" value="<?= $entered['WorkingDay'] ?? date("Y/m/d") ?> " hidden>
                            <input type="text" name="UserName" id="UserName" value="<?= $_POST['UserName'] ?? null ?>" hidden>
                        </div>
                    </form>
                </div>
            </div>
        </section>
        <script src="/js/attendance.js"></script>
        <script>
            const nowTime = new Date();
            const nowHour = set2fig(nowTime.getHours());
            const nowMin = set2fig(nowTime.getMinutes());
            const nowSec = set2fig(nowTime.getSeconds());
            const msg = nowHour + ":" + nowMin;

            function showClock3() {
                document.getElementById("rtca").innerHTML = msg;
            }

            setInterval("showClock3()", 1000);

            function Attendance() {
                document.getElementById('AttendanceTime').value = nowHour + ":" + nowMin + ":" + nowSec;
                document.form2.submit();
            }

            function Outing() {
                document.getElementById('OutingTime').value = nowHour + ":" + nowMin + ":" + nowSec;
                document.form2.submit();
            }

            function Reentry() {
                document.getElementById('ReentryTime').value = nowHour + ":" + nowMin + ":" + nowSec;
                document.form2.submit();
            }

            function Leaving() {
                document.getElementById('LeavingTime').value = nowHour + ":" + nowMin + ":" + nowSec;
                document.form2.submit();
            }

            setTimeout(function() {
                window.location.href = '/attendance';
            }, 20 * 1000);
        </script>