<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/Matcha/config/database.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/Matcha/init.php');

if (!empty($_POST['uname'])){
    $uname = $_POST['uname'];
    $user = $_SESSION['username'];

    $sql = $conn->prepare(
        "UPDATE
            `cosincla_matcha`.`profile_photos`
        SET
            `user_id` = '$uname'
        WHERE
            `user_id` LIKE '$user';");
    $sql->execute();

    $sql = $conn->prepare(
        "UPDATE
            `cosincla_matcha`.`uploads`
        SET
            `image_creator` = '$uname'
        WHERE
            `image_creator` LIKE '$user';");
    $sql->execute();

    $sql = $conn->prepare(
        "UPDATE
            `cosincla_matcha`.`users`
        SET
            `username` = '$uname'
        WHERE
            `username` LIKE '$user';");
    $sql->execute();
    
    $_SESSION['username'] = $uname;
    echo '<script type=text/javascript>alert("Username changed successfully"); window.location="http://localhost/Matcha/main_page/mp.php";</script>';
}
else
    echo '<script type=text/javascript>alert("Invalid input"); window.location="http://localhost/Matcha/user_e/user_e.php";</script>';
?>