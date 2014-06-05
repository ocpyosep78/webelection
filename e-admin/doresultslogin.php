<?php
//Web-based Election Software
//Copyright (c) 2008, BRAD HEAP, All rights reserved.
//Adapted Jan. 2010 by Gabriel Rholl, St. Olaf College SGA Webmaster
//Purpose: Function to process the admin screen login, allows power users to view results without access to admin page
//WARNING: Currently allows power users to access admin page (bug)

ini_set('display_errors', 1);
ini_set('display_warnings', 1);

// connect to db server.
include('../includes/dbconnection.php');

// get the true username and password
$sqlq = "SELECT value FROM options WHERE optionname = CONVERT( _utf8 'resultsuser' USING latin1 )";
$sqlresult = mysql_query($sqlq);
if (!$sqlresult) {
    die('Invalid query: ' . mysql_error());
}
$trueuser = mysql_fetch_object($sqlresult);

$sqlq = "SELECT value FROM options WHERE optionname = CONVERT( _utf8 'resultspword' USING latin1 )";
$sqlresult = mysql_query($sqlq);
if (!$sqlresult) {
    die('Invalid query: ' . mysql_error());
}
$truepword = mysql_fetch_object($sqlresult);

// check if these match submitted
if($trueuser->value == mysql_real_escape_string($_POST['user']) && $truepword->value == mysql_real_escape_string($_POST['pword'])) {
	$_SESSION['loggedin'] = true;
	header('location:results.php');
	exit;
}

?>
