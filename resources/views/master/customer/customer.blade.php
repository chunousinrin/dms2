@extends('adminlte::page')

@section('title', '中濃森林組合　-顧客管理-')

@section('content_header')
<link rel="stylesheet" href="/css/dms_table.css">
<script src="https://ajaxzip3.github.io/ajaxzip3.js"></script>

<ul class="content_head">
    <li>

        <?php
        $dbh = new PDO('mysql:host=localhost;dbname=' . env('DB_DATABASE') . ';charset=utf8', env('DB_USERNAME'), env('DB_PASSWORD'));
        $page_flag = 0;

        echo "<h1>";
        if (!empty($_POST['csedit'])) {
            $page_flag = 1;
            echo "顧客情報修正";
        } elseif (!empty($_POST['editsave'])) {
            $page_flag = 2;
            echo "顧客管理";
        } elseif (!empty($_POST['cdel'])) {
            $page_flag = 3;
            echo "顧客管理";
        } elseif (!empty($_POST['csnew'])) {
            $page_flag = 4;
            echo "新規顧客登録";
        } elseif (!empty($_POST['newconf'])) {
            $page_flag = 5;
            echo "登録内容確認";
        } elseif (!empty($_POST['newsave'])) {
            $page_flag = 6;
            echo "新規保存";
        } else {
            $page_flag = 99;
            echo "顧客管理";
        };
        echo "</h1>";
        ?>

    </li>
    <li>
        <form method="post" name="customeredit">
            @csrf
            <button type="submit" class="btn btn-secondary rounded-0 btn-sm px-4">新規登録</button>
            <input type="hidden" name="csnew" id="csnew" value="csnew">
        </form>
    </li>
</ul>

<style>
    .etable {
        width: 60%;
        margin: 0 auto;
    }

    .etable tr {
        border-bottom: 1px solid silver;
    }

    .etable input[type="text"],
    .etable textarea {
        width: 100%;
    }

    .etable tr td:first-child {
        width: 0;
        white-space: nowrap;
    }
</style>

@stop

@section('content')
<!--修正-->
<?php if ($page_flag === 1) : ?>
    @include('master.customer.customer_edit')

    <!--修正確認-->
<?php elseif ($page_flag === 2) : ?>
    @include('master.customer.customer_edit_save')
    @include('master.customer.customer_list')

    <!--削除-->
<?php elseif ($page_flag === 3) :
    $sql = "DELETE FROM customer WHERE CustomerID = " . $_POST['bizNumber'];
    $stmt = $dbh->query($sql);
    $del = $stmt->fetch();
?>
    <div>削除しました</div>
    @include('master.customer.customer_list')

    <!--新規-->
<?php elseif ($page_flag === 4) : ?>
    @include('master.customer.customer_new_reg')

    <!--新規確認-->
<?php elseif ($page_flag === 5) : ?>
    @include('master.customer.customer_new_conf')

    <!--新規保存-->
<?php elseif ($page_flag === 6) : ?>
    @include('master.customer.customer_new_save')
    @include('master.customer.customer_list')

    <!--一覧-->
<?php else : ?>
    @include('master.customer.customer_list')
<?php endif; ?>

@stop

@section('js')

@stop