<?php
//Web-based Election Software
//Copyright (c) 2008, BRAD HEAP, All rights reserved.
//No modification Jan. 2010 by Gabriel Rholl, St. Olaf College SGA Webmaster
//Purpose: Function to change the election description and title

ini_set('display_errors', 1);
ini_set('display_warnings', 1);
include('loggedincheck.php');

// connect to db server.
include('../includes/dbconnection.php');

$sqlq = "UPDATE options SET value = '".mysql_real_escape_string($_POST['title'])."' WHERE optionname = 'electitle'";
$sqlresult = mysql_query($sqlq);
if (!$sqlresult) {
    die('Invalid query: ' . mysql_error());
}

$sqlq = "UPDATE options SET value = '".mysql_real_escape_string($_POST['desc'])."' WHERE optionname = 'elecdesc'";
$sqlresult = mysql_query($sqlq);
if (!$sqlresult) {
    die('Invalid query: ' . mysql_error());
}

header("location:index.php#elecdata");

?>