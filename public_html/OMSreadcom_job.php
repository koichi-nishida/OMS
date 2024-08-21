
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
    $query = "SELECT comID, comName, comCity, STATE.stateNum, STATE.stateName, comEmail, comDesc
    FROM COMPANY JOIN STATE ON STATE.stateNum = COMPANY.stateNum WHERE comID = ?";
    $stmt = $mysqli->prepare($query);
    $stmt-> execute([$_GET['id']]);

  if ($stmt)  {
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "<form action='OMSreadcom_job.php' method='POST'>\n";
    echo "<div>\n";
    echo "<label>\n";
    echo "<h2>Information of ".$row['comName']."</h2>\n";
    echo "<h3>City: ".$row['comCity']."</h3>\n";
    echo "<h3>State: ".$row['stateName']."</h3>\n";
    echo "<h3>Email Address: ".$row['comEmail']."</h3>\n";
    echo "<h3>Description: ".$row['comDesc']."</h3>\n";

    echo "<br /><p>&laquo:<a href='OMSreadjob_users.php'>Back to Main Page</a>\n";
    echo "</label>\n";
    echo "</div>\n";
  }
  else {
    $_SESSION["message"] = "Company could not be found!";
    redirect("OMSreadjob_users.php");
  }
  }

  new_footer(" OMS ");
	Database::dbDisconnect($mysqli);

?>
