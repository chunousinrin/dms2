
<?php
$sql = "SELECT MAX(ID) as No FROM `accountbook`;";
$stmt = $dbh->query($sql);
$result = $stmt->fetch();

$tempfile = $_FILES['FileName']['tmp_name'];
$fname = $_FILES['FileName']['name'];
$filename = './UploadFiles/' . $_POST['SerialNumber'] . "." . substr($fname, strrpos($fname, '.') + 1);

$id_sql = "SHOW TABLE STATUS WHERE Name = 'accountbook'";
$id_st = $dbh->query($id_sql);
$id = $id_st->fetch();

if (is_uploaded_file($tempfile)) {
    if (move_uploaded_file($tempfile, $filename)) {
        try {
            //DB名、ユーザー名、パスワードを変数に格納
            $dsn = 'mysql:dbname=cf756484_dms;host=localhost;charset=utf8';
            $user = 'cf756484_root';
            $password = 'AgVj4jDXzK';

            $PDO = new PDO($dsn, $user, $password); //PDOでMySQLのデータベースに接続
            $PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //PDOのエラーレポートを表示

            //input.phpの値を取得
            $sql = "INSERT INTO accountbook (
                    ErrlNumber,
                    UserID,
                    TradingDate,
                    RIType,
                    DocumentType,
                    Customer,
                    Amount,
                    FileName,
                    Remark
                ) 
                VALUES (
                    :ErrlNumber,
                    :UserID,
                    :TradingDate,
                    :RIType,
                    :DocumentType,
                    :Customer,
                    :Amount,
                    :FileName,
                    :Remark
                )";
            $stmt = $PDO->prepare($sql); //値が空のままSQL文をセット
            $params = array(
                ':ErrlNumber' => $_POST['SerialNumber'],
                ':UserID' => $_POST['UserID'],
                ':TradingDate' => $_POST['TradingDate'],
                ':RIType' => $_POST['RIType'],
                ':DocumentType' => $_POST['DocumentType'],
                ':Customer' => $_POST['Customer'],
                ':Amount' => $_POST['Amount'],
                ':FileName' => $_POST['SerialNumber'] . "." . substr($fname, strrpos($fname, '.') + 1),
                ':Remark' => $_POST['Remark']
            );
            $stmt->execute($params); //挿入する値が入った変数をexecuteにセットしてSQLを実行

        } catch (PDOException $e) {
            exit('データベースに接続できませんでした。' . $e->getMessage());
        }
        echo $filename . "をアップロードしました。";
    } else {
        echo "ファイルをアップロードできません。";
    }
} else {
    echo "ファイルが選択されていません。";
}

?>