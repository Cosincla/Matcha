<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/Matcha/config/database.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/Matcha/init.php');

if (!empty($_POST["email"])){
    $new = $_POST['email'];
    $user = $_SESSION['username'];

    $sql = $conn->prepare(
        "SELECT
            `email`, `name`
        FROM
            `cosincla_matcha`.`users`
        WHERE
            `username` LIKE '$user';");
    $sql->execute();

    $sql->setFetchMode(PDO::FETCH_ASSOC);
    $stuff = $sql->fetchAll();
    foreach($stuff as $s) {
        if ($s['email'] === $new){
            echo '<script type=text/javascript>alert("New Email cannot be old Email"); window.location="http://localhost/Matcha/main_page/mp.php";</script>';
            exit();
        }
        else {
            $_SESSION['email'] = $new;
            
            $sql = $conn->prepare(
                "INSERT INTO 
                    `cosincla_matcha`.`verification` (`user_id`, `unlock`)
                VALUES 
                    (:u_i, :u_c);");
            $username = $_SESSION['username'];
            $code = getRandomWord(10);
            $sql->execute(array(
                ':u_i' => $username,
                ':u_c' => $code));

            $to      = $new;
            $subject = 'Password reset';
            $link    = 'http://localhost/Matcha/email_e/email_v.php';
            $message = 'Greetings ' . $s['name'] . "\n" . "\n". 'Here is a link to reset your password:  ' . $link . "\n" . 'Here is your verification code:  ' . $code . "\n" . "\n" . 'Kind regards' . "\n" . 'The Camagru Team.';
            $message = wordwrap($message, 70);
            mail($to, $subject, $message, "From: local-owner@localhost.com");
            echo '<script type=text/javascript>alert("A verification Email has been sent to new email address"); window.location="http://localhost/Matcha/main_page/mp.php";</script>';    
        }
    }
}
else
    echo '<script type=text/javascript>alert("Invalid input"); window.location="http://localhost/Matcha/email_e/emaile.php";</script>';

?>