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



  $query = "SELECT acID, acUser, acFirst, acLast, acCity, STATE.stateNum, STATE.stateName, acEmail, POS.posID, POS.posName
  FROM ACCOUNT JOIN STATE JOIN POS
  ON ACCOUNT.stateNum = STATE.stateNum and ACCOUNT.posID = POS.posID where acID = ?;";
	$stmt = $mysqli->prepare($query);
	$stmt-> execute([$_SESSION['userID']]);

  if ($stmt) {
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		echo "<div class='row'>\n";

		echo "<h2>Your Information</h2>\n";
		echo "<h3>User Name: ".$row['acUser']."</h3>\n";
		echo "<h3>First Name: ".$row['acFirst']."</h3>\n";
		echo "<h3>Last Name: ".$row['acLast']."</h3>\n";
    echo "<h3>City: ".$row['acCity']."</h3>\n";
    echo "<h3>State: ".$row['stateName']."</h3>\n";
    echo "<h3>Email Address: ".$row['acEmail']."</h3>\n";
    echo "<h3>Status: ".$row['posName']."</h3>\n";
		echo "<h4><a href='OMSupdate_userprofile_users.php'>Update Your Profile</a></h4>\n";
		echo "<br>\n";
		echo "<h2>Your Favorites</h2>\n";
		echo "<table>\n";
		echo "  <thead>\n";
		echo "    <tr><th></th><th>Job</th><th>Company</th></tr>\n";
		echo "  </thead>\n";
		echo "  <tbody>\n";

		$query1 = "SELECT ACCOUNT.acID, JOB.jobID, JOB.jobName, COMPANY.comName, jobArc
		FROM ACCOUNT JOIN FAVORITE JOIN JOB JOIN COMPANY
		ON FAVORITE.jobID = JOB.jobID AND COMPANY.comID = JOB.comID AND ACCOUNT.acID = FAVORITE.acID
		WHERE ACCOUNT.acID = ? and jobArc = 0";
    $stmt1 = $mysqli -> prepare($query1);
    $stmt1 -> execute([$_SESSION['userID']]);
		while($row1 = $stmt1->fetch(PDO::FETCH_ASSOC)) {
      echo "<tr>";
			echo "<td><a style='color:red;' href='OMSdeletefav.php?id=".urlencode($row1['jobID'])."' onclick='return confirm(\"Are you sure you want to delete?\");'>X</a></td>\n";
      echo "<td>".$row1['jobName']."</td>\n";
			echo "<td>".$row1['comName']."</td>\n";
      echo "</tr>";
    }
		echo "  </tbody>\n";
    echo "</table>\n";

		echo "</div>\n";
		echo "<br /><p>&laquo:<a href='OMSuserhome.php'>Back to Main Page</a>\n";
	}

  new_footer(" OMS ");
	Database::dbDisconnect($mysqli);

?>
