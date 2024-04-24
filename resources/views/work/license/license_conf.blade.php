<form action="" method="post" name="f_conf">
  @csrf
  <table class="table table-hover table-borderless ctable">
    <tbody>
      <tr>
        <td class="table-primary col-sm-2">整理番号</td>
        <td>
          <?= $_POST['ReferenceNumber'] ?>
          <?php
          if (!empty($_POST['BranchNumber'])) {
            echo "　-　" . $_POST['BranchNumber'];
          };
          ?>
          <input type="hidden" id="ReferenceNumber" name="ReferenceNumber" value="<?= $_POST['ReferenceNumber'] ?>">
          <input type="hidden" id="BranchNumber" name="BranchNumber" value="<?= $_POST['BranchNumber'] ?>">
        </td>
      </tr>
      <tr>
        <td class="table-primary col-sm-2">施設名称</td>
        <td>
          <?= $_POST['FacilityName'] ?>
          <input type="hidden" id="FacilityName" name="FacilityName" value="<?= $_POST['FacilityName'] ?>">
        </td>
      </tr>
      <tr>
        <td class="table-primary col-sm-2">保安林種</td>
        <td>
          <?= $_POST['ForestReserve'] ?>
          <input type="hidden" id="ForestReserve" name="ForestReserve" value="<?= $_POST['ForestReserve'] ?>" value="<?= $_POST['ForestReserve'] ?>">
        </td>
      </tr>
      <tr>
        <td class="table-primary col-sm-2">森林所在地</td>
        <td>
          <?= $_POST['Location'] ?>
          <input type="hidden" id="Location" name="Location" value="<?= $_POST['Location'] ?>">
        </td>
      </tr>
      <tr>
        <td class="table-primary col-sm-2">筆数</td>
        <td>
          <?= $_POST['Stock'] ?>
          <input type="hidden" id="Stock" name="Stock" value="<?= $_POST['Stock'] ?>">
        </td>
      </tr>
      <tr>
        <td class="table-primary col-sm-2">申請者</td>
        <td>
          <?= $_POST['Applicant'] ?>
          <input type="hidden" id="Applicant" name="Applicant" value="<?= $_POST['Applicant'] ?>">
        </td>
      </tr>
      <tr>
        <td class="table-primary col-sm-2">連絡先</td>
        <td>
          <?= $_POST['Contact'] ?>
          <input type="hidden" id="Contact" name="Contact" value="<?= $_POST['Contact'] ?>">
        </td>
      </tr>
      <tr>
        <td class="table-primary col-sm-2">許可面積</td>
        <td>
          <?= $_POST['PermittedArea'] ?>
          <input type="hidden" id="PermittedArea" name="PermittedArea" value="<?= $_POST['PermittedArea'] ?>">
        </td>
      </tr>
      <tr>
        <td class="table-primary col-sm-2">申請年月日</td>
        <td>
          <?= $_POST['ApplicationDate'] ?>
          <input type="hidden" id="ApplicationDate" name="ApplicationDate" value="<?= $_POST['ApplicationDate'] ?>">
        </td>
      </tr>
      <tr>
        <td class="table-primary col-sm-2">許可年月日</td>
        <td>
          <?= $_POST['PermitDate'] ?>
          <input type="hidden" id="PermitDate" name="PermitDate" value="<?= $_POST['PermitDate'] ?>">
        </td>
      </tr>
      <tr>
        <td class="table-primary col-sm-2">指令番号</td>
        <td>
          <?= $_POST['InstructionNumber'] ?>
          <input type="hidden" id="InstructionNumber" name="InstructionNumber" value="<?= $_POST['InstructionNumber'] ?>">
        </td>
      </tr>
      <tr>
        <td class="table-primary col-sm-2">許可始期</td>
        <td>
          <?= $_POST['LicensedStartDate'] ?>
          <input type="hidden" id="LicensedStartDate" name="LicensedStartDate" value="<?= $_POST['LicensedStartDate'] ?>">
        </td>
      </tr>
      <tr>
        <td class="table-primary col-sm-2">許可終期</td>
        <td>
          <?= $_POST['LicensedEndDate'] ?>
          <input type="hidden" id="LicensedEndDate" name="LicensedEndDate" value="<?= $_POST['LicensedEndDate'] ?>">
        </td>
      </tr>
      <tr>
        <td class="table-primary col-sm-2">完了</td>
        <td>
          <?= $_POST['Completed'] ?>
          <input type="hidden" id="Completed" name="Completed" value="<?= $_POST['Completed'] ?>">
        </td>
      </tr>
      <tr>
        <td class="table-primary col-sm-2">皆伐完了日</td>
        <td>
          <?= $_POST['DeforestationDate'] ?>
          <input type="hidden" id="DeforestationDate" name="DeforestationDate" value="<?= $_POST['DeforestationDate'] ?? null ?>">
        </td>
      </tr>
      <tr>
        <td class="table-primary col-sm-2">植栽完了日</td>
        <td>
          <?= $_POST['PlantingDate'] ?>
          <input type="hidden" id="PlantingDate" name="PlantingDate" value="<?= $_POST['PlantingDate'] ?>">
        </td>
      </tr>
      <tr>
        <td class=" table-primary col-sm-2">提出日
        </td>
        <td>
          <?= $_POST['SubmissionDate'] ?>
          <input type="hidden" id="SubmissionDate" name="SubmissionDate" value="<?= $_POST['SubmissionDate'] ?>">
        </td>
      </tr>
      <tr>
        <td class="table-primary col-sm-2">備考</td>
        <td>
          <div>
            <?= nl2br($_POST['Remark']) ?>
            <input type="hidden" name="Remark" value="<?= $_POST['Remark'] ?>">
          </div>
        </td>
      </tr>
    </tbody>
  </table>

  <div style="width:100%;text-align:center;" class="pb-5">
    <input class="btn btn-secondary rounded-0 btn-sm px-4" type="button" name="btn_back" value="戻る" onclick="history.back()">
    <input class="btn btn-secondary rounded-0 btn-sm px-4" type="submit" name="save" value="保存">
    <input type="hidden" name="sbmtype" value="4">
  </div>
</form>