<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/Matcha/config/database.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/Matcha/init.php');

if (!empty($_POST['new'])){
    $_SESSION['pnew'] = $_POST['new'];
    $user = $_SESSION['username'];

    $sql = $conn->prepare(
        "SELECT
            `email`
        FROM
            `cosincla_matcha`.`users`
        WHERE
            `username` LIKE '$user';");
    $sql->execute();

    $sql->setFetchMode(PDO::FETCH_ASSOC);
    $stuff = $sql->fetchAll();
    foreach($stuff as $s) {
        $email = $s['email'];
    }
    
    $sql = $conn->prepare(
        "INSERT INTO 
            `cosincla_matcha`.`verification` (`user_id`, `unlock`)
        VALUES 
            (:u_i, :u_c);");
    
    $code = getRandomWord(10);
    $sql->execute(array(
        ':u_i' => $user,
        ':u_c' => $code));

    $to      = $email;
    $subject = 'Password change';
    $link    = 'http://localhost/Matcha/pswd/pswd_v.php';
    $message = 'Greetings ' . $user . "\n" . "\n". 'Here is a link to reset your password:  ' . $link . "\n" . 'Here is your verification code:  ' . $code . "\n" . "\n" . 'Kind regards' . "\n" . 'The Camagru Team.';
    $message = wordwrap($message, 70);
    mail($to, $subject, $message, "From: local-owner@localhost.com");
    echo '<script type=text/javascript>alert("A verification email has been sent"); window.location="http://localhost/Matcha/main_page/mp.php";</script>';
}
else
    echo '<script type=text/javascript>alert("Invalid input"); window.location="http://localhost/Matcha/pswd/pswd.php";</script>';
?>