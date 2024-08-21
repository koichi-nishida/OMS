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

	echo "<h3>Update Your Profile</h3>";
	echo "<div class='row'>";
	echo "<label for='left-label' class='left inline'>";

	if (isset($_POST["submit"])) {

    if((!empty($_POST['adfirst'])) && (!(trim($_POST['adfirst']) == ""))
    && (!empty($_POST['adlast'])) && (!(trim($_POST['adlast']) == "")) && (!empty($_POST['email'])) && (!(trim($_POST['email']) == ""))){


		$query3 = "UPDATE ADMIN SET adFirst = ?, adLast = ?, adEmail = ? WHERE adID = ?;";
   	$stmt3 = $mysqli->prepare($query3);
		$stmt3 -> execute([$_POST['adfirst'], $_POST['adlast'], $_POST['email'], $_SESSION['aduserID']]);

		if($stmt3) {
			$_SESSION['message'] = "Your profile has been updated";
      redirect("OMSadminhome.php");
		}else{
			$_SESSION["message"] = "ERROR!! Could not update your profile!!";
		}
		redirect("OMSadminhome.php");
	}
  else{
    $_SESSION['message'] = "Could not update your profile!! Fill in all information!";
    redirect("OMSadminhome.php");
  }
  $_SESSION['message'] = "Could not update your profile!! Fill in all information!";
  redirect("OMSadminhome.php");

}

	else {

	  if (isset($_SESSION['aduserID']) && $_SESSION['aduserID'] !== "") {
		  $query = "SELECT adUser, adFirst, adLast, adEmail
		  FROM ADMIN WHERE adID = ?";
			$stmt = $mysqli->prepare($query);
			$stmt-> execute([$_SESSION['aduserID']]);


		if ($stmt)  {
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
      echo "<form action='OMSupdateadmins.php' method='POST'>\n";
      echo "<p>First Name: <input type=text name='adfirst' value = '".$row['adFirst']."'></p>\n";
      echo "<p>Last Name: <input type=text name='adlast' value = '".$row['adLast']."'></p>\n";
      echo "<p>Email Address: <input type=email name='email' value = ".$row['adEmail']."></p>\n";
      echo "<input type='submit' name='submit' value='Update'/>\n";
			echo "</form>\n";
		  echo "<h3>".$row['adUser']." Information</h3>\n";
			echo "<br /><p>&laquo:<a href='OMSadminhome.php'>Back to Main Page</a>\n";
			echo "</label>\n";
			echo "</div>\n";
		}
		else {
			$_SESSION["message"] = "Your Profile could not be found!";
			redirect("OMSadminhome.php");
		}
	  }
    }

new_footer(" OMS ");
Database::dbDisconnect($mysqli);

?>
