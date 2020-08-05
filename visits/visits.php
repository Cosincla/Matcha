<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/Matcha/config/database.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/Matcha/init.php');

?>
<!doctype <!DOCTYPE html>
<html>
<head>
    <title>Matcha</title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="style5.css" />
</head>
<body>
<div class="right">
    <div class="rview">
        <form method="POST">
        <?php
            $user = $_SESSION['username'];
            $sql = $conn->prepare(
                "SELECT
                    `visits`, `visitor`
                FROM
                    `cosincla_matcha`.`visits`
                WHERE
                    `visited` LIKE '$user';");
            $sql->execute();
            $sql->setFetchMode(PDO::FETCH_ASSOC);
            $stuff = $sql->fetchAll();
            if (!empty($stuff)){
                foreach($stuff as $s){
                    ?><hr><?php
                    $vr = $s['visitor'];
                    $vs = $s['visits'];
                    echo "User: ".$vr." has visited your profile ".$vs." times.";
                    ?><hr><?php
                }
            }
        ?>
        </form>
    </div>
</div>
<div class="footer">
    <div class="back" onclick="goBack()">
        <script>function goBack() {window.history.back();}</script><p style="text-align: center">Back</p></A>
    </div>
</div>
</body>
<footer id="footer">
	<p>&copy; Terms and conditions apply.<br>cosincla2018.</p>
</footer>
</html>