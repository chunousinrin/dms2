<?php
try {
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //PDOのエラーレポートを表示

    $stmt = $dbh->prepare('UPDATE customer SET 
        name = :name,
        post_code = :post_code,
        address1 = :address1,
        address2 = :address2,
        phone = :phone,
        email = :email,
        Remark = :Remark
        WHERE CustomerID = :CustomerID
        ');

    $stmt->execute(
        array(
            ':name' => $_POST['cname'],
            ':post_code' => $_POST['zip01'],
            ':address1' => $_POST['addr11'],
            ':address2' => $_POST['addr12'],
            ':phone' => $_POST['cphone'],
            ':email' => $_POST['cemail'],
            ':Remark' => $_POST['cremark'],
            ':CustomerID' => $_POST['CustomerID']
        )
    );
} catch (PDOException $e) {
    exit('データベースに接続できませんでした。' . $e->getMessage());
}

?>
<p>変更を保存しました</p>