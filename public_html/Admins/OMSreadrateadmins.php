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

  $query = "SELECT RATING.jobID, RATING.acID, JOB.jobName, rating, comment, ACCOUNT.acUser, COMPANY.comName, COMPANY.comID
  FROM RATING JOIN JOB JOIN ACCOUNT JOIN COMPANY
  ON JOB.jobID = RATING.jobID AND ACCOUNT.acID = RATING.acID AND COMPANY.comID = JOB.comID ORDER BY RATING.jobID;";

  $stmt = $mysqli -> query($query);
	$stmt -> execute();

  if ($stmt) {
		echo "<div class='row'>\n";
		echo "<center>\n";
		echo "<h2>Reviews</h2>\n";
		echo "<table>\n";
		echo "  <thead>";
		echo "    <tr><th></th><th>Opportunity</th><th>Company</th><th>Username</th><th>Comment</th><th>Rating</th></tr>\n";
		echo "  </thead>\n";
		echo "  <tbody>\n";

    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      echo "<tr>";
			echo "<td><a style='color:red;' href='OMSdeleterating.php?id=".urlencode($row['jobID'])."&id2=".urlencode($row['acID'])."' onclick='return confirm(\"Are you sure you want to delete?\");'>X</a></td>\n";
      echo "<td>".$row['jobName']."</td>\n";
      echo "<td>".$row['comName']."</td>\n";
			echo "<td>".$row['acUser']."</td>\n";
			echo "<td>".$row['comment']."</td>\n";
			echo "<td>".$row['rating']."</td>\n";
      echo "</tr>";
    }
    echo "  </tbody>\n";
    echo "</table>\n";
    echo "</center>\n";
		echo "</div>\n";
		echo "<br /><p>&laquo:<a href='OMSadminhome.php'>Back to Main Page</a>";
	}

  new_footer(" OMS ");
	Database::dbDisconnect($mysqli);

?>
