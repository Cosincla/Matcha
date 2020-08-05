<!doctype <!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Matcha</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="style27.css">
</head>
<body>
<div>
    <div class="box">
        <form method="POST" action="loc.php">
            <h3 style="text-align: center; font-family: Courier New, Courier, monospace">City/Town:<br><input type="text" name="city"></h3>
            <h3 style="text-align: center; font-family: Courier New, Courier, monospace">Region:<br><input type="text" name="region"></h3>
            <h3 style="text-align: center; font-family: Courier New, Courier, monospace">Postal code:<br><input type="text" name="post"></h3>
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