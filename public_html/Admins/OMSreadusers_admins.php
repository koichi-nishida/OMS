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

  $query = "SELECT acID, acUser, acFirst, acLast, acCity, STATE.stateNum, STATE.stateName, acEmail, POS.posID, POS.posName
  FROM ACCOUNT JOIN STATE JOIN POS
  ON ACCOUNT.stateNum = STATE.stateNum  and ACCOUNT.posID = POS.posID ORDER BY acLast ASC;";

  $stmt = $mysqli -> query($query);
	$stmt -> execute();

  if ($stmt) {
		echo "<div class='row'>\n";
		echo "<center>\n";
		echo "<h2>Users</h2>\n";
		echo "<table>\n";
		echo "  <thead>\n";
		echo "    <tr><th></th><th>User Name</th><th>First Name</th><th>Last Name</th><th>City</th><th>State</th><th>Email Address</th><th>Status</th></tr>\n";
		echo "  </thead>\n";
		echo "  <tbody>\n";

    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      echo "<tr>\n";
			echo "<td><a style='color:red;' href='OMSdeleteusers.php?id=".urlencode($row['acID'])."' onclick='return confirm(\"Are you sure you want to delete?\");'>X</a></td>\n";
      echo "<td>".$row['acUser']."</td>\n";
			echo "<td>".$row['acFirst']."</td>\n";
			echo "<td>".$row['acLast']."</td>\n";
      echo "<td>".$row['acCity']."</td>\n";
      echo "<td>".$row['stateName']."</td>\n";
      echo "<td>".$row['acEmail']."</td>\n";
      echo "<td>".$row['posName']."</td>\n";
			echo "<td><a href='OMSupdate_userprofile_admins.php?id=".urlencode($row['acID'])."'>Edit</a></td>\n";
      echo "</tr>\n";
    }
    echo "  </tbody>\n";
    echo "</table>\n";

		echo "</center>\n";
		echo "</div>\n";
		echo "<br /><p>&laquo:<a href='OMSadminhome.php'>Back to Main Page</a>\n";
	}

  new_footer(" OMS ");
	Database::dbDisconnect($mysqli);

?>
