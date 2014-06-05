<?php
//Web-based Election Software
//Copyright (c) 2008, BRAD HEAP, All rights reserved.
//Modified Jan. 2010 by Gabriel Rholl, St. Olaf College SGA Webmaster
//Purpose: To log the user's votes in the SGL database following submission

ini_set('display_errors', 1);
ini_set('display_warnings', 1);

session_start();

if( is_null($_SESSION['voteformcheck']) ) {			// if this file is accessed without first going through index.php redirect
	header('location:index.php');
	exit;
} 

// connect to db server.
include('includes/dbconnection.php');

// check election timing.
  // make sure that the time is after election opening
  $sqlq = "SELECT value FROM options where optionname = CONVERT( _utf8 'starttime' USING latin1 )";
  $sqlresult = mysql_query($sqlq);
  if (!$sqlresult) {
    die('Invalid query: ' . mysql_error());
  }
  $starttime = mysql_fetch_object($sqlresult);
  if( time() < $starttime->value ) {
	header("location:index.php");
	exit;
  } 

  // make sure that the time is before the election closing
  $sqlq = "SELECT value FROM options where optionname = CONVERT( _utf8 'endtime' USING latin1 )";
  $sqlresult = mysql_query($sqlq);
  if (!$sqlresult) {
    die('Invalid query: ' . mysql_error());
  }
  $endtime = mysql_fetch_object($sqlresult);
  if( time() > $endtime->value ) {
	header("location:index.php");
	exit;
  }

// check against list of previous voters
$voterid = mysql_real_escape_string($_SESSION['user']);
$alreadyvoted = false;
$sqlq = "SELECT id FROM voters WHERE voters.id = '".$voterid."'";
$resultq = mysql_query($sqlq);
if (!$resultq) {
    die('Invalid query: ' . mysql_error());
}
while($row = mysql_fetch_array($resultq)) {
	$_SESSION['login'] = NULL; //Log voter out if they're voting too many times
	header("location:voteerror.php?error=1");
	exit;
}

$sqlq = "SELECT id FROM specialvoters WHERE specialvoters.id = '".$voterid."'";
$resultq = mysql_query($sqlq);
if (!$resultq) {
    die('Invalid query: ' . mysql_error());
}
while($row = mysql_fetch_array($resultq)) {
	header("location:voteerror.php?error=1");
	exit;
}

//check options to check if you need to check the roll.
$sqlq = "SELECT value FROM options where options.optionname = 'useroll'";
$resultq = mysql_query($sqlq);
if (!$resultq) {
    die('Invalid query: ' . mysql_error());
}
$useroll = mysql_fetch_object($resultq);
if( $useroll->value == "yes") {
	// check ID against list of eligerable voters
	$notonroll = true;
	$file = fopen("roll.dat","r");
	while( ($currentLine = fgets($file)) != NULL) {
		//$s = $voterid.",".$_POST['dobyear']."-".$_POST['dobmonth']."-".$_POST['dobday'];		// use this line if you want to check against date of birth
		if(strstr($currentLine,$voterid) != false ) {	// match has been found					// otherwise un comment this line
		//if(strstr($currentLine,$s) != false ) {	// match has been found							// and comment this one.
			$notonroll = false;
		} 
	}
	fclose($file);
	if($notonroll ) {
	
		// find out if special are allowed
		$sqlq = "SELECT value FROM options where options.optionname = 'allowspecial'";
		$resultq = mysql_query($sqlq);
		if (!$resultq) {
   			 die('Invalid query: ' . mysql_error());
		}
		$specialvotes = mysql_fetch_object($resultq);
		
		// if true process special
		if($specialvotes->value=="yes") {
		
			// Record id, firstname, lastname into votersdb
			$sqlq = "INSERT INTO specialvoters (id, lastname, firstname) VALUES ('".mysql_real_escape_string($_SESSION['user'])."','".mysql_real_escape_string($_POST['lastname'])."','".mysql_real_escape_string($_POST['firstname'])."')";
			$resultq = mysql_query($sqlq);
			if (!$resultq) {
    			die('Invalid query: ' . mysql_error());
			}
			
			// Record id, position, candidate into votesdb - this needs to be a loop for each position.
			
			// loop through the positions being contested
			$sqlq  = "SELECT * FROM `positions`";
			$sqlresult = mysql_query($sqlq);
			if (!$sqlresult) {
    			die('Invalid query: ' . mysql_error());
			}
			while($row = mysql_fetch_array($sqlresult)) { // SPECIAL VOTES
				$sql2q = "INSERT INTO specialvotes (id, pos, can) VALUES ('".mysql_real_escape_string($_SESSION['user'])."','".mysql_real_escape_string($row['position'])."','".mysql_real_escape_string($_POST[addslashes(str_replace(" ","_",$row['position']))])."')";
				$resultq = mysql_query($sql2q);
				if (!$resultq) {
    				die('Invalid query: ' . mysql_error());
				}
			}
			
			header("location:complete.php");
			exit;
		
		// if not prompt error.
		} else {
			header("location:voteerror.php?error=2");
			exit;
		}
	}
}

