<?php
//Web-based Election Software
//Copyright (c) 2008, BRAD HEAP, All rights reserved.
//No modification Jan. 2010 by Gabriel Rholl, St. Olaf College SGA Webmaster
//Purpose: Function to provide "security" for the election by only allowing people on a roll to vote.
//	Doesn't seem to work, nor do we need it. I'd like to cut it.

ini_set('display_errors', 1);
ini_set('display_warnings', 1);
include('loggedincheck.php');

// connect to db server.
include('../includes/dbconnection.php');

$sqlq = "UPDATE options SET value = '".mysql_real_escape_string($_POST['useroll'])."' WHERE optionname = 'useroll'";
$sqlresult = mysql_query($sqlq);
if (!$sqlresult) {
    die('Invalid query: ' . mysql_error());
}

$sqlq = "UPDATE options SET value = '".mysql_real_escape_string($_POST['allowspecial'])."' WHERE optionname = 'allowspecial'";
$sqlresult = mysql_query($sqlq);
if (!$sqlresult) {
    die('Invalid query: ' . mysql_error());
}

header("location:index.php#security");

?>