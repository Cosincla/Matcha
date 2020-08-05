<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/Matcha/config/database.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/Matcha/init.php');

if (isset($_SESSION["username"])){?><!doctype <!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Matcha</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="style300.css">
</head>
<body>
<div style="display: flex">
    <div class="box">
        <h1 style="text-align: center"><u>Profile photo</u></h1>
        <hr>
        <div id="view" style="border-radius: 250px; margin-left: 5%; width: 18vw; height: 18vw; text-align: center; background-size: cover; background-repeat: no-repeat; background-position: center center;
            <?php 
                echo "background-image: url('".$_SESSION['profile']."');";
            ?>
            <?php
            if (isset($_GET['image']))
                echo "background-image: url('profile_photos/".$_GET['image'].".png');";
            ?>"></div>
        <form method="POST" action="profile.php" enctype="multipart/form-data" target="uphoto">
            <input type="file" name="fileToUpload" id="button"/>
            <input type="submit" name="submit" value="Upload file" id="button"/>
        </form>
        <form action="save.php"><button type="submit" style="font-size: 20">Save photo</button></form>
    </div>
</div>
<div class="footer">
    <div class="back" onclick="goBack()">
        <script>function goBack() {window.history.back();}</script><p style="text-align: center">Back</p></A>
    </div>
</div>
</body>
</html>
<?php }
else
    echo '<script type=text/javascript>alert("Please log in"); window.location="http://localhost/Matcha/";</script>';
?>