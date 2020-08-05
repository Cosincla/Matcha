<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/Matcha/config/database.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/Matcha/init.php');

$user = $_SESSION["username"];
$person = $_GET['person']; 
$sql = $conn->prepare(
    "UPDATE
        `cosincla_matcha`.`blocks`
    SET
        `block` = 0
    WHERE
        `blocker_id` LIKE '$user' AND `blocked_id` LIKE '$person';");
$sql->execute();
echo '<script type=text/javascript>alert("User has been unblocked"); window.location="http://localhost/Matcha/users/users.php";</script>';