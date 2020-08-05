<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/Matcha/config/database.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/Matcha/init.php');

if (isset($_SESSION["username"])){
    
    $user = $_SESSION["username"];

    $sql = $conn->prepare(
        "SELECT
            `username`
        FROM
            `cosincla_matcha`.`profiles`
        WHERE
            `username` LIKE '$user';");
    $sql->execute();
    $sql->setFetchMode(PDO::FETCH_ASSOC);
    $stuff = $sql->fetchAll();
    if (empty($stuff)){
        $sql = $conn->prepare("INSERT INTO `cosincla_matcha`.`profiles` (`username`)
             VALUES (:p_u);");
        $sql->execute(array(':p_u' => $user));
    }
    $sql = $conn->prepare(
        "SELECT
            `bio_check`,
            `cover_check`,
            `images_check`
        FROM
            `cosincla_matcha`.`profiles`
        WHERE
            `username` LIKE '$user';");
    $sql->execute();
    $sql->setFetchMode(PDO::FETCH_ASSOC);
    $stuff = $sql->fetchAll();
    foreach($stuff as $s){
        $b = $s['bio_check'];
        $c = $s['cover_check'];
        $i = $s['images_check'];
    }
    if ($b === '0'){
        echo '<script type=text/javascript>alert("Please add a Biography");</script>';
    }
    if ($c === '0'){
        echo '<script type=text/javascript>alert("Please add a Cover Image");</script>';
    }
    if ($i === '0'){
        echo '<script type=text/javascript>alert("Please add between one and five images to your gallery");</script>';
    }
    if (($b === '1') && ($c === '1') && ($i === '1')){
        $sql = $conn->prepare(
            "UPDATE
                `cosincla_matcha`.`users`
            SET
                `pictures` = 1
            WHERE
                `username` LIKE '$user';");
        $sql->execute();
    }
    if (($b === '0') || ($c === '0') || ($i === '0')) {
        $sql = $conn->prepare(
            "UPDATE
                `cosincla_matcha`.`users`
            SET
                `pictures` = 0
            WHERE
                `username` LIKE '$user';");
        $sql->execute();
    }
    ?><!doctype <!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Matcha</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="style29.css">
</head>
<body>
<div class="header">
    <div class="profile" style="position: absolute; border-radius: 250px; width: 5vw; height: 5vw; text-align: center; background-size: cover; background-repeat: no-repeat; background-position: center center;
        <?php 
            echo "background-image: url('".$_SESSION['profile']."');";
        ?>">
    </div>
    <p style="text-align: center"><u>My Profile</u></p>
<div>
    <div class="lbox">
        <div class="ubox">
        <?php 
            $sql = $conn->prepare(
                "SELECT
                    `cover_check`, `cover_image`
                FROM
                    `cosincla_matcha`.`profiles`
                WHERE
                    `username` LIKE '$user';");
            $sql->execute();
            $sql->setFetchMode(PDO::FETCH_ASSOC);
            $stuff = $sql->fetchAll();
            if (!empty($stuff)){
                foreach ($stuff as $s){
                    if ($s['cover_check'] === '1'){
                        $pic = $s['cover_image'];
                        ?><div style="border-radius: 15px; width: 100%; height: 100%; background-size: cover; background-repeat: no-repeat; background-position: center center;
                        <?php 
                            echo "background-image: url('cover_images/upload/".$pic.".png');";
                        ?>">
                        </div><?php
                    }
                }
            }
        ?>
        </div>
        <button onclick="window.location='http://localhost/Matcha/myprofile/cover_images/cover.php'">Upload/Take Photo</button>
        <div class="bbox">
            <?php
                $sql = $conn->prepare(
                    "SELECT
                        `bio`
                    FROM
                        `cosincla_matcha`.`profiles`
                    WHERE
                        `username` LIKE '$user';");
                $sql->execute();
                $sql->setFetchMode(PDO::FETCH_ASSOC);
                $stuff = $sql->fetchAll();
                foreach ($stuff as $s){
                    echo $s['bio'];
                }
            ?>
        </div>
        <button onclick="window.location='http://localhost/Matcha/myprofile/biography/biography.php'">Edit Biography</button>
    </div>
    <div class="rbox">
        <p style="text-align: center"><u>Photos</u></p>
        <hr>
        <div class="lview">
        <?php
            $sql = $conn->prepare(
                "SELECT
                    COUNT(`id`) AS 'images'
                FROM
                    `cosincla_matcha`.`uploads`
                WHERE
                    `image_creator` LIKE '$user' && `image_id` NOT LIKE 'cover' && `image_id` NOT LIKE 'replacement';");
            $sql->execute();
            $sql->setFetchMode(PDO::FETCH_ASSOC);
            $stuff = $sql->fetchAll();
            foreach($stuff as $s){
                if ($s['images'] === '0'){
                    $sql = $conn->prepare(
                        "UPDATE
                            `cosincla_matcha`.`profiles`
                        SET
                            `images_check` = 0
                        WHERE
                            `username` LIKE '$user';");
                    $sql->execute();
                    echo '<script type=text/javascript>alert("You have no images");</script>';
                }
                else{
                    if ($s['images'] > 5){
                        $sql = $conn->prepare(
                            "UPDATE
                                `cosincla_matcha`.`profiles`
                            SET
                                `images_check` = 0
                            WHERE
                                `username` LIKE '$user';");
                        $sql->execute();
                        echo '<script type=text/javascript>alert("You have too many images, maximum amount is five pictures");</script>';
                    }
                    else{
                        $sql = $conn->prepare(
                            "UPDATE
                                `cosincla_matcha`.`profiles`
                            SET
                                `images_check` = 1
                            WHERE
                                `username` LIKE '$user';");
                        $sql->execute();
                    }
                    $sql = $conn->prepare(
                        "SELECT
                            `image_id`
                        FROM
                            `cosincla_matcha`.`uploads`
                        WHERE
                            `image_creator` LIKE '$user' AND `image_id` NOT LIKE 'cover' AND `image_id` NOT LIKE 'replacement';");
                    $sql->execute();
                    $sql->setFetchMode(PDO::FETCH_ASSOC);
                    $stuff = $sql->fetchAll();
                    foreach($stuff as $s){
                    $lemon = $s['image_id'];
                    echo "<a style='font-size: 1vw;
                    position: relative;
                    width: 6vw;
                    height: 3vw;
                    margin-left: 0%;
                    margin-top: 1000%;
                    background-color: #B4B0B0;
                    border-radius: 15px;
                    padding: 4px;';
                    href='http://localhost/Matcha/myprofile/del.php?image=$lemon'>Delete<a>";?>
                    <img style="width: 100%; border-radius: 15px" src="/Matcha/myprofile/gallery/upload/<?php echo $s['image_id'].".png"; ?>">
                    <?php
                    }
                }
            }
        ?>
        </div>
        <button onclick="window.location='http://localhost/Matcha/myprofile/gallery/gall.php'">Upload/Take Photo</button>
    </div>
</div>
<div class="footer">
<div class="back">
        <a href="http://localhost/Matcha/users/users.php"><p style="text-align: center">Back</p></A>
    </div>
</div>
</body>
</html>
<?php }
else
    echo '<script type=text/javascript>alert("Please log in"); window.location="http://localhost/Matcha/";</script>';
?>