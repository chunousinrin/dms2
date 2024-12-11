<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html lang="ja">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>test</title>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://code.jquery.com/ui/1.13.3/jquery-ui.js"></script>
    <script src="https://rawgit.com/jquery/jquery-ui/master/ui/i18n/datepicker-ja.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/themes/flick/jquery-ui.min.css">

    <style>
        @page {
            size: A4;
            margin: 0;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background-color: rgba(2, 51, 40, 0.2);
            width: 100%;
            -webkit-print-color-adjust: exact;
            color-adjust: exact;
            position: relative;
        }

        .slctr {
            width: 100%;
            /*box-sizing: border-box;*/
            text-align: center;
            background-color: #fff;
            padding: 2em 0;
            position: sticky;
            top: 0;
            left: 0;
            border-bottom: 3px solid #444444;
        }

        .slctr ul {
            width: 100%;
            max-width: 210mm;
            margin: 0 auto;
            list-style-type: none;
            box-sizing: border-box;
            display: flex;
            border: 1px solid lightseagreen;
            font-size: 10pt;
        }

        .slctr ul li {
            line-height: 2.5em;
        }

        .slctr ul li * {
            border: none;
            outline: none;
            width: 100%;
        }

        .srcbtn {
            background-color: lightseagreen;
            text-align: center;
            cursor: pointer;
            transition: 0.5s;
        }

        .srcbtn:hover {
            transition: 0.5s;
            background-color: rgba(32, 178, 170, 0.8);
        }

        .wrap {
            width: 210mm;
            height: 297mm;
            box-sizing: border-box;
            background-color: white;
            margin: 3em auto;
            padding: 15mm;
            box-shadow: 0px 0px 15px -5px #777777;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .table {
            width: 100%;
            margin: 0 auto;
            border-collapse: collapse;
            font-size: 10pt;
            color: #444444;
        }

        .table td {
            padding: 0.35em 0.5em;
        }

        .table thead tr {
            background-color: #c3e6cb !important;
        }

        .table tr td {
            border-right: 1px solid silver;
        }

        .table tr td:last-child {
            border: none;
        }

        .table thead tr {
            border-bottom: 2px solid silver;
        }

        .table tbody tr {
            border-bottom: 1px solid silver;
        }

        .table tbody tr:hover {
            background-color: rgba(68, 68, 68, 0.1);
        }


        @media screen and (max-width:800px) {
            .wrap {
                width: 100%;
                height: 100%;
                margin: 1em auto;
                padding: 1em;
                box-shadow: none;
            }

        }

        @media print {
            body {
                background: none;
            }

            .wrap {
                box-shadow: none;
                margin: 0 auto;
            }


            .noprint {
                display: none;
            }

            .nodw input {
                background: none;
            }

            .table tbody tr,
            .table tbody tr:hover {
                background: none;
            }
        }
    </style>
</head>

<body>
    <section class="slctr noprint">
        <ul>
            <li style="width: 35%;"><input type="text" name="stdate" id="stdate" class="text-center datepicker" value=""></li>
            <li style="width: 10%;"><span class="text-center">～</span></li>
            <li style="width: 35%;"><input type="text" name="eddate" id="eddate" class="text-center datepicker" value=""></li>
            <li style="width: 20%;display: flex;">
                <div id="srcbtn" class="srcbtn">表示</div>
                <div id="prtbtn" class="srcbtn" style="margin-left: 0.5em;">印刷</div>
            </li>
        </ul>
    </section>

    <section>
        <div class="wrap">
            <div id="ttl" class=""></div>
            <table class="table" id="table" style="table-layout: fixed;">
                <thead>
                    <tr>
                        <td class="text-center" style="width: 35mm;">作業員名</td>
                        <td class="text-center" style="background-color: #c3e6cb !important;">出勤</td>
                        <td class="text-center" style="background-color: #c3e6cb !important;">一日欠勤</td>
                        <td class="text-center" style="background-color: #c3e6cb !important;">一日有給</td>
                        <td class="text-center" style="background-color: #c3e6cb !important;">半日欠勤</td>
                        <td class="text-center" style="background-color: #c3e6cb !important;">半日有給</td>
                        <td class="text-center" style="background-color: #c3e6cb !important;">特別休暇</td>
                        <td class="text-center" style="background-color: #c3e6cb !important;">労災</td>
                    </tr>
                </thead>
                <tbody id="atTr">
                </tbody>
            </table>
        </div>
    </section>

    <script>
        $stdate = document.getElementById('stdate');
        $eddate = document.getElementById('eddate');
        $ttl = document.getElementById('ttl');

        document.getElementById('srcbtn').addEventListener('click', (e) => {
            if (!$stdate.value) {
                alert("集計開始日が入力されていません");
            } else if (!$eddate.value) {
                alert("集計終了日が入力されていません");
            } else {
                $.getJSON(
                    "/test2.php", {
                        StartVal: $("#stdate").val(),
                        EndVal: $("#eddate").val(),
                    },
                    function(data, status) {
                        $("#atTr").children().remove();
                        for (i in data) {
                            var row = data[i];
                            $("#atTr").append('<tr>' +
                                '<td class="">' + row['Name'] + '</td>' +
                                '<td class="text-right">' + row['出勤'] + '</td>' +
                                '<td class="text-right">' + row['一日欠勤'] + '</td>' +
                                '<td class="text-right">' + row['一日有給'] + '</td>' +
                                '<td class="text-right">' + row['半日欠勤'] + '</td>' +
                                '<td class="text-right">' + row['半日有給'] + '</td>' +
                                '<td class="text-right">' + row['特別休暇'] + '</td>' +
                                '<td class="text-right">' + row['労災'] + '</td></tr>');
                            $ttl.innerText = '集計対象期間：' + $stdate.value + " ～ " + $eddate.value;
                        };
                    });
            }
        })

        document.getElementById('prtbtn').addEventListener('click', (e) => {
            if (!$stdate.value) {
                alert("集計開始日が入力されていません");
            } else if (!$eddate.value) {
                alert("集計終了日が入力されていません");
            } else if (table.rows.length < 2) {
                alert("印刷するデータがありません")
            } else {
                window.print();
            }
        })

        $(".datepicker").datepicker({
            dateformat: "yy-mm-dd",
            showButtonPanel: true,
            changeYear: true,
            changeMonth: true,
        });

        $.datepicker._gotoToday = function(id) {
            var target = $(id);
            var inst = this._getInst(target[0]);
            var date = new Date();
            this._setDate(inst, date);
            this._hideDatepicker();
        };
    </script>

</body>

</html>