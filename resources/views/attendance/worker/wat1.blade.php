<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@100..900&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>

    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://code.jquery.com/ui/1.13.3/jquery-ui.js"></script>
    <script src="https://rawgit.com/jquery/jquery-ui/master/ui/i18n/datepicker-ja.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/themes/flick/jquery-ui.min.css">

    <title>Document</title>
    <?php
    if (!empty($_POST['sbmtype'])) {
        $sbmtype = $_POST['sbmtype'];
    } elseif (!empty($_GET['sbmtype'])) {
        $sbmtype = $_GET['sbmtype'];
    } else {
        $sbmtype = '1';
    };

    $dbh = new PDO('mysql:host=localhost;dbname=' . env('DB_DATABASE') . ';charset=utf8', env('DB_USERNAME'), env('DB_PASSWORD'));
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
            overflow-x: hidden;
            width: 100vw;
            height: 100vh;
        }


        section {
            display: flex;
            flex-wrap: wrap;
        }

        .wgname {
            width: calc((100% / 3) - 1em);
            margin: 0 0.5em;
            margin-top: 0.5em;
            padding: 2% 0;
            text-align: center;
            border: 0.3em solid rgba(32, 178, 170, 1);
            background-color: rgba(32, 178, 170, 0.5);
            cursor: pointer;
            font-size: clamp(1.1rem, 1.7rem, 1.7rem);
            box-shadow: 5px 5px 5px -5px #464646;
            font-weight: bolder;
        }

        .table td,
        .fs {
            font-size: max(8px, min(1.3rem, 1.3rem));
            font-size: clamp(8px, 1.3rem, 1.3rem);
        }

        .bs {
            background-color: rgba(32, 178, 170, 1) !important;
            color: white !important;
        }

        .bsh:hover {
            background-color: rgba(32, 178, 170, 0.5) !important;
        }

        .table tbody td {
            padding-top: 2em;
            padding-bottom: 2em;
        }
    </style>
</head>

<body>
    <?php if ($sbmtype == "1") : ?>
        @include('attendance.worker.wat2')
    <?php elseif ($sbmtype == "2") : ?>
        @include('attendance.worker.wat3')
    <?php elseif ($sbmtype == "3") : ?>
        @include('attendance.worker.wat4')
    <?php elseif ($sbmtype == "4") : ?>
        <?php
        for ($i = 1; $i < $_POST['kensu'] + 1; $i++) {
            if (!empty($_POST['WorkerNameID' . $i])) {
                $wasql = "INSERT INTO worker_attendance (AttendanceDay, WorkerNameID, watID) VALUES (:AttendanceDay, :WorkerNameID, :watID)";
                $wastmt = $dbh->prepare($wasql);
                $params = array(':AttendanceDay' => $_POST['shukkinbi'], ':WorkerNameID' => $_POST['WorkerNameID' . $i], ':watID' => $_POST['watID' . $i]);
                $wastmt->execute($params);
            } else {
                echo false;
            };
        };
        header("Location:./worker");
        exit();
        ?>
    <?php else : ?>
        @include('attendance.worker.wat2')
    <?php endif ?>

</body>

<script src="/js/document_manage.js"></script>
</section>
<input type="text" name="sbmtype" id="sbmtype" value="3" hidden>
</form>

<script>
    //ラジオボタン選択・解除
    document.querySelectorAll("input[type=radio]").forEach((radio) => {
        radio.addEventListener("click", () => {
            if (radio.classList.contains("is-checked")) {
                radio.classList.remove("is-checked");
                radio.checked = false;
            } else {
                document
                    .querySelectorAll("input[type='radio'].is-checked")
                    .forEach((checkedRadio) => {
                        checkedRadio.classList.remove("is-checked");
                    });
                radio.classList.add("is-checked");
            }
        });
    });

    //セレクトボックス活性・非活性切り替え
    const changeSelectEnable = function(el) {
        const name = el.getAttribute('name')
        const select = document.querySelector(`[data-sync="${name}"]`)

        if (el.value === select.getAttribute('data-active')) {
            select.disabled = false
        } else {
            select.disabled = true
        }
    }

    const radio = document.querySelectorAll('.js-selectEnableRadio input[type="radio"]')
    radio.forEach((el) => {
        el.addEventListener('change', (ev) => {
            changeSelectEnable(ev.target)
        })
    })

    function sbmtcheck() {
        var shukin = document.getElementById("shukkinbi").value;
        if (shukin == "") {
            alert("出勤日を入力してください");
        } else {
            document.wat2.submit();
        }
    }

    function datecheck() {
        var dt = new Date();
        var shukkinbi = new Date(document.getElementById('shukkinbi').value);

        if (dt.getDate() - 3 <= shukkinbi.getDate() && shukkinbi.getDate() <= dt.getDate()) {

        } else {
            alert("本日より3日前まで入力できます");
            document.getElementById('shukkinbi').value = null;
        }
    }

    $("#gotop").bind("click", function() {
        window.location.href = '/worker';
    });
</script>

</html>