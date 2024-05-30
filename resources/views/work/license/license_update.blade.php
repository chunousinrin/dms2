@extends('adminlte::page')

@section('title')
<?php
$cname = DB::table('conf_registername')
    ->where('RegisterID', '1')
    ->get();
echo $cname[0]->RegisterName . "　-許可期限管理-";
?>
@endsection

@section('content_header')
<h1>許可期限管理</h1>
<link rel="stylesheet" href="/css/cnu_table.css">
<script>
    window.onload = function() {
        document.getElementById("l3").checked = true;
        document.getElementById("l3-2").checked = true;
    }

    function lcsudt() {
        if (window.confirm('更新してもよろしいですか?')) { // 確認ダイアログを表示
            document.getElementById('btn_confirm').value = "更新";

        } else { // 「キャンセル」時の処理
            window.alert('キャンセルされました'); // 警告ダイアログを表示
            return false; // 送信を中止
        }
    }

    function lcsdlt() {
        if (window.confirm('削除してもよろしいですか?')) { // 確認ダイアログを表示
            document.getElementById('btn_confirm').value = "削除";

        } else { // 「キャンセル」時の処理
            window.alert('キャンセルされました'); // 警告ダイアログを表示
            return false; // 送信を中止
        }
    }
</script>

<?php
if (!empty($_GET['btn_confirm'])) {
    $types = $_GET['btn_confirm'];
} else {
    $types = '表示';
}

$dbh = new PDO('mysql:host=localhost;dbname=dms;charset=utf8', 'root', '');

if (!empty($_GET['BranchNumber'])) {
    $BranchNumber = $_GET['BranchNumber'];
} else {
    $BranchNumber = null;
}
if (!empty($_GET['ApplicationDate'])) {
    $ApplicationDate = $_GET['ApplicationDate'];
} else {
    $ApplicationDate = null;
}
if (!empty($_GET['PermitDate'])) {
    $PermitDate = $_GET['PermitDate'];
} else {
    $PermitDate = null;
}
if (!empty($_GET['InstructionNumber'])) {
    $InstructionNumber = $_GET['InstructionNumber'];
} else {
    $InstructionNumber = null;
}
if (!empty($_GET['LicensedStartDate'])) {
    $LicensedStartDate = $_GET['LicensedStartDate'];
} else {
    $LicensedStartDate = null;
}
if (!empty($_GET['LicensedEndDate'])) {
    $LicensedEndDate = $_GET['LicensedEndDate'];
} else {
    $LicensedEndDate = null;
}
if (!empty($_GET['DeforestationDate'])) {
    $DeforestationDate = $_GET['DeforestationDate'];
} else {
    $DeforestationDate = null;
}
if (!empty($_GET['PlantingDate'])) {
    $PlantingDate = $_GET['PlantingDate'];
} else {
    $PlantingDate = null;
}
if (!empty($_GET['SubmissionDate'])) {
    $SubmissionDate = $_GET['SubmissionDate'];
} else {
    $SubmissionDate = null;
}
if (!empty($_GET['StartDate'])) {
    $StartDate = $_GET['StartDate'];
} else {
    $StartDate = null;
}
if (!empty($_GET['CompletionDate'])) {
    $CompletionDate = $_GET['CompletionDate'];
} else {
    $CompletionDate = null;
}
?>

@stop

