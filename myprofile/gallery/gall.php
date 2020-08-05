<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/Matcha/config/database.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/Matcha/init.php');

if (isset($_SESSION["username"])){?>
<!doctype <!DOCTYPE html>
<html>
<head>
    <title>Matcha</title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="style516.css" />
</head>
<body style="background-color: maroon">
<div style="display: flex">
    <div class="left">
        <p style="text-align: center"><u>Preview</u></p>
        <div class="view">
            <div id="uphoto" style="margin-left: 1.3%; width: 40vw; height: 30vw; position: absolute; background-size: 40vw 30vw;
            <?php   if (isset($_GET['image']))
                        echo "background-image: url('uploads/".$_GET['image'].".png');";
                    if (isset($_POST["clear"]))
                        echo "background-image: none";
            ?>"></div>
            <div id="sticker2" style="margin-left: 1.3%; width: 40vw; height: 30vw; position: absolute; background-size: 40vw 30vw;"></div>
            <div id="sticker1" style="margin-left: 1.3%; width: 40vw; height: 30vw; position: absolute; background-size: 40vw 30vw;"></div>
            <video id="video" width="100%" height="100%" autoplay></video>
        </div>
        <form method="POST" action="edite.php" enctype="multipart/form-data" target="uphoto">
            <input type="file" name="fileToUpload" id="button"/>
            <input type="submit" name="submit" value="Upload file" id="button"/>
            <button type="button" id="capture" style="left-margin: 50%">Take Photo</button>
        </form>
        <div class="view">
            <canvas id="canvas" style="width: 94%; margin-left: 3%; border: 1px solid black;"></canvas>
            <form method="POST" action="uploade.php" enctype="multipart/form-data">
                <input type="hidden" name="sub_image" id="sub_image" value="">
                <button type="submit" id="save">Save photo</button>
            </form>
            <canvas id="canvas_2" style="width: 320px; height: 220px; display: none"></canvas>
        </div>
        <div class="space"></div>
    </div>
    <div class="back" onclick="goBack()">
        <script>function goBack() {window.history.back();}</script><p style="text-align: center">Back</p></A>
    </div>
</div>
<script src="video.js"></script>
</body>
<footer id="footer">
	<p>&copy; Terms and conditions apply.<br>cosincla2018.</p>
</footer>
</html>
<?php }
else
    echo '<script type=text/javascript>alert("Please log in"); window.location="http://localhost/Matcha/";</script>';
?>