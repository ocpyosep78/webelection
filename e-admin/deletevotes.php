<?php
//Web-based Election Software
//Copyright (c) 2008, BRAD HEAP, All rights reserved.
//No modification Jan. 2010 by Gabriel Rholl, St. Olaf College SGA Webmaster
//Purpose: Function to delete all votes from the election database

ini_set('display_errors', 1);
ini_set('display_warnings', 1);

include('loggedincheck.php');

// connect to db server.
include('../includes/dbconnection.php');

$sql = "TRUNCATE TABLE `votes`";
$sqlresult = mysql_query($sql);
if (!$sqlresult) {
    die('Invalid query: ' . mysql_error());
}

$sql = "TRUNCATE TABLE `voters`";
$sqlresult = mysql_query($sql);
if (!$sqlresult) {
    die('Invalid query: ' . mysql_error());
}

$sql = "TRUNCATE TABLE `specialvotes`";
$sqlresult = mysql_query($sql);
if (!$sqlresult) {
    die('Invalid query: ' . mysql_error());
}

$sql = "TRUNCATE TABLE `specialvoters`";
$sqlresult = mysql_query($sql);
if (!$sqlresult) {
    die('Invalid query: ' . mysql_error());
}

header("location:index.php#resetdata");

?>