<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/Matcha/config/database.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/Matcha/init.php');

if (!empty($_POST["interest_1"]) && !empty($_POST["interest_2"]) && !empty($_POST["interest_3"]) && !empty($_POST["interest_4"]))
{
    $user = $_SESSION['username'];
    $i1 = $_POST["interest_1"];
    $i2 = $_POST["interest_2"];
    $i3 = $_POST["interest_3"];
    $i4 = $_POST["interest_4"];

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
    if (empty($stuff)){
        $sql = $conn->prepare("INSERT INTO `cosincla_matcha`.`interests` (`user_id`, `interest_1`, `interest_2`, `interest_3`, `interest_4`) 
        VALUES (:p_uid, :p_i, :p_in, :p_int, :p_inte);");    
        $sql->execute(array(
            ':p_uid' => $user,
            ':p_i' => $i1,
            ':p_in' => $i2,
            ':p_int' => $i3,
            ':p_inte' => $i4));
        
        $sql = $conn->prepare(
            "SELECT
                `interests`
            FROM
                `cosincla_matcha`.`users`
            WHERE
                `username` LIKE '$user';");
        $sql->execute();
        $sql->setFetchMode(PDO::FETCH_ASSOC);
        $stuff = $sql->fetchAll();
        foreach($stuff as $s){
            if ($s['interests'] === '0'){
                $sql = $conn->prepare(
                    "UPDATE
                        `cosincla_matcha`.`users`
                    SET
                        `interests` = 1
                    WHERE
                        `username` LIKE '$user';");
                $sql->execute();
            }
        }
    }
    else {
        $sql = $conn->prepare(
            "UPDATE
                `cosincla_matcha`.`interests`
            SET
                `interest_1` = '$i1',
                `interest_2` = '$i2',
                `interest_3` = '$i3',
                `interest_4` = '$i4'
            WHERE
                `user_id` LIKE '$user';");
        $sql->execute();
    }
    echo '<script type=text/javascript>alert("Interests successfully updated"); window.location="http://localhost/Matcha/users/users.php";</script>';
}
else
    echo '<script type=text/javascript>alert("Incomplete input"); window.location="http://localhost/Matcha/user_e/user_e.php";</script>';
?>