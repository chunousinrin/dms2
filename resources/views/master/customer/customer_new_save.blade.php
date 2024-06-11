<?php
try {
    $PDO = new PDO('mysql:host=localhost;dbname=' . env('DB_DATABASE') . ';charset=utf8', env('DB_USERNAME'), env('DB_PASSWORD'));
    $PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //PDOのエラーレポートを表示

    //input.phpの値を取得
    $cname = $_POST['cname'];
    $post_code = $_POST['zip01'];
    $address1 = $_POST['addr11'];
    $address2 = $_POST['addr12'];
    $phone = $_POST['cphone'];
    $email = $_POST['cemail'];
    $remark = $_POST['cremark'];

    $sql = "INSERT INTO customer (
    name,
    post_code,
    address1,
    address2,
    phone,
    email,
    remark)
    VALUES (
    :name,
    :post_code,
    :address1,
    :address2,
    :phone,
    :email,
    :remark)";
    $stmt = $PDO->prepare($sql); //値が空のままSQL文をセット
    $params = array(
        ':name' => $cname,
        ':post_code' => $post_code,
        ':address1' => $address1,
        ':address2' => $address2,
        ':phone' => $phone,
        ':email' => $email,
        ':remark' => $remark
    );
    $stmt->execute($params); //挿入する値が入った変数をexecuteにセットしてSQLを実行

} catch (PDOException $e) {
    exit('データベースに接続できませんでした。' . $e->getMessage());
}
?>

<p>登録完了</p>