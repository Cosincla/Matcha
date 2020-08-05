<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/Matcha/config/database.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/Matcha/init.php');

$user = $_SESSION['username'];
$person = $_GET['person'];
$rate = $_POST['rate'];
$sql = $conn->prepare(
    "SELECT
        `rating`
    FROM
        `cosincla_matcha`.`ratings`
    WHERE
        `rater_id` LIKE '$user' AND `rated_id` LIKE '$person';");
$sql->execute();
$sql->setFetchMode(PDO::FETCH_ASSOC);
$stuff = $sql->fetchAll();
if (empty($stuff)){
    $sql = $conn->prepare(
        "INSERT INTO `cosincla_matcha`.`ratings` (`rating`, `rated_id`, `rater_id`) 
        VALUES (:p_r, :p_rd, :p_rr);");
    $sql->execute(array(
        ':p_r' => $rate,
        ':p_rd' => $person,
        ':p_rr' => $user));
}
else {
    $sql = $conn->prepare(
        "UPDATE
            `cosincla_matcha`.`ratings`
        SET
            `rating` = '$rate'
        WHERE
            `rated_id` LIKE '$person' AND `rater_id` LIKE '$user';");
    $sql->execute();
}
echo '<script type=text/javascript>alert("User rating has been recorded"); window.location="http://localhost/Matcha/viewbio/vbiography.php?person='.$person.'";</script>';