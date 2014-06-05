<?php
//Web-based Election Software
//Copyright (c) 2008, BRAD HEAP, All rights reserved.
//No modification Jan. 2010 by Gabriel Rholl, St. Olaf College SGA Webmaster
//Purpose: Function to alter the dates of the election

ini_set('display_errors', 1);
ini_set('display_warnings', 1);
include('loggedincheck.php');

// connect to db server.
include('../includes/dbconnection.php');

// create time for start
$starttime = mktime(mysql_real_escape_string($_POST['starthour']),mysql_real_escape_string($_POST['startmin']),0,mysql_real_escape_string($_POST['startmonth']),mysql_real_escape_string($_POST['startday']),mysql_real_escape_string($_POST['startyear']));
$sqlq = "UPDATE options SET value = '".$starttime."' WHERE optionname = 'starttime'";
$sqlresult = mysql_query($sqlq);
if (!$sqlresult) {
    die('Invalid query: ' . mysql_error());
}

// create time for end
$endtime = mktime(mysql_real_escape_string($_POST['endhour']),mysql_real_escape_string($_POST['endmin']),0,mysql_real_escape_string($_POST['endmonth']),mysql_real_escape_string($_POST['endday']),mysql_real_escape_string($_POST['endyear']));
$sqlq = "UPDATE options SET value = '".$endtime."' WHERE optionname = 'endtime'";
$sqlresult = mysql_query($sqlq);
if (!$sqlresult) {
    die('Invalid query: ' . mysql_error());
}

header("location:index.php#timing");

?>