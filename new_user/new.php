<!doctype <!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Matcha</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="style2.css">
</head>
<body>
<div>
    <div class="box">
        <form method="POST" action="signup.php">
            <h3 style="text-align: center; font-family: Courier New, Courier, monospace">First:<br><input type="text" name="first"></h3>
            <h3 style="text-align: center; font-family: Courier New, Courier, monospace">Surname:<br><input type="text" name="surname"></h3>
            <h3 style="text-align: center; font-family: Courier New, Courier, monospace">Gender:<br><input list="genders" name="gender">
            <datalist id="genders">
                <option value="Female">
                <option value="Male">
                <option value="Other">
            </datalist></h3>
            <h3 style="text-align: center; font-family: Courier New, Courier, monospace">Preference:<br><input list="sex" name="sex">
            <datalist id="sex">
                <option value="Both">
                <option value="Female">
                <option value="Male">
            </datalist></h3>
            <h3 style="text-align: center; font-family: Courier New, Courier, monospace">Age:<br><input type="text" name="age"></h3>
            <h3 style="text-align: center; font-family: Courier New, Courier, monospace">Username:<br><input type="text" name="username"></h3>
            <h3 style="text-align: center; font-family: Courier New, Courier, monospace">Email:<br><input type="email" name="email"></h3>
            <h3 style="text-align: center; font-family: Courier New, Courier, monospace">Password:<br><input type="password" name="pwd" required pattern="^(?=.*\d)[a-zA-Z\d]{8,13}$" title="Password must contain between 8-13 characters with at least one number"></h3>
            <h3 style="text-align: center; font-family: Courier New, Courier, monospace">Confirm Password:<br><input type="password" name="pwdc"></h3>
            <input style="width: 70%; margin-left: 15%" type="submit" value="Finished?">
        </form>
    </div>
</div>
<div class="footer">
    <div class="back">
        <a href="http://localhost/Matcha/"><p style="text-align: center">Back</p></A>
    </div>
</div>
</body>
</html>