@extends('adminlte::page')

@section('title', '中濃森林組合　-許可期限管理-')

@section('content_header')
<link rel="stylesheet" href="/css/dms_table.css">
<?php
$dbh = new PDO('mysql:host=localhost;dbname=dms;charset=utf8', 'root', '');

$sqlcnt = "SELECT COUNT(*)as cnt FROM license_history";
$stsqlcnt = $dbh->query($sqlcnt);
$lcscnt = $stsqlcnt->fetch();


if (!empty($_GET['limit'])) {
  $limit = $_GET['limit'];
} else {
  $limit = 25;
}

if (!empty($_GET['dateoder'])) {
  $od = $_GET['dateoder'];
} else {
  $od = " ORDER BY lmt DESC";
}

if (!empty($_GET['keyword'])) {
  $srch0 = "keyword LIKE '%" . $_GET['keyword'] . "%'";
} else {
  $srch0 = null;
}

if (!empty($_GET['startDate']) && !empty($_GET['endDate'])) {
  $srch1 = "ApplicationDate Between '" . $_GET['startDate'] . "' AND '" . $_GET['endDate'] . "'";
} elseif (!empty($_GET['startDate']) && empty($_GET['endDate'])) {
  $srch1 = "ApplicationDate >= '" . $_GET['startDate'] . "'";
} elseif (empty($_GET['startDate']) && !empty($_GET['endDate'])) {
  $srch1 = "ApplicationDate <= '" . $_GET['endDate'] . "'";
} else {
  $srch1 = null;
}

if (!empty($_GET['dclass'])) {
  $srch2 = "ForestReserve = '" . $_GET['dclass'] . "'";
} else {
  $srch2 = null;
}

if (!empty($_GET['creater'])) {
  $srch3 = "userID = '" . $_GET['creater'] . "'";
} else {
  $srch3 = null;
}

if (!empty($srch0) && !empty($srch1) && !empty($srch2) && !empty($srch3)) { //0+1+2+3
  $srch = $srch0 . " and " . $srch1 . " and " . $srch2 . " and " . $srch3 . $od . " LIMIT " . $limit;
} elseif (!empty($srch0) && empty($srch1) && !empty($srch2) && !empty($srch3)) { //0+2+3
  $srch = $srch0 . " and " . $srch2 . " and " . $srch3 . $od . " LIMIT " . $limit;
} elseif (!empty($srch0) && !empty($srch1) && empty($srch2) && !empty($srch3)) { //0+1+3
  $srch = $srch0 . " and " . $srch1 . " and " . $srch3 . $od . " LIMIT " . $limit;
} elseif (!empty($srch0) && !empty($srch1) && !empty($srch2) && empty($srch3)) { //0+1+2
  $srch = $srch0 . " and " . $srch1 . " and " . $srch2 . $od . " LIMIT " . $limit;
} elseif (empty($srch0) && !empty($srch1) && !empty($srch2) && !empty($srch3)) { //1+2+3
  $srch = $srch1 . " and " . $srch2 . " and " . $srch3 . $od . " LIMIT " . $limit;
} elseif (!empty($srch0) && !empty($srch1) && empty($srch2) && empty($srch3)) { //0+1
  $srch = $srch0 . " and " . $srch1 . $od . " LIMIT " . $limit;
} elseif (!empty($srch0) && empty($srch1) && !empty($srch2) && empty($srch3)) { //0+2
  $srch = $srch0 . " and " . $srch2 . $od . " LIMIT " . $limit;
} elseif (!empty($srch0) && empty($srch1) && empty($srch2) && !empty($srch3)) { //0+3
  $srch = $srch0 . " and " . $srch3 . $od . " LIMIT " . $limit;
} elseif (empty($srch0) && !empty($srch1) && !empty($srch2) && empty($srch3)) { //1+2
  $srch = $srch1 . " and " . $srch2 . $od . " LIMIT " . $limit;
} elseif (empty($srch0) && !empty($srch1) && empty($srch2) && !empty($srch3)) { //1+3
  $srch = $srch1 . " and " . $srch3 . $od . " LIMIT " . $limit;
} elseif (empty($srch0) && empty($srch1) && !empty($srch2) && !empty($srch3)) { //2+3
  $srch = $srch2 . " and " . $srch3 . $od . " LIMIT " . $limit;
} elseif (!empty($srch0) && empty($srch1) && empty($srch2) && empty($srch3)) { //0
  $srch = $srch0 . $od . " LIMIT " . $limit;
} elseif (empty($srch0) && !empty($srch1) && empty($srch2) && empty($srch3)) { //1
  $srch = $srch1 . $od . " LIMIT " . $limit;
} elseif (empty($srch0) && empty($srch1) && !empty($srch2) && empty($srch3)) { //2
  $srch = $srch2 . $od . " LIMIT " . $limit;
} elseif (empty($srch0) && empty($srch1) && empty($srch2) && !empty($srch3)) { //3
  $srch = $srch3 . $od . " LIMIT " . $limit;
} else {
  $srch = "1" . $od . " LIMIT " . $limit;
}
?>

