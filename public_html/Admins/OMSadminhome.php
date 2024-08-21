<?php
require_once("session.php");
require_once("included_functions_group8.php");
require_once("databasegroup8.php");

new_head("OMS");
new_admin("Sign Out");
if(empty($_SESSION['adusername'])){
	echo "You are not logged in";
	redirect("OMSadminlogin.php");
}

	$mysqli = Database::dbConnect();
	$mysqli -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	if (($output = message()) !== null) {
		echo $output;
	}

		echo "<div class='row'>\n";
		echo "<center>\n";
		echo "<h2>Admin Home Page</h2> \n";
		echo "<h3>Welcome ".$_SESSION['adfname']."</h3> \n";
    echo "<br><br><h6><a href='OMSreadjob_admins.php'> Opportunities</a>: Browse, Delete, Update, Post, Archive/Unarchive Opportunities</h6>\n";
		echo "<br><br><h6><a href='OMSreadcompany_admins.php'> Companies</a>: Browse, Delete, Update, Add Companies</h6>\n";
		echo "<br><br><h6><a href='OMSreadusers_admins.php'> Users</a>: Browse, Delete, Add Users</h6>\n";
		echo "<br><br><h6><a href='OMSread_adminprofile.php'> Admins</a>: Browse, Delete, Add Admins</h6>\n";
		echo "<br><br><h6><a href='OMSreadrateadmins.php'> Reviews</a>: Browse, Delete Reviews</h6>\n";
		echo "<br><br><br<br><br><br><a href='OMSupdateadmins.php'> Update Your Profile \n";
		echo "<br><br><br><a href='OMSadminspwd.php'> Change Your Password: Want to change your password? \n";
		echo "</center>\n";
		echo "</div>\n";


  new_footer(" OMS ");
	Database::dbDisconnect($mysqli);

?>
