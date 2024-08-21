

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

  $query = "SELECT jobID, jobName, TYPE.typeID, TYPE.typeName, jobDesc, COMPANY.comID, COMPANY.comName, jobDate, jobURL, jobArc
  FROM JOB JOIN COMPANY JOIN TYPE
  ON JOB.typeID = TYPE.typeID AND JOB.comID = COMPANY.comID ORDER BY jobID DESC;";

  $stmt = $mysqli -> query($query);
	$stmt -> execute();

  if ($stmt) {
		echo "<div class='row'>\n";
		echo "<center>";
		echo "<h2>Opportunities</h2>\n";
		echo "<table>";
		echo "  <thead>\n";
		echo "    <tr><th></th><th>Name</th><th>Opportunity Type</th><th>Description</th><th>Company</th><th>Start Date</th><th>URL</th><th></th><th></th><th>Archive /Unarchive</th></tr>\n";
		echo "  </thead>";
		echo "  <tbody>\n";

    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      echo "<tr>";
			echo "<td><a style='color:red;' href='OMSdeletejob.php?id=".urlencode($row['jobID'])."' onclick='return confirm(\"Are you sure you want to delete?\");'>X</a></td>\n";
      echo "<td>".$row['jobName']."</td>\n";
			echo "<td>".$row['typeName']."</td>\n";
			echo "<td>".$row['jobDesc']."</td>\n";
			echo "<td>".$row['comName']."</td>\n";
			echo "<td>".$row['jobDate']."</td>\n";
			if($row['jobURL'] == ''){
			echo "<td>No URL</td>\n";
		 }else{
			echo "<td><a href='../../../../".urlencode($row['jobURL'])."'>URL</a></td>\n";
		 }
			echo "<td><a href='OMSupdate_job.php?id=".urlencode($row['jobID'])."'>Edit</a></td>\n";
			echo "<td><a style='color:green;' href='OMSarchive.php?id=".urlencode($row['jobID'])."'> &#9989</a></td>\n";
			if($row['jobArc'] == 1){
				echo "<td>Archived</td>\n";
			}else{
			echo "<td></td>\n";
			}
      echo "</tr>";
    }
    echo "  </tbody>\n";
    echo "</table>";

		echo "<a href='OMScreate_jobs_admins.php'> Post an Opportunity";
    echo "</center>\n";
		echo "</div>";
		echo "<br /><p>&laquo:<a href='OMSadminhome.php'>Back to Main Page</a>";
	}

  new_footer(" OMS ");
	Database::dbDisconnect($mysqli);

?>
