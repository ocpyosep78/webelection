<?php
//Web-based Election Software
//Copyright (c) 2008, BRAD HEAP, All rights reserved.
//No modification Jan. 2010 by Gabriel Rholl, St. Olaf College SGA Webmaster
//Purpose: Function to check if the user is already logged in

ini_set('display_errors', 1);
ini_set('display_warnings', 1);

session_start();

if( is_null($_SESSION['loggedin']) ) {
	header('location:loginpage.php');
	exit;
} else if( $_SESSION['loggedin'] == false) {
	header('location:loginpage.php?error=2');
	exit;
}

?>