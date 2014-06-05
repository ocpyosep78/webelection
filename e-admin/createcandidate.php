<?php
//Web-based Election Software
//Copyright (c) 2008, BRAD HEAP, All rights reserved.
//No modification Jan. 2010 by Gabriel Rholl, St. Olaf College SGA Webmaster
//Purpose: Function to add a candidate to the election database

ini_set('display_errors', 1);
ini_set('display_warnings', 1);
include('loggedincheck.php');

// connect to db server.
include('../includes/dbconnection.php');

$sqlq = "INSERT INTO candidates (lastname, firstname, position, affliation, blurb) VALUES ('".mysql_real_escape_string($_POST['lastname'])."','".mysql_real_escape_string($_POST['firstname'])."','".mysql_real_escape_string($_POST['role'])."','".mysql_real_escape_string($_POST['affliation'])."','".mysql_real_escape_string($_POST['blurb'])."')";
$sqlresult = mysql_query($sqlq);
if (!$sqlresult) {
    die('Invalid query: ' . mysql_error());
}

header("location:index.php#candidates");

?>