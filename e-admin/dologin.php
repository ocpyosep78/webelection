<?php
//Web-based Election Software
//Copyright (c) 2008, BRAD HEAP, All rights reserved.
//No modification Jan. 2010 by Gabriel Rholl, St. Olaf College SGA Webmaster
//Purpose: Function to process the admin screen login 

ini_set('display_errors', 1);
ini_set('display_warnings', 1);

session_start();

// connect to db server.
include('../includes/dbconnection.php');

//*** Modification by Gabe Rholl 1/2010
// Purpose: Checks to see if power users logged in to view the results
include('doresultslogin.php');
//***

// get the true username and password
$sqlq = "SELECT value FROM options WHERE optionname = CONVERT( _utf8 'username' USING latin1 )";
$sqlresult = mysql_query($sqlq);
if (!$sqlresult) {
    die('Invalid query: ' . mysql_error());
}
$trueuser = mysql_fetch_object($sqlresult);

$sqlq = "SELECT value FROM options WHERE optionname = CONVERT( _utf8 'userpword' USING latin1 )";
$sqlresult = mysql_query($sqlq);
if (!$sqlresult) {
    die('Invalid query: ' . mysql_error());
}
$truepword = mysql_fetch_object($sqlresult);

// check if these match submitted
if($trueuser->value == mysql_real_escape_string($_POST['user']) && $truepword->value == mysql_real_escape_string($_POST['pword'])) {
	$_SESSION['loggedin'] = true;
	header('location:index.php');
	exit;
}

// else redirect back to login
else {
	header('location:loginpage.php?error=1');
	exit;
}

?>
