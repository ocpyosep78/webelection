<?php
//Web-based Election Software
//Copyright (c) 2008, BRAD HEAP, All rights reserved.
//Page created Jan. 2010 by Gabriel Rholl, St. Olaf College SGA Webmaster
//Purpose: Function to create a new voter roll. Receives .dat file and uploads it 
//	in the election database.

ini_set('display_errors', 1);
ini_set('display_warnings', 1);
include('loggedincheck.php');

// connect to db server.
include('../includes/dbconnection.php');

$file = fopen($_POST['voterroll'] . ".dat","r");
while( ($currentLine = fgets($file)) != NULL) {//scan through each line of the file
	$voterid = trim($currentLine);
	$sqlq = "INSERT INTO voterroll (id, alias) VALUES ('".mysql_real_escape_string($voterid)."','".mysql_real_escape_string($_POST['voterroll'])."')";
	$resultq = mysql_query($sqlq);
	if (!$resultq) {
	    die('Invalid query: ' . mysql_error());
	}
}
fclose($file);

header("location:index.php#positions");

?>