<?PHP

require_once($_SERVER['DOCUMENT_ROOT'].'/Matcha/config/database.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/Matcha/init.php');

if (!empty($_POST["pword"] && !empty($_POST["code"]))){
    $new = $_POST["pword"];
    $code = $_POST["code"];
    $hash = hash('whirlpool', $new);
    $sql = $conn->prepare(
        "SELECT
            `user_id`
        FROM
            `cosincla_matcha`.`verification`
        WHERE
           `unlock` LIKE '$code';");
    $sql->execute();

    $sql->setFetchMode(PDO::FETCH_ASSOC);
    $stuff = $sql->fetchAll();
    if (!empty($stuff)){
        foreach($stuff as $s)
            $name = $s['user_id'];
    }
    else {
        echo '<script type=text/javascript>alert("User does not exist"); window.location="http://localhost/Matcha/email_r/prec.php";</script>';
        exit();
    }
    
    $sql = $conn->prepare(
        "UPDATE
            `cosincla_matcha`.`users`
        SET
            `password` = '$hash'
        WHERE
            `username` LIKE '$name';");
    $sql->execute();

    $sql = $conn->prepare(
        "DELETE FROM
            `cosincla_matcha`.`verification`
        WHERE
            `user_id`='$name';");
    $sql->execute();
    echo '<script type=text/javascript>alert("Password successfully changed"); window.location="http://localhost/Matcha/";</script>';
}
else
    echo '<script type=text/javascript>alert("Invalid input"); window.location="http://localhost/Matcha/email_r/prec.php";</script>';
?>