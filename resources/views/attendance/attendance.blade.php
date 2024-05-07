<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@100..900&display=swap" rel="stylesheet">
    <title>中濃森林組合 - 入退出記録 -</title>

    <?php
    if (!empty($_POST['sbmtype'])) {
        $sbmtype = $_POST['sbmtype'];
    } elseif (!empty($_GET['sbmtype'])) {
        $sbmtype = $_GET['sbmtype'];
    } else {
        $sbmtype = '1';
    };

    $dbh = new PDO('mysql:host=localhost;dbname=cf756484_dms;charset=utf8', 'cf756484_root', 'AgVj4jDXzK');
    $user_sql = "SELECT * FROM users WHERE used = 1";
    $user_st = $dbh->query($user_sql);
    ?>

    <style>
        * {
            box-sizing: border-box;
            min-height: 0vw;
            font-family: "Noto Sans JP", sans-serif;
            font-optical-sizing: auto;
            font-weight: 500;
            font-style: normal;
        }

        body {
            margin: 0;
            padding: 0;
            overflow: hidden;
            width: 100vw;
            height: 100vh;
        }

        /* -- first -- */
        #first {
            display: flex;
            flex-wrap: wrap;
        }

        .namelist {
            width: calc((100% / 4) - 1em);
            margin: 0 0.5em;
            margin-top: 0.5em;
            padding: 2% 0;
            text-align: center;
            border: 0.3em solid rgba(32, 178, 170, 1);
            background-color: rgba(32, 178, 170, 0.5);
            cursor: pointer;
            font-size: max(8px, min(1.7rem, 1.7rem));
            font-size: clamp(8px, 1.7rem, 1.7rem);
        }

        /* -- second -- */
        #second {
            display: grid;
            grid-template-columns: 1fr 2fr;
            grid-template-rows: 1fr;
            grid-column-gap: 0px;
            grid-row-gap: 0px;
            height: 100vh;
            width: 100vw;
        }

        .clock {
            grid-area: 1 / 1 / 2 / 2;
            background-color: lightseagreen;
            position: relative;
        }

        .clock div {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: rgba(255, 255, 255, 0.7);
            padding: 5%;
            text-align: center;
        }

        .clock div h1 {
            margin: 0;
            padding: 0;
        }

        .timecard {
            grid-area: 1 / 2 / 2 / 3;
            position: relative;
            text-align: center;
        }

        .backbtn {
            position: fixed;
            top: 5%;
            right: 5%;
            display: block;
            width: 50px;
            height: 50px;
            line-height: 50px;
            text-align: center;
            text-decoration: none;
            border-radius: 50%;
            z-index: 1;
            background-color: darkblue;
            color: #fff;
            font-size: 1rem;
            font-weight: bolder;
            border: none;
            box-shadow: 0px 0px 7px 5px #fafafa;
            cursor: pointer;
        }

        .timecard_inner {
            position: absolute;
            top: 15%;
            left: 50%;
            transform: translateX(-50%);
        }

        .timecard_inner h4 {
            font-size: max(12px, min(2rem, 2rem));
            font-size: clamp(12px, 2rem, 2rem);
            font-weight: normal;
            margin: 0.3em 0 !important;
            padding: 0 1em;
        }

        .btnbox label {
            border: 2px solid seagreen;
            background-color: rgba(32, 178, 170, 0.4);
            padding: 3%;
            display: block;
            font-size: max(8px, min(1.3rem, 1.3rem));
            font-size: clamp(8px, 1.3rem, 1.3rem);
            margin-bottom: 0.5em;
            cursor: pointer;
            box-shadow: 0px 0px 6px -2px #777777;
            border-radius: 0px;
        }

        @media screen and (max-width:800px) {

            /* --first -- */
            .namelist {
                width: calc((100% / 3) - 1em);
                padding: 1em 0;
            }

            /* -- second -- */
            #second {
                display: block;
            }

            .clock {
                height: 30vh;
            }

            .backbtn {
                top: calc(30vh + 1%);
            }

            .timecard_inner {
                position: relative;
            }

        }
    </style>

</head>

<body>
    <?php
    if (!empty($_POST['AttendanceTime'])) {
        $attendance = $_POST['AttendanceTime'];
    } else {
        $attendance = null;
    }
    if (!empty($_POST['OutingTime'])) {
        $outing = $_POST['OutingTime'];
    } else {
        $outing = null;
    }
    if (!empty($_POST['ReentryTime'])) {
        $reentry = $_POST['ReentryTime'];
    } else {
        $reentry = null;
    }
    if (!empty($_POST['LeavingTime'])) {
        $leaving = $_POST['LeavingTime'];
    } else {
        $leaving = null;
    }
    ?>

    <?php if ($sbmtype == "1") : ?>
        @include('attendance.at1')

    <?php elseif ($sbmtype == "2") : ?>
        @include('attendance.at2')

    <?php elseif ($sbmtype == "3") : ?>
        <?php
        echo "更新";
        $sql = "UPDATE attendance SET name = :name WHERE id = :id";
        $up_at_sql = "UPDATE attendance SET UserID=:UserID,WorkingDay=:WorkingDay,AttendanceTime=:AttendanceTime,OutingTime=:OutingTime,ReentryTime=:ReentryTime,LeavingTime=:LeavingTime WHERE UserID=:UserID AND WorkingDay = :WorkingDay";
        $up_at_st = $dbh->prepare($up_at_sql);
        $up_params = array(':UserID' => $_POST['UserID'], ':WorkingDay' => $_POST['WorkingDay'], ':AttendanceTime' => $attendance, ':OutingTime' => $outing, ':ReentryTime' => $reentry, ':LeavingTime' => $leaving, ':UserID' => $_POST['UserID'], ':WorkingDay' => date('Y/m/d'));
        $up_at_st->execute($up_params);
        ?>
        @include('attendance.at2')

    <?php elseif ($sbmtype == "4") : ?>
        <?php
        $ist_at_sql = "INSERT INTO attendance (UserID,WorkingDay,AttendanceTime,OutingTime,ReentryTime,LeavingTime) VALUES (:UserID,:WorkingDay,:AttendanceTime,:OutingTime,:ReentryTime,:LeavingTime)";
        $ist_at_st = $dbh->prepare($ist_at_sql);
        $ist_params = array(':UserID' => $_POST['UserID'], ':WorkingDay' => $_POST['WorkingDay'], ':AttendanceTime' => $attendance, ':OutingTime' => $outing, ':ReentryTime' => $reentry, ':LeavingTime' => $leaving);
        $ist_at_st->execute($ist_params);
        ?>
        @include('attendance.at2')

    <?php else : ?>
        @include('attendance.at1')

    <?php endif ?>


</body>

<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
<script src="https://coco-factory.jp/ugokuweb/wp-content/themes/ugokuweb/data/8-2-1/js/8-2-1.js"></script>
<script>
    function name_click(elem) {
        var getid = $(elem).data('value');
        console.log(getid); //undefined
        document.getElementById('UserID').value = getid;

        var getname = $(elem).children().data('value');
        console.log(getname);
        document.getElementById('UserName').value = getname;

        document.form1.submit()
        return false;
    };
</script>

</html>