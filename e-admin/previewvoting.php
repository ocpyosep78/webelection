<?php
//Web-based Election Software
//Copyright (c) 2008, BRAD HEAP, All rights reserved.
//No modification Jan. 2010 by Gabriel Rholl, St. Olaf College SGA Webmaster
//Purpose: Function to display a preview of the ballot. As of 3/3, does not accurately represent real ballot.

ini_set('display_errors', 1);
ini_set('display_warnings', 1);
include('loggedincheck.php');

//session_start();
$_SESSION['voteformcheck'] = true;

// connect to db server.
include('../includes/dbconnection.php');

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<base href="http://elections.asa.ac.nz/" />
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
<script language="javascript" type="text/javascript">
<!--

function checkform(form) {

	if(form.studentid.value=="") {
		alert("Please enter you student id");
		form.studentid.focus();
		return false;
	}
	
	if(form.studentid.value.length<6) {
		alert("Please enter you student id");
		form.studentid.focus();
		return false;
	}
	
	if (form.studentid.value != form.cstudentid.value) {
    alert( "Please make sure your student id matches" );
    form.studentid.focus();
    return false ;
  }
	
	if(form.lastname.value=="") {
		alert("Please enter you last name");
		form.lastname.focus();
		return false;
	}
	
	if (form.firstname.value=="") {
		alert("Please enter you firstname");
		form.firstname.focus();
		return false;
	} 
	
	//return true;
	return false; /* this is only because of this being fake*/

}

-->
</script>
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
//]]>
</script>

</head>

<body>
<!--<?php
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
?>-->
<img src="header.jpg" width="600" height="108" />
<p id="votingformtitle">Voting Form</p>

<form action="voteprocessor.php" method="post" enctype="multipart/form-data" name="voteform" id="voteform" onsubmit="return checkform(this)">
<table cellpadding="4" cellspacing="0" border="0" id="votetable">
<tr>
<td class="studentidtd">Student ID Number:</td>
<td><input name="studentid" type="text" id="studentid" /></td>
<td>&nbsp;</td>
</tr>
<tr>
<td class="studentidtd">Confirm Student ID Number:</td>
<td><input name="cstudentid" type="text" id="cstudentid" /></td>
<td>&nbsp;</td>
</tr>
<tr>
  <td id="lastnametd">Full Last Name: </td>
  <td><input name="lastname" type="text" id="lastname" /></td>
  <td>&nbsp;</td>
</tr>
<tr>
  <td id="firstnametd">Full First Name: </td>
  <td><input name="firstname" type="text" id="firstname" /></td>
  <td>&nbsp;</td>
</tr>
<tr>
  <td id="dobetd">Date of Birth: </td>
  <td>
    <select name="dobyear" id="dobyear">
      <option value="Year">Year</option>
      <?php
	  	for($i=1993;$i>=1920;$i--) {
			echo "<option value=".$i.">".$i."</option>";
		}
	  ?>
    </select>
    <select name="dobmonth" id="dobmonth">
      <option value="Month">Month</option>
      <?php
	  	for($i=1;$i<13;$i++) {
			printf ("<option value=%02d>%02d</option>",$i,$i);
		}
	  ?>
    </select>
    <select name="dobday" id="dobday">
      <option value="Day">Day</option>
      <?php
	  	for($i=1;$i<32;$i++) {
			printf ("<option value=%02d>%02d</option>",$i,$i);
		}
	  ?>
    </select>
    </td>
  <td>&nbsp;</td>
</tr>
<?php
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
	while($row = mysql_fetch_array($sqlresult)) {

  // first create a blank row that is used as a spacer
  echo '<tr><td colspan=4><hr /></td></tr>';
  // create the position being run for
  if($useaffliation->value == "yes") {
  	if($useblurbs->value == "yes") {
  		echo '<tr><td class="positiontd">'.$row['position'].'</td><td class="novotetd"><label><input name="'.$row['position'].'" type="radio" value="noVote" checked />No Vote</label></td><td class="affliation">&nbsp;</td><td class="blurbtext">&nbsp;</td></tr>';
  	} else {
	    echo '<tr><td class="positiontd">'.$row['position'].'</td><td class="novotetd"><label><input name="'.$row['position'].'" type="radio" value="noVote" checked />No Vote</label></td><td class="affliation">&nbsp;</td></tr>';
	}
  } else {
  	if($useblurbs->value == "yes") {
    	echo '<tr><td class="positiontd">'.$row['position'].'</td><td class="novotetd"><label><input name="'.$row['position'].'" type="radio" value="noVote" checked />No Vote</label></td><td class="blurbtext">&nbsp;</td></tr>';
  	} else {
	    echo '<tr><td class="positiontd">'.$row['position'].'</td><td class="novotetd"><label><input name="'.$row['position'].'" type="radio" value="noVote" checked />No Vote</label></td></tr>';
	}
  }

  // create the candidates
  if($canorder->value == "lastname") {
  	$sqlq2 = "SELECT `rowid` , `lastname` , `firstname`, `affliation` , `blurb` FROM `candidates` WHERE `position` = '".mysql_real_escape_string($row['position'])."' ORDER BY `lastname` ASC";
  } else {
    $sqlq2 = "SELECT `rowid` , `lastname` , `firstname`, `affliation` , `blurb` FROM `candidates` WHERE `position` = '".mysql_real_escape_string($row['position'])."' ORDER BY `firstname` ASC";
  }
  $sqlresult2 = mysql_query($sqlq2);
  if (!$sqlresult2) {
    die('Invalid query: ' . mysql_error());
  }
  while($canrow = mysql_fetch_array($sqlresult2)) {
  	
	echo '<tr><td class="positiontd">&nbsp;</td>';
	if($presentationorder->value == "firstnamefirst") {
		echo '<td width=180 valign="top"><label><input name="'.$row['position'].'" type="radio" value="'.$canrow['rowid'].'" /><span class="firstname">'.$canrow['firstname'].'</span> <span class="lastname">'.$canrow['lastname'].'</span></label></td>';
	} else {
	    echo '<td width=180 valign="top"><label><input name="'.$row['position'].'" type="radio" value="'.$canrow['rowid'].'" /><span class="lastname">'.$canrow['lastname'].',</span> <span class="firstname">'.$canrow['firstname'].'</span></label></td>';
	}
	if($useaffliation->value == "yes") {
		if($canrow['affliation']=="") {
			echo '<td class="affliation" width=100 valign="top">&nbsp;</td>';
		} else 
		echo '<td class="affliation" width=100 valign="top">( '.$canrow['affliation'].' )</td>';
	}
	if($useblurbs->value == "yes") {
		echo '<td class="blurbtext"><span class="plus">Click here to read the candidate\'s blurb</span><div class="blurbdis"><span>'.nl2br($canrow['blurb']).'</span></div></td></tr>';
	}
	
  }

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

}

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
