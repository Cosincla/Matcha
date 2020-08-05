<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/Camagru/config/database.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/Camagru/init.php');

$uname = $_SESSION['username'];
$name = $_SESSION['woop'];
$text = $_POST['text'];
if (isset($_POST['like'])) {
    $sql = $conn->prepare(
        "SELECT
            `like`
        FROM
            `cosincla_camagru`.`likes`
        WHERE
            `like_id` LIKE '$uname' AND `image_id` LIKE '$name';");
        $sql->execute();
        $sql->setFetchMode(PDO::FETCH_ASSOC);
        $stuff = $sql->fetchAll();

        if (!empty($stuff)) {
            foreach($stuff as $s) {
                $num = $s['like'];
                echo $num;
                if ($num == 1 && $num != 0) {
                    $sql = $conn->prepare(
                        "UPDATE
                            `cosincla_camagru`.`likes`
                        SET
                            `like` = 0
                        WHERE
                            `like_id` LIKE '$uname' AND `image_id` LIKE '$name';");
                    $sql->execute();
                    echo '<script type=text/javascript>alert("Image is no longer liked"); window.location="http://localhost/Camagru/gallery/gall.php";</script>';
                }
                else if ($num == 0 && $num != 1) {
                    $sql = $conn->prepare(
                        "UPDATE
                            `cosincla_camagru`.`likes`
                        SET
                            `like` = 1
                        WHERE
                            `like_id` LIKE '$uname' AND `image_id` LIKE '$name';");
                    $sql->execute();
                    echo '<script type=text/javascript>alert("Image has been liked"); window.location="http://localhost/Camagru/gallery/gall.php";</script>';
                }
            }
        }
        else if (empty($stuff)) {
            $sql = $conn->prepare(
                "SELECT
                    `image_creator`
                FROM
                    `cosincla_camagru`.`uploads`
                WHERE
                    `image_id` LIKE '$name';");
            $sql->execute();
            $sql->setFetchMode(PDO::FETCH_ASSOC);
            $stff = $sql->fetchAll();
            foreach($stff as $t) {
                $cname = $t['image_creator'];
            }
            $sql = $conn->prepare(
                "INSERT INTO
                    `cosincla_camagru`.`likes` (`image_creator`, `image_id`, `like_id`,`like`)
                VALUES
                    (:p_ic, :p_iid, :p_lid, :p_l);");
            $sql->execute(array(
                ':p_ic' => $cname,
                ':p_iid' => $name,
                ':p_lid' => $uname,
                ':p_l' => 1
            ));
            echo '<script type=text/javascript>alert("Image has been liked"); window.location="http://localhost/Camagru/gallery/gall.php";</script>';
    }
}
    
else if (isset($_POST['comment'])){
    if (!empty($_POST['text'])) {
        $text = $_POST['text'];
        $ptext = htmlentities($text);
        if (strlen($text) < 200) {
            $sql = $conn->prepare(
                "SELECT
                    `image_creator`
                FROM
                    `cosincla_camagru`.`uploads`
                WHERE
                    `image_id` LIKE '$name';");
            $sql->execute();
            $sql->setFetchMode(PDO::FETCH_ASSOC);
            $stff = $sql->fetchAll();
            foreach($stff as $t)
                $cname = $t['image_creator'];
            $sql = $conn->prepare(
                "INSERT INTO
                    `cosincla_camagru`.`comments` (`image_id`, `image_creator`, `comment`, `commenter`)
                VALUES
                    (:p_iid, :p_ic, :p_c, :p_cid);");
            
            $sql->execute(array(
                ':p_iid' => $name,
                ':p_ic' => $cname,
                ':p_c' => $ptext,
                ':p_cid' => $uname,
            ));

            $sql = $conn->prepare(
                "SELECT
                    `email_on_comment`, `email`
                FROM
                    `cosincla_camagru`.`users`
                WHERE
                    `username` LIKE '$cname';"
            );
            $sql->execute();
            $sql->setFetchMode(PDO::FETCH_ASSOC);
            $stiff = $sql->fetchAll();
            foreach($stiff as $i) {
                $yes = $i['email_on_comment'];
                $email = $i['email'];
            }
            if ($yes == 1 && $yes !== 0){
                $to      = $email;
                $subject = 'Comment';
                $message = 'Greetings ' . $cname . "\n" . "\n". 'User:  ' . $uname . ' has commeted on one of your images.' . "\n" . "\n" . 'They commented that: ' . $text . "\n" . "\n" . 'Kind regards' . "\n" . 'The Camagru Team.';
                $message = wordwrap($message, 70);
                mail($to, $subject, $message, "From: local-owner@localhost.com");
            }
            echo '<script type=text/javascript>alert("Successfully commented"); window.location="http://localhost/Camagru/gallery/gall.php";</script>';
        }
        else
            echo '<script type=text/javascript>alert("Comment is too long, must be less than 200 characters"); window.location="http://localhost/Camagru/gallery/gall.php.php";</script>';
    }
    else
        echo '<script type=text/javascript>alert("Invalid input"); window.location="http://localhost/Camagru/gallery/gall.php";</script>';
}
?>