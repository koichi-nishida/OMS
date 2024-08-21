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

  $query = "SELECT comID, comName, comCity, STATE.stateNum, STATE.stateName, comEmail, comDesc
  FROM COMPANY JOIN STATE
  ON STATE.stateNum = COMPANY.stateNum ORDER BY comName ASC;";

  $stmt = $mysqli -> query($query);
	$stmt -> execute();

  if ($stmt) {
		echo "<div class='row'>\n";
		echo "<center>\n";
		echo "<h2>Companies</h2>\n";
		echo "<table>\n";
		echo "  <thead>\n";
		echo "    <tr><th>Name</th><th>City</th><th>State</th><th>Email Address</th><th>Description</th></tr>\n";
		echo "  </thead>\n";
		echo "  <tbody>\n";

    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      echo "<tr>";
			echo "<td>".$row['comName']."</td>\n";
			echo "<td>".$row['comCity']."</td>\n";
			echo "<td>".$row['stateName']."</td>\n";
			echo "<td>".$row['comEmail']."</td>\n";
      echo "<td>".$row['comDesc']."</td>\n";
			echo "<td><a href='OMSjob_come.php?id=".urlencode($row['comID'])."'>View Opportunities</a></td>\n";
      echo "</tr>\n";
    }
    echo "  </tbody>\n";
    echo "</table>\n";
    echo "</center>\n";
		echo "</div>\n";
		echo "<br /><p>&laquo:<a href='OMSuserhome.php'>Back to Main Page</a>\n";
	}

  new_footer(" OMS ");
	Database::dbDisconnect($mysqli);

?>
