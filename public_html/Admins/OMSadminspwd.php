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
	echo "<label for='left-label' class='left inline'>\n";

	if (isset($_POST["submit"])) {
			if($_POST['adpwd'] == $_POST['adpwd1']){
		    if((!empty($_POST['adpwd'])) && (!(trim($_POST['adpwd']) == "")) ){

		      $adpwd = $_POST["adpwd"];
		  		$passwordEncrypt = password_encrypt($adpwd);

				$query3 = "UPDATE ADMIN SET adHash = ? WHERE adID = ?;";
		   	$stmt3 = $mysqli->prepare($query3);
				$stmt3 -> execute([$passwordEncrypt, $_SESSION['aduserID']]);

				if($stmt3) {
					$_SESSION['message'] = "Your password has been updated";
		      redirect("OMSadminhome.php");
				}else{
					$_SESSION["message"] = "ERROR!! Could not update your password!!userhome";
				}
				redirect("OMSadminhome.php");
			}
		  else{
		    $_SESSION['message'] = "Could not update your profile!! Fill in your new password!";
		    redirect("OMSadminhome.php");
		  }
		  $_SESSION['message'] = "Could not update your profile!! Fill in your new password!";
		  redirect("OMSadminhome.php");
	}else{
		$_SESSION['message'] = "Password does not match";
	  redirect("OMSadminspwd.php");
	}
}

	else {

			echo "<h3>Change Your Password</h3>\n";
      echo "<form action='OMSadminspwd.php' method='POST'>\n";
      echo "<p>New Password: <input type=password name='adpwd' value = ''></p>\n";
			echo "<p>Confirm new Password: <input type=password name='adpwd1' value = ''></p>\n";
      echo "<input type='submit' name='submit' value='Update'/>\n";
			echo "</form>\n";
			echo "<br /><p>&laquo:<a href='OMSadminhome.php'>Back to Main Page</a>\n";
			echo "</label>\n";
			echo "</div>\n";

    }

new_footer(" OMS ");
Database::dbDisconnect($mysqli);

?>
