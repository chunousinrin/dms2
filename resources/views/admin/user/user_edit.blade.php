<?php
$user_sql = "SELECT * FROM users WHERE id = " . $user['id'];
$user_stmt = $dbh->query($user_sql);
$result = $user_stmt->fetch();
?>
<form action="" method="post" name="f_input" enctype="multipart/form-data">
    @csrf
    <table class="table table-hover table-borderless ctable">
        <tbody>
            <tr>
                <td class="table-success col-sm-2">id<span class="required_item">必須</span></td>
                <td>
                    <input type="text" id="id" name="id" class="form-control rounded-0" value="<?= $result['id'] ?>" readonly>
                </td>
            </tr>
            <tr>
                <td class="table-success col-sm-2">ユーザー名<span class="required_item">必須</span></td>
                <td>
                    <input type="text" name="name" id="name" class="form-control rounded-0" value="<?= $result['name'] ?>" required>
                </td>
            </tr>
            <tr>
                <td class="table-success col-sm-2">Email<span class="required_item">必須</span></td>
                <td>
                    <input type="text" id="email" name="email" class="form-control rounded-0" value="<?= $result['email'] ?>" required>
                </td>
            </tr>
            <tr>
                <td class="table-success col-sm-2">パスワード<span class="required_item">必須</span></td>
                <td>
                    <input type="password" id="password" name="password" class="form-control rounded-0" value="<?= $result['password'] ?>" required>
                    <input type="hidden" id="old_password" name="old_password" value="<?= $result['password'] ?>">
                </td>
            </tr>
        </tbody>
    </table>

    <table class="table table-hover table-borderless ctable">
        <tbody>
            <tr>
                <td class="table-success col-sm-2">部署</td>
                <td>
                    <input type="text" name="department" id="department" class="form-control rounded-0" value="<?= $result['department'] ?>">
                </td>
            </tr>
            <tr>
                <td class="table-success col-sm-2">所属</td>
                <td>
                    <input type="text" name="section" id="section" class="form-control rounded-0" value="<?= $result['section'] ?>">
                </td>
            </tr>
            <tr>
                <td class="table-success col-sm-2">役職</td>
                <td>
                    <input type="text" name="position" id="position" class="form-control rounded-0" value="<?= $result['position'] ?>">
                </td>
            </tr>
            <tr>
                <td class="table-success col-sm-2">印章</td>
                <td>
                    <div class="input-group mb-2">
                        <div class="col-1 text-center"><?php echo '<img style="width:auto;height:calc(2.25rem + 2px);" src="data:image/svg+xml;base64,' . base64_encode($result['stamp']) . '" >'; ?></div>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="stamp" name="stamp" accept="image/svg+xml" value="">
                            <label class="custom-file-label" for="stamp" data-browse="参照">ファイル選択...</label>
                        </div>
                    </div>
                    <a href="https://e-inkan.com/select.html">印章ダウンロードサイト</a>
                </td>
            </tr>
        </tbody>
    </table>

    <div style="width:100%;text-align:center;" class="pb-5">
        <button class="btn btn-secondary rounded-0 btn-sm px-4" onclick="history.back()">戻る</button>
        <button class="btn btn-secondary rounded-0 btn-sm px-4" onclick="">保存</button>
        <input type="hidden" name="sbmtype" value="9">
    </div>
</form>

<style>
    .custom-file {
        overflow: hidden;
    }

    .custom-file-label {
        white-space: nowrap;
    }
</style>