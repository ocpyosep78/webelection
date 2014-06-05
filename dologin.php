<?php
//Created Jan. 2010 by Gabriel Rholl, St. Olaf College SGA Webmaster
//Purpose: To cross-check the voter's login with the St. Olaf LDAP server

	ini_set('display_errors', 1);
	ini_set('display_warnings', 1);

	session_start();

	include 'ldapfunctions.php';  // Information about LDAP authentication	
	include 'functions.php'; // Functions pertaining to checking user status (webmaster, administrator, etc).

	if (($result = ldap_authenticate($_POST['user'], $_POST['pword'])) == NULL) {
		header('location:loginpage.php?error=1');
		exit;
	} else {
		$_SESSION['login'] = true;//Set the user's state to "logged in"
		$_SESSION['user'] = $_POST['user'];//Set their session username
		$_SESSION['pword'] = $_POST['pword'];//Set their session password
		header('location:index.php');
		exit;
	}

?>