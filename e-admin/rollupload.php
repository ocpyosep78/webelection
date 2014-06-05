<?php
//Web-based Election Software
//Copyright (c) 2008, BRAD HEAP, All rights reserved.
//No modification Jan. 2010 by Gabriel Rholl, St. Olaf College SGA Webmaster
//Purpose: Processes the voter-roll technology provided by the software designer (not Gabe!)
// 	Doesn't seem to work. I'd like to cut it.

ini_set('display_errors', 1);
ini_set('display_warnings', 1);
include('loggedincheck.php');

// connect to db server.
include('../includes/dbconnection.php');

if( move_uploaded_file($_FILES['newfile']['tmp_name'],"../roll.dat")) {
	chmod("../roll.dat",0777);
	header("location:index.php#security");
	exit;
}



?>