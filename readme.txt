Web-based Election Software

www.brad.net.nz

Version: 13102008b

* Copyright (c) 2008, BRAD HEAP
* All rights reserved.
*
* Redistribution and use in source and binary forms, with or without
* modification, are permitted provided that the following conditions are met:
*     * Redistributions of source code must retain the above copyright
*       notice, this list of conditions and the following disclaimer.
*     * Redistributions in binary form must reproduce the above copyright
*       notice, this list of conditions and the following disclaimer in the
*       documentation and/or other materials provided with the distribution.
*     * The names of its contributors may be used to endorse or promote products
*       derived from this software without specific prior written permission.
*
* THIS SOFTWARE IS PROVIDED BY BRAD HEAP ''AS IS'' AND ANY
* EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED
* WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
* DISCLAIMED. IN NO EVENT SHALL BRAD HEAP BE LIABLE FOR ANY
* DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES
* (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
* LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND
* ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
* (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS
* SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.

Installation Instructions
1. Upload the entire contents on the elections software to your webserver. Keep the folder and file structure intact
2. Insert the e-admin/install/sqldrop.sql file into your sql server
3. If you have not manually created a webbased mysql user for this program drop the e-admin/install/user.sql file into your sql server
4. Check that the includes/dbconnection.php file contains the correct server and user settings for your webserver
5. Make sure that roll.dat and thanks.php are both readable and writeable (chmod 777)
6. Load up http://<yourWebAddressHere>/<pathToElectionsFolder>/e-admin/index.php
7. Login using username: user and password: password
8. Change the default username and password
9. Set up the election
10. If you want to modify the design start by changing the main.css file
11. Voters should access the election by loading http://<yourWebAddressHere>/<pathToElectionsFolder>/index.php

Modification Instructions:
1. There is quite a few things you can edit/change in the index.php file feel free to open it up and look at the comments.
2. Also check out the styles.css file
3. You can edit the voteerror.php file to change the messages that are displayed if an error occurs.
4. Lines 76 - 78 of voteprocessor.php enable you to check against a roll. The default settings assume your roll also includes
	a student id and date of birth... i.e.
	studentid,dobyear-dobymonth-dobday
	12345678,1985-12-01

	if you disable this and just look for an id make sure each line of the roll.dat file only has one id per line.

5. In large freeform text boxes you can use HTML tags which will change the look of the page... such as including images of candidates.
	i.e. <img src="photos/lastname.jpg" style="float:right;padding-left:5px;padding-bottom:5px;">
