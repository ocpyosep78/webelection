<?php
//Web-based Election Software
//Copyright (c) 2008, BRAD HEAP, All rights reserved.
//Modification Jan. 2010 by Gabriel Rholl, St. Olaf College SGA Webmaster
//Purpose: Function to create a new position in the election database; also 
//	check to see if the position needs a voter roll and attach that on if so

ini_set('display_errors', 1);
ini_set('display_warnings', 1);

include('loggedincheck.php');

// connect to db server.
include('../includes/dbconnection.php');

//*** Modification by Gabe Rholl 1/2010
//Purpose: To conditionally add a new position. Replaces original code. 

//Check to see if there is voter exclusivity for this position, then act correspondingly
if(isset($_POST['rollcheck']) && $_POST['rollcheck'] == 'Yes' && $_POST['voterroll'] != '') {
	//Yes, you need to apply exclusivity
	$sqlq = "INSERT INTO positions (position, rank, voterroll) VALUES ('".mysql_real_escape_string($_POST['positionname'])."','".mysql_real_escape_string($_POST['rank'])."','".mysql_real_escape_string($_POST['voterroll'])."')";
	$sqlresult = mysql_query($sqlq);
	if (!$sqlresult) {
	    die('Invalid query: ' . mysql_error());
	}
} else {
	// No, create a normal candidate with null values in the voterroll position to indicate so
	$sqlq = "INSERT INTO positions (position, rank, voterroll) VALUES ('".mysql_real_escape_string($_POST['positionname'])."','".mysql_real_escape_string($_POST['rank'])."',NULL)";
	$sqlresult = mysql_query($sqlq);
	if (!$sqlresult) {
	    die('Invalid query: ' . mysql_error());
	}
}
//***

header("location:index.php#positions");

?>

