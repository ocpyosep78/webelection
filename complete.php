<?php
//Web-based Election Software
//Copyright (c) 2008, BRAD HEAP, All rights reserved.
//Modified Jan. 2010 by Gabriel Rholl, St. Olaf College SGA Webmaster
//Purpose: To forward users on to a Thank You page following voting and
//	log their session out

ini_set('display_errors', 1);
ini_set('display_warnings', 1);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<!--*** Modification by Gabe Rholl 1/2010
Purpose: To redirect users to the Oleville homepage-->
<META HTTP-EQUIV="Refresh" CONTENT="5; URL=http://www.oleville.com/">
<!--***-->

<title>Voting Complete</title></head>
<body>

<!--*** Modification by Gabe Rholl 1/2010
Purpose: To log out user before showing "Thank You" page-->
<?php 
	session_start();
	$_SESSION['login'] = NULL;
	include('thanks.php');
?>
<!--***-->
</body>
</html>