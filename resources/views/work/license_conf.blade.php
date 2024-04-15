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
<?php

use Ramsey\Uuid\Type\Decimal;

if (!empty($_POST['btn_confirm'])) {
  $types = $_POST['btn_confirm'];
} else {
  $types = '表示';
}
?>
<?php
$dbh = new PDO('mysql:host=localhost;dbname=dms;charset=utf8', 'root', '');

if (!empty($_POST['BranchNumber'])) {
  $BranchNumber = $_POST['BranchNumber'];
} else {
  $BranchNumber = null;
}
if (!empty($_POST['Stock'])) {
  $Stock = $_POST['Stock'];
} else {
  $Stock = 0;
}
if (!empty($_POST['StPermittedAreaock'])) {
  $PermittedArea = $_POST['PermittedArea'];
} else {
  $PermittedArea = 0;
}
if (!empty($_POST['ApplicationDate'])) {
  $ApplicationDate = $_POST['ApplicationDate'];
} else {
  $ApplicationDate = null;
}
if (!empty($_POST['PermitDate'])) {
  $PermitDate = $_POST['PermitDate'];
} else {
  $PermitDate = null;
}
if (!empty($_POST['InstructionNumber'])) {
  $InstructionNumber = $_POST['InstructionNumber'];
} else {
  $InstructionNumber = null;
}
if (!empty($_POST['LicensedStartDate'])) {
  $LicensedStartDate = $_POST['LicensedStartDate'];
} else {
  $LicensedStartDate = null;
}
if (!empty($_POST['LicensedEndDate'])) {
  $LicensedEndDate = $_POST['LicensedEndDate'];
} else {
  $LicensedEndDate = null;
}
if (!empty($_POST['DeforestationDate'])) {
  $DeforestationDate = $_POST['DeforestationDate'];
} else {
  $DeforestationDate = null;
}
if (!empty($_POST['PlantingDate'])) {
  $PlantingDate = $_POST['PlantingDate'];
} else {
  $PlantingDate = null;
}
if (!empty($_POST['SubmissionDate'])) {
  $SubmissionDate = $_POST['SubmissionDate'];
} else {
  $SubmissionDate = null;
}
?>
<h1>許可期限管理</h1>
@stop

