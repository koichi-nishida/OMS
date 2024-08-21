
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
    $query = "SELECT jobID, jobName, TYPE.typeID, TYPE.typeName, jobDesc, COMPANY.comID, COMPANY.comName, jobDate, jobURL, jobArc
    FROM JOB JOIN COMPANY JOIN TYPE
    ON JOB.typeID = TYPE.typeID AND JOB.comID = COMPANY.comID where jobArc = 0 and COMPANY.comID = ?";
    $stmt = $mysqli->prepare($query);
    $stmt-> execute([$_GET['id']]);


  if ($stmt)  {
    echo "<div class='row'>\n";
		echo "<br><br>";
		echo "<center>\n";
    $query1 = "SELECT * FROM COMPANY WHERE comID = ?";
    $stmt1 = $mysqli -> prepare($query1);
    $stmt1 -> execute([$_GET['id']]);
    $row1 = $stmt1->fetch(PDO::FETCH_ASSOC);
    echo "<h3>Opportunities at ".$row1['comName']."</h3>\n";
    echo "<table>\n";
		echo "  <thead>\n";
		echo "    <tr><th>Name</th><th>Opportunity Type</th><th>Description</th><th>Start Date</th><th>URL</th></tr>\n";
		echo "  </thead>\n";
		echo "  <tbody>\n";

    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      echo "<tr>";
      echo "<td>".$row['jobName']."</td>\n";
			echo "<td>".$row['typeName']."</td>\n";
			echo "<td>".$row['jobDesc']."</td>\n";
			echo "<td>".$row['jobDate']."</td>\n";
			if($row['jobURL'] == ''){
			echo "<td>No URL</td>\n";
		 }else{
			echo "<td><a href='../../../../".urlencode($row['jobURL'])."'>URL</a></td>\n";
		 }
			echo "</tr>";
    }
    echo "  </tbody>\n";
    echo "</table>\n";
    echo "</center>\n";
    echo "</div>\n";
		echo "<br /><p>&laquo:<a href='OMSreadcom.php'>Back to Main Page</a>\n";
  }
  else {
    $_SESSION["message"] = "Company could not be found!";
    redirect("OMSreadcom.php");
  }
  }

  new_footer(" OMS ");
	Database::dbDisconnect($mysqli);

?>
