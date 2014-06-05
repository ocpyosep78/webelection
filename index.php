<?php
//Web-based Election Software
//Copyright (c) 2008, BRAD HEAP, All rights reserved.
//Modified Jan. 2010 by Gabriel Rholl, St. Olaf College SGA Webmaster
//Purpose: Main page; Includes ballot and forces authentication by using
//	code copied from /e-admin authentication methods.

ini_set('display_errors', 1);
ini_set('display_warnings', 1);

//*** Modification by Gabe Rholl 1/2010
//Purpose: To enable LDAP authentication. Imitates e-admin log-in.
if ( isset( $_GET['reset'] ) ) {
	session_start();
	$_SESSION['login'] = NULL; //Log user out- they log in later with "loggedincheck.php"
}
	
include('loggedincheck.php'); //Added to grab authentication from LDAP servers.
//***

$_SESSION['voteformcheck'] = true;			// the setting of this variable ensures that if someone access the voteprocessor.php file
											// without first access this page they will be redirected to this page.
// connect to db server.
include('includes/dbconnection.php');

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
<link href="styles.css" rel="stylesheet" type="text/css" />

<!--*** Modification by Gabe Rholl 1/2010
Purpose: Removed JavaScript Authentication (We use LDAP, and the function
has already been called) 
***-->

<style>

span.plus {
	cursor: pointer;
	text-decoration: underline;
}

div.blurbdis {
	display: none;
}

</style>

<style type="text/css">
	
	body, table {
		font-family: tahoma;
		font-size: 10pt;
	}
	
	body {
		text-align: center;
		margin: 20px auto 20px auto;
		width: 960px;
	}
	
	form {
		background-color: #FFFFCC;
		width: 950px;
		text-align: left;
	}
	
	form p {
		margin-left: 10px;
	}
	
	</style>
<script type="text/javascript">
//<![CDATA[
window.onload = function()
{
	s = document.getElementsByTagName("SPAN");
	for (i = 0; i < s.length; i++)
	{
		if (s[i].className == 'plus')
		{
			s[i].onclick = function()
			{
				x = (this.parentNode).childNodes[1];
				if (x.expanded)
				{
					x.style.display = 'none';
					this.innerHTML = 'Click here to read the candidate\'s blurb';
					x.expanded = false;
				}
				else
				{
					x.style.display = 'block';
					this.innerHTML = 'Click here to close the candidate\'s blurb';
					x.expanded = true;
				}
			}
		}
	}
}

// set the radio button with the given value as being checked
// do nothing if there are no radio buttons
// if the given value does not exist, all the radio buttons
// are reset to unchecked
function setCheckedValue(radioObj, newValue) {
	if(!radioObj)
		return;
	var radioLength = radioObj.length;
	if(radioLength == undefined) {
		radioObj.checked = (radioObj.value == newValue.toString());
		return;
	}
	for(var i = 0; i < radioLength; i++) {
		radioObj[i].checked = false;
		if(radioObj[i].value == newValue.toString()) {
			radioObj[i].checked = true;
		}
	}
}

//]]>
</script>

</head>

<body>
<?php
  // get the name of the title from the server
  $sqlq = "SELECT value FROM options WHERE optionname = CONVERT( _utf8 'electitle' USING latin1 )";
  $sqlresult = mysql_query($sqlq);
  if (!$sqlresult) {
    die('Invalid query: ' . mysql_error());
  }
  $electitle = mysql_fetch_object($sqlresult);
  print '<p id="electitle">'.$electitle->value.'</p>';

  // get the name of the title from the server
  $sqlq = "SELECT value FROM options WHERE optionname = CONVERT( _utf8 'elecdesc' USING latin1 )";
  $sqlresult = mysql_query($sqlq);
  if (!$sqlresult) {
    die('Invalid query: ' . mysql_error());
  }
  $elecdesc = mysql_fetch_object($sqlresult);
  print '<p id="elecdesc">'.$elecdesc->value.'</p>';
?>
<img src="images/header.jpg" alt="header" width="960" height="211" /> <!-- if you have a header image you can insert it here-->
<p id="votingformtitle">Voting Form</p>
<!-- you can put whatever html tags you like here -->
<?php
  // make sure that the time is after election opening
  $sqlq = "SELECT value FROM options where optionname = CONVERT( _utf8 'starttime' USING latin1 )";
  $sqlresult = mysql_query($sqlq);
  if (!$sqlresult) {
    die('Invalid query: ' . mysql_error());
  }
  $starttime = mysql_fetch_object($sqlresult);
  if( time() < $starttime->value ) {
	echo '<p id="votemsg">Voting Opens: '.date('r',$starttime->value).'</p>';
	echo '<p style="text-align: center">The current server time is: '.date('r').'</p>';
	//*** Modification by Gabe Rholl 2/2010
	//Purpose: Added Log Out link
	echo '<p style="text-align: center"><a href="index.php?reset=Y">Log Out</a></p>';
	//***
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
	echo '<p id="votemsg">Voting Closed: '.date('r',$endtime->value).'</p>';
	echo '<p style="text-align: center">The current server time is: '.date('r').'</p>';
	//*** Modification by Gabe Rholl 2/2010
	//Purpose: Added Log Out link
	echo '<p style="text-align: center"><a href="index.php?reset=Y">Log Out</a></p>';
	//***
	exit;
  }
