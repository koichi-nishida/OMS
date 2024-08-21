<?php
require_once("session.php");
require_once("included_functions_group8.php");
require_once("databasegroup8.php");
	new_header("OMS");

	$mysqli = Database::dbConnect();
	$mysqli -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	if (($output = message()) !== null) {
		echo $output;
	}
session_start();
if(empty($_SESSION['username'])){
	echo "You are not logged in";
	redirect("OMSlogin.php");
}


echo "<div class='row'>\n";
echo "<center>\n";
echo "<h2>Home Page</h2>\n";
echo "<h3>Welcome ".$_SESSION['fname']."</h3>\n";
echo "<br><h6><a href='OMSread_userprofile_users.php'> My Profile</a>: View and Update your profile, and View and Delete your favorites</h6>\n";
echo "<br><br><h6><a href='OMSreadjob_users.php'>Opportunities</a>: Browse and Post Opportunities</h6>\n";
echo "<br><br><h6><a href='OMSreadcom.php'>Companies</a>: Browse companies and Views opportunities for a company</h6>\n";
echo "<br><br><h6><a href='OMScreate_jobs_users.php'>Post an Opportunity";
echo "<br><br><br><br><br><a href='OMSuserpwd.php'> Change Your Password: Want to change your password?\n";
echo "<br><br><br><a href='OMSadmincontact.php'>Contact Admins: Any Questions or Troubles?\n";
echo "</center>\n";
echo "</div>\n";

  new_footer(" OMS ");
	Database::dbDisconnect($mysqli);

?>
