<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html lang="ja">

<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>test</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <style>
        body {
            padding: 2em;
        }
    </style>
</head>

<body>

    <div class="form-row border border-success rounded-0 m-0 mb-2">
        <div class="form-group col-sm-5 mb-0 p-0">
            <input type="date" name="stdate" id="stdate" class="form-control border-0 rounded-0 text-center" value="">
        </div>
        <div class="form-group col-sm-1 mb-0 p-0">
            <label for="" class="form-control rounded-0 border-0 mb-0 text-center">～</label>
        </div>
        <div class="form-group col-sm-5 mb-0 p-0">
            <input type="date" name="eddate" id="eddate" class="form-control border-0 rounded-0 text-center" value="">
        </div>
        <div class="form-group col-sm-1 mb-0 p-0">
            <button type="button" class="form-control rounded-0 btn btn-success border-0" id="" onclick="checkID();">Show</button>
        </div>
    </div>

    <table class="table table-sm table-bordered table-striped table-hover">
        <thead class="table-success">
            <tr>
                <td class="text-center">ID</td>
                <td class="text-center">Name</td>
                <td class="text-center">出勤</td>
                <td class="text-center">一日欠勤</td>
                <td class="text-center">一日有給</td>
                <td class="text-center">半日欠勤</td>
                <td class="text-center">半日有給</td>
                <td class="text-center">特別休暇</td>
                <td class="text-center">労災</td>
            </tr>
        </thead>
        <tbody id="atTr">
        </tbody>
    </table>

    <script>
        function checkID() {
            $.getJSON(
                "/test2.php", {
                    StartVal: $("#stdate").val(),
                    EndVal: $("#eddate").val(),
                },
                function(data, status) {
                    $("#atTr").children().remove(); //子要素は毎回全て削除します(初期化)
                    for (i in data) {
                        var row = data[i];
                        //取得したデータをAppendで1行ずつ追加
                        $("#atTr").append('<tr><td class="col-sm-1">' + row['ID'] + '</td>' +
                            '<td class="col-sm-4">' + row['Name'] + '</td>' +
                            '<td class="col-sm-1 text-right">' + row['出勤'] + '</td>' +
                            '<td class="col-sm-1 text-right">' + row['一日欠勤'] + '</td>' +
                            '<td class="col-sm-1 text-right">' + row['一日有給'] + '</td>' +
                            '<td class="col-sm-1 text-right">' + row['半日欠勤'] + '</td>' +
                            '<td class="col-sm-1 text-right">' + row['半日有給'] + '</td>' +
                            '<td class="col-sm-1 text-right">' + row['特別休暇'] + '</td>' +
                            '<td class="col-sm-1 text-right">' + row['労災'] + '</td></tr>');
                    };
                });
        };
    </script>

</body>

</html>