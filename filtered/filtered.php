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
    <link rel="stylesheet" type="text/css" href="style5707.css" />
</head>
<body style="background-color: maroon">
<div class="right">
    <div class="rview">
        <form method="POST">
        <?php
            $user = $_SESSION['username'];
            $sql = $conn->prepare(
            "SELECT
                `age`, `fame`, `distance`, `interests`, `order`
            FROM
                `cosincla_matcha`.`filters`
            WHERE
                `username` LIKE '$user';");
            $sql->execute();
            $sql->setFetchMode(PDO::FETCH_ASSOC);
            $stuff = $sql->fetchAll();
            foreach($stuff as $s){
                if ($s['age'] != NULL){
                    $age = $s['age'];
                    $age = explode("-", $age);
                    $minage = $age[0];
                    $maxage = $age[1];
                }
                if ($s['fame'] != NULL){
                    $fame = $s['fame'];
                    $fame = explode("-", $fame);
                    $minfame = $fame[0];
                    $maxfame = $fame[1];
                }
                if ($s['distance'] != NULL){
                    $dist = $s['distance'];
                    $dist = explode("-", $dist);
                    $mindist = explode("km", $dist[0]);
                    $maxdist = explode("km", $dist[1]);
                }
                if ($s['interests'] != NULL){
                    $int = $s['interests'];
                    $int = explode("-", $int);
                    $minint = $int[0];
                    $maxint = $int[1];
                }
                if ($s['order'] != NULL){
                    $order = $s['order'];
                }
            }
            $sql = $conn->prepare(
                "SELECT
                    `gender`, `preference`
                FROM
                    `cosincla_matcha`.`users`
                WHERE
                    `username` LIKE '$user';");
            $sql->execute();
            $sql->setFetchMode(PDO::FETCH_ASSOC);
            $stiff = $sql->fetchAll();
            foreach ($stiff as $t){
                $mypref = $t['preference'];
                $mygen = $t['gender'];
            }
            if ($order === "Age") {
                $sql = $conn->prepare(
                    "SELECT
                        `username`
                    FROM
                        `cosincla_matcha`.`profiles`
                    LEFT JOIN `cosincla_matcha`.`users` ON `cosincla_matcha`.`profiles`.`username` = `cosincla_matcha`.`users`.`username`
                    WHERE
                        `bio_check` LIKE 1 AND `cover_check` LIKE 1 AND `images_check` LIKE 1 AND `username` NOT lIKE '$user'
                    ORDER BY `age` ASC;");
                $sql->execute();
                $sql->setFetchMode(PDO::FETCH_ASSOC);
                $stuff = $sql->fetchAll();
            }
            if ($order === "Fame") {
                $sql = $conn->prepare(
                    "SELECT
                        `profiles`.`username`
                    FROM
                        `cosincla_matcha`.`profiles`
                    JOIN `cosincla_matcha`.`fame` ON `cosincla_matcha`.`profiles`.`username` = `cosincla_matcha`.`fame`.`username`
                    WHERE
                        `bio_check` LIKE 1 AND `cover_check` LIKE 1 AND `images_check` LIKE 1 AND `profiles`.`username` NOT lIKE '$user'
                    ORDER BY `average` DESC;");
                $sql->execute();
                $sql->setFetchMode(PDO::FETCH_ASSOC);
                $stuff = $sql->fetchAll();
            }
            if ($order === "Distance") {
                $sql = $conn->prepare(
                    "SELECT
                        `username`
                    FROM
                        `cosincla_matcha`.`profiles`
                    LEFT JOIN `cosincla_matcha`.`distance` ON (`cosincla_matcha`.`profiles`.`username` = `cosincla_matcha`.`distance`.`user_2` AND `user_1` LIKE '$user') 
                    WHERE
                        `bio_check` LIKE 1 AND `cover_check` LIKE 1 AND `images_check` LIKE 1 AND `user_2` NOT lIKE '$user'
                    ORDER BY `distance` ASC;");
                $sql->execute();
                $sql->setFetchMode(PDO::FETCH_ASSOC);
                $stuff = $sql->fetchAll();
            }
            if ($order === "Interests") {
                $sql = $conn->prepare(
                    "SELECT
                        `username`
                    FROM
                        `cosincla_matcha`.`profiles`
                    LEFT JOIN `cosincla_matcha`.`matches` ON (`cosincla_matcha`.`profiles`.`username` = `cosincla_matcha`.`matches`.`user_2` AND `user_1` LIKE '$user') 
                    WHERE
                        `bio_check` LIKE 1 AND `cover_check` LIKE 1 AND `images_check` LIKE 1 AND `user_2` NOT lIKE '$user'
                    ORDER BY `matches` DESC;");
                $sql->execute();
                $sql->setFetchMode(PDO::FETCH_ASSOC);
                $stuff = $sql->fetchAll();
            }
            else{
                $sql = $conn->prepare(
                    "SELECT
                        `username`
                    FROM
                        `cosincla_matcha`.`profiles`
                    WHERE
                        `bio_check` LIKE 1 AND `cover_check` LIKE 1 AND `images_check` LIKE 1 AND `username` NOT lIKE '$user';");
                $sql->execute();
                $sql->setFetchMode(PDO::FETCH_ASSOC);
                $stuff = $sql->fetchAll();
            }
            foreach ($stuff as $s){
                $person = $s['username'];
                $sql = $conn->prepare(
                    "SELECT
                        `age`
                    FROM
                        `cosincla_matcha`.`users`
                    WHERE
                        `username` lIKE '$person';");
                $sql->execute();
                $sql->setFetchMode(PDO::FETCH_ASSOC);
                $stiff = $sql->fetchAll();
                foreach ($stiff as $t){
                    $page = $t['age'];
                    if ($page >= $minage && $page <= $maxage){
                        $person = $s['username'];
                        $sql = $conn->prepare(
                        "SELECT
                            `rating`
                        FROM
                            `cosincla_matcha`.`ratings`
                        WHERE
                            `rated_id` lIKE '$person';");
                    $sql->execute();
                    $sql->setFetchMode(PDO::FETCH_ASSOC);
                    $stiff = $sql->fetchAll();
                    if (!empty($stiff)){
                        $total = 0;
                        $count = 0;
                        foreach ($stiff as $t){
                            $count++;
                            $rate = $t['rating'];
                            $total = $total + $rate;
                        }
                        $average = $total / $count;
                        if ($average >= $minfame && $average <= $maxfame) {
                            $person = $s['username'];
                            $sql = $conn->prepare(
                            "SELECT
                                `distance`
                            FROM
                                `cosincla_matcha`.`distance`
                            WHERE
                                `user_1` LIKE '$user' AND `user_2` LIKE '$person';");
                            $sql->execute();
                            $sql->setFetchMode(PDO::FETCH_ASSOC);
                            $stiff = $sql->fetchAll();
                            foreach ($stiff as $t){
                                $dista = $t['distance'];
                                if ($dista >= $mindist[0] && $dista <= $maxdist[0]){
                                    $sql = $conn->prepare(
                                        "SELECT
                                            `matches`
                                        FROM
                                            `cosincla_matcha`.`matches`
                                        WHERE
                                            `user_1` LIKE '$user' AND `user_2` LIKE '$person';");
                                    $sql->execute();
                                    $sql->setFetchMode(PDO::FETCH_ASSOC);
                                    $stiff = $sql->fetchAll();
                                    foreach ($stiff as $t){
                                        $mat = $t['matches'];
                                    }
                                    if ($mat >= $minint && $mat <= $maxint){
                                       $sql = $conn->prepare(
                                        "SELECT
                                            `gender`, `preference`
                                        FROM
                                            `cosincla_matcha`.`users`
                                        WHERE
                                            `username` LIKE '$person';");
                                        $sql->execute();
                                        $sql->setFetchMode(PDO::FETCH_ASSOC);
                                        $stiff = $sql->fetchAll();
                                        foreach ($stiff as $t){
                                            $pref = $t['preference'];
                                            $gen = $t['gender'];
                                        }
                                        if (($mypref == $gen || $mypref == "Both") && ($pref == $mygen || $pref == "Both")){
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
                                                    href='http://localhost/Matcha/viewbio/vbiography.php?person=$person'>View Profile<a>"; ?>
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
                                                            $stiff = $sql->fetchAll();
                                                            if (empty($stiff))
                                                                echo "background-image: url('https://i.imgur.com/3RPJcXd.png');";
                                                            else{
                                                                foreach ($stiff as $s){
                                                                    echo "background-image: url('http://localhost/Matcha/pphoto/profile_photos/".$s['id'].".png');";
                                                                }
                                                            }
                                                        ?>">
                                                    </div>
                                                    <img style="margin-top: -7%; width: 100%; border-radius: 15px; position absolute" src="/Matcha/myprofile/cover_images/upload/<?php echo $lemon.".png"; ?>">
                                                </div>
                                            </div><?php
                                            }
                                        } 
                                    }
                                }
                            }
                        }
                    }
                }
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