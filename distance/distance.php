<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/Matcha/config/database.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/Matcha/init.php');

if (isset($_SESSION['username'])){
    $user = $_SESSION['username'];
    $sql = $conn->prepare(
        "SELECT
            `latitude`, `longitude`
        FROM
            `cosincla_matcha`.`location`
        WHERE
            `user_id` LIKE '$user';");
    $sql->execute();
    $sql->setFetchMode(PDO::FETCH_ASSOC);
    $stuff = $sql->fetchAll();
    if (!empty($stuff)){
        foreach($stuff as $s){
            $mylat = $s['latitude'];
            $mylong = $s['longitude'];
        }
        $sql = $conn->prepare(
            "SELECT
                `user_id`, `latitude`, `longitude`
            FROM
                `cosincla_matcha`.`location`
            WHERE
                `user_id` NOT LIKE '$user';");
        $sql->execute();
        $sql->setFetchMode(PDO::FETCH_ASSOC);
        $stuff = $sql->fetchAll();
        if (!empty($stuff)){
                foreach($stuff as $s){
                $person = $s['user_id'];
                $lat = $s['latitude'];
                $long = $s['longitude'];
                $dist = round(ABS(
                    ACOS(
                        SIN(($lat / 180 * 3.141592)) * 
                        SIN(($mylat / 180 * 3.141592)) + 
                        COS(($lat / 180 * 3.141592)) * 
                        COS(($mylat / 180 * 3.141592)) * 
                        COS(($mylong / 180 * 3.141592) - 
                        ($long / 180 * 3.141592)))) * 6371);
                $sql = $conn->prepare(
                    "SELECT
                        `distance`
                    FROM
                        `cosincla_matcha`.`distance`
                    WHERE
                        `user_1` LIKE '$user' AND `user_2` LIKE '$person';");
                $sql->execute();
                $sql->setFetchMode(PDO::FETCH_ASSOC);
                $stuff = $sql->fetchAll();
                if (empty($stuff)){
                    $sql = $conn->prepare(
                        "INSERT INTO
                            `cosincla_matcha`.`distance`
                        VALUES
                            (:p_u1, :p_u2, :p_d)");
                    $sql->execute(array(
                        'p_u1' => $user,
                        'p_u2' => $person,
                        'p_d' => $dist
                    ));
                }
                else {
                    $sql = $conn->prepare(
                        "UPDATE
                            `cosincla_matcha`.`distance`
                        SET
                            `distance` = '$dist'
                        WHERE
                            `user_1` LIKE '$user' AND `user_2` LIKE '$person';");
                    $sql->execute();
                }
            }
        }
    }
}