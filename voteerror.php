<?php
//Web-based Election Software
//Copyright (c) 2008, BRAD HEAP, All rights reserved.
//Modified Jan. 2010 by Gabriel Rholl, St. Olaf College SGA Webmaster

ini_set('display_errors', 1);
ini_set('display_warnings', 1);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<META HTTP-EQUIV="Refresh" CONTENT="10; URL=/">
<title>Vote Error</title></head>
<body>

<?php

if($_GET['error']==1) {

?>

<h1 align="center">Error: You have already voted.</h1>

<?php

}

else {

?>

<h1 align="center">Error: You are not on the voting roll.</h1>

<?php

}


?>

<h2 align="center">If you think this in error please contact the election admistrator at <a href="mailto:sgawebmaster@stolaf.edu">sgawebmaster@stolaf.edu</a>.</h2>

</body>
</html>