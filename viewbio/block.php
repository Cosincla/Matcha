<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/Matcha/config/database.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/Matcha/init.php');
$user = $_SESSION["username"];
$person = $_GET['person'];
$sql = $conn->prepare(
    "SELECT
        `blocked_id`, `blocked_id`, `block`
    FROM
        `cosincla_matcha`.`blocks`
    WHERE
        `blocked_id` LIKE '$person' AND `blocker_id` LIKE '$user';");
$sql->execute();
$sql->setFetchMode(PDO::FETCH_ASSOC);
$stuff = $sql->fetchAll();
if (empty($stuff)){
    $sql = $conn->prepare(
        "INSERT INTO
            `cosincla_matcha`.`blocks` (`blocked_id`, `blocker_id`, `block`)
        VALUES
            (:p_bd, :p_br, :p_bk);");
    $sql->execute(array(
        ':p_bd' => $person,
        ':p_br' => $user,
        ':p_bk' => '1'
    ));
    echo '<script type=text/javascript>alert("User has been blocked"); window.location="http://localhost/Matcha/users/users.php";</script>'; 
}
else {
    foreach($stuff as $s){
        if ($s['block'] === '1'){
            $sql = $conn->prepare(
                "UPDATE
                    `cosincla_matcha`.`blocks`
                SET
                    `block` = '0'
                WHERE
                    `blocked_id` LIKE '$person' AND `blocker_id` LIKE '$user';");
            $sql->execute();
            echo '<script type=text/javascript>alert("User is no longer blocked"); window.location="http://localhost/Matcha/users/users.php";</script>'; 
        }
        else{
            $sql = $conn->prepare(
                "UPDATE
                    `cosincla_matcha`.`blocks`
                SET
                    `block` = '1'
                WHERE
                    `blocked_id` LIKE '$person' AND `blocker_id` LIKE '$user';");
            $sql->execute();
            echo '<script type=text/javascript>alert("User has been blocked"); window.location="http://localhost/Matcha/users/users.php";</script>'; 
        }
    }
}

?>