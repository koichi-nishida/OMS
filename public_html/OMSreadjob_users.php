
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


if(isset($_POST["submit"])){
$job = $_POST['job'];

	if($_POST['state'] == 0){

		if($_POST['type'] == 0){
			//all types and all states

		$query = "SELECT JOB.jobID, jobName, TYPE.typeID, TYPE.typeName, jobDesc, COMPANY.comID, COMPANY.comName, jobDate, jobURL
	  FROM JOB JOIN COMPANY JOIN TYPE
	  ON JOB.typeID = TYPE.typeID AND JOB.comID = COMPANY.comID where jobArc = 0 and jobName LIKE '%{$job}%' ORDER BY jobID DESC;";

	  $stmt = $mysqli->query($query);
		$stmt -> execute();

	  if ($stmt) {
			echo "<div class='row'>\n";
			echo "<center>\n";
			echo "<h2>Opportunities</h2>\n";
			echo "</center>\n";
			echo "<form action='OMSreadjob_users.php' method='POST'>\n";
			echo "<p>Search by Keyword: <input type=text name='job' value = '$job'></p>\n";
			echo "<p>Filter by Type: <select name='type'>";
			echo "<option value = 0>ALL</option>";
			$query2 = "SELECT * FROM TYPE ORDER BY typeID ASC";
			$stmt2 = $mysqli -> prepare($query2);
			$stmt2 -> execute();
			while($row1 = $stmt2->fetch(PDO::FETCH_ASSOC)) {
				echo "<option value =".$row1["typeID"].">".$row1["typeName"]."</option>\n";
			}
			echo "</select>\n";
			echo "</p>\n";

			echo "<p>Filter by State: <select name='state'>";
			echo "<option value = 0>ALL</option>";
			$query1 = "SELECT * FROM STATE ORDER BY stateCode ASC";
			$stmt1 = $mysqli -> prepare($query1);
			$stmt1 -> execute();
			while($row = $stmt1->fetch(PDO::FETCH_ASSOC)) {
				echo "<option value =".$row["stateNum"].">".$row["stateName"]."</option>\n";
			}
			echo "</select>\n";
			echo "</p>\n";
			echo "<input type='submit' name='submit' value='Filter'/>\n";
			echo "</form>\n";
			echo "<center>\n";
			echo "<table>\n";
			echo "  <thead>\n";
			echo "    <tr><th>Add to My Favorite</th><th>Name</th><th>Opportunity Type</th><th>Description</th><th>Start Date</th><th>URL</th><th></th><th></th><th>Company</th><th></th></tr>\n";
			echo "  </thead>\n";
			echo "  <tbody>\n";

	    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
	      echo "<tr>\n";
				echo "<td><a style='color:red;' href='OMSaddfavorite.php?id=".urlencode($row['jobID'])."'>&#10025</a></td>\n";
	      echo "<td>".$row['jobName']."</td>\n";
				echo "<td>".$row['typeName']."</td>\n";
				echo "<td>".$row['jobDesc']."</td>\n";
				echo "<td>".$row['jobDate']."</td>\n";
				if($row['jobURL'] == ''){
				echo "<td>No URL</td>\n";
			 }else{
				echo "<td><a href='../../../../".urlencode($row['jobURL'])."'>URL</a></td>\n";
			 }
				echo "<td><a href='OMSreadrating.php?id=".urlencode($row['jobID'])."'>View Comments</a></td>\n";
				echo "<td><a href='OMScreaterating.php?id=".urlencode($row['jobID'])."'>Post a Comment</a></td>\n";
				echo "<td>".$row['comName']."</td>\n";
				echo "<td><a href='OMSreadcom_job.php?id=".urlencode($row['comID'])."'>Detail</a></td>\n";
	      echo "</tr>\n";
	    }
	    echo "  </tbody>\n";
	    echo "</table>\n";

					echo "<a href='OMScreatejobfromjobs.php'> Post an Opportunity";

	    echo "</center>\n";
			echo "</div>\n";
			echo "<br /><p>&laquo:<a href='OMSuserhome.php'>Back to Main Page</a>\n";
		}
	}else{
			//one type and all states
			$query5 = "SELECT JOB.jobID, jobName, TYPE.typeID, TYPE.typeName, jobDesc, COMPANY.comID, COMPANY.comName, jobDate, jobURL, COMPANY.stateNum
			FROM JOB JOIN COMPANY JOIN TYPE JOIN STATE
			ON JOB.typeID = TYPE.typeID AND JOB.comID = COMPANY.comID AND STATE.stateNum = COMPANY.stateNum
			where jobArc = 0 and JOB.typeID = ? and jobName LIKE '%{$job}%' ORDER BY jobID DESC;";
			$stmt5 = $mysqli ->prepare($query5);
			$stmt5 -> execute([$_POST['type']]);

			if($stmt5){
				echo "<div class='row'>\n";
				echo "<center>\n";
				echo "<h2>Opportunities</h2>\n";
				echo "</center>\n";
				echo "<form action='OMSreadjob_users.php' method='POST'>\n";
				echo "<p>Search by Keyword: <input type=text name='job' value = '$job'></p>\n";
				echo "<p>Filter by Type: <select name='type'>";
				echo "<option value = 0>ALL</option>";
				$query2 = "SELECT * FROM TYPE ORDER BY typeID ASC";
				$stmt2 = $mysqli -> prepare($query2);
				$stmt2 -> execute();
				while($row1 = $stmt2->fetch(PDO::FETCH_ASSOC)) {
					echo "<option value =".$row1["typeID"];
					if($_POST['type'] == $row1["typeID"])
					{
						echo " selected ";
					}
					echo ">".$row1["typeName"]."</option>\n";
				}
				echo "</select>\n";
				echo "</p>\n";

				echo "<p>Filter by State: <select name='state'>";
				echo "<option value = 0>ALL</option>";
				$query1 = "SELECT * FROM STATE ORDER BY stateCode ASC";
				$stmt1 = $mysqli -> prepare($query1);
				$stmt1 -> execute();
				while($row = $stmt1->fetch(PDO::FETCH_ASSOC)) {
					echo "<option value =".$row["stateNum"].">".$row["stateName"]."</option>\n";
				}
				echo "</select>\n";
				echo "</p>\n";

				echo "<input type='submit' name='submit' value='Filter'/>\n";
				echo "</form>\n";
				echo "<center>\n";
				echo "<table>\n";
				echo "  <thead>\n";
				echo "    <tr><th>Add to My Favorite</th><th>Name</th><th>Opportunity Type</th><th>Description</th><th>Start Date</th><th>URL</th><th></th><th></th><th>Company</th><th></th></tr>\n";
				echo "  </thead>\n";
				echo "  <tbody>\n";

				while($row = $stmt5->fetch(PDO::FETCH_ASSOC)) {
					echo "<tr>\n";
					echo "<td><a style='color:red;' href='OMSaddfavorite.php?id=".urlencode($row['jobID'])."'>&#10025</a></td>\n";
					echo "<td>".$row['jobName']."</td>\n";
					echo "<td>".$row['typeName']."</td>\n";
					echo "<td>".$row['jobDesc']."</td>\n";
					echo "<td>".$row['jobDate']."</td>\n";
					if($row['jobURL'] == ''){
					echo "<td>No URL</td>\n";
				 }else{
					echo "<td><a href='../../../../".urlencode($row['jobURL'])."'>URL</a></td>\n";
				 }
					echo "<td><a href='OMSreadrating.php?id=".urlencode($row['jobID'])."'>View Comments</a></td>\n";
					echo "<td><a href='OMScreaterating.php?id=".urlencode($row['jobID'])."'>Post a Comment</a></td>\n";
					echo "<td>".$row['comName']."</td>\n";
					echo "<td><a href='OMSreadcom_job.php?id=".urlencode($row['comID'])."'>Detail</a></td>\n";
					echo "</tr>\n";
				}
				echo "  </tbody>\n";
				echo "</table>\n";
						echo "<a href='OMScreatejobfromjobs.php'> Post an Opportunity";
				echo "</center>\n";
				echo "</div>\n";
				echo "<br /><p>&laquo:<a href='OMSuserhome.php'>Back to Main Page</a>\n";
			}
	}

}else{
			//one state and all types
			if($_POST['type'] == 0){

				$query5 = "SELECT JOB.jobID, jobName, TYPE.typeID, TYPE.typeName, jobDesc, COMPANY.comID, COMPANY.comName, jobDate, jobURL, COMPANY.stateNum
			  FROM JOB JOIN COMPANY JOIN TYPE JOIN STATE
			  ON JOB.typeID = TYPE.typeID AND JOB.comID = COMPANY.comID AND STATE.stateNum = COMPANY.stateNum
				where jobArc = 0 and COMPANY.stateNum = ? and jobName LIKE '%{$job}%' ORDER BY jobID DESC;";
				$stmt5 = $mysqli ->prepare($query5);
				$stmt5 -> execute([$_POST['state']]);

				if($stmt5){
					echo "<div class='row'>\n";
					echo "<center>\n";
					echo "<h2>Opportunities</h2>\n";
					echo "</center>\n";
					echo "<form action='OMSreadjob_users.php' method='POST'>\n";
					echo "<p>Search by Keyword: <input type=text name='job' value = '$job'></p>\n";
					echo "<p>Filter by Type: <select name='type'>";
					echo "<option value = 0>ALL</option>";
					$query2 = "SELECT * FROM TYPE ORDER BY typeID ASC";
					$stmt2 = $mysqli -> prepare($query2);
					$stmt2 -> execute();
					while($row1 = $stmt2->fetch(PDO::FETCH_ASSOC)) {
						echo "<option value =".$row1["typeID"].">".$row1["typeName"]."</option>\n";
					}
					echo "</select>\n";
					echo "</p>\n";

					echo "<p>Filter by State: <select name='state'>";
			    echo "<option value = 0>ALL</option>";
					$query1 = "SELECT * FROM STATE ORDER BY stateCode ASC";
					$stmt1 = $mysqli -> prepare($query1);
					$stmt1 -> execute();
					while($row = $stmt1->fetch(PDO::FETCH_ASSOC)) {
						echo "<option value =".$row["stateNum"];
						if($_POST['state']==$row["stateNum"])
						{
							echo " selected ";
						}
						echo ">".$row["stateName"]."</option>\n";
					}
					echo "</select>\n";
					echo "</p>\n";
					echo "<input type='submit' name='submit' value='Filter'/>\n";
					echo "</form>\n";
					echo "<center>\n";
					echo "<table>\n";
					echo "  <thead>\n";
					echo "    <tr><th>Add to My Favorite</th><th>Name</th><th>Opportunity Type</th><th>Description</th><th>Start Date</th><th>URL</th><th></th><th></th><th>Company</th><th></th></tr>\n";
					echo "  </thead>\n";
					echo "  <tbody>\n";

			    while($row = $stmt5->fetch(PDO::FETCH_ASSOC)) {
			      echo "<tr>\n";
						echo "<td><a style='color:red;' href='OMSaddfavorite.php?id=".urlencode($row['jobID'])."'>&#10025</a></td>\n";
			      echo "<td>".$row['jobName']."</td>\n";
						echo "<td>".$row['typeName']."</td>\n";
						echo "<td>".$row['jobDesc']."</td>\n";
						echo "<td>".$row['jobDate']."</td>\n";
						if($row['jobURL'] == ''){
						echo "<td>No URL</td>\n";
					 }else{
						echo "<td><a href='../../../../".urlencode($row['jobURL'])."'>URL</a></td>\n";
					 }
					 	echo "<td><a href='OMSreadrating.php?id=".urlencode($row['jobID'])."'>View Comments</a></td>\n";
						echo "<td><a href='OMScreaterating.php?id=".urlencode($row['jobID'])."'>Post a Comment</a></td>\n";
						echo "<td>".$row['comName']."</td>\n";
						echo "<td><a href='OMSreadcom_job.php?id=".urlencode($row['comID'])."'>Detail</a></td>\n";
			      echo "</tr>\n";
			    }
			    echo "  </tbody>\n";
			    echo "</table>\n";
							echo "<a href='OMScreatejobfromjobs.php'> Post an Opportunity";
			    echo "</center>\n";
					echo "</div>\n";
					echo "<br /><p>&laquo:<a href='OMSuserhome.php'>Back to Main Page</a>\n";
				}
			}else{
				//one state and one type
				$query5 = "SELECT JOB.jobID, jobName, TYPE.typeID, TYPE.typeName, jobDesc, COMPANY.comID, COMPANY.comName, jobDate, jobURL, COMPANY.stateNum
			  FROM JOB JOIN COMPANY JOIN TYPE JOIN STATE
			  ON JOB.typeID = TYPE.typeID AND JOB.comID = COMPANY.comID AND STATE.stateNum = COMPANY.stateNum
				where jobArc = 0 and COMPANY.stateNum = ? and TYPE.typeID = ? and jobName LIKE '%{$job}%' ORDER BY jobID DESC;";
				$stmt5 = $mysqli ->prepare($query5);
				$stmt5 -> execute([$_POST['state'], $_POST['type']]);

				if($stmt5){
					echo "<div class='row'>\n";
					echo "<center>\n";
					echo "<h2>Opportunities</h2>\n";
					echo "</center>\n";
					echo "<form action='OMSreadjob_users.php' method='POST'>\n";
					echo "<p>Search by Keyword: <input type=text name='job' value = '$job'></p>\n";
					echo "<p>Filter by Type: <select name='type'>";
					echo "<option value = 0>ALL</option>";
					$query2 = "SELECT * FROM TYPE ORDER BY typeID ASC";
					$stmt2 = $mysqli -> prepare($query2);
					$stmt2 -> execute();
					while($row1 = $stmt2->fetch(PDO::FETCH_ASSOC)) {
						echo "<option value =".$row1["typeID"];
						if($_POST['type'] == $row1["typeID"])
						{
							echo " selected ";
						}
						echo ">".$row1["typeName"]."</option>\n";
					}
					echo "</select>\n";
					echo "</p>\n";

					echo "<p>Filter by State: <select name='state'>";
			    echo "<option value = 0>ALL</option>";
					$query1 = "SELECT * FROM STATE ORDER BY stateCode ASC";
					$stmt1 = $mysqli -> prepare($query1);
					$stmt1 -> execute();
					while($row = $stmt1->fetch(PDO::FETCH_ASSOC)) {
						echo "<option value =".$row["stateNum"];
						if($_POST['state']==$row["stateNum"])
						{
							echo " selected ";
						}
						echo ">".$row["stateName"]."</option>\n";
					}
					echo "</select>\n";
					echo "</p>\n";
					echo "<input type='submit' name='submit' value='Filter'/>\n";
					echo "</form>\n";
					echo "<center>\n";
					echo "<table>\n";
					echo "  <thead>\n";
					echo "    <tr><th>Add to My Favorite</th><th>Name</th><th>Opportunity Type</th><th>Description</th><th>Start Date</th><th>URL</th><th></th><th></th><th>Company</th><th></th></tr>\n";
					echo "  </thead>\n";
					echo "  <tbody>\n";

			    while($row = $stmt5->fetch(PDO::FETCH_ASSOC)) {
			      echo "<tr>\n";
						echo "<td><a style='color:red;' href='OMSaddfavorite.php?id=".urlencode($row['jobID'])."'>&#10025</a></td>\n";
			      echo "<td>".$row['jobName']."</td>\n";
						echo "<td>".$row['typeName']."</td>\n";
						echo "<td>".$row['jobDesc']."</td>\n";
						echo "<td>".$row['jobDate']."</td>\n";
						if($row['jobURL'] == ''){
						echo "<td>No URL</td>\n";
					 }else{
						echo "<td><a href='../../../../".urlencode($row['jobURL'])."'>URL</a></td>\n";
					 }
					 	echo "<td><a href='OMSreadrating.php?id=".urlencode($row['jobID'])."'>View Comments</a></td>\n";
						echo "<td><a href='OMScreaterating.php?id=".urlencode($row['jobID'])."'>Post a Comment</a></td>\n";
						echo "<td>".$row['comName']."</td>\n";
						echo "<td><a href='OMSreadcom_job.php?id=".urlencode($row['comID'])."'>Detail</a></td>\n";
			      echo "</tr>\n";
			    }
			    echo "  </tbody>\n";
			    echo "</table>\n";
					echo "<a href='OMScreatejobfromjobs.php'> Post an Opportunity";
			    echo "</center>\n";
					echo "</div>\n";
					echo "<br /><p>&laquo:<a href='OMSuserhome.php'>Back to Main Page</a>\n";
				}
			}
		}
}else{
	//default read job file
  $query = "SELECT JOB.jobID, jobName, TYPE.typeID, TYPE.typeName, jobDesc, COMPANY.comID, COMPANY.comName, jobDate, jobURL
  FROM JOB JOIN COMPANY JOIN TYPE
  ON JOB.typeID = TYPE.typeID AND JOB.comID = COMPANY.comID where jobArc = 0 ORDER BY jobID DESC;";

  $stmt = $mysqli->query($query);
	$stmt -> execute();
  if ($stmt) {
		echo "<div class='row'>\n";
		echo "<center>\n";
		echo "<h2>Opportunities</h2>\n";
		echo "</center>\n";
		echo "<form action='OMSreadjob_users.php' method='POST'>\n";
		echo "<p>Search by Keyword: <input type=text name='job'></p>\n";
		echo "<p>Filter by Type: <select name='type'>";
		echo "<option value = 0>ALL</option>";
		$query2 = "SELECT * FROM TYPE ORDER BY typeID ASC";
		$stmt2 = $mysqli -> prepare($query2);
		$stmt2 -> execute();
		while($row1 = $stmt2->fetch(PDO::FETCH_ASSOC)) {
			echo "<option value =".$row1["typeID"].">".$row1["typeName"]."</option>\n";
		}
		echo "</select>\n";
		echo "</p>\n";


		echo "<p>Filter by State: <select name='state'>";
		echo "<option value = 0>ALL</option>";
		$query1 = "SELECT * FROM STATE ORDER BY stateCode ASC";
		$stmt1 = $mysqli -> prepare($query1);
		$stmt1 -> execute();
		while($row = $stmt1->fetch(PDO::FETCH_ASSOC)) {
			echo "<option value =".$row["stateNum"].">".$row["stateName"]."</option>\n";
		}
		echo "</select>\n";
		echo "</p>\n";

		echo "<input type='submit' name='submit' value='Filter'/>\n";

		echo "</form>\n";
		echo "<center>\n";
		echo "<table>\n";
		echo "  <thead>\n";
		echo "    <tr><th>Add to My Favorite</th><th>Name</th><th>Opportunity Type</th><th>Description</th><th>Start Date</th><th>URL</th><th></th><th></th><th>Company</th><th></th></tr>\n";
		echo "  </thead>\n";
		echo "  <tbody>\n";

    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      echo "<tr>\n";
			echo "<td><a style='color:red;' href='OMSaddfavorite.php?id=".urlencode($row['jobID'])."'>&#10025</a></td>\n";
      echo "<td>".$row['jobName']."</td>\n";
			echo "<td>".$row['typeName']."</td>\n";
			echo "<td>".$row['jobDesc']."</td>\n";
			echo "<td>".$row['jobDate']."</td>\n";
			if($row['jobURL'] == ''){
			echo "<td>No URL</td>\n";
		 }else{
			echo "<td><a href='../../../../".urlencode($row['jobURL'])."'>URL</a></td>\n";
		 }
			echo "<td><a href='OMSreadrating.php?id=".urlencode($row['jobID'])."'>View Comments</a></td>\n";
			echo "<td><a href='OMScreaterating.php?id=".urlencode($row['jobID'])."'>Post a Comment</a></td>\n";
			echo "<td>".$row['comName']."</td>\n";
			echo "<td><a href='OMSreadcom_job.php?id=".urlencode($row['comID'])."'>Detail</a></td>\n";
      echo "</tr>\n";
    }
    echo "  </tbody>\n";
    echo "</table>\n";

				echo "<a href='OMScreatejobfromjobs.php'> Post an Opportunity";

    echo "</center>\n";
		echo "</div>\n";
		echo "<br /><p>&laquo:<a href='OMSuserhome.php'>Back to Main Page</a>\n";
	}
}

  new_footer(" OMS ");
	Database::dbDisconnect($mysqli);

?>
