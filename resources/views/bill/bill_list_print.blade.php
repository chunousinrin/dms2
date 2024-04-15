<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <style>
        * {
            font-size: 10pt;
        }

        @page {
            size: A4 landscape;
            margin-top: 15mm;
            margin-left: 15mm;
            margin-right: 10mm;
            margin-bottom: 10mm;
        }

        body {
            background-color: lightgray;
            margin: 0;
        }

        .prwrap {
            background-color: white;
            width: 297mm;
            margin: 2em auto;
            padding-top: 15mm;
            padding-right: 10mm;
            padding-bottom: 10mm;
            padding-left: 15mm;
            box-sizing: border-box;
            box-shadow: 1px 1px 5px 1px rgba(85, 85, 85, 0.7);
        }

        .noprint {
            width: 100%;
            height: 4em;
            line-height: 4em;
            position: sticky;
            top: 0;
            left: 0;
            text-align: center;
            background-color: white;
            border-bottom: 3px solid lightseagreen;
            backdrop-filter: blur(1px);
        }


        @media print {
            body {
                width: 272mm;
                height: 185mm;
                background: none;
            }

            .prwrap {
                padding: 0;
                margin: 0;
                box-shadow: none;
            }

            .noprint {
                display: none;
            }

        }
    </style>
    <title>Document</title>
</head>

<body style="position: relative;">
    <div class="noprint">
        <input class="btn btn-secondary rounded-0 px-5" type="button" name="btn_back" value="戻る" onclick="window.close()">
        <input class="btn btn-secondary rounded-0 px-5" type="button" value="印刷" onclick="window.print()">
    </div>
    <div class="prwrap">
        <table class="table table-sm table-striped">
            <thead>
                <tr>
                    <td colspan="7">
                        <h2>請求書発行履歴一覧</h2>
                    </td>
                </tr>
                <tr class="table-success">
                    <th>作成日</th>
                    <th>請求番号</th>
                    <th>作成者</th>
                    <th>顧客名</th>
                    <th>事業名/場所</th>
                    <th>請求金額</th>
                    <th>入金日</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $dbh = new PDO('mysql:host=localhost;dbname=dms;charset=utf8', 'root', '');
                $sql = $_POST['billlist'];
                $stmt = $dbh->query($sql);
                $sum_price = 0;
                while ($result = $stmt->fetch(PDO::FETCH_BOTH)) { ?>
                    <tr>
                        <td style="white-space:nowrap"><?= $result['CreatedDate'] ?></td>
                        <td style="white-space:nowrap"><?= $result['BillNumber'] ?></td>
                        <td style="white-space:nowrap"><?= $result['UserName'] ?></td>
                        <td><?= $result['Customer'] ?></td>
                        <td><?= $result['BizName'] ?><br><?= str_replace('　', '', $result['Location']) ?></td>
                        <td style="text-align:right;white-space:nowrap"><?= number_format($result['price']) ?></td>
                        <?php $sum_price = $sum_price + $result['price']; ?>
                        <td style="white-space:nowrap"><?= $result['PaymentDate'] ?></td>
                    </tr>
                <?php } ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan='5'></td>
                    <td style='text-align:right;'><?= number_format($sum_price) ?></td>
                    <td></td>
                </tr>
            </tfoot>
        </table>
    </div>
</body>

</html>