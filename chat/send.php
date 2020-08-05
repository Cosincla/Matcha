<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/Matcha/config/database.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/Matcha/init.php');

if (isset($_SESSION["username"])){
    $user = $_SESSION['username'];
    $person = $_SESSION['person'];
    if (!empty($_POST["text"])){
        $message = $_POST['text'];
        $sql = $conn->prepare(
            "INSERT INTO
                `cosincla_matcha`.`messages` (`sender`, `receiver`, `message`)
             VALUES (:p_s, :p_r, :p_m);");
        $sql->execute(array(
            ':p_s' => $user,
            ':p_r' => $person,
            ':p_m' => $message
        ));
        echo '<script type=text/javascript>window.location="http://localhost/Matcha/chat/c.php?person='.$person.'";</script>';
    }
    else
        echo '<script type=text/javascript>alert("Please do not send empty messages"); window.location="http://localhost/Matcha/chat/c.php?person='.$person.'";</script>';
}
else
    echo '<script type=text/javascript>alert("Please log in"); window.location="http://localhost/Matcha/";</script>';
?>