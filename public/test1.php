<style>
    body {
        background-color: rgba(0, 0, 0, 0.5);
    }
</style>

<?php
$dbh = new PDO('mysql:host=localhost;dbname=forest_union;charset=utf8', 'root', '');
$sql = "SELECT * FROM union_members WHERE 脱退年月日 is null";
$stmt = $dbh->query($sql);
while ($result = $stmt->fetch(PDO::FETCH_BOTH)) : ?>
    <div><?= $result['組合員番号'] ?>　<?= $result['氏名1'] ?></div>

<?php endwhile ?>