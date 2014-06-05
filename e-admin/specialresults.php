<?php
//Web-based Election Software
//Copyright (c) 2008, BRAD HEAP, All rights reserved.
//No modification Jan. 2010 by Gabriel Rholl, St. Olaf College SGA Webmaster
//Purpose: Function to allow viewing of "special votes". We don't use it and I'd like to cut it

ini_set('display_errors', 1);
ini_set('display_warnings', 1);
include('loggedincheck.php');

// connect to db server.
include('../includes/dbconnection.php');

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<?php
  // get the name of the title from the server
  $sqlq = "SELECT value FROM options WHERE optionname = CONVERT( _utf8 'electitle' USING latin1 )";
  $sqlresult = mysql_query($sqlq);
  if (!$sqlresult) {
    die('Invalid query: ' . mysql_error());
  }
  $electitle = mysql_fetch_object($sqlresult);
  print '<title>'.$electitle->value.'</title>';
?>
</head>

<body>
<h1 align="center">Results of Special Votes </h1>
<?php

// loop through list of positions
$sqlq  = "SELECT position FROM `positions` ORDER BY `positions`.`rank` ASC";
$sqlresult = mysql_query($sqlq);
if (!$sqlresult) {
    die('Invalid query: ' . mysql_error());
}
while($row = mysql_fetch_array($sqlresult)) {

	print "<strong>".$row['position']."</strong>";

	// for each positions loop through each candidate.
	$sql2 = "SELECT rowid, lastname, firstname FROM candidates WHERE position = '".mysql_real_escape_string($row['position'])."'";
	$sql2result = mysql_query($sql2);
	if (!$sql2result) {
    	die('Invalid query: ' . mysql_error());
	}
	while($row2 = mysql_fetch_array($sql2result)) {
	
		print '<br />'.$row2['firstname'].' '.$row2['lastname'].' ';
	
		// for each candidate count number of votes where candidate = candidate id
		$sql3 = "SELECT * FROM specialvotes WHERE specialvotes.can = '".$row2['rowid']."'";
		$sql3result = mysql_query($sql3);
		if (!$sql3result) {
    		die('Invalid query: ' . mysql_error());
		}
		print mysql_num_rows($sql3result);
	
	}
	
	// get the number of no confidence votes
	$sql2 = "SELECT * FROM specialvotes WHERE specialvotes.can = 'noConfidence' AND specialvotes.pos = '".mysql_real_escape_string($row['position'])."'";
	$sql2result = mysql_query($sql2);
	print "<br />No Confidence ".mysql_num_rows($sql2result);
	
	// get the number of no votes
	$sql2 = "SELECT * FROM specialvotes WHERE specialvotes.can = 'noVote' AND specialvotes.pos = '".mysql_real_escape_string($row['position'])."'";
	$sql2result = mysql_query($sql2);
	print "<br />No Vote ".mysql_num_rows($sql2result);
	
	print "<br /><br />";
	
}

?>
<p>&nbsp;</p>
</body>
</html>