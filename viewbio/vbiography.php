<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/Matcha/config/database.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/Matcha/init.php');

if (isset($_SESSION["username"])){
    $user = $_SESSION["username"];
    $person = $_GET['person'];

    $sql = $conn->prepare(
        "SELECT
            `visits`
        FROM
            `cosincla_matcha`.`visits`
        WHERE
            `visitor` LIKE '$user' AND `visited` LIKE '$person';");
    $sql->execute();
    $sql->setFetchMode(PDO::FETCH_ASSOC);
    $stuff = $sql->fetchAll();
    if (empty($stuff)){
        $sql = $conn->prepare(
            "INSERT INTO
                `cosincla_matcha`.`visits` (`visited`, `visitor`, `visits`)
            VALUES
                (:p_vd, :p_vr, :p_vs);");
        $sql->execute(array(
            ':p_vd' => $person,
            ':p_vr' => $user,
            ':p_vs' => 1
        ));
    }
    else {
        foreach ($stuff as $s){
            $old = $s['visits'];
        }
        $new = $old + 1;
        $sql = $conn->prepare(
            "UPDATE
                `cosincla_matcha`.`visits`
            SET
                `visits` = '$new'
            WHERE
                `visitor` LIKE '$user' AND `visited` LIKE '$person';");
        $sql->execute();
    }

?><!doctype <!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Matcha</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="style290.css">
</head>
<body>
<div class="header">
    <div class="profile" style="position: absolute; border-radius: 250px; width: 5vw; height: 5vw; text-align: center; background-size: cover; background-repeat: no-repeat; background-position: center center;
        <?php
            $sql = $conn->prepare(
                "SELECT
                    `id`
                FROM
                    `cosincla_matcha`.`profile_photos`
                WHERE
                    `user_id` LIKE '$person' AND `selected` LIKE '1';");
            $sql->execute();
            $sql->setFetchMode(PDO::FETCH_ASSOC);
            $stuff = $sql->fetchAll();
            if (empty($stuff))
                echo "background-image: url('https://i.imgur.com/3RPJcXd.png');";
            else{
                foreach ($stuff as $s){
                    echo "background-image: url('http://localhost/Matcha/pphoto/profile_photos/".$s['id'].".png');";
                }
            }
        ?>">
    </div>
    <p style="text-align: center"><u><?php echo $person;?></u></p>
<div>
    <div class="lbox">
        <div class="ubox">
        <?php 
            $sql = $conn->prepare(
                "SELECT
                    `cover_image`
                FROM
                    `cosincla_matcha`.`profiles`
                WHERE
                    `username` LIKE '$person';");
            $sql->execute();
            $sql->setFetchMode(PDO::FETCH_ASSOC);
            $stuff = $sql->fetchAll();
            foreach ($stuff as $s){
                    $pic = $s['cover_image'];
                    ?><div style="border-radius: 15px; width: 100%; height: 100%; background-size: cover; background-repeat: no-repeat; background-position: center center;
                    <?php 
                        echo "background-image: url('../myprofile/cover_images/upload/".$pic.".png');";
                    ?>">
                    </div><?php
                }
        ?>
        </div>
        <div class="bbox" style="font-size: 1vw;">
            <?php
                $sql = $conn->prepare(
                    "SELECT
                        `bio`
                    FROM
                        `cosincla_matcha`.`profiles`
                    WHERE
                        `username` LIKE '$person';");
                $sql->execute();
                $sql->setFetchMode(PDO::FETCH_ASSOC);
                $stuff = $sql->fetchAll();
                foreach ($stuff as $s){
                    echo $s['bio'];
                }
            ?>
        </div>
        <button onclick="window.location='http://localhost/Matcha/viewbio/block.php?person=<?php echo $person; ?>'">Block user</button>
        <button onclick="window.location='http://localhost/Matcha/viewbio/like.php?person=<?php echo $person; ?>'">Like user</button>
        <button onclick="window.location='http://localhost/Matcha/rating/rate.php?person=<?php echo $person; ?>'">Rate user</button>
    </div>
    <div class="rbox">
        <p style="text-align: center"><u>Photos</u></p>
        <hr>
        <p style="font-size: 0.7vw;"><?php     
            $sql = $conn->prepare(
                "SELECT
                    COUNT(`rating`) AS 'rates'
                FROM
                    `cosincla_matcha`.`ratings`
                WHERE
                    `rated_id` LIKE '$person';");
            $sql->execute();
            $sql->setFetchMode(PDO::FETCH_ASSOC);
            $stuff = $sql->fetchAll();
            foreach($stuff as $s){
                $rates = $s['rates'];
            }
            if ($rates != 0){
                $sql = $conn->prepare(
                    "SELECT
                        `rating`
                    FROM
                        `cosincla_matcha`.`ratings`
                    WHERE
                        `rated_id` LIKE '$person';");
                $sql->execute();
                $sql->setFetchMode(PDO::FETCH_ASSOC);
                $stuff = $sql->fetchAll();
                $total = 0;
                foreach($stuff as $s){
                    $total = $total + $s['rating'];
                }
                if ($total != 0 && $rates != 0){
                    $num = round($total / $rates);
                    echo "This user has an avereage rating of ".$num."/10 from ".$rates." user(s).";
                }
            }
        ?></p>
        <div class="lview">
        <?php
            $sql = $conn->prepare(
                "SELECT
                    COUNT(`id`) AS 'images'
                FROM
                    `cosincla_matcha`.`uploads`
                WHERE
                    `image_creator` LIKE '$person' && `image_id` NOT LIKE 'cover' && `image_id` NOT LIKE 'replacement';");
            $sql->execute();
            $sql->setFetchMode(PDO::FETCH_ASSOC);
            $stuff = $sql->fetchAll();
            foreach($stuff as $s){
                $sql = $conn->prepare(
                    "SELECT
                        `image_id`
                    FROM
                        `cosincla_matcha`.`uploads`
                    WHERE
                        `image_creator` LIKE '$person' AND `image_id` NOT LIKE 'cover' AND `image_id` NOT LIKE 'replacement';");
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
                href='http://localhost/Matcha/myprofile/del.php?image=$lemon'><a>";?>
                <img style="width: 100%; border-radius: 15px" src="/Matcha/myprofile/gallery/upload/<?php echo $s['image_id'].".png"; ?>">
                <?php
                }
            }
        ?>
        </div>
    </div>
    <div class="rrbox">
        <p style="text-align: center"><u>Information</u></p>
        <hr>
        <div class="rrview">
            <?php
            $sql = $conn->prepare(
                "SELECT
                    `name`, `surname`, `age`
                FROM
                    `cosincla_matcha`.`users`
                WHERE
                    `username` LIKE '$person';");
            $sql->execute();
            $sql->setFetchMode(PDO::FETCH_ASSOC);
            $stuff = $sql->fetchAll();
            foreach ($stuff as $s){
                $name = $s['name'];
                $sname = $s['surname'];
                $age = $s['age'];
            }
            $sql = $conn->prepare(
                "SELECT
                    `city`
                FROM
                    `cosincla_matcha`.`location`
                WHERE
                    `user_id` LIKE '$person';");
            $sql->execute();
            $sql->setFetchMode(PDO::FETCH_ASSOC);
            $stuff = $sql->fetchAll();
            foreach ($stuff as $s){
                $city = $s['city'];
            }
            ?>
            <p style="text-align: center">Name: <?php echo $name." ".$sname;?></u></p>
            <p style="text-align: center">Age: <?php echo $age;?></u></p>
            <p style="text-align: center">City: <?php echo $city;?></u></p>
        </div>
    </div> 
</div>
<div class="footer">
<div class="footer">
    <div class="back">
        <a href="http://localhost/Matcha/users/users.php"><p style="text-align: center">Back</p></A>
    </div>
</div>
</body>
</html>
<?php
}
else
    echo '<script type=text/javascript>alert("Please log in"); window.location="http://localhost/Matcha/";</script>';
?>