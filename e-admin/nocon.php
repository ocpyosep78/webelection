<?php
//Web-based Election Software
//Copyright (c) 2008, BRAD HEAP, All rights reserved.
//No modification Jan. 2010 by Gabriel Rholl, St. Olaf College SGA Webmaster
//Purpose: Function to create/modify no confidence candidates... we don't even use it and I'd like to delete it.

ini_set('display_errors', 1);
ini_set('display_warnings', 1);
include('loggedincheck.php');

// connect to db server.
include('../includes/dbconnection.php');

$sqlq = "UPDATE options SET value = '".mysql_real_escape_string($_POST['noconreq'])."' WHERE optionname = 'nocon'";
$sqlresult = mysql_query($sqlq);
if (!$sqlresult) {
    die('Invalid query: ' . mysql_error());
}

if(mysql_real_escape_string($_POST['nocontext'])=="") $nocontext = "No Confidence";
else $nocontext = mysql_real_escape_string($_POST['nocontext']);

$sqlq = "UPDATE `webelec`.`candidates` SET `lastname` = '".$nocontext."', `blurb` = '".mysql_real_escape_string($_POST['noconblurb'])."' WHERE position = 'No Confidence'";
$sqlresult = mysql_query($sqlq);
if (!$sqlresult) {
    die('Invalid query: ' . mysql_error());
}

//echo $sqlq;

header("location:index.php#noconfidence");

?>