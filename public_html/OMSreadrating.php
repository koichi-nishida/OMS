
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


  if (isset($_GET["id"]) && $_GET["id"] !== "") {
    $query = "SELECT rating, comment, JOB.jobName, ACCOUNT.acUser
		FROM RATING JOIN JOB JOIN ACCOUNT ON JOB.jobID = RATING.jobID and ACCOUNT.acID = RATING.acID
		WHERE RATING.jobID = ? and rating is NOT NULL";
    $stmt = $mysqli->prepare($query);
    $stmt-> execute([$_GET['id']]);

  if ($stmt)  {
		echo "<div class='row'>\n";
		echo "<center>\n";
		echo "<h2>      </h2>\n";
    $query1 = "SELECT * FROM JOB WHERE jobID = ?";
    $stmt1 = $mysqli -> prepare($query1);
    $stmt1 -> execute([$_GET['id']]);
    $row1 = $stmt1->fetch(PDO::FETCH_ASSOC);

    echo "<h3>Comments on ".$row1['jobName']."</h3>\n";

		$query2 = "SELECT ROUND(AVG(rating), 2) as average FROM RATING WHERE jobID = ?";
    $stmt2 = $mysqli -> prepare($query2);
    $stmt2 -> execute([$_GET['id']]);
    $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);

		echo "<h3>Average Rating: ".$row2['average']." / 5.00</h3>\n";

		echo "<table>\n";
		echo "  <thead>\n";
		echo "    <tr><th>Username</th><th>Rating</th><th>Comment</th></tr>\n";
		echo "  </thead>\n";
		echo "  <tbody>\n";

    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      echo "<tr>";
		  echo "<td>".$row['acUser']."</td>\n";
      echo "<td>".$row['rating']."</td>\n";
			echo "<td>".$row['comment']."</td>\n";
			echo "</tr>";
    }
    echo "  </tbody>\n";
    echo "</table>\n";


		echo "</center>\n";
    echo "</div>\n";
		echo "<br /><p>&laquo:<a href='OMSreadjob_users.php'>Back to Main Page</a>\n";
  }
  else {
    $_SESSION["message"] = "Company could not be found!";
    redirect("OMSreadjob_users.php");
  }
  }

  new_footer(" OMS ");
	Database::dbDisconnect($mysqli);

?>
