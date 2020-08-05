<!doctype <!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Matcha</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="style4.css">
</head>
<body>
<div style="display: flex">
    <div class="box">
        <form method="POST" action="precp.php">
        <h3 style="text-align: center; font-family: Courier New, Courier, monospace">New Password:<br><input type="password" name="pword" required pattern="^(?=.*\d)[a-zA-Z\d]{8,13}$" title="Password must contain between 8-13 characters with at least one number"></h3>
        <h3 style="text-align: center; font-family: Courier New, Courier, monospace">Verification Code:<br><input type="text" name="code"></h3>
        <input style="width: 70%; margin-left: 15%" type="submit" value="Finished?">
        </form>
    </div>
</div>
<div class="footer">
</div>
</body>
</html>