// Record id, firstname, lastname into votersdb
$sqlq = "INSERT INTO voters (id, lastname, firstname) VALUES ('".mysql_real_escape_string($_SESSION['user'])."','".mysql_real_escape_string($_POST['lastname'])."','".mysql_real_escape_string($_POST['firstname'])."')";
$resultq = mysql_query($sqlq);
if (!$resultq) {
    die('Invalid query: ' . mysql_error());
}

// Record id, position, candidate into votesdb - this needs to be a loop for each position.

// loop through the positions being contested
$sqlq  = "SELECT * FROM `positions`";
$sqlresult = mysql_query($sqlq);
if (!$sqlresult) {
    die('Invalid query: ' . mysql_error());
}
while($row = mysql_fetch_array($sqlresult)) {
	//Write-in stuff (NOTE: STILL SET FOR POSTGRESQL!!!
	//!!!!!!!!!!!!
	
	
	//$sql = "SELECT lastname FROM candidates WHERE rowid = '".intval($_POST[addslashes(str_replace(" ","_",$row['position']))])."'";
	//$result = pg_query($sql);
	//if (!$result) {
	//    die('Invalid query: ' . pg_last_error());
	//}
	//$lastname = pg_fetch_array($result);
	//if($lastname == 'Write-in') {
	//	$sqlq = "INSERT INTO writein (position, name) VALUES ('".pg_escape_string($row['position'])."','".pg_escape_string($_POST['wi-'.str_replace(" ","_",$row['position']))])."')";
	//	$resultq = pg_query($sqlq);
	//	if (!$resultq) {
	//    	die('Invalid query: ' . pg_last_error());
	//	}
	//}
	
	if(isset($_POST[addslashes(str_replace(" ","_",$row['position']))])){ // Added to compensate for positions that are not voted on by everyone (Were there any votes at all?)
		$sqlq = "INSERT INTO votes (id, pos, can) VALUES ('".mysql_real_escape_string($_SESSION['user'])."','".mysql_real_escape_string($row['position'])."','".mysql_real_escape_string($_POST[addslashes(str_replace(" ","_",$row['position']))])."')";
		$resultq = mysql_query($sqlq);
		if (!$resultq) {
    		die('Invalid query: ' . mysql_error());
		}
		// Send in write-in if necessary
		if($_POST[addslashes(str_replace(" ","_",$row['position']))] == 'writeIn') {
			$sqlq = "INSERT INTO write_in_candidates (position, candidate_name) VALUES ('".mysql_real_escape_string($row['position'])."','".mysql_real_escape_string($_POST[addslashes(str_replace(" ","_",$row['position'].'-wi'))])."')";
			$resultq = mysql_query($sqlq); // update results table
			if (!$resultq) {
   				die('Invalid query: ' . mysql_error());
			} 
		}
	}
}

/*foreach($_POST as $key => $value) {
	echo stripslashes(str_replace("_"," ",$key));
	echo $value;
}*/

// redirect to thank you page
$_SESSION['login'] = false; //Log user out
header("location:complete.php");

?>