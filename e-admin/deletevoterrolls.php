<?php
//Web-based Election Software
//Copyright (c) 2008, BRAD HEAP, All rights reserved.
//Created Jan. 2010 by Gabriel Rholl, St. Olaf College SGA Webmaster
//Purpose: Function to delete all voter rolls from the election database

ini_set('display_errors', 1);
ini_set('display_warnings', 1);

include('loggedincheck.php');

// connect to db server.
include('../includes/dbconnection.php');

$sql = "TRUNCATE TABLE `voterroll`";

$sqlresult = mysql_query($sql);
if (!$sqlresult) {
    die('Invalid query: ' . mysql_error());
}

header("location:index.php#resetdata");

?>