<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/Matcha/config/database.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/Matcha/init.php');

if (isset($_SESSION['username'])){
    $user = $_SESSION['username'];
    $sql = $conn->prepare(
        "SELECT
            `interest_1`,
            `interest_2`,
            `interest_3`,
            `interest_4`
        FROM
            `cosincla_matcha`.`interests`
        WHERE
            `user_id` LIKE '$user';");
    $sql->execute();
    $sql->setFetchMode(PDO::FETCH_ASSOC);
    $stuff = $sql->fetchAll();
    foreach($stuff as $s){
        $myint1 = $s['interest_1'];
        $myint2 = $s['interest_2'];
        $myint3 = $s['interest_3'];
        $myint4 = $s['interest_4'];
    }
    $sql = $conn->prepare(
        "SELECT
            `user_id`,
            `interest_1`,
            `interest_2`,
            `interest_3`,
            `interest_4`
        FROM
            `cosincla_matcha`.`interests`
        WHERE
            `user_id` NOT LIKE '$user';");
    $sql->execute();
    $sql->setFetchMode(PDO::FETCH_ASSOC);
    $stuff = $sql->fetchAll();
    foreach($stuff as $s){
        $int1 = $s['interest_1'];
        $int2 = $s['interest_2'];
        $int3 = $s['interest_3'];
        $int4 = $s['interest_4'];
        $person = $s['user_id'];
        $match = 0;
        if ($myint1 == $int1 || $myint1 == $int2 || $myint1 == $int3 || $myint1 == $int4)
            $match++;
        if ($myint2 == $int1 || $myint2 == $int2 || $myint2 == $int3 || $myint2 == $int4)
            $match++;
        if ($myint3 == $int1 || $myint3 == $int2 || $myint3 == $int3 || $myint3 == $int4)
            $match++;
        if ($myint4 == $int1 || $myint4 == $int2 || $myint4 == $int3 || $myint4 == $int4)
            $match++;
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
        if (empty($stiff)){
            $sql = $conn->prepare(
                "INSERT INTO
                    `cosincla_matcha`.`matches` (`matches`, `user_1`, `user_2`)
                VALUES
                    (:p_m, :p_u1, :p_u2)");
            $sql->execute(array(
                ':p_m' => $match,
                ':p_u1' => $user,
                ':p_u2' => $person
            ));
        }
        else {
            $sql = $conn->prepare(
                "UPDATE
                    `cosincla_matcha`.`matches`
                SET
                    `matches` = '$match'
                WHERE
                    `user_1` LIKE '$user' AND `user_2` LIKE '$person';");
            $sql->execute(array(
                ':p_m' => $match,
                ':p_u1' => $user,
                ':p_u2' => $person
            ));
        }
    }
}