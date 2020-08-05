<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/Matcha/config/setup.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/Matcha/landing_page/lp.php');

session_destroy();
echo '<script type=text/javascript>alert("Logout successful"); window.location="http://localhost/Matcha";</script>';

?>