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

	echo "<h3>Update Your Profile</h3>\n";
	echo "<div class='row'>\n";
	echo "<label for='left-label' class='left inline'>\n";

	if (isset($_POST["submit"])) {

    if((!empty($_POST['fname'])) && (!(trim($_POST['fname']) == "")) && (!empty($_POST['lname'])) && (!(trim($_POST['lname']) == ""))
    && (!empty($_POST['city'])) && (!(trim($_POST['city']) == ""))
  && (!empty($_POST['email'])) && (!(trim($_POST['email']) == ""))){

		$query3 = "UPDATE ACCOUNT SET acFirst = ?, acLast = ?, acCity = ?, stateNum = ?, acEmail = ?, posID = ? WHERE acID = ?;";
   	$stmt3 = $mysqli->prepare($query3);
		$stmt3 -> execute([$_POST['fname'], $_POST['lname'], $_POST['city'], $_POST['state'], $_POST['email'], $_POST['pos'], $_POST['acid']]);

		if($stmt3) {
			$_SESSION['message'] = "Your profile has been updated";
      redirect("OMSread_userprofile_users.php");
		}else{
			$_SESSION["message"] = "ERROR!! Could not update your profile!!";
		}
		redirect("OMSread_userprofile_users.php");
	}
  else{
    $_SESSION['message'] = "Could not update your profile!! Fill in all information!";
    redirect("OMSread_userprofile_users.php");
  }
  $_SESSION['message'] = "Could not update your profile!! Fill in all information!";
  redirect("OMSread_userprofile_users.php");

}

	else {

	  if (isset($_SESSION['userID']) && $_SESSION['userID'] !== "") {
		  $query = "SELECT acID, acUser, acFirst, acLast, acCity, ACCOUNT.stateNum, STATE.stateCode, acEmail, ACCOUNT.posID, POS.posName
		  FROM ACCOUNT JOIN STATE JOIN POS ON STATE.stateNum = ACCOUNT.stateNum AND ACCOUNT.posID = POS.posID WHERE acID = ?";
			$stmt = $mysqli->prepare($query);
			$stmt-> execute([$_SESSION['userID']]);


		if ($stmt)  {
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
      echo "<form action='OMSupdate_userprofile_users.php' method='POST'>\n";

      echo "<p>First Name: <input type=text name='fname' value = '".$row['acFirst']."'></p>\n";
      echo "<p>Last Name: <input type=text name='lname' value = '".$row['acLast']."'></p>\n";
      echo "<p>City: <input type=text name='city' value = '".$row['acCity']."'></p>\n";

      echo "<p>State: <select name='state'>\n";
      $query1 = "SELECT * FROM STATE ORDER BY stateCode ASC";
      $stmt1 = $mysqli -> prepare($query1);
      $stmt1 -> execute();
      while($row1 = $stmt1->fetch(PDO::FETCH_ASSOC)) {
        echo "<option value =".$row1["stateNum"];
        if($row["stateNum"] == $row1["stateNum"]){
          echo " selected ";
        }

        echo ">".$row1["stateCode"]."</option>\n";
      }
      echo "</select>\n";
      echo "</p>\n";

      echo "<p>Email Address: <input type=email name='email' value = ".$row['acEmail']."></p>\n";

      echo "<p>Status: <select name='pos'>\n";
      $query2 = "SELECT * FROM POS ORDER BY posName ASC";
      $stmt2 = $mysqli -> prepare($query2);
      $stmt2 -> execute();
      while($row2 = $stmt2->fetch(PDO::FETCH_ASSOC)) {
        echo "<option value =".$row2["posID"];
        if($row["posID"] == $row2["posID"]){
          echo " selected ";
        }
        echo ">".$row2["posName"]."</option>\n";
      }
      echo "</select>\n";
			echo "</p>\n";
      echo "<input type = 'hidden' name = 'acid' value = '".$row['acID']."' />\n";
      echo "<input type='submit' name='submit' value='Update'/>\n";
			echo "</form>\n";
		  echo "<h3>".$row['acUser']." Information</h3>\n";
			echo "<br /><p>&laquo:<a href='OMSread_userprofile_users.php'>Back to Main Page</a>\n";
			echo "</label>\n";
			echo "</div>\n";
		}
		else {
			$_SESSION["message"] = "Your Profile could not be found!";
			redirect("OMSread_userprofile_users.php");
		}
	  }
    }

new_footer(" OMS ");
Database::dbDisconnect($mysqli);

?>
