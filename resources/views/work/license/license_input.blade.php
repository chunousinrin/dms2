@extends('adminlte::page')

@section('title', '中濃森林組合　-許可期限管理-')

@section('content_header')
<script>
  window.onload = function() {
    document.getElementById("l3").checked = true;
    document.getElementById("l3-2").checked = true;
  }
</script>
<link rel="stylesheet" href="/css/cnu_table.css">
<h1>許可期限管理</h1>

@stop

@section('content')
<p>新規入力</p>
<form action="/license/conf" method="post" name="lcs">
  @csrf
  <ul class="lst">
    <li></li>
    <li style="display: none;">
      <div class="lbl">
        <label>ID</label>
      </div>
      <div class="ipt">
        <input type="text" name="LicenseID">
      </div>
    </li>
    <li>
      <div class="lbl">
        <label>整理番号</label><span class="hissu">必須</span>
      </div>
      <div class="ipt">
        <input type="text" name="ReferenceNumber" required>
      </div>
    </li>
    <li>
      <div class="lbl">
        <label>枝番</label>
      </div>
      <div class="ipt">
        <input type="text" name="BranchNumber">
      </div>
    </li>
    <li>
      <div class="lbl">
        <label>施設名称</label>
      </div>
      <div class="ipt">
        <input type="text" name="FacilityName">
      </div>
    </li>
    <li>
      <div class="lbl">
        <label>保安林種</label>
      </div>
      <div class="ipt">
        <input type="text" name="ForestReserve">
      </div>
    </li>
    <li>
      <div class="lbl">
        <label>森林所在地</label>
      </div>
      <div class="ipt">
        <input type="text" name="Location">
      </div>
    </li>
    <li>
      <div class="lbl">
        <label>筆数</label>
      </div>
      <div class="ipt">
        <input type="text" name="Stock">
      </div>
    </li>
    <li>
      <div class="lbl">
        <label>申請者</label>
      </div>
      <div class="ipt">
        <input type="text" name="Applicant">
      </div>
    </li>
    <li>
      <div class="lbl">
        <label>連絡先</label>
      </div>
      <div class="ipt">
        <input type="text" name="Contact">
      </div>
    </li>
    <li>
      <div class="lbl">
        <label>許可面積</label>
      </div>
      <div class="ipt">
        <input type="text" name="PermittedArea">
      </div>
    </li>
    <li>
      <div class="lbl">
        <label>申請年月日</label><span class="hissu">必須</span>
      </div>
      <div class="ipt">
        <input type="text" name="ApplicationDate" class="iptdt" required>
      </div>
    </li>
    <li>
      <div class="lbl">
        <label>許可年月日</label><span class="hissu">必須</span>
      </div>
      <div class="ipt">
        <input type="text" name="PermitDate" class="iptdt" required>
      </div>
    </li>
    <li>
      <div class="lbl">
        <label>指令番号</label>
      </div>
      <div class="ipt">
        <input type="text" name="InstructionNumber">
      </div>
    </li>
    <li>
      <div class="lbl">
        <label>許可始期</label><span class="hissu">必須</span>
      </div>
      <div class="ipt">
        <input type="text" name="LicensedStartDate" class="iptdt" required>
      </div>
    </li>
    <li>
      <div class="lbl">
        <label>許可終期</label><span class="hissu">必須</span>
      </div>
      <div class="ipt">
        <input type="text" name="LicensedEndDate" class="iptdt" required>
      </div>
    </li>
    <li>
      <div class="lbl">
        <label>完了</label>
      </div>
      <div class="ipt">
        <input type="text" name="Completed">
      </div>
    </li>
    <li>
      <div class="lbl">
        <label>皆伐完了日</label>
      </div>
      <div class="ipt">
        <input type="text" name="DeforestationDate" class="iptdt">
      </div>
    </li>
    <li>
      <div class="lbl">
        <label>植栽完了日</label>
      </div>
      <div class="ipt">
        <input type="text" name="PlantingDate" class="iptdt">
      </div>
    </li>
    <li>
      <div class="lbl">
        <label>提出日</label>
      </div>
      <div class="ipt">
        <input type="text" name="SubmissionDate" class="iptdt">
      </div>
    </li>
    <li>
      <div class="lbl">
        <label>備考</label>
      </div>
      <div class="ipt">
        <textarea rows="5" style="height:100px;" name="Remark"></textarea>
      </div>
    </li>

  </ul>
  <div style="margin:0 auro;padding:10px 0;text-align:center;">
    <a class="btn btn-secondary rounded-0 send_input" onclick="history.back()">戻る</a>
    <button class="btn btn-secondary rounded-0">入力内容の確認</button>
  </div>
</form>

@stop

@section('js')

@stop