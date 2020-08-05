<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/Matcha/config/database.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/Matcha/init.php');

$sql = $conn->prepare(
    "SELECT
        `username`
    FROM
        `cosincla_matcha`.`profiles`
    WHERE
        `bio_check` LIKE 1 AND `cover_check` LIKE 1 AND `images_check` LIKE 1;");
$sql->execute();
$sql->setFetchMode(PDO::FETCH_ASSOC);
$stuff = $sql->fetchAll();
foreach ($stuff as $s){
    $person = $s['username'];
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
        $stiff = $sql->fetchAll();
        $total = 0;
        foreach($stiff as $i){
            $total = $total + $i['rating'];
            }
        if ($total != 0){
            $num = round($total / $rates);
        }
    }
    else {
        $num = 0;
    }
    
    $sql = $conn->prepare(
        "SELECT
            `average`
        FROM
            `cosincla_matcha`.`fame`
        WHERE
            `username` LIKE '$person';");
    $sql->execute();
    $sql->setFetchMode(PDO::FETCH_ASSOC);
    $stoff = $sql->fetchAll();
    if (empty($stoff)){
        $sql = $conn->prepare(
            "INSERT INTO
                `cosincla_matcha`.`fame` (`username`, `average`)
            VALUES
                (:p_u, :p_a)");
        $sql->execute(array(
            ':p_u' => $person,
            ':p_a' => $num
        ));
    }
    else {
        $sql = $conn->prepare(
            "UPDATE
                `cosincla_matcha`.`fame`
            SET
                `average` = '$num'
            WHERE
                `username` LIKE '$person';");
        $sql->execute();
    }
}