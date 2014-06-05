<?php
//Web-based Election Software
//Copyright (c) 2008, BRAD HEAP, All rights reserved.
//Modified Feb. 2010 by Gabriel Rholl, St. Olaf College SGA Webmaster
//Purpose: Page displayed when a user is not yet logged in; accesses
//   LDAP and verifies identity

//ini_set('display_errors', 1);
//ini_set('display_warnings', 1);

// start the session
session_start();
$_SESSION['login'] = false;

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="styles.css" rel="stylesheet" type="text/css" />
<title>Election Log-In</title>
<style type="text/css">
<!--
.style1 {font-size: small}
-->
</style>
<script language="JavaScript" type="text/javascript">
<!--
function checkpass ( form )
{

  if (form.user.value == "") {
  	alert( "Please enter a username" );
	form.user.focus();
	return false;
  }
  
  if (form.pword.value == "") {
  	alert( "Please enter a password" );
	form.pword.focus();
	return false;
  }

  return true ;
}
-->
</script>

</head>

<body>
<div align="center"><img src="images/header.jpg" alt="header" width="960" height="211" /></div> <!-- if you have a header image you can insert it here-->

<h1 align="center" font="Trebuchet MS">SGA 2010 Spring Elections </h1>
<?php

if($_GET['error']=="1") {
  print '<h2 align="center" style="color:red">ERROR: Incorrect Password</h2>';
}

if($_GET['error']=="2") {
  print '<h2 align="center" style="color:red">Access Denied: You are not logged in. Log in and try again.</h2>';
}

?>
<h2 align="center">Please Log In to Vote</h2>
<form action="dologin.php" method="post" enctype="multipart/form-data" name="login" id="login"  onSubmit="return checkpass(this);">
<table border="0" align="center" cellpadding="0" cellspacing="0">
<tr>
<td>User Name: </td>
<td><input name="user" type="text" id="user" /></td>
</tr>
<tr>
<td>Password: </td>
<td><input name="pword" type="password" id="pword" /></td>
</tr>
<tr>
<td>&nbsp;</td>
<td><input type="submit" name="Submit" value="Login" /></td>
</tr>
</table>
</form>
<p>&nbsp;</p>
</body>
</html>
