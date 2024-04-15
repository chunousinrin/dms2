@extends('adminlte::page')

@section('title', '中濃森林組合　-業務日報-')

@section('content_header')
<style>
    .table-wrap {
        overflow-x: auto;
        background-color: white;
        padding: 1em;
        box-shadow: 5px 5px 5px -5px #464646;
    }

    .table-wrap h5 {
        color: #006451;
        position: relative;
    }

    .table-wrap h5 div {
        position: absolute;
        top: 50%;
        right: 0;
        transform: translateY(-50%);
    }

    .table-wrap h5 div a {
        background-color: #8fd19e;
    }

    .table-wrap h5 div a span {
        font-family: "Font Awesome 5 Free";
        font-weight: 900;
        margin-right: 0.5em;
    }

    .table-wrap table {
        width: 100%;
        white-space: nowrap;
    }

    .table-wrap table thead tr td {
        text-align: center;
    }
</style>



<h1 class="drstitle">業務日報
    <div>
        <a href="/drs/history" class="btn btn-secondary rounded-0">履歴</a>
        <a href="/drs/input" class="btn btn-secondary rounded-0">新規入力</a>
    </div>
</h1>
@stop

@section('content')
<form action="" method="get" id="drshistory">
    <caption>履歴検索</caption>
    <ul class="srcwrap" style="display:inherit;margin-bottom:0.5em;">
        <li style="width: 100%;display:flex;margin-bottom:0.5em;">
            <label style="color: white;width:6em">勤務日</label>
            <input type="text" name="worksd" style="width: 6em;background-color:white;" class="iptdt" value="">
            <label for="endDate" style="padding:0 0.5em;width:initial;color:white;">～</label>
            <input type="text" name="worked" style="width: 6em;background-color:white;" class="iptdt" value="">
        </li>
    </ul>
    <input class="btn btn-secondary rounded-0" type="submit" value="検索">
    <input class="btn btn-secondary rounded-0" type="submit" value="印刷" formaction="working_list" formmethod="get" formtarget="_blank">

</form>

<div style="width:100%;text-align:right;">
    <span>表示件数</span>
    <select name="sellimit" onchange="submit()" form="drshistory">
        <option value='50' hidden selected>50</option>
        <option value="25">25</option>
        <option value="50">50</option>
        <option value="100">100</option>
        <option value="200">200</option>
        <option value="">全件</option>
    </select>
</div>

<div class="table-wrap">
    <table style="width: 100%;" class="table table-bordered table-sm">
        <thead>
            <tr class="table-success">
                <td>勤務日</td>
                <td colspan="2">午前</td>
                <td colspan="2">午後</td>
                <td>天気</td>
                <td>備考</td>
            </tr>
        </thead>
        <tbody>
            @foreach($reports as $ev)
            <tr>
                <td>{{$ev->WorkingDay}}</td>
                <td>{{$ev->AmIndustry}}</td>
                <td>{{$ev->AmRemark}}</td>
                <td>{{$ev->PmIndustry}}</td>
                <td>{{$ev->PmRemark}}</td>
                <td>{{$ev->tenki1}}</td>
                <td>{{$ev->Remark}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
<?php

$dbh = 0;

?>


@stop

@section('js')

@stop