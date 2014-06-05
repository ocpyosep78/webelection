<?php
//Web-based Election Software
//Copyright (c) 2008, BRAD HEAP, All rights reserved.
//Modified Jan. 2010 by Gabriel Rholl, St. Olaf College SGA Webmaster
//Purpose: To display a vote-admin page that can be used to fix any vote irregularities

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

<title>Vote Admin</title></head>
<body>
<h1 align="center">WARNING: Altering the votes alters the results of the election</h1>
<h2 align="center">This page should only be used to fix problems such as double voters and non-eligible voters only.</h2>
<table cellpadding="0" cellspacing="0" border="1" width="100%">
<tr>
<td><strong>Student ID</strong></td>
<td><strong>Lastname</strong></td>
<td><strong>Firstname</strong></td>
<td><strong>Delete</strong></td>
<?php
$sqlq = "SELECT * FROM voters ORDER by id ASC";
$sqlresult = mysql_query($sqlq);
if (!$sqlresult) {
    die('Invalid query: ' . mysql_error());
}

while($row = mysql_fetch_array($sqlresult)) {
	print "<tr><td>".$row['id']."</td><td>".$row['lastname']."</td><td>".$row['firstname']."</td><td><a href=\"deletevote.php?id=".$row['id']."\" onclick=\"return confirm('This action cannot be undone. Are you sure you want to proceed?');\">Delete Votes</a></td></tr>";
}

?>
</tr>
</table>
</body>
</html>