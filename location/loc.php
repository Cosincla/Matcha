<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/Matcha/config/database.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/Matcha/init.php');

if (!empty($_POST["city"]) && !empty($_POST["region"]) && !empty($_POST["post"])) {
    $user = $_SESSION['username'];
    $city = $_POST["city"];
    $reg = $_POST["region"];
    $post = $_POST["post"];

    $details = json_decode(file_get_contents('https://maps.google.com/maps/api/geocode/json?address='.$city.'%20'.$reg.'%20'.$post.'&key=AIzaSyBna3Dy8MvDeppDhgkEM06ddl7YJoYnAyI', true));
    $lat_1 = $details->results[0]->geometry->bounds->northeast->lat;
    $lng_1 = $details->results[0]->geometry->bounds->northeast->lng;
    $lat_2 = $details->results[0]->geometry->bounds->northeast->lat;
    $lng_2 = $details->results[0]->geometry->bounds->northeast->lng;
    $lat = ($lat_1 + $lat_2) / 2;
    $long = ($lng_1 + $lng_2) / 2;

    $sql = $conn->prepare(
        "SELECT
            `tracker`
        FROM
            `cosincla_matcha`.`location`
        WHERE
            `user_id` LIKE '$user';");
    $sql->execute();
    $sql->setFetchMode(PDO::FETCH_ASSOC);
    $stuff = $sql->fetchAll();
    foreach($stuff as $s) {
        if ($s['tracker'] == 1){
            $sql = $conn->prepare(
                "UPDATE
                    `cosincla_matcha`.`location`
                SET
                    `tracker` = 0
                WHERE
                    `user_id` LIKE '$user';");
            $sql->execute();
        }
    }
    $sql = $conn->prepare(
        "UPDATE
            `cosincla_matcha`.`location`
        SET
            `latitude` = '$lat',
            `longitude` = '$long',
            `city` = '$city',
            `region` = '$reg',
            `code` = '$post'
        WHERE
            `user_id` LIKE '$user';");
    $sql->execute();
    echo '<script type=text/javascript>alert("Location is now set"); window.location="http://localhost/Matcha/users/users.php";</script>';
}
else
    echo '<script type=text/javascript>alert("Incomplete input"); window.location="http://localhost/Matcha/user_e/user_e.php";</script>';
?>