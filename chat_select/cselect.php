<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/Matcha/config/database.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/Matcha/init.php');

?>
<!doctype <!DOCTYPE html>
<html>
<head>
    <title>Matcha</title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="style56.css" />
</head>
<body>
<div class="right">
    <div class="rview">
        <form method="POST">
        <?php
            $user = $_SESSION['username'];
            $sql = $conn->prepare(
                "SELECT
                    `liked_id`
                FROM
                    `cosincla_matcha`.`likes`
                WHERE
                    `liker_id` LIKE '$user' AND `like` LIKE 1;");
            $sql->execute();
            $sql->setFetchMode(PDO::FETCH_ASSOC);
            $stuff = $sql->fetchAll();
            if (empty($stuff)){
                echo '<script type=text/javascript>alert("Please like another user to be able to utilize this feature"); window.location="http://localhost/Matcha/users/users.php";</script>';
            }
            else{
                foreach($stuff as $s){
                    $person = $s['liked_id'];
                    $sql = $conn->prepare(
                        "SELECT
                            `like`
                        FROM
                            `cosincla_matcha`.`likes`
                        WHERE
                            `liked_id` LIKE '$user' AND `liker_id` LIKE '$person';");
                    $sql->execute();
                    $sql->setFetchMode(PDO::FETCH_ASSOC);
                    $stiff = $sql->fetchAll();
                    if (empty($stiff)){
                        echo '<script type=text/javascript>alert("None of the other users seem to like you..."); window.location="http://localhost/Matcha/users/users.php";</script>';
                    }
                    else {
                        foreach ($stiff as $i){
                            $like = $i['like'];
                            if ($like === '0'){
                                ?><hr><?php
                                    echo "User: ".$person." has reconsidered liking your profile.";
                                ?><hr><?php
                            }
                            else if ($like === '1'){
                                ?><hr><?php
                                    echo "User: ".$person." likes your profile. ".'<a href="http://localhost/Matcha/chat/c.php?person='.$person.'">Send this user a message?</a>';
                                ?><hr><?php
                            }
                        }
                    }
                }
            }
        ?>
        </form>
    </div>
</div>
<div class="footer">
    <div class="back" onclick="goBack()">
        <script>function goBack() {window.history.back();}</script><p style="text-align: center">Back</p></A>
    </div>
</div>
</body>
<footer id="footer">
	<p>&copy; Terms and conditions apply.<br>cosincla2018.</p>
</footer>
</html>