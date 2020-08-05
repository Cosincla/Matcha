<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/Matcha/config/database.php');
?><!DOCTYPE html>
<html>
<head>
	<title>Matcha</title>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="/Matcha/landing_page/style1.css" />
</head>
<body style="background-color: maroon">
	<div class="header">
		<h2 style="text-align: center"><u>Welcome to Matcha</u></h2>
	</div>
	<div class="image">
		<p style="text-align: center"><u>Find the love of your life or your next mistake.</u></p>
	</div>
	<div style="display: flex">
		<DIV style="width: 90%;" class="right">
			<p style="text-align: center"><u>Login</u></p>
			<hr>
			<form method="POST" action="/Matcha/landing_page/login.php">
				<p style="font-family: Courier New, Courier, monospace">Username:<br><input type="text" name="login" style="width: 80%"></p>
				<p style="font-family: Courier New, Courier, monospace">Password:<br><input type="password" name="password" style="width: 80%"></p>
				<input type="submit" id="submit" value="OK">
				<p style="text-align: center"><u>Forgot your Passwrod?</u></p>
				<A href="http://localhost/Matcha/email_r/email.php"><p><u>Click here</u></p></A>
			</form>
			<hr>
			<p style="text-align: center"><u>New User?</u></p>
			<A href="http://localhost/Matcha/new_user/new.php"><p><u>Click here</u></p></A>
		</DIV>
	</div>
	<footer id="footer">
		<p>&copy; Terms and conditions apply.<br>cosincla2018.</p>
	</footer>
</body>
</html>