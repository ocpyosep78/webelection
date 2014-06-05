<?php
//Created Jan. 2008 by Taylor Reece, St. Olaf College SGA Webmaster
//Purpose: To provide a set of LDAP authentication functions.

	$ldapconfig['host'] = 'nac.stolaf.edu';
	$ldapconfig['port'] = '389';
	$ldapconfig['basedn'] = 'ou=stoUsers,dc=stolaf,dc=edu';


	function ldap_authenticate($PHP_AUTH_USER, $PHP_AUTH_PW) {
	    global $ldapconfig;

	    if ($PHP_AUTH_USER != "" && $PHP_AUTH_PW != "") {
        	$ds=@ldap_connect($ldapconfig['host'],$ldapconfig['port']);
	        $r = @ldap_search( $ds, $ldapconfig['basedn'], 'uid=' . $PHP_AUTH_USER);
	        if ($r) {
	            $result = @ldap_get_entries( $ds, $r);
	            if ($result[0]) {
        	        if (@ldap_bind( $ds, $result[0]['dn'], $PHP_AUTH_PW) ) {
                	    return $result[0];
	                }
	            }
	        }
	    }
	    return NULL;
	}
?>
