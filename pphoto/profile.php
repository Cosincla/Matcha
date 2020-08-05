<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/Matcha/config/database.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/Matcha/init.php');

$target_dir = "profile_photos/";
if(!is_dir($target_dir))
    mkdir($target_dir, 0755, true);
$user = $_SESSION['username'];
if (isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if ($check !== false) {
        $sql = $conn->prepare("INSERT INTO `cosincla_matcha`.`profile_photos` (`user_id`) VALUES (:p_ui)");
        $sql->execute(array(':p_ui' => $user));
        $last_id = $conn->lastInsertId();
        $new_image = $last_id.".png";
        $filename = $_FILES["fileToUpload"]["tmp_name"];
        if (move_uploaded_file($filename, $target_dir.$new_image)){
            $_SESSION['image'] = $last_id;
            header("Location: http://localhost/Matcha/pphoto/pphoto.php?image=".$last_id);
        }
        else
            echo '<script type=text/javascript>alert("There was an error while uploading your image"); window.location="http://localhost/Matcha/pphoto/pphoto.php";</script>';
    }
    else
        echo '<script type=text/javascript>alert("Image is an invalid size"); window.location="http://localhost/Matcha/pphoto/pphoto.php";</script>';
}
else
    echo '<script type=text/javascript>alert("Input is invalid"); window.location="http://localhost/Matcha/pphoto/pphoto.php";</script>';
?>