<?PHP

require_once($_SERVER['DOCUMENT_ROOT'].'/Matcha/config/database.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/Matcha/init.php');

if (!empty($_POST["login"]) && !empty($_POST["password"])){
    $uname = $_POST["login"];
    $pword = $_POST["password"];
    $hash = hash('whirlpool', $pword);
    
    $sql = $conn->prepare(
        "SELECT
            `password`,
            `username`,
            `validated`
        FROM
            `cosincla_matcha`.`users`
        WHERE
            `username` LIKE '$uname';");
    $sql->execute();

    $sql->setFetchMode(PDO::FETCH_ASSOC);
    $stuff = $sql->fetchAll();
    if (empty($stuff))
        echo '<script type=text/javascript>alert("User does not exist"); window.location="http://localhost/Matcha/";</script>';
    foreach($stuff as $s) {
        if ($s['password'] === $hash){
            if ($s['validated'] == 1){
                echo '<script type=text/javascript>alert("Login successful"); window.location="/Matcha/users/users.php";</script>';
                $_SESSION['username'] = $s['username'];
                $user = $_SESSION['username'];
                $sql = $conn->prepare(
                    "SELECT
                        `id`
                    FROM
                        `cosincla_matcha`.`profile_photos`
                    WHERE
                        `user_id` LIKE '$user' AND `selected` = 1;"
                );
                $sql->execute();
                $sql->setFetchMode(PDO::FETCH_ASSOC);
                $stuff = $sql->fetchAll();
                if (empty($stuff)){
                    $_SESSION['profile'] = "https://i.imgur.com/3RPJcXd.png";
                }
                else {
                    foreach($stuff as $s)
                        $photo = $s['id'];
                    $_SESSION['profile'] = "/Matcha/pphoto/profile_photos/".$photo.".png";
                }

                $ip = file_get_contents('http://checkip.dyndns.com/');
                $i = explode(' ', $ip);
                $details = json_decode(file_get_contents('https://ipinfo.io/?'.$i[5]));
                $coords = $details->loc;
                $cords = explode(",", $coords);
                $lat = $cords[0];
                $lon = $cords[1];
                $city = $details->city;
                $reg = $details->region;
                $code = $details->postal;
                
                $sql = $conn->prepare(
                    "SELECT
                        `tracker`
                    FROM
                        `cosincla_matcha`.`location`
                    WHERE
                        `user_id` LIKE '$user'"
                );
                $sql->execute();
                $sql->setFetchMode(PDO::FETCH_ASSOC);
                $stuff = $sql->fetchAll();
                if (empty($stuff)){
                    $track = 1;
                    $sql = $conn->prepare("INSERT INTO `cosincla_matcha`.`location` (`user_id`, `latitude`, `longitude`, `city`, `region`, `code`, `tracker`)
                    VALUES (:p_uid, :p_lat, :p_lon, :p_city, :p_reg, :p_code, :p_track)");
                    $sql->execute(array(
                        ':p_uid' => $user,
                        ':p_lat' => $lat,
                        ':p_lon' => $lon,
                        ':p_city' => $city,
                        ':p_reg' => $reg,
                        ':p_code' => $code,
                        ':p_track' => $track));
                }
                else {
                    foreach($stuff as $s){
                        if ($s['tracker'] === 1) {
                            $sql = $conn->prepare(
                                "UPDATE
                                    `cosincla_matcha`.`location`
                                SET
                                    `latitude` = '$lat',
                                    `longitude` = '$lon',
                                    `city` = '$city',
                                    `region` = '$reg',
                                    `code` = '$code'
                                WHERE
                                    `user_id` LIKE '$user';");
                            $sql->execute();
                        }
                    }
                }
                exit();
            }
            else
                echo '<script type=text/javascript>alert("User is not verified"); window.location="http://localhost/Matcha/";</script>';
        }
        else {
            if ($s['validated'] == 1)
                echo '<script type=text/javascript>alert("Password is incorrect"); window.location="http://localhost/Matcha/";</script>';
            else
                echo '<script type=text/javascript>alert("User does not exist"); window.location="http://localhost/Matcha/";</script>';
        }
    }
}
else
    echo '<script type=text/javascript>alert("Invalid input"); window.location="http://localhost/Matcha/";</script>';
session_unset();
?>