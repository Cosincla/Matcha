<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/Matcha/config/database.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/Matcha/init.php');

$temp = $_GET['image'];
$_SESSION['delete'] = $temp; 
if (isset($_SESSION["username"])){?>
<!doctype <!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Camagru</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="style876.css">
</head>
<body>
<div style="display: flex">
    <div class="box">
        <form method="POST" action="delete.php">
        <p style="text-align: center"><u>Are you sure you would like to delete this image?</u></p>
        <input style="width: 70%; margin-left: 15%" type="submit" value="Yes" name="yes">
        <input style="width: 70%; margin-left: 15%" type="submit" value="No" name="no">
        </form>
    </div>
</div>
<div class="footer">
    <div class="back">
        <a href="http://localhost/Matcha/myprofile/my.php"><p style="text-align: center">Back</p></A>
    </div>
</div>
</body>
</html>
<?php }
else
    echo '<script type=text/javascript>alert("Please log in"); window.location="http://localhost/Matcha/";</script>';
?>