@section('content')
<?php
if ($types == '保存') {
  $sql = "INSERT INTO license (
    ReferenceNumber,
    BranchNumber,
    FacilityName,
    ForestReserve,
    Location,
    Stock,
    Applicant,
    Contact,
    PermittedArea,
    ApplicationDate,
    PermitDate,
    InstructionNumber,
    LicensedStartDate,
    LicensedEndDate,
    Completed,
    DeforestationDate,
    PlantingDate,
    SubmissionDate,
    Remark)
    VALUES (
      :ReferenceNumber,
    :BranchNumber,
    :FacilityName,
    :ForestReserve,
    :Location,
    :Stock,
    :Applicant,
    :Contact,
    :PermittedArea,
    :ApplicationDate,
    :PermitDate,
    :InstructionNumber,
    :LicensedStartDate,
    :LicensedEndDate,
    :Completed,
    :DeforestationDate,
    :PlantingDate,
    :SubmissionDate,
    :Remark)";

  $stmt = $dbh->prepare($sql);
  $params = array(
    ':ReferenceNumber' => $_POST['ReferenceNumber'],
    ':BranchNumber' => $BranchNumber,
    ':FacilityName' => $_POST['FacilityName'],
    ':ForestReserve' => $_POST['ForestReserve'],
    ':Location' => $_POST['Location'],
    ':Stock' => $_POST['Stock'],
    ':Applicant' => $_POST['Applicant'],
    ':Contact' => $_POST['Contact'],
    ':PermittedArea' => $_POST['PermittedArea'],
    ':ApplicationDate' => $ApplicationDate,
    ':PermitDate' => $PermitDate,
    ':InstructionNumber' => $InstructionNumber,
    ':LicensedStartDate' => $LicensedStartDate,
    ':LicensedEndDate' => $LicensedEndDate,
    ':Completed' => $_POST['Completed'],
    ':DeforestationDate' => $DeforestationDate,
    ':PlantingDate' => $PlantingDate,
    ':SubmissionDate' => $SubmissionDate,
    ':Remark' => $_POST['Remark']
  );
  $stmt->execute($params);
  print "<p>保存しました</p>
    <a class='btn btn-secondary rounded-0' href='/license'>許可期限管理トップ</a>
    <a class='btn btn-secondary rounded-0' href='/'>Home</a>";
} elseif ($types == '表示') {
  echo "<p>入力内容確認</p>";
?>
  <form action="" method="post" name="lcs">
    @csrf
    <ul class="lst">
      <li></li>
      <li>
        <div class="lbl">
          <label>整理番号</label><span class="hissu">必須</span>
        </div>
        <div class="ipt">
          <input readonly style="outline: none;background:none" type="text" name="ReferenceNumber" value="<?= $_POST['ReferenceNumber'] ?>">
        </div>
      </li>
      <li>
        <div class="lbl">
          <label>枝番</label>
        </div>
        <div class="ipt">
          <input readonly style="outline: none;background:none" type="text" name="BranchNumber" value="<?= $_POST['BranchNumber'] ?>">
        </div>
      </li>
      <li>
        <div class="lbl">
          <label>施設名称</label>
        </div>
        <div class="ipt">
          <input readonly style="outline: none;background:none" type="text" name="FacilityName" value="<?= $_POST['FacilityName'] ?>">
        </div>
      </li>
      <li>
        <div class="lbl">
          <label>保安林種</label>
        </div>
        <div class="ipt">
          <input readonly style="outline: none;background:none" type="text" name="ForestReserve" value="<?= $_POST['ForestReserve'] ?>">
        </div>
      </li>
      <li>
        <div class="lbl">
          <label>森林所在地</label>
        </div>
        <div class="ipt">
          <input readonly style="outline: none;background:none" type="text" name="Location" value="<?= $_POST['Location'] ?>">
        </div>
      </li>
      <li>
        <div class="lbl">
          <label>筆数</label>
        </div>
        <div class="ipt">
          <input readonly style="outline: none;background:none" type="text" name="Stock" value="<?= $Stock ?>">
        </div>
      </li>
      <li>
        <div class="lbl">
          <label>申請者</label>
        </div>
        <div class="ipt">
          <input readonly style="outline: none;background:none" type="text" name="Applicant" value="<?= $_POST['Applicant'] ?>">
        </div>
      </li>
      <li>
        <div class="lbl">
          <label>連絡先</label>
        </div>
        <div class="ipt">
          <input readonly style="outline: none;background:none" type="text" name="Contact" value="<?= $_POST['Contact'] ?>">
        </div>
      </li>
      <li>
        <div class="lbl">
          <label>許可面積</label>
        </div>
        <div class="ipt">
          <input readonly style="outline: none;background:none" type="text" name="PermittedArea" value="<?= $PermittedArea ?>">
        </div>
      </li>
      <li>
        <div class=" lbl">
          <label>申請年月日</label><span class="hissu">必須</span>
        </div>
        <div class="ipt">
          <input readonly style="outline: none;background:none" type="text" name="ApplicationDate" value="<?= $_POST['ApplicationDate'] ?>">
        </div>
      </li>
      <li>
        <div class="lbl">
          <label>許可年月日</label><span class="hissu">必須</span>
        </div>
        <div class="ipt">
          <input readonly style="outline: none;background:none" type="text" name="PermitDate" value="<?= $_POST['PermitDate'] ?>">
        </div>
      </li>
      <li>
        <div class="lbl">
          <label>指令番号</label>
        </div>
        <div class="ipt">
          <input readonly style="outline: none;background:none" type="text" name="InstructionNumber" value="<?= $_POST['InstructionNumber'] ?>">
        </div>
      </li>
      <li>
        <div class="lbl">
          <label>許可始期</label><span class="hissu">必須</span>
        </div>
        <div class="ipt">
          <input readonly style="outline: none;background:none" type="text" name="LicensedStartDate" value="<?= $_POST['LicensedStartDate'] ?>">
        </div>
      </li>
      <li>
        <div class="lbl">
          <label>許可終期</label><span class="hissu">必須</span>
        </div>
        <div class="ipt">
          <input readonly style="outline: none;background:none" type="text" name="LicensedEndDate" value="<?= $_POST['LicensedEndDate'] ?>">
        </div>
      </li>
      <li>
        <div class="lbl">
          <label>完了</label>
        </div>
        <div class="ipt">
          <input readonly style="outline: none;background:none" type="text" name="Completed" value="<?= $_POST['Completed'] ?>">
        </div>
      </li>
      <li>
        <div class="lbl">
          <label>皆伐完了日</label>
        </div>
        <div class="ipt">
          <input readonly style="outline: none;background:none" type="text" name="DeforestationDate" value="<?= $_POST['DeforestationDate'] ?>">
        </div>
      </li>
      <li>
        <div class="lbl">
          <label>植栽完了日</label>
        </div>
        <div class="ipt">
          <input readonly style="outline: none;background:none" type="text" name="PlantingDate" value="<?= $_POST['PlantingDate'] ?>">
        </div>
      </li>
      <li>
        <div class="lbl">
          <label>提出日</label>
        </div>
        <div class="ipt">
          <input readonly style="outline: none;background:none" type="text" name="SubmissionDate" value="<?= $_POST['SubmissionDate'] ?>">
        </div>
      </li>
      <li>
        <div class="lbl">
          <label>備考</label>
        </div>
        <div class="ipt">
          <textarea readonly style="outline: none;background:none;height:100px;" name="Remark"><?= $_POST['Remark'] ?></textarea>
        </div>
      </li>

    </ul>

    <input type="hidden" id="btn_confirm" name="btn_confirm">

    <div style="margin:0 auro;padding:10px 0;text-align:center;">
      <a class="btn btn-secondary rounded-0 send_input" onclick="history.back()">戻る</a>
      <button class="btn btn-secondary rounded-0" onclick="lcssv();">保存</button>
    </div>
  </form>

<?php
}
?>
@csrf
@stop

@section('content')
@stop

@section('js')
<script>
  function lcssv() {
    document.getElementById('btn_confirm').value = "保存";
  }
</script>
@stop