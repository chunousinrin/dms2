<?php

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
    ':Stock' => $Stock,
    ':Applicant' => $_POST['Applicant'],
    ':Contact' => $_POST['Contact'],
    ':PermittedArea' => $PermittedArea,
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
