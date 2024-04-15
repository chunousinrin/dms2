<style>
    body {
        background-color: rgba(0, 0, 0, 0.5);
    }
</style>

<?php
$dbh = new PDO('mysql:host=localhost;dbname=dms;charset=utf8', 'root', '');
$sql = "SELECT * FROM conf_jforestlogo";
$stmt = $dbh->query($sql);
$result = $stmt->fetch(); ?>

<?php echo '<img style="opacity:0.8;bottom:0;width:auto;height:100px;" src="data:image/svg+xml;base64,' . base64_encode($result['JforestColor']) . '" >'; ?>
<?php echo '<img style="opacity:0.8;bottom:0;width:auto;height:100px;" src="data:image/svg+xml;base64,' . base64_encode($result['JforestWhite']) . '" >'; ?>