<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/Matcha/config/database.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/Matcha/init.php');

session_destroy();
echo '<script type=text/javascript>alert("Logout successful"); window.location="http://localhost/Matcha";</script>';

?>