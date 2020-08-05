<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/Matcha/config/database.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/Matcha/init.php');
$user = $_SESSION["username"];
$person = $_GET['person'];
$sql = $conn->prepare(
    "SELECT
        `liked_id`, `liker_id`, `like`
    FROM
        `cosincla_matcha`.`likes`
    WHERE
        `liked_id` LIKE '$person' AND `liker_id` LIKE '$user';");
$sql->execute();
$sql->setFetchMode(PDO::FETCH_ASSOC);
$stuff = $sql->fetchAll();
if (empty($stuff)){
    $sql = $conn->prepare(
        "INSERT INTO
            `cosincla_matcha`.`likes` (`liked_id`, `liker_id`, `like`)
        VALUES
            (:p_ld, :p_lr, :p_lk);");
    $sql->execute(array(
        ':p_ld' => $person,
        ':p_lr' => $user,
        ':p_lk' => '1'
    ));
    echo '<script type=text/javascript>alert("User has been liked"); window.location="http://localhost/Matcha/users/users.php";</script>'; 
}
else {
    foreach($stuff as $s){
        if ($s['like'] === '1'){
            $sql = $conn->prepare(
                "UPDATE
                    `cosincla_matcha`.`likes`
                SET
                    `like` = '0'
                WHERE
                    `liked_id` LIKE '$person' AND `liker_id` LIKE '$user';");
            $sql->execute();
            echo '<script type=text/javascript>alert("User is no longer liked"); window.location="http://localhost/Matcha/users/users.php";</script>'; 
        }
        else{
            $sql = $conn->prepare(
                "UPDATE
                    `cosincla_matcha`.`likes`
                SET
                    `like` = '1'
                WHERE
                    `liked_id` LIKE '$person' AND `liker_id` LIKE '$user';");
            $sql->execute();
            echo '<script type=text/javascript>alert("User has been liked"); window.location="http://localhost/Matcha/users/users.php";</script>'; 
        }
    }
}

?>