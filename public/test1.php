<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html lang="ja">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>test</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="./main.js"></script>
    <?php
    //DB接続
    $dbh = new PDO('mysql:host=localhost;dbname=cf756484_dms;charset=utf8', 'cf444722_root', 'U7jC6Xaq');
    $category_sql = "SELECT * FROM equipment_category";
    $category_stmt = $dbh->query($category_sql);
    ?>
</head>

<body>
    <select id="category_id" name="category_id" onchange="getMachine();">
        <option value="">--選択してください--</option>
        <?php
        while ($category = $category_stmt->fetch(PDO::FETCH_BOTH)) {
            echo "<option value='" . $category['ID'] . "'>" . $category['CategoryName'] . "</option>";
        };
        ?>
    </select>
    <select id="machine_id" name="machine_id" onchange="getReserve();">
        <option value="">--選択してください--</option>
    </select>
    <table class="table table-bordered table-sm table-hover" id="table">
        <thead>
            <tr class="table-success">
                <td>重機名称</td>
                <td>利用期間</td>
                <td>使用者</td>
                <td>指示書番号</td>
                <td>現場</td>
            </tr>
        </thead>
        <tbody id="usage">
        </tbody>
    </table>
</body>

</html>