?>
<!--*** Modification by Gabe Rholl 2/2010
Purpose: To prevent page from reloading itself-->
<form action="voteprocessor.php" method="post" enctype="multipart/form-data" name="voteform" id="voteform">
<!--***-->
<table cellpadding="4" cellspacing="0" border="0" id="votetable">
<?php
	//*** Modification by Gabe Rholl 2/2010
	//Purpose: Removed old authentication methods, including Name, ID, DOB, etc.
	//***
	// find out if you require no confidence and store away text and blurb if need be.
	$sqlq = "SELECT value FROM options WHERE optionname = 'nocon'";
	$sqlresult = mysql_query($sqlq);
	if (!$sqlresult) {
    	die('Invalid query: ' . mysql_error());
    }
	$answer = mysql_fetch_object($sqlresult);
	if($answer->value=="yes") {
		$usenocon = true;
		// get no con text and blurb
		$sqlq = "SELECT lastname, blurb FROM candidates WHERE position = 'No Confidence'";
		$sqlresult = mysql_query($sqlq);
		if (!$sqlresult) {
 		   die('Invalid query: ' . mysql_error());
		}
		$noconrow = mysql_fetch_array($sqlresult);
	} else {
		$usenocon = false;
	}
	
	// find out if you need to display the affliation of the candidates
	$sqlq = "SELECT value FROM options WHERE optionname = 'affliation'";
	$sqlresult = mysql_query($sqlq);
	if (!$sqlresult) {
 	   die('Invalid query: ' . mysql_error());
	}
	$useaffliation = mysql_fetch_object($sqlresult);
	
	// find out if you need to display the blurbs of the candidates
	$sqlq = "SELECT value FROM options WHERE optionname = 'blurbs'";
	$sqlresult = mysql_query($sqlq);
	if (!$sqlresult) {
 	   die('Invalid query: ' . mysql_error());
	}
	$useblurbs = mysql_fetch_object($sqlresult);
	
	// find out how the candidates should be ranked.
	$sqlq = "SELECT value FROM options WHERE optionname = 'canorder'";
	$sqlresult = mysql_query($sqlq);
	if (!$sqlresult) {
 	   die('Invalid query: ' . mysql_error());
	}
	$canorder = mysql_fetch_object($sqlresult);
	
	// find out what order the names should be displayed in
	$sqlq = "SELECT value FROM options WHERE optionname = 'presentation'";
	$sqlresult = mysql_query($sqlq);
	if (!$sqlresult) {
 	   die('Invalid query: ' . mysql_error());
	}
	$presentationorder = mysql_fetch_object($sqlresult);

	// loop to create positions and candidates
	$sqlq  = "SELECT * FROM `positions` ORDER BY `positions`.`rank` ASC";
	$sqlresult = mysql_query($sqlq);
	if (!$sqlresult) {
 	   die('Invalid query: ' . mysql_error());
	}
	while($row = mysql_fetch_array($sqlresult)) { // loop through positions
	
		//*** Modification by Gabe Rholl 2/2010
		//Purpose: Check for exclusive positions and user access to those positions
		if($row['voterroll'] != NULL) { //If the position is tied to a voter roll, check the username for vote eligibility
			if(!isset($eligible[$row['voterroll']])) { //If there is no value for this index of eligible, set it to false
				$eligible[$row['voterroll']] = false;
			}
			if(!isset($rollchecked[$row['voterroll']])) { //If there is no value for this index of rollchecked, set it to false
				$rollchecked[$row['voterroll']] = false;
			}
			if($rollchecked[$row['voterroll']] == false) {//If the roll hasn't already been checked, do it
				// check ID against list of eligible voters		
				$sql = "SELECT * FROM `voterroll` WHERE `id` = '".mysql_real_escape_string($_SESSION['user'])."'";
  				$result = mysql_query($sql);
			 	if (!$result) {
			    	die('Invalid query: ' . mysql_error());
				}
				//Search through the voter rolls that the user belongs to
				while($roll = mysql_fetch_array($result)) { 
					if($roll['alias'] == $row['voterroll'] && $roll['id'] == $_SESSION['user']) {
						$eligible[$row['voterroll']] = true;
					}
				} 
				$rollchecked[$row['voterroll']] = true;
			}
			if($eligible[$row['voterroll']] == false) {//Check if user is eligable to vote for this position
				continue; // Break the loop iteration; this user is not authorized to vote here
			} 
		} 
	  //***
	  
	  // first create a blank row that is used as a spacer
	  echo '<tr><td colspan=4><hr /></td></tr>';
	  // create the position being run for
	  echo '<tr><td class="positiontd">'.$row['position'].'</td>';
	  //*** Modification by Gabe Rholl 3/2010
	  //Purpose: Cut out "No Vote" code; we don't allow abstaining
	
	  // create the candidates
	  if($canorder->value == "lastname") {//Put them in order by last name or first name
  		$sqlq2 = "SELECT `rowid` , `lastname` , `firstname`, `affliation` , `blurb` FROM `candidates` WHERE `position` = '".mysql_real_escape_string($row['position'])."' ORDER BY `lastname` ASC";
	  } else {
    	$sqlq2 = "SELECT `rowid` , `lastname` , `firstname`, `affliation` , `blurb` FROM `candidates` WHERE `position` = '".mysql_real_escape_string($row['position'])."' ORDER BY `firstname` ASC";
	  }
	  $sqlresult2 = mysql_query($sqlq2);
	  if (!$sqlresult2) {
	    die('Invalid query: ' . mysql_error());
	  }
	  
	  //Load up candidates into an array
	  $numCan = mysql_numrows($sqlresult2);
	  for($i = 0; $i < $numCan; $i++){
		  $data[$i] = mysql_fetch_array($sqlresult2);
	  }
	  
	  if ($numCan > 1) {shuffle($data);} // Randomize order
	  
  	for($i = 0; $i < $numCan; $i++) { //loop through candidates
	  	
		//*** GR: Added for formatting of table; adds extra column if not in first row (first row has position name)
 		if($i != 0) { echo '<td class="positiontd">&nbsp;</td>'; }
  		
		if($presentationorder->value == "firstnamefirst") { //order firstname first
			echo '<td width=180 valign="top"><label><input name="'.$row['position'].'" type="radio" value="'.$data[$i]['rowid'].'" /><span class="firstname">'.$data[$i]['firstname'].'</span> <span class="lastname">'.$data[$i]['lastname'].'</span></label></td>';
		} else { //order lastname first
		    echo '<td width=180 valign="top"><label><input name="'.$row['position'].'" type="radio" value="'.$data[$i]['rowid'].'" /><span class="lastname">'.$data[$i]['lastname'].',</span> <span class="firstname">'.$data[$i]['firstname'].'</span></label></td>';
		}
		if($useaffliation->value == "yes") { //Show affiliations
			if($data[$i]['affliation']=="") { //No affiliation
				echo '<td class="affliation" width=100 valign="top">&nbsp;</td>';
			} else // Yes there is an affiliation!
			echo '<td class="affliation" width=100 valign="top">( '.$data[$i]['affliation'].' )</td>';
		}
		if($useblurbs->value == "yes") { //show blurbs
			echo '<td class="blurbtext"><span class="plus">Click here to read the candidate\'s blurb</span><div class="blurbdis"><span>'.nl2br($data[$i]['blurb']).'</span></div></td></tr>';
		}
		
	  } // End candidate loop
	
	  // create no confidence
	  if($usenocon == "true")  {
		  if($useaffliation->value == "yes") {
		  	if($useblurbs->value == "yes") {
				echo '<tr><td class="positionid">&nbsp;</td><td class="nocon"><label><input name="'.$row['position'].'" type="radio" value="noConfidence" />'.$noconrow['lastname'].'</label></td><td class="affliation">&nbsp;</td><td class="blurbtext">'.$noconrow['blurb'].'</td></tr>';
			} else {
				echo '<tr><td class="positionid">&nbsp;</td><td class="nocon"><label><input name="'.$row['position'].'" type="radio" value="noConfidence" />'.$noconrow['lastname'].'</label></td><td class="affliation">&nbsp;</td></tr>';
			}
		  } else {
		  	if($useblurbs->value == "yes") {
				echo '<tr><td class="positionid">&nbsp;</td><td class="nocon"><label><input name="'.$row['position'].'" type="radio" value="noConfidence" />'.$noconrow['lastname'].'</label></td><td class="blurbtext">'.$noconrow['blurb'].'</td></tr>';
			} else {
				echo '<tr><td class="positionid">&nbsp;</td><td class="nocon"><label><input name="'.$row['position'].'" type="radio" value="noConfidence" />'.$noconrow['lastname'].'</label></td></tr>';
			}
		  }
	  } 
	  
	//For every position, there needs to be the option for a write-in (by-laws)
	echo '<tr><td class="positiontd">&nbsp;</td><td><label><input name="'.$row['position'].'" type="radio" value="writeIn" /><span class="firstname">Write In: </span></label><input type="text" name="'.$row['position'].'-wi'.'" onclick="setCheckedValue(document.forms[\'voteform\'].elements[\''.$row['position'].'\'], \'writeIn\');" /></td><td class="affliation">&nbsp;</td><td class="blurbtext">&nbsp;</td></tr>'; 
	} // End While Loop of positions
?>
<tr>
<td colspan="4"><hr /></td>
</tr>
<tr>
<td>&nbsp;</td>
<td><input type="submit" name="Submit" value="Cast Votes" /></td>
<td>&nbsp;</td>
</tr>
</table>
</form>
</body>
</html>