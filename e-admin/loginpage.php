<?php
//Web-based Election Software
//Copyright (c) 2008, BRAD HEAP, All rights reserved.
//No modification Jan. 2010 by Gabriel Rholl, St. Olaf College SGA Webmaster
//Purpose: Displays administration/settings login page

//ini_set('display_errors', 1);
//ini_set('display_warnings', 1);

// start the session
session_start();
$_SESSION['loggedin'] = false;

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Election Admin - Please Log In</title>
<style type="text/css">
<!--
.style1 {font-size: small}
-->
</style>

</head>

<body>
<h1 align="center">Webbased Election Admin </h1>
<p align="center" class="style1">&copy; 2008 Brad Heap (www.brad.net.nz). This software is free to use and distribute including code. However, this copyright message should remain in place at all times. You are free to modify the code for your own purposes provided that a base message is left in place crediting me. No guarantee of any form is given for use of this software. Use at your own peril. </p>
<p align="left" class="style1">If you have not already done so, make sure that you load the <code>sqldump.sql</code> file into your SQL server before proceeding any further. Also check the settings in the <code>includes/dbconnection.php</code> file. Finally make sure Javascript is enabled. Failure to do so will result in non-functionality of this software.</p>
<?php

if($_GET['error']=="1") {
  print '<h2 align="center" style="color:red">ERROR: Incorrect Password</h2>';
}

if($_GET['error']=="2") {
  print '<h2 align="center" style="color:red">Access Denied: You are not logged in. Log in and try again.</h2>';
}

?>
<h2 align="center">Please Log In to Continue</h2>
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
