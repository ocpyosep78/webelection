<?php
//Web-based Election Software
//Copyright (c) 2008, BRAD HEAP, All rights reserved.
//Modified Feb. 2010 by Gabriel Rholl, St. Olaf College SGA Webmaster
//Purpose: To hold log-on values of the MySQL server

$serveraddr = "mysql.stolaf.edu";		// this is the location of your database server - normally localhost
$dbuser = "oleville";			// this is the username you need to log into your mysql server
$dbpassword = "juniper";		// this is the password for the user.
$dbname = 'oleville';			// this is the name of the database on the db server

if(!$dbconn = mysql_connect($serveraddr,$dbuser,$dbpassword)) {				// connect to the db server
	print '<p><strong>ERROR: </strong>Could not connect to db server</p>';
	exit;
}
if(!mysql_select_db($dbname)) {
	print '<p><strong>ERROR: </strong>Could not connect to db on server</p>';
	exit;
}

?>