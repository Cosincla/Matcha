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
    <link rel="stylesheet" type="text/css" href="style45.css" />
</head>
<body>
<div class="right">
    <div class="rview">
        <form method="POST">
        <?php
            $user = $_SESSION['username'];
            $sql = $conn->prepare(
                "SELECT
                    `liker_id`
                FROM
                    `cosincla_matcha`.`likes`
                WHERE
                    `liked_id` LIKE '$user' AND `like` LIKE 1;");
            $sql->execute();
            $sql->setFetchMode(PDO::FETCH_ASSOC);
            $stuff = $sql->fetchAll();
            if (!empty($stuff)){
                foreach($stuff as $s){
                    ?><hr><?php
                    $lr = $s['liker_id'];
                    echo "User: ".$lr." has liked your profile.".'<a href="http://localhost/Matcha/viewbio/vbiography.php?person='.$lr.'">View Profile?</a>';
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