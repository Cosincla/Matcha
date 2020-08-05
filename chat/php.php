<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/Matcha/config/database.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/Matcha/init.php');

$user = $_SESSION['username'];
$person = $_SESSION['person'];
$sql = $conn->prepare(
    "SELECT
        `message`, `sender`
    FROM
        `cosincla_matcha`.`messages`
    WHERE
        `sender` LIKE '$person' AND `receiver` LIKE '$user' OR `sender` LIKE '$user' AND `receiver` LIKE '$person'
    ORDER BY
        `date_created`;");
$sql->execute();
$sql->setFetchMode(PDO::FETCH_ASSOC);
$stuff = $sql->fetchAll();
if (empty($stuff)){
    echo "This is the start of your converstaion with ".$person.".<br>";
}
else {
    foreach ($stuff as $s) {
        if ($s['sender'] == $user){
            ?><div style='font-size: 1vw;
            position: relative;
            min-height: 10%;
            margin-left: 45%;
            background-color: aquamarine;
            border-radius: 15px;
            padding: 4px;
            word-break: break-all; word-wrap: break-word;
            text-size: 1vw;'><p><?php echo $s['message']; ?></p></div><br><?php
        }
        else if ($s['sender'] == $person) {
            ?><div style='font-size: 1vw;
            position: relative;
            min-height: 10%;
            width: 50%;
            margin-left: 2%;
            background-color: #B4B0B0;
            border-radius: 15px;
            word-break: break-all; word-wrap: break-word;
            padding: 4px;
            text-size: 1vw;'><p><?php echo $s['message']; ?></p></div><br><?php
        }                    
    }
}