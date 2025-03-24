<!doctype html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="css/dms_table.css">
    <link rel="stylesheet" href="css/document_manage.css">

    <style>
    </style>
</head>

<body>
    <h2>一般作業指示書</h2>
    <section class="shijisho">
        <form action="" method="post">
            <table class="table ctable">
                <tbody>
                    <tr>
                        <td class="col-sm-2 table-success">
                            指示書番号
                            <span class="required_item">必須</span>
                        </td>
                        <td class="col-sm-10">
                            <input type="text" name="shijishoNo" id="shijishoNo" class="form-control rounded-0">
                        </td>
                    </tr>

                    <tr>
                        <td class="col-sm-2 table-success">
                            現場作業責任者
                            <span class="required_item">必須</span>
                        </td>
                        <td class="col-sm-10">
                            <input type="text" name="sekininsha" id="sekininsha" class="form-control rounded-0">
                        </td>
                    </tr>

                    <tr>
                        <td class="col-sm-2 table-success">
                            指示日
                            <span class="required_item">必須</span>
                        </td>
                        <td class="col-sm-10">
                            <input type="text" name="shijibi" id="shijibi" class="form-control rounded-0 datepicker">
                        </td>
                    </tr>

                    <tr>
                        <td class="col-sm-2 table-success">
                            担当者
                            <span class="required_item">必須</span>
                        </td>
                        <td class="col-sm-10">
                            <input type="text" name="tantosha" id="tantosha" class="form-control rounded-0">
                        </td>
                    </tr>

                    <tr>
                        <td class="col-sm-2 table-success">
                            現場通称
                            <span class="required_item">必須</span>
                        </td>
                        <td class="col-sm-10">
                            <input type="text" name="genbamei" id="genbamei" class="form-control rounded-0">
                        </td>
                    </tr>

                    <tr>
                        <td class="col-sm-2 table-success">
                            発注者
                            <span class="required_item">必須</span>
                        </td>
                        <td class="col-sm-10">
                            <input type="text" name="hacchu_shoyusha" id="hacchu_shoyusha" class="form-control rounded-0 mb-2" placeholder="所有者">
                            <input type="text" name="hacchu_renrakusaki" id="hacchu_renrakusaki" class="form-control rounded-0" placeholder="連絡先">
                        </td>
                    </tr>


                    <tr>
                        <td class="col-sm-2 table-success">
                            作業場所
                            <span class="required_item">必須</span>
                        </td>
                        <td class="col-sm-10">
                            <input type="text" name="sagyo_jusho" id="sagyo_jusho" class="form-control rounded-0 mb-2" placeholder="住所">
                            <input type=" text" name="sagyo_rinshohan" id="sagyo_rinshohan" class="form-control rounded-0" placeholder="林小班">
                        </td>
                    </tr>

                    <tr>
                        <td class="col-sm-2 table-success">
                            契約 / 事業名称
                            <span class="required_item">必須</span>
                        </td>
                        <td class="col-sm-10">
                            <input type="text" name="keiyakumei" id="keiyakumei" class="form-control rounded-0">
                        </td>
                    </tr>

                    <tr>
                        <td class="col-sm-2 table-success">
                            作業内容
                            <span class="required_item">必須</span>
                        </td>
                        <td class="col-sm-10">
                            <textarea name="sagyonaiyo" id="sagyonaiyo" class="form-control rounded-0"></textarea>
                        </td>
                    </tr>

                    <tr>
                        <td class="col-sm-2 table-success">
                            作業量
                            <span class="required_item">必須</span>
                        </td>
                        <td class="col-sm-10">
                            <input type="text" name="sagyoryo" id="sagyoryo" class="form-control rounded-0">
                        </td>
                    </tr>

                    <tr>
                        <td class="col-sm-2 table-success">
                            工期
                        </td>
                        <td class="col-sm-10">
                            <div class="form-row">
                                <div class="form-group col-sm-5">
                                    <input type="text" name="koki1" id="koki1" class="form-control rounded-0 datepicker" placeholder="工期1">
                                </div>
                                <div class="form-group col-sm-2">
                                    <span class="form-control rounded-0 border-0 text-center">～</span>
                                </div>
                                <div class="form-group col-sm-5">
                                    <input type="text" name="koki2" id="koki2" class="form-control rounded-0 datepicker" placeholder="工期2">
                                </div>
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td class="col-sm-2 table-success">
                            使用機械
                        </td>
                        <td class="col-sm-10">
                            <input type="text" name="kikai" id="kikai" class="form-control rounded-0">
                        </td>
                    </tr>

                    <tr>
                        <td class="col-sm-2 table-success">
                            作業費
                        </td>
                        <td class="col-sm-10">
                            <input type="text" name="sagyohi" id="sagyohi" class="form-control rounded-0">
                        </td>
                    </tr>

                    <tr>
                        <td class="col-sm-2 table-success">
                            作業留意点
                        </td>
                        <td class="col-sm-10">
                            <textarea name="ryuiten" id="ryuiten" class="form-control rounded-0"></textarea>
                        </td>
                    </tr>

                    <tr>
                        <td class="col-sm-2 table-success">
                            添付書類
                        </td>
                        <td class="col-sm-10">
                            <input type="text" name="tenpu" id="tenpu" class="form-control rounded-0">
                        </td>
                    </tr>

                </tbody>
            </table>
            <div class="btn btn-sm px-4" style="background-color:#8fd19e" id="eqlist">一覧</div>
            <div class="btn btn-sm px-4 mx-2" style="background-color:#8fd19e" id="equpdate">更新</div>
            <div class="btn btn-sm px-4" style="background-color:#8fd19e" id="eqdelete">削除</div>
        </form>
    </section>
</body>

</html>