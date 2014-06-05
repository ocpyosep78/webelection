<?php
//Web-based Election Software
//Copyright (c) 2008, BRAD HEAP, All rights reserved.
//Modified Jan. 2010 by Gabriel Rholl, St. Olaf College SGA Webmaster
//Purpose: Displays options for admin manipulation of election

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
<title>Election Admin</title>
<style type="text/css">
<!--
.style1 {font-size: small}
-->
</style>
<script language="javascript" type="text/javascript" src="tiny_mce/tiny_mce.js"></script>
<script language="javascript" type="text/javascript">
tinyMCE.init({
	mode : "textareas",
	theme : "advanced",
	editor_selector : "mceEditor",
	editor_deselector : "mceNoEditor",
	theme_advanced_toolbar_location : "top",
	theme_advanced_toolbar_align : "center",
	theme_advanced_statusbar_location : "bottom"
});
</script>
<script language="JavaScript" type="text/javascript">
<!--

function checkelecname(form) {

	if(form.title.value == "") {
		alert("Please enter a name for the election");
		form.title.focus();
		return false;
	}

	return true;
}

function checkpos(form) {

	if(form.positionname.value == "") {
		alert("Please enter a name for the position");
		form.positionname.focus();
		return false;
	}
	
	if(form.rank.value == "0") {
		alert("Please enter a rank for the position");
		form.rank.focus();
		return false;
	}
	
	return true;
	
}

function checkcan(form) {

	if(form.lastname.value=="") {
		alert("Please enter the candidate's last name");
		form.lastname.focus();
		return false;
	}
	
	if(form.firstname.value=="") {
		alert("Please enter the candidate's first name");
		form.firstname.focus();
		return false;
	}
	
	return true;
}

