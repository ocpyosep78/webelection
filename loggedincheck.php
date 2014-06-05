<?php
//Web-based Election Software
//Copyright (c) 2008, BRAD HEAP, All rights reserved.
//Modified Feb. 2010 by Gabriel Rholl, St. Olaf College SGA Webmaster
//Purpose: To identify whether a user is logged in or not

ini_set('display_errors', 1);
ini_set('display_warnings', 1);

session_start();

if( is_null($_SESSION['login']) ) {
	header('location:loginpage.php');
	exit;
} else if( $_SESSION['login'] == false) {
	header('location:loginpage.php?error=2');
	exit;
}

?>