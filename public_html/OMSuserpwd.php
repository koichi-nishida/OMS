<?php

require_once("session.php");
require_once("included_functions_group8.php");
require_once("databasegroup8.php");


new_header("OMS");
new_logout("Sign out");

if(empty($_SESSION['username'])){
	echo "You are not logged in";
	redirect("OMSlogin.php");
}


$mysqli = Database::dbConnect();
$mysqli -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if (($output = message()) !== null) {
  echo $output;
}

	echo "<div class='row'>";
	echo "<label for='left-label' class='left inline'>";

	if (isset($_POST["submit"])) {
		if($_POST['acpwd'] == $_POST['acpwd1']){
	    if((!empty($_POST['acpwd'])) && (!(trim($_POST['acpwd']) == "")) ){

	      $acpwd = $_POST["acpwd"];
	  		$passwordEncrypt = password_encrypt($acpwd);

			$query3 = "UPDATE ACCOUNT SET acHash = ? WHERE acID = ?;";
	   	$stmt3 = $mysqli->prepare($query3);
			$stmt3 -> execute([$passwordEncrypt, $_SESSION['userID']]);

			if($stmt3) {
				$_SESSION['message'] = "Your password has been updated";
	      redirect("OMSuserhome.php");
			}else{
				$_SESSION["message"] = "ERROR!! Could not update your password!!";
			}
			redirect("OMSuserhome.php");
		}
	  else{
	    $_SESSION['message'] = "Could not update your password!! Fill in your new password!";
	    redirect("OMSuserhome.php");
	  }
	  $_SESSION['message'] = "Could not update your password!! Fill in your new password!";
	  redirect("OMSuserhome.php");
}else{
	$_SESSION['message'] = "Password does not match";
	redirect("OMSuserpwd.php");
}
}

	else {

      echo "<form action='OMSuserpwd.php' method='POST'>\n";
			echo "<h3>Change Your Password</h3>\n";
      echo "<p>New Password: <input type=password name='acpwd' value = ''></p>\n";
			echo "<p>Confirm New Password: <input type=password name='acpwd1' value = ''></p>\n";
      echo "<input type='submit' name='submit' value='Update'/>\n";
			echo "</form>\n";

			echo "<br /><p>&laquo:<a href='OMSuserhome.php'>Back to Main Page</a>\n";
			echo "</label>\n";
			echo "</div>\n";

    }

new_footer(" OMS ");
Database::dbDisconnect($mysqli);

?>
