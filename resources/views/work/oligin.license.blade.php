@extends('adminlte::page')

@section('title', '中濃森林組合　-許可期限管理-')

@section('content_header')
<?php
if (!empty($_GET['st'])) {
  $st = $_GET['st'];
} else {
  $st = 'LicenseID';
}

if (!empty($_GET['od'])) {
  $od = $_GET['od'];
} else {
  $od = 'DESC';
}
?>
<script>
  window.onload = function() {
    document.getElementById("l3").checked = true;
    document.getElementById("l3-2").checked = true;
  }
</script>
<link rel="stylesheet" href="/css/cnu_table.css">
<style>
  .lists tbody tr td {
    cursor: pointer;
    cursor: hand;
  }
</style>
<h1 style="width: 100%;position:relative;">許可期限管理
  <a style="top:0;right:0;position:absolute;" class="btn btn-secondary rounded-0" href="/license/input">新規作成</a>
</h1>

@stop

@section('content')
<form action="" method="get">
  <caption>履歴検索</caption>

  <ul class="srcwrap">
    <li style="width: 100%;">
      <input style="padding:0 0.5em;width:100%;background-color:rgba(255, 255, 255, 1);" name="keyword" type="text" class="kensaku" placeholder="キーワード">
    </li>
    <li>
      <input type="reset" value="" style="vertical-align:middle;width: 2em;height:2em;background-color:rgba(255, 255, 255, 1);background-image:url(https://icongr.am/entypo/cross.svg?size=15&color=858585)">
    </li>
    <li>
      <input type="submit" value="" style="vertical-align:middle; width: 2em;height:2em;background-color:silver;background-image:url(https://icongr.am/feather/search.svg?size=10&color=ffffff)">
    </li>
    <li>
      <label for="fltr" class="fltrlb" style="width: 6em;color:rgba(255, 255, 255, 1);text-align:center;line-height:2em;font-weight:normal;margin:0;">詳細検索</label>
    </li>
  </ul>
  <input type="checkbox" name="fltr" id="fltr" style="display: none;">
  <ul class="advsrc">
    <li style="margin-top: 0.5em;">
      <label>申請期間</label>
      <input type="text" name="startDate" id="startDate" style="width: 6em;" class="iptdt">
      <label for="endDate" style="padding:0 0.5em;width:initial;">～</label>
      <input type="text" name="endDate" id="endDate" style="width: 6em;" onchange="submit()" class="iptdt">
    </li>
    <li>
      <label for="hoanrin">保安林種</label>
      <select name="hoanrin" id="hoanrin" onchange="submit()">
        <option value="" disabled selected>-- 選択してください --</option>
        <option value="土流">土流</option>
        <option value="水かん">水かん</option>
      </select>
    </li>
  </ul>
</form>
<?php
if (!empty($_GET['keyword'])) {
  $srch = "where keyword Like '%" . $_GET['keyword'] . "%'";
} elseif (!empty($_GET['startDate']) && !empty($_GET['endDate'])) {
  $srch = "where 	ApplicationDate Between '" . $_GET['startDate'] . "' and '" . $_GET['endDate'] . "'";
} elseif (!empty($_GET['hoanrin'])) {
  $srch = "where ForestReserve = '" . $_GET['hoanrin'] . "'";
} else {
  $srch = "";
};
?>
<hr>