function checkpass ( form )
{

  if (form.username.value == "") {
  	alert( "Please enter a username" );
	form.username.focus();
	return false;
  }
  
  if (form.userpass.value == "") {
  	alert( "Please enter a password" );
	form.userpass.focus();
	return false;
  }

  if (form.userpass.value != form.userpasscheck.value) {
    alert( "Passwords do not match" );
    form.userpass.focus();
    return false ;
  }

  return true ;
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
<h1 align="center">Web-based Election Administration Interface</h1>
<p align="center" class="style1">&copy; 2008 Brad Heap (www.brad.net.nz). This software is free to use and distribute including code. However, this copyright message should remain in place at all times. You are free to modify the code for your own purposes provided that a base message is left in place crediting me. No guarantee of any form is given for use of this software. Use at your own peril. </p>
<p align="left" class="style1">If you have not already done so. Make sure that you load the <code>sqldump.sql</code> file into your SQL server before proceeding any further. Also check the settings in the <code>includes/dbconnection.php</code> file. Finally make sure Javascript is enabled. Failure to do so will result in non-functionality of this software.</p>
<h2 align="center">If you can see this you have successfully logged in. Well done.</h2>
<p align="left">Creating an election is easy. Just follow the steps outlined below and you will be up and running in under 10 minutes. (I hope). </p>
<hr />
<p><strong>1. Initial Setup.</strong></p>
<blockquote>
  <p><strong><a name="userdata" id="userdata"></a>1a</strong>. If you have not changed the default username and password do it now. You do not want the entire world to be able to muck about with your election.</p>
  <form action="changeuser.php" method="post" enctype="multipart/form-data" name="userdata" id="userdata" onSubmit="return checkpass(this);">
  <table border="0" cellpadding="2" cellspacing="0">
  <tr>
  <td>New Username: </td>
  <td><input name="username" type="text" id="username" /></td>
  </tr>
  <tr>
  <td>New Password: </td>
  <td><input name="userpass" type="password" id="userpass" /></td>
  </tr>
  <tr>
  <td>Confirm Password:</td>
  <td><input name="userpasscheck" type="password" id="userpasscheck" /></td>
  </tr>
  <tr>
  <td>&nbsp;</td>
  <td><input type="submit" name="Submit" value="Change Login" /></td>
  </tr>
    </table>

  </form>
  <p><a name="resetdata" id="resetdata"></a><strong>1b.</strong> If you have run an election before on this server make sure that you clear out the old data. Otherwise you will end up with a very messed up and corrupt result. </p>
  <p><strong>Warning:</strong> The following actions cannot be undone. </p>
  <ul>
    <li><a href="http://www.oleville.com/election/e-admin/deletevotes.php" onclick="return confirm('This action cannot be undone. Are you sure you want to proceed?');">Click here to clear out all of the old votes</a>.</li>
    <li><a href="http://www.oleville.com/election/e-admin/deletecandidates.php" onclick="return confirm('This action cannot be undone. Are you sure you want to proceed?');">Click here to clear out all of the old candidates.</a></li>
    <li><a href="http://www.oleville.com/election/e-admin/deletepositions.php" onclick="return confirm('This action cannot be undone. Are you sure you want to proceed?');">Click here to clear out all of the old positions.</a> <em>(Note: Only click this button if the positions that are being contested have changed.)</em></li>
<!--*** Modification by Gabriel Rholl 3/10, Purpose: Add in a voter roll deletion option-->   
    <li><a href="http://www.oleville.com/election/e-admin/deletevoterrolls.php" onclick="return confirm('This action cannot be undone. Are you sure you want to proceed?');">Click here to clear out all of the old voter rolls.</a></li>
<!--***-->    
  </ul>
  <p><strong><a name="elecdata" id="elecdata"></a>1c.</strong> The name and description of your election. Enter or edit it here. (160 Characters Max).</p>
  <form action="changedesc.php" method="post" enctype="multipart/form-data" name="elecdisc" id="elecdisc" onsubmit="return checkelecname(this)">
  <table cellpadding="0" cellspacing="0" border="0">
  <tr>
  <td>Election Title: </td>
  <td>
  <?php
  // get the name of the title from the server
  $sqlq = "SELECT value FROM options WHERE optionname = CONVERT( _utf8 'electitle' USING latin1 )";
  $sqlresult = mysql_query($sqlq);
  if (!$sqlresult) {
    die('Invalid query: ' . mysql_error());
}
  $electitle = mysql_fetch_object($sqlresult);
  print '<input name="title" type="text" id="title" value="'.$electitle->value.'" size="80" maxlength="80" />';
  ?>
  </td>
  </tr>
  <tr>
  <td>Description: </td>
  <td>
  <?php
  // get the name of the description from the server
  $sqlq = "SELECT value FROM options WHERE optionname = CONVERT( _utf8 'elecdesc' USING latin1 )";
  $sqlresult = mysql_query($sqlq);
  if (!$sqlresult) {
    die('Invalid query: ' . mysql_error());
}
  $elecdesc = mysql_fetch_object($sqlresult);
  print '<textarea name="desc" cols="80" rows="2" id="desc" class="mceNoEditor">'.$elecdesc->value.'</textarea>';
  ?>
  </td>
  </tr>
  <tr>
  <td>&nbsp;</td>
  <td><input type="submit" name="Submit" value="Set" /></td>
  </tr>
  </table>
  </form>
</blockquote>
<hr />
<p><strong><a name="positions" id="positions"></a>2. Positions to Contest</strong></p>
<p>First, you need to create some positions or roles for people to run for. Create them here. </p>
<p>The following is a list of the current positions that are being contested in this election. Make sure you delete any positions that are <u>not</u> being contested. If the list is empty then no positions have been created (see step 1b above).</p>
<table cellpadding="0" cellspacing="0" border="1" width="50%">
<tr>
<td><strong>Position:</strong></td><td><strong>Rank:</strong></td>
<td><strong>Voter Roll:</strong></td><td><strong>Delete:</strong></td>
</tr>
<?php
$sqlq = "SELECT * FROM positions ORDER by rank ASC";
$sqlresult = mysql_query($sqlq);
if (!$sqlresult) {
    die('Invalid query: ' . mysql_error());
}

while($row = mysql_fetch_array($sqlresult)) {
	print "<tr><td>".$row['position']."</td><td>".$row['rank']."</td><td>".$row['voterroll']."</td><td><a href=\"deletepos.php?pos=".$row['position']."\" onclick=\"return confirm('This action cannot be undone. Are you sure you want to proceed?');\">Delete Position</a></td></tr>";
	$positions[] = $row['position'];
}

?>
</table>
<p>Use the form below to create a new position to be contested. Enter the name as it will appear on the voting form. Proper grammar is expected here. There is a difference between &quot;president&quot; and &quot;President&quot;. Also give a rank to how high up the voting form you wish the position to be. A position like President should be ranked first while a general Executive position should be a lot lower. This works best if there is one rank per position. So maybe you should think about the order you want positions to appear on the voting paper <u>before</u> you go any further. </p>
<form action="createposition.php" method="post" enctype="multipart/form-data" name="newposition" id="newposition" onsubmit="return checkpos(this)">
  Name of Position: 
    <input name="positionname" type="text" id="positionname" size="40" /> 
  Rank: 
  <input name="rank" type="text" id="rank" value="0" size="3" maxlength="3" /><br />
<!--*** Modification 3/2010 by Gabriel Rholl. Purpose: To add voter roll checks to the election functionality-->
  Is this an exclusive vote position?
  <input name="rollcheck" type="checkbox" id="rollcheck" value="Yes"/>
  If so, name of voter roll:
  <input name="voterroll" type="text" id="voterroll" size="40" />
  <input type="submit" name="Submit" value="Create Position" />
</form>

<hr />
<p>Use the form below to upload a new voter roll.</p>
<form action="createvoterroll.php" method="post" enctype="multipart/form-data" name="newvoterroll" id="newvoterroll" onsubmit="return checkpos(this)">
  Name of Voter Roll: 
  <input name="voterroll" type="text" id="voterroll" size="40" /> 
  <input type="submit" name="Submit" value="Create Voter Roll" />
</form>
<p>Use the form below to delete an existing voter roll.</p>
<form action="deletevoterroll.php" method="post" enctype="multipart/form-data" name="delvoterroll" id="delvoterroll" onsubmit="return checkpos(this)">
  Name of Voter Roll: 
  <input name="voterroll" type="text" id="voterroll" size="40" /> 
  <input type="submit" name="Submit" value="Delete Voter Roll" />
</form>
<hr />
<!--***-->  

<p><a name="candidates" id="candidates"></a><strong>3. Candidates Contesting Positions</strong> </p>
<p>The following is a list of the current candidates listed in the database contesting this election. Make sure that the data here is correct because this is exactly the same text that will be used in the voting form so (as above) there is a difference between &quot;John Doe&quot; and &quot;john doe&quot;.</p>
<p>Note: If you want to change the details of a candidate you will have to delete that candidate and recreate it.</p>
<table cellpadding="0" cellspacing="0" border="1" width="100%">
<tr>
<td><strong>Last Name:</strong></td>
<td><strong>First Name:</strong></td>
<td><strong>Position:</strong></td>
<td><strong>Affliation:</strong></td>
<td width="30%"><strong>Blurb:</strong></td>
<td><strong>Delete:</strong></td>
</tr>
<?php
$sqlq = "SELECT * FROM candidates WHERE `position` != CONVERT( _utf8 'No Confidence' USING latin1 ) ORDER by position ASC";
$sqlresult = mysql_query($sqlq);
if (!$sqlresult) {
    die('Invalid query: ' . mysql_error());
}

while($row = mysql_fetch_array($sqlresult)) {
	print "<tr><td>".$row['lastname']."</td><td>".$row['firstname']."</td><td>".$row['position']."</td><td>".$row['affliation']."</td><td><span class=\"plus\">Click here to read the candidate's blurb</span><div class=\"blurbdis\"><span>".$row['blurb']."</span></div></td><td><a href=\"deletecan.php?can=".$row['rowid']."\" onclick=\"return confirm('This action cannot be undone. Are you sure you want to proceed?');\">Delete Candidate</a></td></tr>";
}

?>
</table>
<p>Use this form to add another candidate to contest the election. </p>
<form action="createcandidate.php" method="post" enctype="multipart/form-data" name="newcandidate" id="newcandidate" onsubmit="return checkcan(this)">
<table cellpadding="0" cellspacing="0" border="0">
<tr>
<td>Last Name: </td>
<td><input name="lastname" type="text" id="name" size="40" /></td>
</tr>
<tr>
<td>First Name: </td>
<td><input name="firstname" type="text" id="name" size="40" /></td>
</tr>
<tr>
<td>Role:</td>
<td><select name="role">
  <?php
  foreach( $positions as $key => $value ) {
  	print '<option value="'.$value.'">'.$value.'</option>';
  }
  ?>
</select></td>
</tr>
<tr>
<td>Affliation: </td>
<td><input name="affliation" type="text" id="affliation" size="40" /></td>
</tr>
<tr>
  <td>Blurb: </td>
  <td><textarea name="blurb" cols="40" rows="5" id="blurb"></textarea></td>
  </tr>
<tr>
  <td>&nbsp;</td>
  <td colspan="2"><input type="submit" name="Submit" value="Add Candidate" /></td>
  </tr>
</table>
</form>
<hr />
<p><a name="noconfidence" id="noconfidence"></a><strong>4. No Confidence Candidate</strong> </p>
<form action="nocon.php" method="post" enctype="multipart/form-data" name="nocon" id="nocon">
  Does your election require the option for a 'No Confidence' candidate? 
  <label><input name="noconreq" type="radio" value="yes" checked="checked" onclick="nocon.nocontext.disabled=false; nocon.noconblurb.disabled=false; nocon.nocontext.value='No Confidence'; " />
  Yes</label>
  / 
  <label><input name="noconreq" type="radio" value="no" onclick="nocon.nocontext.disabled=true; nocon.noconblurb.disabled=true;" />No</label> 
  <?php
  $sqlq = "SELECT value FROM options where optionname = CONVERT( _utf8 'nocon' USING latin1 )";
  $sqlresult = mysql_query($sqlq);
  if (!$sqlresult) {
    die('Invalid query: ' . mysql_error());
  }
  $currentnocon = mysql_fetch_object($sqlresult);
  print "(current setting: <strong>".$currentnocon->value."</strong>)"; 
  ?>
  <p>No Confidence Candidate Label: 
  <?php
  $sqlq = "SELECT `lastname` , `blurb` FROM `candidates` WHERE `position` = CONVERT( _utf8 'No Confidence' USING latin1 )";
  $sqlresult = mysql_query($sqlq);
  if (!$sqlresult) {
    die('Invalid query: ' . mysql_error());
  }
  $row = mysql_fetch_array($sqlresult);
  print '<input name="nocontext" type="text" id="nocontext" value="'.$row['lastname'].'" />';
  ?>
    
(Note: This is the text used to identify a No Confidence candidate instead of an individual) </p>
  <p>No Confidence Candidate Blurb (this is optional):<br />
    <textarea name="noconblurb" cols="40" rows="5" id="noconblurb"><?php print $row['blurb']; ?></textarea>
    <br />
    Note: This blurb should identify the person or group responsible for running this type of campaign. This candidate and blurb will be repeated on the ballot for all positions being contested.<br />
    <input type="submit" name="Submit" value="Save" />
</p>
</form>
<hr />
<p><a name="timing" id="timing"></a><strong>5. Election Timing</strong> </p>
<p>Use the form below to set the start and finish time for the running of the election. For the timing to work accurately, the server is required to also be running on the correct time. To check the server time compare the live time from the server with your current system time. Server Live Time: <strong><?php print date('H:i d/m/Y'); ?></strong> (<?php print date('r'); ?>) If the time is incorrect either correct the time on the server, or work out the time offset and set the start and finish time to account for this. </p>
<form action="setdates.php" method="post" enctype="multipart/form-data" name="dateset" id="dateset">
  <p>Current election start time:<strong>
  <?php
  $sqlq = "SELECT value FROM options where optionname = CONVERT( _utf8 'starttime' USING latin1 )";
  $sqlresult = mysql_query($sqlq);
  if (!$sqlresult) {
    die('Invalid query: ' . mysql_error());
  }
  $starttime = mysql_fetch_object($sqlresult);
  print date('H:i d/m/Y',$starttime->value); 
  ?></strong>  
  <br />
    Change: Hour:
      <select name="starthour">
      <?php
  for($i = 0; $i < 24; $i++) print '<option value="'.$i.'">'.$i.'</option>';
  ?>
    </select>
    Minute:
    <select name="startmin">
      <?php
  for($i = 0; $i < 60; $i++) print '<option value="'.$i.'">'.$i.'</option>';
  ?>
    </select>
    Day:
    <select name="startday">
      <?php
  for($i = 1; $i < 32; $i++) print '<option value="'.$i.'">'.$i.'</option>';
  ?>
    </select>
    Month:
    <select name="startmonth">
      <?php
  for($i = 1; $i < 13; $i++) print '<option value="'.$i.'">'.$i.'</option>';
  ?>
    </select>
    Year:
    <select name="startyear">
      <?php
  for($i = 2008; $i < 2020; $i++) print '<option value="'.$i.'">'.$i.'</option>';
  ?>
    </select>
  </p>
  <p>Current election end time: <strong>
  <?php
  $sqlq = "SELECT value FROM options where optionname = CONVERT( _utf8 'endtime' USING latin1 )";
  $sqlresult = mysql_query($sqlq);
  if (!$sqlresult) {
    die('Invalid query: ' . mysql_error());
  }
  $endtime = mysql_fetch_object($sqlresult);
  print date('H:i d/m/Y',$endtime->value); 
  ?></strong>
  <br />
    Change: Hour: 
  <select name="endhour">
  <?php
  for($i = 0; $i < 24; $i++) print '<option value="'.$i.'">'.$i.'</option>';
  ?>
  </select> Minute: 
  <select name="endmin">
  <?php
  for($i = 0; $i < 60; $i++) print '<option value="'.$i.'">'.$i.'</option>';
  ?>
  </select> Day: 
  <select name="endday">
  <?php
  for($i = 1; $i < 32; $i++) print '<option value="'.$i.'">'.$i.'</option>';
  ?>
  </select> 
  Month: 
  <select name="endmonth">
  <?php
  for($i = 1; $i < 13; $i++) print '<option value="'.$i.'">'.$i.'</option>';
  ?>
  </select> 
  Year: 
  <select name="endyear">
  <?php
  for($i = 2008; $i < 2020; $i++) print '<option value="'.$i.'">'.$i.'</option>';
  ?>
  </select></p>
  <p>
    <input type="submit" name="Submit" value="Set" />
  </p>
</form>
<hr />
<p><strong><a name="presentation" id="presentation"></a>6. Presentation and Layout</strong></p>
<p><strong>Note: </strong>If you want to change to colours and other display formatting of the voting form, alter the <code>styles.css</code> file. </p>
<form action="presentationsettings.php" method="post" enctype="multipart/form-data" name="presentation" id="presentation">
<p>Sort order of Candidates Names: <label><input name="sortorder" type="radio" value="lastname" checked="true" /> Lastname First</label> / <label><input name="sortorder" type="radio" value="firstname" /> Firstname First</label><br />
  Current Setting: <?php
  $sqlq = "SELECT value FROM options where optionname = CONVERT( _utf8 'canorder' USING latin1 )";
  $sqlresult = mysql_query($sqlq);
  if (!$sqlresult) {
    die('Invalid query: ' . mysql_error());
  }
  $canorder = mysql_fetch_object($sqlresult);
  if($canorder->value == "lastname") {
  	print "<strong>Lastname First</strong>";
  } else {
  	print "<strong>Firstname First</strong>";
  }
  ?></p>
<p>Presentation of Candidates Names: <label><input name="presentation" type="radio" value="firstnamefirst" checked="true" />Firstname Lastname</label> / <label><input name="presentation" type="radio" value="lastnamefirst" />Lastname, Firstname</label><br />
Current Setting: <?php
  $sqlq = "SELECT value FROM options where optionname = CONVERT( _utf8 'presentation' USING latin1 )";
  $sqlresult = mysql_query($sqlq);
  if (!$sqlresult) {
    die('Invalid query: ' . mysql_error());
  }
  $presentation = mysql_fetch_object($sqlresult);
  if($presentation->value == "firstnamefirst") {
  	print "<strong>Firstname Lastname</strong>";
  } else {
  	print "<strong>Lastname, Firstname</strong>";
  }
  ?></p>
<p>Display candidate affliation: <label><input name="affliation" type="radio" value="yes" checked="true" />Yes</label> / <label><input name="affliation" type="radio" value="no" />No</label> 
  <br />
  Current Setting: <?php
  $sqlq = "SELECT value FROM options where optionname = CONVERT( _utf8 'affliation' USING latin1 )";
  $sqlresult = mysql_query($sqlq);
  if (!$sqlresult) {
    die('Invalid query: ' . mysql_error());
  }
  $affliation = mysql_fetch_object($sqlresult);
  print "<strong>".$affliation->value."</strong>"; 
  ?>
</p>
<p>Display candidate blurbs: <label><input name="blurbs" type="radio" value="yes" checked="true" />Yes</label> / <label><input name="blurbs" type="radio" value="no" />No</label> 
  <br />
  Current Setting: <?php
  $sqlq = "SELECT value FROM options where optionname = 'blurbs'";
  $sqlresult = mysql_query($sqlq);
  if (!$sqlresult) {
    die('Invalid query: ' . mysql_error());
  }
  $blurbs = mysql_fetch_object($sqlresult);
  print "<strong>".$blurbs->value."</strong>"; 
  ?>
</p>
<p>Thanks for voting page:<br />
  <textarea name="thankspage" cols="50" rows="15" id="thankspage" class="mceEditor"><?php include('../thanks.php'); ?></textarea>
</p>
<p>
  <input type="submit" name="Submit" value="Save" />
</p>
</form>
<hr />
<p><strong><a name="security" id="security"></a>7. Security of Voting </strong></p>
<form action="security.php" method="post" enctype="multipart/form-data" name="security" id="security">
<p>Use uploaded roll of eligible voters?: <label><input name="useroll" type="radio" value="yes" />Yes</label> / <label><input name="useroll" type="radio" value="no" checked="true" />No</label> 
  <br />
  Current Setting: <?php
  $sqlq = "SELECT value FROM options where optionname = 'useroll'";
  $sqlresult = mysql_query($sqlq);
  if (!$sqlresult) {
    die('Invalid query: ' . mysql_error());
  }
  $roll = mysql_fetch_object($sqlresult);
  print "<strong>".$roll->value."</strong>"; 
  ?>
</p>
<p>Allow Special Votes?: <label><input name="allowspecial" type="radio" value="yes" checked="checked" />
Yes</label> / <label><input name="allowspecial" type="radio" value="no" />
No</label> 
<br />
  Current Setting: <?php
  $sqlq = "SELECT value FROM options where optionname = 'allowspecial'";
  $sqlresult = mysql_query($sqlq);
  if (!$sqlresult) {
    die('Invalid query: ' . mysql_error());
  }
  $special = mysql_fetch_object($sqlresult);
  print "<strong>".$special->value."</strong>"; 
  ?></p>
<p>    <input type="submit" name="Submit" value="Save" />
</p>
</form>
<form action="rollupload.php" method="post" enctype="multipart/form-data" name="dataupload" id="dataupload">
<p>Upload a new roll of eligible voters. <br />
<i>Note: This file must be .txt format, and have one student id per line with no other data in the file</i><br />
<input type="hidden" name="MAX_FILE_SIZE" value="3000000" />
<input type="file" name="newfile" />
<input type="submit" name="submit" value="Upload" /></p>
</form>
<hr />
<p><strong><a name="preview" id="preview"></a>8. Preview Voting Form</strong></p>
<p><a href="previewvoting.php" target="_blank">Click here</a> to see a preview of the voting form as it will appear during the election. (note this opens in a new window). </p>
<hr />
<p><strong><a name="results" id="results"></a>9. Election Results</strong></p>
<p><a href="results.php" target="_blank">Click here</a> to view the results of normal voting. (note this opens in a new window) 
<?php
$result = mysql_query("SELECT * FROM voters");
$num_rows = mysql_num_rows($result);

echo "Currently $num_rows votes have been cast";
?>
</p>
<p><a href="specialresults.php" target="_blank">Click here</a> to view the results of any special votes. (note this opens in a new window) 
<?php
$result = mysql_query("SELECT * FROM specialvoters");
$num_rows = mysql_num_rows($result);

echo "Currently $num_rows votes have been cast";
?></p>
<p><a href="adminvotes.php" target="_blank">Click here</a> to administrator the votes cast. (note this opens in a new window) </p>
<p><a href="specialadminvotes.php" target="_blank">Click here</a> to administrator the special votes cast. (note this opens in a new window) </p>
<hr />
</body>
</html>
