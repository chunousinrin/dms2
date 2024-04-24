<form action="" method="post" name="f_input">
  @csrf
  <table class="table table-hover table-borderless ctable">
    <tbody>
      <tr>
        <td class="table-success col-sm-2">整理番号<span class="required_item">必須</span></td>
        <td>
          <div class="input-group">
            <input type="text" id="ReferenceNumber" name="ReferenceNumber" required class="form-control rounded-0 col-10">
            <input type="text" id="BranchNumber" name="BranchNumber" class="form-control rounded-0 col-2" placeholder="枝番">
          </div>
        </td>
      </tr>
      <tr>
        <td class="table-success col-sm-2">施設名称</td>
        <td>
          <input type="text" id="FacilityName" name="FacilityName" class="form-control rounded-0 ">
        </td>
      </tr>
      <tr>
        <td class="table-success col-sm-2">保安林種</td>
        <td>
          <input type="text" name="ForestReserve" id="ForestReserve" list="clist" autocomplete="on" value="<?= $_POST['ForestReserve'] ?? null ?>" placeholder="入力または一覧から選択してください" class="form-control rounded-0">
          <datalist id="clist">
            <?php
            $sql = "SELECT ForestReserve FROM license_history GROUP BY ForestReserve;";
            $stmt = $dbh->query($sql);
            while ($row = $stmt->fetch(PDO::FETCH_BOTH)) {
              echo "<option value='" . $row['ForestReserve'] . "'></option>";
            }
            ?>
          </datalist>
        </td>
      </tr>
      <tr>
        <td class="table-success col-sm-2">森林所在地</td>
        <td>
          <input type="text" id="Location" name="Location" class="form-control rounded-0 ">
        </td>
      </tr>
      <tr>
        <td class="table-success col-sm-2">筆数</td>
        <td>
          <input type="text" id="Stock" name="Stock" class="form-control rounded-0 ">
        </td>
      </tr>
      <tr>
        <td class="table-success col-sm-2">申請者</td>
        <td>
          <input type="text" id="Applicant" name="Applicant" class="form-control rounded-0 ">
        </td>
      </tr>
      <tr>
        <td class="table-success col-sm-2">連絡先</td>
        <td>
          <input type="text" id="Contact" name="Contact" class="form-control rounded-0 ">
        </td>
      </tr>
      <tr>
        <td class="table-success col-sm-2">許可面積</td>
        <td>
          <input type="text" id="PermittedArea" name="PermittedArea" class="form-control rounded-0 ">
        </td>
      </tr>
      <tr>
        <td class="table-success col-sm-2">申請年月日<span class="required_item">必須</span></td>
        <td>
          <input type="text" id="ApplicationDate" name="ApplicationDate" required class="form-control rounded-0 datepicker">
        </td>
      </tr>
      <tr>
        <td class="table-success col-sm-2">許可年月日<span class="required_item">必須</span></td>
        <td>
          <input type="text" id="PermitDate" name="PermitDate" required class="form-control rounded-0 datepicker">
        </td>
      </tr>
      <tr>
        <td class="table-success col-sm-2">指令番号</td>
        <td>
          <input type="text" id="InstructionNumber" name="InstructionNumber" class="form-control rounded-0 ">
        </td>
      </tr>
      <tr>
        <td class="table-success col-sm-2">許可始期<span class="required_item">必須</span></td>
        <td>
          <input type="text" id="LicensedStartDate" name="LicensedStartDate" required class="form-control rounded-0 datepicker">
        </td>
      </tr>
      <tr>
        <td class="table-success col-sm-2">許可終期<span class="required_item">必須</span></td>
        <td>
          <input type="text" id="LicensedEndDate" name="LicensedEndDate" required class="form-control rounded-0 datepicker">
        </td>
      </tr>
      <tr>
        <td class="table-success col-sm-2">完了</td>
        <td>
          <input type="text" id="Completed" name="Completed" class="form-control rounded-0 ">
        </td>
      </tr>
      <tr>
        <td class="table-success col-sm-2">皆伐完了日</td>
        <td>
          <input type="text" id="DeforestationDate" name="DeforestationDate" class="form-control rounded-0 datepicker">
        </td>
      </tr>
      <tr>
        <td class="table-success col-sm-2">植栽完了日</td>
        <td>
          <input type="text" id="PlantingDate" name="PlantingDate" class="form-control rounded-0 datepicker">
        </td>
      </tr>
      <tr>
        <td class=" table-success col-sm-2">提出日
        </td>
        <td>
          <input type="text" id="SubmissionDate" name="SubmissionDate" class="form-control rounded-0 datepicker">
        </td>
      </tr>
      <tr>
        <td class="table-success col-sm-2">備考</td>
        <td>
          <textarea id="Remark" name="Remark" class="form-control rounded-0"></textarea>
        </td>
      </tr>
    </tbody>
  </table>

  <div style="width:100%; margin:0 auto;;text-align:center;">
    <button class="btn btn-secondary rounded-0 btn-sm px-4 mb-5" onclick="history.back()">戻る</button>
    <button class="btn btn-secondary rounded-0 btn-sm px-4 mb-5">入力内容を確認する</button>
    <input type="hidden" name="sbmtype" value="3">
  </div>
</form>