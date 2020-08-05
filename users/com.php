<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/Matcha/config/database.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/Matcha/init.php');

$temp = $_GET['image'];
$_SESSION['woop'] = $temp; 
if (isset($_SESSION["username"])){?>
<!doctype <!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Matcha</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="style36.css">
</head>
<body>
<div style="display: flex">
    <div class="box">
        <div class="view">
            <img style="width: 100%; border-radius: 15px;" src="/Matcha/main_page/uploads/<?php echo $_GET['image'].".png"; ?>">
        </div>
        <div style="text-align: center;">
            <form method="POST" action="stuff.php">
                    <p style="text-align: center">Comment:<input type="text" name="text"></p>
                    <input class="button" type="submit" id="submit" value="Comment" name="comment"><br>
                    <input class="button" type="submit" id="submit" value="Like/Unlike" name="like">
            </form>
        </div>    
    </div>
</div>
<div class="footer">
    <div class="back">
        <a href="http://localhost/Matcha/gallery/gall.php"><p style="text-align: center">Back</p></A>
    </div>
</div>
</body>
</html>
<?php }
else
    echo '<script type=text/javascript>alert("Please log in"); window.location="http://localhost/Matcha/";</script>';
?>