<ul class="content_head">
  <li>
    <h1>許可期限管理</h1>
  </li>
  <li>
    <a class="btn btn-sm btn-secondary rounded-0 px-4" href="/license/input">新規作成</a>
  </li>
</ul>

@stop

@section('content')
<form action="" method="get" name="history">
  <div class="search_box">
    <div class="input-group">
      <input class="form-control rounded-0" type="text" name="keyword" value="<?= $_GET['keyword'] ?? null ?>" placeholder="キーワード">
      <input class="btn btn-sm btn-secondary rounded-0 col-1" type="submit" value="検索">
    </div>
  </div>
  <details class="accordion">
    <summary>詳細検索</summary>
    <div>
      <table class="table table-sm table-hover table-borderless" style="width: 70%;margin:0!important;">
        <tr>
          <td>申請期間</td>
          <td style="display: flex;align-items:center">
            <input type="text" name="startDate" class="form-control rounded-0 iptdt" value="<?= $_GET['startDate'] ?? null ?>">
            <span style="padding:0 1em;">～</span>
            <input type="text" name="endDate" class="form-control rounded-0 iptdt" value="<?= $_GET['endDate'] ?? null ?>">
          </td>
        </tr>
        <tr>
          <td>保安林種</td>
          <td>
            <select class="form-control rounded-0 iptbx" name="dclass">
              <?php
              if (!empty($_GET['dclass'])) {
                echo "<option value='" . $_GET['dclass'] . "' hidden selected>" . $_GET['dclass'] . "</option>";
              } else {
                echo "<option value='' disabled selected>-- 選択してください --</option>";
              }
              ?>
              <option value="土流">土流</option>
              <option value="水かん">水かん</option>
            </select>
          </td>
        </tr>
      </table>
    </div>
  </details>

  <hr>

  <div style="width:100%;display:flex;">
    <div style="width: 100%;">履歴一覧</div>
    <div style="width: 100%;text-align:right;">
      <span>表示件数</span>
      <select name="limit" onchange="submit()">
        <option value="<?= $limit ?>" selected hidden><?= $limit ?></option>
        <option value="25">25</option>
        <option value="50">50</option>
        <option value="100">100</option>
        <option value="200">200</option>
        <option value="<?= $lcscnt['cnt'] ?>">全件</option>
      </select>
    </div>
  </div>

  <div class="table-wrap">
    <table class="table table-bordered table-sm table-hover">
      <thead style="position: sticky;top:calc(-1em - 1px);">
        <tr class="table-success">
          <td></td>
          <td>
            <div class="table-th">
              ID
              <div>
                <a class="asc" onclick="lcidasc()"></a>
                <a class="desc" onclick="lciddesc()"></a>
              </div>
            </div>
          </td>
          <td>
            <div class="table-th">
              残日数
              <div>
                <a class="asc" onclick="lmtasc()"></a>
                <a class="desc" onclick="lmtdesc()"></a>
              </div>
            </div>
          </td>
          <td>
            <div class="table-th">
              整理番号
              <div>
                <a class="asc" onclick="rfnumasc()"></a>
                <a class="desc" onclick="rfnumdesc()"></a>
              </div>
            </div>
          </td>
          <td>枝番</td>
          <td>施設名称</td>
          <td>保安林種</td>
          <td>森林所在地</td>
          <td>筆数</td>
          <td>申請者</td>
          <td>連絡先</td>
          <td>許可面積</td>
          <td>
            <div class="table-th">
              申請年月日
              <div>
                <a class="asc" onclick="apdateasc()"></a>
                <a class="desc" onclick="apdatedesc()"></a>
              </div>
            </div>
          </td>
          <td>
            <div class="table-th">
              許可年月日
              <div>
                <a class="asc" onclick="pmdateasc()"></a>
                <a class="desc" onclick="pmdatedesc()"></a>
              </div>
            </div>
          </td>
          <td>指令番号</td>
          <td>
            <div class="table-th">
              許可始期
              <div>
                <a class="asc" onclick="lsdateasc()"></a>
                <a class="desc" onclick="lsdatedesc()"></a>
              </div>
            </div>
          </td>
          <td>
            <div class="table-th">
              許可終期
              <div>
                <a class="asc" onclick="ledateasc()"></a>
                <a class="desc" onclick="ledatedesc()"></a>
              </div>
            </div>
          </td>
          <td>完了</td>
          <td>
            <div class="table-th">
              皆伐完了日
              <div>
                <a class="asc" onclick="dfdateasc()"></a>
                <a class="desc" onclick="dfdatedesc()"></a>
              </div>
            </div>
          </td>
          <td>
            <div class="table-th">
              植栽完了日
              <div>
                <a class="asc" onclick="pldateasc()"></a>
                <a class="desc" onclick="pldatedesc()"></a>
              </div>
            </div>
          </td>
          <td>
            <div class="table-th">
              提出日
              <div>
                <a class="asc" onclick="sbmdateasc()"></a>
                <a class="desc" onclick="sbmdatedesc()"></a>
              </div>
            </div>
          </td>
          <td>着手日

          </td>
          <td>完了日</td>
          <td>備考</td>
          <input type="hidden" id="dateoder" name="dateoder" value="<?= $od ?>">
        </tr>
      </thead>
      <tbody>
        <?php
        $sum_price = 0;
        $sql = "SELECT * FROM license_history WHERE $srch";
        $stmt = $dbh->query($sql);
        $sum_price = 0;
        while ($result = $stmt->fetch(PDO::FETCH_BOTH)) {
          if ($result['validity'] == '期限切') {
            echo "<tr id='selid' style='background-color:rgba(255,0,0,0.3);'>";
          } else {
            echo "<tr id='selid'>";
          };

          echo
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
            "<td>" . $result['StartDate'] . "</td>" .
            "<td>" . $result['CompletionDate'] . "</td>" .
            "<td style='max-height:100px'>" . $result['Remark'] . "</td>" .
            "</tr>";
        }
        ?>
    </table>
