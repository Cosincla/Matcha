<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/Matcha/config/database.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/Matcha/init.php');

if (isset($_SESSION["username"])){?>
<!doctype <!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Matcha</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="style271.css">
</head>
<body>
<div>
    <div class="box">
        <form method="POST" action="int.php">
            <h3 style="text-align: center; font-family: Courier New, Courier, monospace">Interest 1:<br><input type="text" name="interest_1" list="interests"></h3>
            <h3 style="text-align: center; font-family: Courier New, Courier, monospace">Interest 2:<br><input type="text" name="interest_2" list="interests"></h3>
            <h3 style="text-align: center; font-family: Courier New, Courier, monospace">Interest 3:<br><input type="text" name="interest_3" list="interests"></h3>
            <h3 style="text-align: center; font-family: Courier New, Courier, monospace">Interest 4:<br><input type="text" name="interest_4" list="interests"></h3>
            <datalist id="interests">
                <option value="Action Movies">
                <option value="Alcohol">
                <option value="Animals">
                <option value="Anime">
                <option value="BDSM">
                <option value="Board games">
                <option value="Books">
                <option value="Card Games">
                <option value="Cats">
                <option value="Dogs">
                <option value="Eating">
                <option value="Fish">
                <option value="Innuendo">
                <option value="Horror Movies">
                <option value="Myths/Legends">
                <option value="Occult">
                <option value="Romantic Movies">
                <option value="Running">
                <option value="Swimming">
                <option value="Video Games">
                <option value="Weed">
            </datalist></h3>
            <input style="width: 70%; margin-left: 15%" type="submit" value="Finished?">
        </form>
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