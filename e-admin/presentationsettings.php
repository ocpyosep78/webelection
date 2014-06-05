<?php
//Web-based Election Software
//Copyright (c) 2008, BRAD HEAP, All rights reserved.
//No modification Jan. 2010 by Gabriel Rholl, St. Olaf College SGA Webmaster
//Purpose: Function to gather presentation settings for display on ballot

ini_set('display_errors', 1);
ini_set('display_warnings', 1);
include('loggedincheck.php');

// connect to db server.
include('../includes/dbconnection.php');

$sqlq = "UPDATE options SET value = '".mysql_real_escape_string($_POST['sortorder'])."' WHERE optionname = 'canorder'";
$sqlresult = mysql_query($sqlq);
if (!$sqlresult) {
    die('Invalid query: ' . mysql_error());
}

$sqlq = "UPDATE options SET value = '".mysql_real_escape_string($_POST['presentation'])."' WHERE optionname = 'presentation'";
$sqlresult = mysql_query($sqlq);
if (!$sqlresult) {
    die('Invalid query: ' . mysql_error());
}

$sqlq = "UPDATE options SET value = '".mysql_real_escape_string($_POST['affliation'])."' WHERE optionname = 'affliation'";
$sqlresult = mysql_query($sqlq);
if (!$sqlresult) {
    die('Invalid query: ' . mysql_error());
}

$sqlq = "UPDATE options SET value = '".mysql_real_escape_string($_POST['blurbs'])."' WHERE optionname = 'blurbs'";
$sqlresult = mysql_query($sqlq);
if (!$sqlresult) {
    die('Invalid query: ' . mysql_error());
}

// store away thanks for voting page
$file = fopen("../thanks.php","w");
fwrite($file,$_POST['thankspage']);
fclose($file);

header("location:index.php#presentation");

?>