</form>
</div>

@stop

@section('js')

@include('edt.datepicker')

<script>
  function lcidasc() {
    document.getElementById('dateoder').value = ' ORDER BY LicenseID ASC';
    document.history.submit();
  }

  function lciddesc() {
    document.getElementById('dateoder').value = ' ORDER BY LicenseID DESC';
    document.history.submit();
  }

  function lmtasc() {
    document.getElementById('dateoder').value = ' ORDER BY lmt ASC';
    document.history.submit();
  }

  function lmtdesc() {
    document.getElementById('dateoder').value = ' ORDER BY lmt DESC';
    document.history.submit();
  }

  function rfnumasc() {
    document.getElementById('dateoder').value = ' ORDER BY ReferenceNumber ASC';
    document.history.submit();
  }

  function rfnumdesc() {
    document.getElementById('dateoder').value = ' ORDER BY ReferenceNumber DESC';
    document.history.submit();
  }

  function apdateasc() {
    document.getElementById('dateoder').value = ' ORDER BY ApplicationDate ASC';
    document.history.submit();
  }

  function apdatedesc() {
    document.getElementById('dateoder').value = ' ORDER BY ApplicationDate DESC';
    document.history.submit();
  }

  function pmdateasc() {
    document.getElementById('dateoder').value = ' ORDER BY PermitDate ASC';
    document.history.submit();
  }

  function pmdatedesc() {
    document.getElementById('dateoder').value = ' ORDER BY PermitDate DESC';
    document.history.submit();
  }

  function lsdateasc() {
    document.getElementById('dateoder').value = ' ORDER BY LicensedStartDate ASC';
    document.history.submit();
  }

  function lsdatedesc() {
    document.getElementById('dateoder').value = ' ORDER BY LicensedStartDate DESC';
    document.history.submit();
  }

  function ledateasc() {
    document.getElementById('dateoder').value = ' ORDER BY LicensedEndDate ASC';
    document.history.submit();
  }

  function ledatedesc() {
    document.getElementById('dateoder').value = ' ORDER BY LicensedEndDate DESC';
    document.history.submit();
  }

  function dfdateasc() {
    document.getElementById('dateoder').value = ' ORDER BY DeforestationDate ASC';
    document.history.submit();
  }

  function dfdatedesc() {
    document.getElementById('dateoder').value = ' ORDER BY DeforestationDate DESC';
    document.history.submit();
  }

  function pldateasc() {
    document.getElementById('dateoder').value = ' ORDER BY PlantingDate ASC';
    document.history.submit();
  }

  function pldatedesc() {
    document.getElementById('dateoder').value = ' ORDER BY PlantingDate DESC';
    document.history.submit();
  }

  function sbmdateasc() {
    document.getElementById('dateoder').value = ' ORDER BY SubmissionDate ASC';
    document.history.submit();
  }

  function sbmdatedesc() {
    document.getElementById('dateoder').value = ' ORDER BY SubmissionDate DESC';
    document.history.submit();
  }

  const setid = document.getElementById('lid');

  $('td').click(function(event) {
    const lid = $(this).parent().find('#licenseid').text()
    setid.value = lid
    document.getElementById('nxt').submit()
  });
</script>
@stop