<div class="hstwrap">
  <table class="lists">
    <thead>
      <tr>
        <th></th>
        <th>ID<a href="license?st=LicenseID&od=ASC" class="asc"></a><br><a href="license?st=LicenseID&od=DESC" class="desc"></a></th>
        <th>残日数<a href="license?st=lmt&od=ASC" class="asc"></a><br><a href="license?st=lmt&od=DESC" class="desc"></a></th>
        <th>整理番号<a href="license?st=ReferenceNumber&od=ASC" class="asc"></a><br><a href="license?st=ReferenceNumber&od=DESC" class="desc"></a></th>
        <th>枝番</th>
        <th>施設名称</th>
        <th>保安林種</th>
        <th>森林所在地</th>
        <th>筆数</th>
        <th>申請者</th>
        <th>連絡先</th>
        <th>許可面積</th>
        <th>申請年月日<a href="license?st=ApplicationDate&od=ASC" class="asc"></a><br><a href="license?st=ApplicationDate&od=DESC" class="desc"></a></th>
        <th>許可年月日<a href="license?st=PermitDate&od=ASC" class="asc"></a><br><a href="license?st=PermitDate&od=DESC" class="desc"></a></th>
        <th>指令番号</th>
        <th>許可始期<a href="license?st=LicensedStartDate&od=ASC" class="asc"></a><br><a href="license?st=LicensedStartDate&od=DESC" class="desc"></a></th>
        <th>許可終期<a href="license?st=LicensedEndDate&od=ASC" class="asc"></a><br><a href="license?st=LicensedEndDate&od=DESC" class="desc"></a></th>
        <th>完了</th>
        <th>皆伐完了日<a href="license?st=DeforestationDate&od=ASC" class="asc"></a><br><a href="license?st=DeforestationDate&od=DESC" class="desc"></a></th>
        <th>植栽完了日<a href="license?st=PlantingDate&od=ASC" class="asc"></a><br><a href="license?st=PlantingDate&od=DESC" class="desc"></a></th>
        <th>提出日<a href="license?st=SubmissionDate&od=ASC" class="asc"></a><br><a href="license?st=SubmissionDate&od=DESC" class="desc"></a></th>
        <th>備考</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $today = date('Y-m-d');
      $dbh = new PDO('mysql:host=localhost;dbname=dms;charset=utf8', 'root', '');
      $sql = "SELECT * FROM license_history {$srch} ORDER BY {$st} {$od};";
      $stmt = $dbh->query($sql);
      while ($result = $stmt->fetch(PDO::FETCH_BOTH)) {
        echo "<tr id='selid'>" .
          "<td name='validity' id='validity' style='text-align:center;'>" . $result['validity'] . "</td>" .
          "<td style='text-align:center;' id='licenseid'>" . $result['LicenseID'] . "</td>" .
          "<td style='text-align:center;'>" . $result['lmt'] . "</td>" .
          "<td style='text-align:center;'>" . $result['ReferenceNumber'] . "</td>" .
          "<td style='text-align:center;'>" . $result['BranchNumber'] . "</td>" .
          "<td>" . $result['FacilityName'] . "</td>" .
          "<td>" . $result['ForestReserve'] . "</td>" .
          "<td>" . $result['Location'] . "</td>" .
          "<td style='text-align:right;'>" . $result['Stock'] . "</td>" .
          "<td>" . $result['Applicant'] . "</td>" .
          "<td>" . $result['Contact'] . "</td>" .
          "<td style='text-align:right;'>" . $result['PermittedArea'] . "</td>" .
          "<td style='text-align:center;'>" . $result['ApplicationDate'] . "</td>" .
          "<td style='text-align:center;'>" . $result['PermitDate'] . "</td>" .
          "<td style='text-align:center;'>" . $result['InstructionNumber'] . "</td>" .
          "<td style='text-align:center;'>" . $result['LicensedStartDate'] . "</td>" .
          "<td style='text-align:center;'>" . $result['LicensedEndDate'] . "</td>" .
          "<td style='text-align:center;'>" . $result['Completed'] . "</td>" .
          "<td>" . $result['DeforestationDate'] . "</td>" .
          "<td>" . $result['PlantingDate'] . "</td>" .
          "<td>" . $result['SubmissionDate'] . "</td>" .
          "<td style='max-height:100px'>" . $result['Remark'] . "</td>" .
          "</tr>";
      };
      $dbh = 0;
      ?>
    </tbody>
  </table>
</div>
<form action="/license/update" method="get" id="nxt">
  <input type="hidden" name="lid" id="lid">
</form>
@stop

@section('js')
<script type="text/javascript">
  $('td:contains("期限切")').css({
    'background-color': 'rgba(255,0,0,0.7)',
    'color': 'white'
  });
  const setid = document.getElementById('lid');

  $('td').click(function(event) {
    const lid = $(this).parent().find('#licenseid').text()
    setid.value = lid
    document.getElementById('nxt').submit()
  });
</script>
@stop