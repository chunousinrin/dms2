<?php

try {
    $pdo = new PDO('mysql:host=localhost;dbname=' . env('DB_DATABASE') . ';charset=utf8', env('DB_USERNAME'), env('DB_PASSWORD'), [PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]);

    if (empty($_POST['WorksPeriod1'])) {
        $WorksPeriod1 = null;
    } else {
        $WorksPeriod1 = $_POST['WorksPeriod1'];
    }
    if (empty($_POST['WorksPeriod2'])) {
        $WorksPeriod2 = null;
    } else {
        $WorksPeriod2 = $_POST['WorksPeriod2'];
    }
    if (empty($_POST['EffectiveDate'])) {
        $EffectiveDate = null;
    } else {
        $EffectiveDate = $_POST['EffectiveDate'];
    }
    // SQL文をセット
    $stmt = $pdo->prepare('INSERT INTO estimate2 (
classicationId,
UserID,
UserName,
StaffDisplay,
Es2Number,
CreatedDate,
CDDisplay,
Branch,
Customer,
CustomerAdd,
Es2BizName,
Es2Location,
WorksType,
WorksPeriod1,
WorksPeriod2,
EffectiveDate,
Es2UnitPrice,
NB,
Summary,
Quantity,
Unit,
UnitPrice,
Amount,
Remark
) VALUES(
:classicationId,
:UserID,
:UserName,
:StaffDisplay,
:Es2Number,
:CreatedDate,
:CDDisplay,
:Branch,
:Customer,
:CustomerAdd,
:Es2BizName,
:Es2Location,
:WorksType,
:WorksPeriod1,
:WorksPeriod2,
:EffectiveDate,
:Es2UnitPrice,
:NB,
:Summary,
:Quantity,
:Unit,
:UnitPrice,
:Amount,
:Remark
)');

    // 1～12行目
    $table = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12);

    foreach ($table as $row) :
        $stmt->bindValue(':classicationId', $_POST['classicationId']);
        $stmt->bindValue(':UserID', $_POST['UserID']);
        $stmt->bindValue(':UserName', $_POST['UserName']);
        $stmt->bindValue(':StaffDisplay', $_POST['StaffDisplay']);
        $stmt->bindValue(':Es2Number', $_POST['SerialNumber']);
        $stmt->bindValue(':CreatedDate', $_POST['CreatedDate'] ?? null);
        $stmt->bindValue(':CDDisplay', $_POST['cddisplay']);
        $stmt->bindValue(':Branch', $_POST['Branch']);
        $stmt->bindValue(':Customer', $_POST['Customer']);
        $stmt->bindValue(':CustomerAdd', $_POST['CustomerAdd']);
        $stmt->bindValue(':Es2BizName', $_POST['TitleName']);
        $stmt->bindValue(':Es2Location', $_POST['Location']);
        $stmt->bindValue(':WorksType', $_POST['WorksType']);
        $stmt->bindValue(':WorksPeriod1', $WorksPeriod1);
        $stmt->bindValue(':WorksPeriod2', $WorksPeriod2);
        $stmt->bindValue(':EffectiveDate', $EffectiveDate);
        $stmt->bindValue(':Es2UnitPrice', $_POST['Es2UnitPrice']);
        $stmt->bindValue(':NB', $_POST['Remark']);
        $stmt->bindValue(':Summary', $_POST['smr' . $row]);
        $stmt->bindValue(':Quantity', $_POST['qat' . $row]);
        $stmt->bindValue(':Unit', $_POST['unt' . $row]);
        $stmt->bindValue(':UnitPrice', $_POST['up' . $row]);
        $stmt->bindValue(':Amount', $_POST['amt' . $row]);
        $stmt->bindValue(':Remark', $_POST['rm' . $row]);
        $stmt->execute();
    endforeach;

    //13行目
    $stmt->bindValue(':classicationId', $_POST['classicationId']);
    $stmt->bindValue(':UserID', $_POST['UserID']);
    $stmt->bindValue(':UserName', $_POST['UserName']);
    $stmt->bindValue(':StaffDisplay', $_POST['StaffDisplay']);
    $stmt->bindValue(':Es2Number', $_POST['SerialNumber']);
    $stmt->bindValue(':CreatedDate', $_POST['CreatedDate'] ?? null);
    $stmt->bindValue(':CDDisplay', $_POST['cddisplay']);
    $stmt->bindValue(':Branch', $_POST['Branch']);
    $stmt->bindValue(':Customer', $_POST['Customer']);
    $stmt->bindValue(':CustomerAdd', $_POST['CustomerAdd']);
    $stmt->bindValue(':Es2BizName', $_POST['TitleName']);
    $stmt->bindValue(':Es2Location', $_POST['Location']);
    $stmt->bindValue(':WorksType', $_POST['WorksType']);
    $stmt->bindValue(':WorksPeriod1', $WorksPeriod1);
    $stmt->bindValue(':WorksPeriod2', $WorksPeriod2);
    $stmt->bindValue(':EffectiveDate', $EffectiveDate);
    $stmt->bindValue(':Es2UnitPrice', $_POST['Es2UnitPrice']);
    $stmt->bindValue(':NB', $_POST['Remark']);
    $stmt->bindValue(':Summary', "直接作業代小計");
    $stmt->bindValue(':Quantity', "");
    $stmt->bindValue(':Unit', "");
    $stmt->bindValue(':UnitPrice', "");
    $stmt->bindValue(':Amount', $_POST['subtotal']);
    $stmt->bindValue(':Remark', "");
    $stmt->execute();

    //14行目(空白)
    $stmt->bindValue(':classicationId', $_POST['classicationId']);
    $stmt->bindValue(':UserID', $_POST['UserID']);
    $stmt->bindValue(':UserName', $_POST['UserName']);
    $stmt->bindValue(':StaffDisplay', $_POST['StaffDisplay']);
    $stmt->bindValue(':Es2Number', $_POST['SerialNumber']);
    $stmt->bindValue(':CreatedDate', $_POST['CreatedDate'] ?? null);
    $stmt->bindValue(':CDDisplay', $_POST['cddisplay']);
    $stmt->bindValue(':Branch', $_POST['Branch']);
    $stmt->bindValue(':Customer', $_POST['Customer']);
    $stmt->bindValue(':CustomerAdd', $_POST['CustomerAdd']);
    $stmt->bindValue(':Es2BizName', $_POST['TitleName']);
    $stmt->bindValue(':Es2Location', $_POST['Location']);
    $stmt->bindValue(':WorksType', $_POST['WorksType']);
    $stmt->bindValue(':WorksPeriod1', $WorksPeriod1);
    $stmt->bindValue(':WorksPeriod2', $WorksPeriod2);
    $stmt->bindValue(':EffectiveDate', $EffectiveDate);
    $stmt->bindValue(':Es2UnitPrice', $_POST['Es2UnitPrice']);
    $stmt->bindValue(':NB', $_POST['Remark']);
    $stmt->bindValue(':Summary', "");
    $stmt->bindValue(':Quantity', "");
    $stmt->bindValue(':Unit', "");
    $stmt->bindValue(':UnitPrice', "");
    $stmt->bindValue(':Amount', "");
    $stmt->bindValue(':Remark', "");
    $stmt->execute();

    //15～16行目
    $table = array(1, 2);

    foreach ($table as $row) :
        $stmt->bindValue(':classicationId', $_POST['classicationId']);
        $stmt->bindValue(':UserID', $_POST['UserID']);
        $stmt->bindValue(':UserName', $_POST['UserName']);
        $stmt->bindValue(':StaffDisplay', $_POST['StaffDisplay']);
        $stmt->bindValue(':Es2Number', $_POST['SerialNumber']);
        $stmt->bindValue(':CreatedDate', $_POST['CreatedDate'] ?? null);
        $stmt->bindValue(':CDDisplay', $_POST['cddisplay']);
        $stmt->bindValue(':Branch', $_POST['Branch']);
        $stmt->bindValue(':Customer', $_POST['Customer']);
        $stmt->bindValue(':CustomerAdd', $_POST['CustomerAdd']);
        $stmt->bindValue(':Es2BizName', $_POST['TitleName']);
        $stmt->bindValue(':Es2Location', $_POST['Location']);
        $stmt->bindValue(':WorksType', $_POST['WorksType']);
        $stmt->bindValue(':WorksPeriod1', $WorksPeriod1);
        $stmt->bindValue(':WorksPeriod2', $WorksPeriod2);
        $stmt->bindValue(':EffectiveDate', $EffectiveDate);
        $stmt->bindValue(':Es2UnitPrice', $_POST['Es2UnitPrice']);
        $stmt->bindValue(':NB', $_POST['Remark']);
        $stmt->bindValue(':Summary', $_POST['idsmr' . $row]);
        $stmt->bindValue(':Quantity', $_POST['idqat' . $row]);
        $stmt->bindValue(':Unit', $_POST['idunt' . $row]);
        $stmt->bindValue(':UnitPrice', "");
        $stmt->bindValue(':Amount', $_POST['idamt' . $row]);
        $stmt->bindValue(':Remark', $_POST['idrmk' . $row]);
        $stmt->execute();
    endforeach;
    //17行目
    $stmt->bindValue(':classicationId', $_POST['classicationId']);
    $stmt->bindValue(':UserID', $_POST['UserID']);
    $stmt->bindValue(':UserName', $_POST['UserName']);
    $stmt->bindValue(':StaffDisplay', $_POST['StaffDisplay']);
    $stmt->bindValue(':Es2Number', $_POST['SerialNumber']);
    $stmt->bindValue(':CreatedDate', $_POST['CreatedDate'] ?? null);
    $stmt->bindValue(':CDDisplay', $_POST['cddisplay']);
    $stmt->bindValue(':Branch', $_POST['Branch']);
    $stmt->bindValue(':Customer', $_POST['Customer']);
    $stmt->bindValue(':CustomerAdd', $_POST['CustomerAdd']);
    $stmt->bindValue(':Es2BizName', $_POST['TitleName']);
    $stmt->bindValue(':Es2Location', $_POST['Location']);
    $stmt->bindValue(':WorksType', $_POST['WorksType']);
    $stmt->bindValue(':WorksPeriod1', $WorksPeriod1);
    $stmt->bindValue(':WorksPeriod2', $WorksPeriod2);
    $stmt->bindValue(':EffectiveDate', $EffectiveDate);
    $stmt->bindValue(':Es2UnitPrice', $_POST['Es2UnitPrice']);
    $stmt->bindValue(':NB', $_POST['Remark']);
    $stmt->bindValue(':Summary', "工事原価");
    $stmt->bindValue(':Quantity', "");
    $stmt->bindValue(':Unit', "");
    $stmt->bindValue(':UnitPrice', "");
    $stmt->bindValue(':Amount', "");
    $stmt->bindValue(':Amount', $_POST['idtotal']);
    $stmt->bindValue(':Remark', "");
    $stmt->execute();
    //18行目(空白)
    $stmt->bindValue(':classicationId', $_POST['classicationId']);
    $stmt->bindValue(':UserID', $_POST['UserID']);
    $stmt->bindValue(':UserName', $_POST['UserName']);
    $stmt->bindValue(':StaffDisplay', $_POST['StaffDisplay']);
    $stmt->bindValue(':Es2Number', $_POST['SerialNumber']);
    $stmt->bindValue(':CreatedDate', $_POST['CreatedDate'] ?? null);
    $stmt->bindValue(':CDDisplay', $_POST['cddisplay']);
    $stmt->bindValue(':Branch', $_POST['Branch']);
    $stmt->bindValue(':Customer', $_POST['Customer']);
    $stmt->bindValue(':CustomerAdd', $_POST['CustomerAdd']);
    $stmt->bindValue(':Es2BizName', $_POST['TitleName']);
    $stmt->bindValue(':Es2Location', $_POST['Location']);
    $stmt->bindValue(':WorksType', $_POST['WorksType']);
    $stmt->bindValue(':WorksPeriod1', $WorksPeriod1);
    $stmt->bindValue(':WorksPeriod2', $WorksPeriod2);
    $stmt->bindValue(':EffectiveDate', $EffectiveDate);
    $stmt->bindValue(':Es2UnitPrice', $_POST['Es2UnitPrice']);
    $stmt->bindValue(':NB', $_POST['Remark']);
    $stmt->bindValue(':Summary', "");
    $stmt->bindValue(':Quantity', "");
    $stmt->bindValue(':Unit', "");
    $stmt->bindValue(':UnitPrice', "");
    $stmt->bindValue(':Amount', "");
    $stmt->bindValue(':Remark', "");
    $stmt->execute();
    //19行目
    $stmt->bindValue(':classicationId', $_POST['classicationId']);
    $stmt->bindValue(':UserID', $_POST['UserID']);
    $stmt->bindValue(':UserName', $_POST['UserName']);
    $stmt->bindValue(':StaffDisplay', $_POST['StaffDisplay']);
    $stmt->bindValue(':Es2Number', $_POST['SerialNumber']);
    $stmt->bindValue(':CreatedDate', $_POST['CreatedDate'] ?? null);
    $stmt->bindValue(':CDDisplay', $_POST['cddisplay']);
    $stmt->bindValue(':Branch', $_POST['Branch']);
    $stmt->bindValue(':Customer', $_POST['Customer']);
    $stmt->bindValue(':CustomerAdd', $_POST['CustomerAdd']);
    $stmt->bindValue(':Es2BizName', $_POST['TitleName']);
    $stmt->bindValue(':Es2Location', $_POST['Location']);
    $stmt->bindValue(':WorksType', $_POST['WorksType']);
    $stmt->bindValue(':WorksPeriod1', $WorksPeriod1);
    $stmt->bindValue(':WorksPeriod2', $WorksPeriod2);
    $stmt->bindValue(':EffectiveDate', $EffectiveDate);
    $stmt->bindValue(':Es2UnitPrice', $_POST['Es2UnitPrice']);
    $stmt->bindValue(':NB', $_POST['Remark']);
    $stmt->bindValue(':Summary', $_POST['otsmr1']);
    $stmt->bindValue(':Quantity', $_POST['otqat1']);
    $stmt->bindValue(':Unit', $_POST['otunt1']);
    $stmt->bindValue(':UnitPrice', "");
    $stmt->bindValue(':Amount', $_POST['otamt1']);
    $stmt->bindValue(':Remark', $_POST['otrmk1']);
    $stmt->execute();
    //20～22行目
    $table = array(2, 3, 4);
    foreach ($table as $row) :
        $stmt->bindValue(':classicationId', $_POST['classicationId']);
        $stmt->bindValue(':UserID', $_POST['UserID']);
        $stmt->bindValue(':UserName', $_POST['UserName']);
        $stmt->bindValue(':StaffDisplay', $_POST['StaffDisplay']);
        $stmt->bindValue(':Es2Number', $_POST['SerialNumber']);
        $stmt->bindValue(':CreatedDate', $_POST['CreatedDate'] ?? null);
        $stmt->bindValue(':CDDisplay', $_POST['cddisplay']);
        $stmt->bindValue(':Branch', $_POST['Branch']);
        $stmt->bindValue(':Customer', $_POST['Customer']);
        $stmt->bindValue(':CustomerAdd', $_POST['CustomerAdd']);
        $stmt->bindValue(':Es2BizName', $_POST['TitleName']);
        $stmt->bindValue(':Es2Location', $_POST['Location']);
        $stmt->bindValue(':WorksType', $_POST['WorksType']);
        $stmt->bindValue(':WorksPeriod1', $WorksPeriod1);
        $stmt->bindValue(':WorksPeriod2', $WorksPeriod2);
        $stmt->bindValue(':EffectiveDate', $EffectiveDate);
        $stmt->bindValue(':Es2UnitPrice', $_POST['Es2UnitPrice']);
        $stmt->bindValue(':NB', $_POST['Remark']);
        $stmt->bindValue(':Summary', $_POST['otsmr' . $row]);
        $stmt->bindValue(':Quantity', $_POST['otqat' . $row]);
        $stmt->bindValue(':Unit', $_POST['otunt' . $row]);
        $stmt->bindValue(':UnitPrice', $_POST['otup' . $row]);
        $stmt->bindValue(':Amount', $_POST['otamt' . $row]);
        $stmt->bindValue(':Remark', $_POST['otrmk' . $row]);
        $stmt->execute();
    endforeach;
} catch (PDOException $e) {
    // エラー発生
    echo "エラーが発生しました。" . $e->getMessage();
} finally {
    // DB接続を閉じる
    $pdo = null;
}
