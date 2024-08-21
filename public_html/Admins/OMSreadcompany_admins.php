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

  $query = "SELECT comID, comName, comCity, STATE.stateNum, STATE.stateName, comEmail, comDesc
  FROM COMPANY JOIN STATE
  ON STATE.stateNum = COMPANY.stateNum ORDER BY comName;";

  $stmt = $mysqli -> query($query);
	$stmt -> execute();

  if ($stmt) {
		echo "<div class='row'>\n";
		echo "<center>";
		echo "<h2>Companies</h2>\n";
		echo "<table>";
		echo "  <thead>\n";
		echo "    <tr><th></th><th>Name</th><th>City</th><th>State</th><th>Email Address</th><th>Description</th></tr>\n";
		echo "  </thead>";
		echo "  <tbody>";

    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      echo "<tr>";
			echo "<td><a style='color:red;' href='OMSdeletecompany.php?id=".urlencode($row['comID'])."' onclick='return confirm(\"Are you sure you want to delete?\");'>X</a></td>\n";
      echo "<td>".$row['comName']."</td>\n";
			echo "<td>".$row['comCity']."</td>\n";
			echo "<td>".$row['stateName']."</td>\n";
			echo "<td>".$row['comEmail']."</td>\n";
      echo "<td>".$row['comDesc']."</td>\n";
			echo "<td><a href='OMSupdate_company.php?id=".urlencode($row['comID'])."'>Edit</a></td>\n";
      echo "</tr>";
    }
    echo "  </tbody>";
    echo "</table>\n";

		echo "<a href='OMScreate_companies.php'> Add a Company ";
    echo "</center>\n";
		echo "</div>\n";
		echo "<br /><p>&laquo:<a href='OMSadminhome.php'>Back to Main Page</a>\n";
	}

  new_footer(" OMS ");
	Database::dbDisconnect($mysqli);

?>
