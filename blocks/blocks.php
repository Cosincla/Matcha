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
    <link rel="stylesheet" type="text/css" href="style570.css" />
</head>
<body style="background-color: maroon">
<div class="right">
    <div class="rview">
        <form method="POST">
        <?php
            $user = $_SESSION["username"];
            $sql = $conn->prepare(
                "SELECT
                    `blocked_id`
                FROM
                    `cosincla_matcha`.`blocks`
                WHERE
                    `blocker_id` LIKE '$user' AND `block` LIKE '1';");
            $sql->execute();
			$sql->setFetchMode(PDO::FETCH_ASSOC);
			$stuff = $sql->fetchAll();
            foreach($stuff as $s){
                $person = $s['blocked_id']; 
                $sql = $conn->prepare(
                    "SELECT
                        `cover_image`
                    FROM
                        `cosincla_matcha`.`profiles`
                    WHERE
                        `username` LIKE '$person';");
                    $sql->execute();
                    $sql->setFetchMode(PDO::FETCH_ASSOC);
                    $stiff = $sql->fetchAll();
                    foreach ($stiff as $t){
                        $lemon = $t['cover_image'];
                ?>
                <?php echo "<a style='font-size: 1vw;
                            position: relative;
                            width: 6vw;
                            height: 3vw;
                            margin-left: 5%;
                            margin-top: 1000%;
                            background-color: #B4B0B0;
                            border-radius: 15px;
                            padding: 4px;';
                            href='http://localhost/Matcha/blocks/unblock.php?person=$person'>Unblock<a>"; ?>
                <div style="margin-top: -7%;">
                    <div style="width: 100%; border-radius: 15px;">
                        <div class="profile" style="margin-top: 7%; position: relative; marginborder-radius: 250px; width: 5vw; height: 5vw; text-align: center; background-size: cover; background-repeat: no-repeat; background-position: center center;
                            <?php
                                $sql = $conn->prepare(
                                    "SELECT
                                        `id`
                                    FROM
                                        `cosincla_matcha`.`profile_photos`
                                    WHERE
                                        `user_id` LIKE '$person' AND `selected` = 1
                                    ;");
                                $sql->execute();

                                $sql->setFetchMode(PDO::FETCH_ASSOC);
                                $staff = $sql->fetchAll();
                                foreach($staff as $a){
                                    $image = "/Matcha/pphoto/profile_photos/".$a['id'].".png";
                                }
                                echo "background-image: url('".$image."');";
                            ?>">
                        </div>
                        <img style="margin-top: -7%; width: 100%; border-radius: 15px; position absolute" src="/Matcha/myprofile/cover_images/upload/<?php echo $lemon.".png"; ?>">
                    </div>
                </div>
            <?php }}?>
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