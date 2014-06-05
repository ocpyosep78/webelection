<?php
//Web-based Election Software
//Copyright (c) 2008, BRAD HEAP, All rights reserved.
//No modification Jan. 2010 by Gabriel Rholl, St. Olaf College SGA Webmaster
//Purpose: Function to delete all candidates in the election database

ini_set('display_errors', 1);
ini_set('display_warnings', 1);
include('loggedincheck.php');

// connect to db server.
include('../includes/dbconnection.php');

$sql = "TRUNCATE TABLE `candidates`";

$sqlresult = mysql_query($sql);
if (!$sqlresult) {
    die('Invalid query: ' . mysql_error());
}

//*** Modification by Gabe Rholl 1/2010
//Purpose: To add affiliation to the fields deleted. (Bug in original version)
$sql = "INSERT INTO `candidates` (`rowid` ,`lastname` ,`firstname` ,`position` ,`affliation` ,`blurb`) VALUES (NULL , 'No Confidence', '', 'No Confidence', '')";
//***
$sqlresult = mysql_query($sql);
if (!$sqlresult) {
    die('Invalid query: ' . mysql_error());
}

header("location:index.php#resetdata");

?>