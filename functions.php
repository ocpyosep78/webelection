<?php	
//Created Jan. 2008 by Taylor Reece, St. Olaf College SGA Webmaster
//Purpose: To provide a set of functions for use by the
// 	(GR 1/2010: now-obsolete) oleville.com admin interface.
// 	(GR 1/2010): Probably not necessary for this election software. 
//  (GR 1/2010): Only concern might be LDAP configuration.

	function getRole($PHP_USER_NAME){
		global $dbh;
		$sql = "SELECT usertype FROM users WHERE username='$PHP_USER_NAME'";
		$result = pg_exec($dbh, $sql);
		$rows = pg_numrows($result);
		if($rows == 0) {
			return NULL; // Not an administrator.
		} else {
			$data = pg_fetch_row($result, 0);
			return $data[0];
		}
	}
	
	function getRoleBySID($sid){
		global $dbh;
		$sql = "SELECT usertype FROM users WHERE sessionid='$sid'";
		$result = pg_exec($dbh, $sql);
		$rows = pg_numrows($result);
		if($rows == 0) {
			echo "Your session has expired, or you logged in elsewhere.  Please log in again <a href=\"index.php\">here</a>"; // Expired session.
			exit();
		} else {
			$data = pg_fetch_row($result, 0);
			return $data[0];
		}
	}
	
	function getUnameBySID($sid){
		global $dbh;
		$sql = "SELECT username FROM users WHERE sessionid='$sid'";
		$result = pg_exec($dbh, $sql);
		$rows = pg_numrows($result);
		if($rows == 0) {
			echo "Your session has expired, or you logged in elsewhere.  Please log in again <a href=\"index.php\">here</a>"; // Expired session.
			exit();
		} else {
			$data = pg_fetch_row($result, 0);
			return $data[0];
		}
	}
		
	function getUIDBySID($sid){
		global $dbh;
		$sql = "SELECT uid FROM users WHERE sessionid='$sid'";
		$result = pg_exec($dbh, $sql);
		$rows = pg_numrows($result);
		if($rows == 0) {
			echo "Your session has expired, or you logged in elsewhere.  Please log in again <a href=\"index.php\">here</a>"; // Expired session.
			exit();
		} else {
			$data = pg_fetch_row($result, 0);
			return $data[0];
		}
	}
	// Set Session IDs; These will remain for the whole login session.
	function setSessionID($uname, $sid){
		global $dbh;
		$sql = "UPDATE users SET sessionid='" . $sid . "' WHERE username='" . $uname . "'";
		pg_exec($dbh,$sql);
	}
	
	function adminSignOut($sid) {
		global $dbh;
		$sql = "UPDATE users SET sessionid=' ' WHERE sessionid='" . $sid . "'";
		pg_exec($dbh,$sql);
	}

	function alterElectionStatus() {
		global $dbh;
		if(getElectionStatus() == 't'){
			$sql = "UPDATE electionstatus SET ison='false' WHERE status='status'";
		} else {
			$sql = "UPDATE electionstatus SET ison='true' WHERE status='status'";
		}
		pg_exec($dbh,$sql);
	}	
	
	function getNumberVoters() {
		global $dbh;
		$sql = "SELECT * FROM voters";
		$result = pg_exec($dbh,$sql);
		$rows = pg_numrows($result);
		return $rows;
	
	}
?>