<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/Matcha/config/database.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/Matcha/init.php');

$del = $_SESSION['delete'];
if (isset($_POST['yes'])){
    $sql = $conn->prepare(
        "DELETE FROM
            `cosincla_matcha`.`uploads`
        WHERE
            `image_id` LIKE '$del';");
    $sql->execute();
    echo '<script type=text/javascript>alert("Image deleted"); window.location="http://localhost/Matcha/myprofile/my.php";</script>';
}
if (isset($_POST['no'])){
    echo '<script type=text/javascript>alert("Image will not be deleted"); window.location="http://localhost/Matcha/myprofile/my.php";</script>';
}
?>