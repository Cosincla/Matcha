<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/Matcha/config/database.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/Matcha/init.php');

$user = $_SESSION['username'];
$sql = $conn->prepare(
    "SELECT
        `username`
    FROM
        `cosincla_matcha`.`filters`
    WHERE
        `username` LIKE '$user';");
$sql->execute();
$sql->setFetchMode(PDO::FETCH_ASSOC);
$stuff = $sql->fetchAll();
if (!empty($stuff)){
    $sql = $conn->prepare(
        "DELETE FROM
            `cosincla_matcha`.`filters`
        WHERE
            `username` LIKE '$user';");
    $sql->execute();
}

if (!empty($_POST["age"]) && !empty($_POST["fame"]) && !empty($_POST["distance"]) && !empty($_POST["interests"]))
{
    $sql = $conn->prepare(
        "SELECT
            `username`
        FROM
            `cosincla_matcha`.`filters`
        WHERE
            `username` LIKE '$user';");
    $sql->execute();
    $sql->setFetchMode(PDO::FETCH_ASSOC);
    $stuff = $sql->fetchAll();
    if (empty($stuff)){
        $sql = $conn->prepare(
            "INSERT INTO
                `cosincla_matcha`.`filters` (`username`)
            VALUES
                (:p_u);");
        $sql->execute(array(':p_u' => $user));
    }
    if ((!empty($_POST['age'])) && ($_POST['age'] === "20-24" || $_POST['age'] === "25-29" || $_POST['age'] === "30-34" || $_POST['age'] === "35-39" || $_POST['age'] === "40-44" || $_POST['age'] === "45-50")){
        $age = $_POST['age'];
        $sql = $conn->prepare(
            "SELECT
                `age`
            FROM
                `cosincla_matcha`.`filters`
            WHERE
                `username` LIKE '$user'");
        $sql->execute();
        $sql->setFetchMode(PDO::FETCH_ASSOC);
        $stuff = $sql->fetchAll();
        if (empty($stuff)){
            $sql = $conn->prepare(
                "INSERT INTO
                    `cosincla_matcha`.`filters` (`age`)
                VALUES
                    (:p_a);");
            $sql->execute(array(':p_a' => $age));
        }
        else {
            $sql = $conn->prepare(
                "UPDATE
                    `cosincla_matcha`.`filters`
                SET
                    `age` = '$age'
                WHERE
                    `username` LIKE '$user';");
            $sql->execute();
        }
    }
    if ((!empty($_POST['fame'])) && ($_POST['fame'] === "0-2" || $_POST['fame'] === "3-5" || $_POST['fame'] === "6-8" || $_POST['fame'] === "9-10")){
        $fame = $_POST['fame'];
        $sql = $conn->prepare(
            "SELECT
                `fame`
            FROM
                `cosincla_matcha`.`filters`
            WHERE
                `username` LIKE '$user'");
        $sql->execute();
        $sql->setFetchMode(PDO::FETCH_ASSOC);
        $stuff = $sql->fetchAll();
        if (empty($stuff)){
            $sql = $conn->prepare(
                "INSERT INTO
                    `cosincla_matcha`.`filters` (`fame`)
                VALUES
                    (:p_f);");
            $sql->execute(array(':p_f' => $fame));
        }
        else {
            $sql = $conn->prepare(
                "UPDATE
                    `cosincla_matcha`.`filters`
                SET
                    `fame` = '$fame'
                WHERE
                    `username` LIKE '$user';");
            $sql->execute();
        }
    }
    if ((!empty($_POST['distance'])) && ($_POST['distance'] === "0km-4km" || $_POST['distance'] === "5km-9km" || $_POST['distance'] === "10km-14km" || $_POST['distance'] === "15km-19km" || $_POST['distance'] === "20km-24km" || $_POST['distance'] === "25km-29km" || $_POST['distance'] === "30km-34km" || $_POST['distance'] === "35km-40km")){
        $dist = $_POST['distance'];
        $sql = $conn->prepare(
            "SELECT
                `distance`
            FROM
                `cosincla_matcha`.`filters`
            WHERE
                `username` LIKE '$user'");
        $sql->execute();
        $sql->setFetchMode(PDO::FETCH_ASSOC);
        $stuff = $sql->fetchAll();
        if (empty($stuff)){
            $sql = $conn->prepare(
                "INSERT INTO
                    `cosincla_matcha`.`filters` (`distance`)
                VALUES
                    (:p_d);");
            $sql->execute(array(':p_d' => $dist));
        }
        else {
            $sql = $conn->prepare(
                "UPDATE
                    `cosincla_matcha`.`filters`
                SET
                    `distance` = '$dist'
                WHERE
                    `username` LIKE '$user';");
            $sql->execute();
        }
    }
    if ((!empty($_POST['interests'])) && ($_POST['interests'] === "1-4" || $_POST['interests'] === "2-4" || $_POST['interests'] === "3-4")){
        $interests = $_POST['interests'];
        $sql = $conn->prepare(
            "SELECT
                `interests`
            FROM
                `cosincla_matcha`.`filters`
            WHERE
                `username` LIKE '$user'");
        $sql->execute();
        $sql->setFetchMode(PDO::FETCH_ASSOC);
        $stuff = $sql->fetchAll();
        if (empty($stuff)){
            $sql = $conn->prepare(
                "INSERT INTO
                    `cosincla_matcha`.`filters` (`interests`)
                VALUES
                    (:p_i);");
            $sql->execute(array(':p_i' => $interests));
        }
        else {
            $sql = $conn->prepare(
                "UPDATE
                    `cosincla_matcha`.`filters`
                SET
                    `interests` = '$interests'
                WHERE
                    `username` LIKE '$user';");
            $sql->execute();
        }
    }
    if ((!empty($_POST['order'])) && ($_POST['order'] === "Age" || $_POST['order'] === "Fame" || $_POST['order'] === "Distance" || $_POST['order'] === "Interests")){
        $order = $_POST['order'];
        $sql = $conn->prepare(
            "SELECT
                `order`
            FROM
                `cosincla_matcha`.`filters`
            WHERE
                `username` LIKE '$user'");
        $sql->execute();
        $sql->setFetchMode(PDO::FETCH_ASSOC);
        $stuff = $sql->fetchAll();
        if (empty($stuff)){
            $sql = $conn->prepare(
                "INSERT INTO
                    `cosincla_matcha`.`filters` (`order`)
                VALUES
                    (:p_o);");
            $sql->execute(array(':p_o' => $interests));
        }
        else {
            $sql = $conn->prepare(
                "UPDATE
                    `cosincla_matcha`.`filters`
                SET
                    `order` = '$order'
                WHERE
                    `username` LIKE '$user';");
            $sql->execute();
        }
    }
    echo '<script type=text/javascript>alert("We will now filter out our users to your filter specifications"); window.location="http://localhost/Matcha/filtered/filtered.php";</script>';
}
else
    echo '<script type=text/javascript>alert("Please select an appropriate filter for each category"); window.location="http://localhost/Matcha/filter/filter.php";</script>';
?>