@section('content')
<?php
if ($types == '更新') {

    $sql = "UPDATE license SET LicenseID = :LicenseID,
    ReferenceNumber = :ReferenceNumber,
    BranchNumber = :BranchNumber,
    FacilityName = :FacilityName,
    ForestReserve = :ForestReserve,
    Location = :Location,
    Stock = :Stock,
    Applicant = :Applicant,
    Contact = :Contact,
    PermittedArea = :PermittedArea,
    ApplicationDate = :ApplicationDate,
    PermitDate = :PermitDate,
    InstructionNumber = :InstructionNumber,
    LicensedStartDate = :LicensedStartDate,
    LicensedEndDate = :LicensedEndDate,
    Completed = :Completed,
    DeforestationDate = :DeforestationDate,
    PlantingDate = :PlantingDate,
    SubmissionDate = :SubmissionDate,
    StartDate=:StartDate,
    CompletionDate=:CompletionDate,
    Remark = :Remark
     WHERE LicenseID = :LicenseID";
    $stmt = $dbh->prepare($sql);
    $params = array(
        ':LicenseID' => $_GET['lid'],
        ':ReferenceNumber' => $_GET['ReferenceNumber'],
        ':BranchNumber' => $BranchNumber,
        ':FacilityName' => $_GET['FacilityName'],
        ':ForestReserve' => $_GET['ForestReserve'],
        ':Location' => $_GET['Location'],
        ':Stock' => $_GET['Stock'],
        ':Applicant' => $_GET['Applicant'],
        ':Contact' => $_GET['Contact'],
        ':PermittedArea' => $_GET['PermittedArea'],
        ':ApplicationDate' => $ApplicationDate,
        ':PermitDate' => $PermitDate,
        ':InstructionNumber' => $InstructionNumber,
        ':LicensedStartDate' => $LicensedStartDate,
        ':LicensedEndDate' => $LicensedEndDate,
        ':Completed' => $_GET['Completed'],
        ':DeforestationDate' => $DeforestationDate,
        ':PlantingDate' => $PlantingDate,
        ':SubmissionDate' => $SubmissionDate,
        'StartDate' => $StartDate,
        'CompletionDate' => $CompletionDate,
        ':Remark' => $_GET['Remark']
    );
    $stmt->execute($params);
    print "<p>更新しました</p>
    <a class='btn btn-secondary rounded-0' href='/license'>許可期限管理トップ</a>
    <a class='btn btn-secondary rounded-0' href='/'>Home</a>";
} elseif ($types == '削除') {
    $sql = "DELETE FROM license WHERE LicenseID = " . $_GET['lid'];
    $stmt = $dbh->query($sql);
    $del = $stmt->fetch();
    print "<p>削除しました</p>
    <a class='btn btn-secondary rounded-0' href='/license'>許可期限管理トップ</a>
    <a class='btn btn-secondary rounded-0' href='/'>Home</a>";
} elseif ($types == '表示') {
    $sql = "SELECT * FROM license WHERE LicenseID = " . $_GET['lid'];
    $stmt = $dbh->query($sql);
    $result = $stmt->fetch();
?>
    <form action="" method="get" name="lcs">
        <ul class="lst">
            <li></li>
            <li style="display: none;">
                <div class="lbl">
                    <label>ID</label>
                </div>
                <div class="ipt">
                    <input type="text" name="LicenseID" value="<?= $result['LicenseID'] ?>">
                </div>
            </li>
            <li>
                <div class="lbl">
                    <label>整理番号</label>
                </div>
                <div class="ipt">
                    <input type="text" name="ReferenceNumber" value="<?= $result['ReferenceNumber'] ?>">
                </div>
            </li>
            <li>
                <div class="lbl">
                    <label>枝番</label>
                </div>
                <div class="ipt">
                    <input type="text" name="BranchNumber" value="<?= $result['BranchNumber'] ?>">
                </div>
            </li>
            <li>
                <div class="lbl">
                    <label>施設名称</label>
                </div>
                <div class="ipt">
                    <input type="text" name="FacilityName" value="<?= $result['FacilityName'] ?>">
                </div>
            </li>
            <li>
                <div class="lbl">
                    <label>保安林種</label>
                </div>
                <div class="ipt">
                    <input type="text" name="ForestReserve" value="<?= $result['ForestReserve'] ?>">
                </div>
            </li>
            <li>
                <div class="lbl">
                    <label>森林所在地</label>
                </div>
                <div class="ipt">
                    <input type="text" name="Location" value="<?= $result['Location'] ?>">
                </div>
            </li>
            <li>
                <div class="lbl">
                    <label>筆数</label>
                </div>
                <div class="ipt">
                    <input type="text" name="Stock" value="<?= $result['Stock'] ?>">
                </div>
            </li>
            <li>
                <div class="lbl">
                    <label>申請者</label>
                </div>
                <div class="ipt">
                    <input type="text" name="Applicant" value="<?= $result['Applicant'] ?>">
                </div>
            </li>
            <li>
                <div class="lbl">
                    <label>連絡先</label>
                </div>
                <div class="ipt">
                    <input type="text" name="Contact" value="<?= $result['Contact'] ?>">
                </div>
            </li>
            <li>
                <div class="lbl">
                    <label>許可面積</label>
                </div>
                <div class="ipt">
                    <input type="text" name="PermittedArea" value="<?= $result['PermittedArea'] ?>">
                </div>
            </li>
            <li>
                <div class="lbl">
                    <label>申請年月日</label>
                </div>
                <div class="ipt">
                    <input type="text" name="ApplicationDate" value="<?= $result['ApplicationDate'] ?>" class="iptdt">
                </div>
            </li>
            <li>
                <div class="lbl">
                    <label>許可年月日</label>
                </div>
                <div class="ipt">
                    <input type="text" name="PermitDate" value="<?= $result['PermitDate'] ?>" class="iptdt">
                </div>
            </li>
            <li>
                <div class="lbl">
                    <label>指令番号</label>
                </div>
                <div class="ipt">
                    <input type="text" name="InstructionNumber" value="<?= $result['InstructionNumber'] ?>">
                </div>
            </li>
            <li>
                <div class="lbl">
                    <label>許可始期</label>
                </div>
                <div class="ipt">
                    <input type="text" name="LicensedStartDate" value="<?= $result['LicensedStartDate'] ?>" class="iptdt">
                </div>
            </li>
            <li>
                <div class="lbl">
                    <label>許可終期</label>
                </div>
                <div class="ipt">
                    <input type="text" name="LicensedEndDate" value="<?= $result['LicensedEndDate'] ?>" class="iptdt">
                </div>
            </li>
            <li>
                <div class="lbl">
                    <label>完了</label>
                </div>
                <div class="ipt">
                    <input type="text" name="Completed" value="<?= $result['Completed'] ?>">
                </div>
            </li>
            <li>
                <div class="lbl">
                    <label>皆伐完了日</label>
                </div>
                <div class="ipt">
                    <input type="text" name="DeforestationDate" value="<?= $result['DeforestationDate'] ?>" class="iptdt">
                </div>
            </li>
            <li>
                <div class="lbl">
                    <label>植栽完了日</label>
                </div>
                <div class="ipt">
                    <input type="text" name="PlantingDate" value="<?= $result['PlantingDate'] ?>" class="iptdt">
                </div>
            </li>
            <li>
                <div class="lbl">
                    <label>提出日</label>
                </div>
                <div class="ipt">
                    <input type="text" name="SubmissionDate" value="<?= $result['SubmissionDate'] ?>" class="iptdt">
                </div>
            </li>
            <li>
                <div class="lbl">
                    <label>着手届提出日</label>
                </div>
                <div class="ipt">
                    <input type="text" name="StartDate" value="<?= $result['StartDate'] ?>" class="iptdt">
                </div>
            </li>
            <li>
                <div class="lbl">
                    <label>完了届提出日</label>
                </div>
                <div class="ipt">
                    <input type="text" name="CompletionDate" value="<?= $result['CompletionDate'] ?>" class="iptdt">
                </div>
            </li>
            <li>
                <div class="lbl">
                    <label>備考</label>
                </div>
                <div class="ipt">
                    <textarea name="Remark" id="Remark" style="height: 100px;"><?= ($result['Remark']) ?></textarea>
                </div>
            </li>

        </ul>

        <input type="hidden" id="udt" name="lid" value="<?= $result['LicenseID'] ?>">
        <input type="hidden" id="btn_confirm" name="btn_confirm">

        <div style="margin:0 auro;padding:10px 0;text-align:center;">
            <a class="btn btn-secondary rounded-0 send_input" onclick="window.history.back();">戻る</a>
            <button class="btn btn-secondary rounded-0" onclick="lcsdlt();">削除</button>
            <button class="btn btn-secondary rounded-0" onclick="lcsudt();">更新</button>
        </div>
    </form>
<?php
}
?>
@stop

@section('js')
<?php
$dbh = 0;
?>
@stop