<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/Matcha/config/database.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/Matcha/init.php');

$_SESSION['person'] = $_GET['person'];
?>
<!doctype <!DOCTYPE html>
<html>
<head>
    <title>Matcha</title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="style569.css" />
</head>
<body>
<div class="right">
    <div class="rview" id="rview">
    </div>
        <script>
        window.onload = getData();
        function getData() {
        var xml = new XMLHttpRequest();

        xml.onload = function() {
            if(xml.status === 200) {
                document.getElementById('rview').innerHTML = xml.responseText;
            }
        };
        xml.open('POST', 'php.php', true);
        xml.send(null);
    }
    setInterval(getData, 1000);
    </script>
    <div>
    <form method="POST" action="send.php">
        <input type="text" class="defaultTextBox" name="text">
        <input type="submit" id="submit" value="Send message">
    </form>
    </div>
</div>
<div class="footer">
    <div class="back" onclick="goBack()">
        <a href="http://localhost/Matcha/users/users.php" style="text-align: center">Back</a>
    </div>
</div>
</body>
<footer id="footer">
	<p>&copy; Terms and conditions apply.<br>cosincla2018.</p>
</footer>
</html>