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


	echo "<h3>Update an Opportunity</h3>\n";
	echo "<div class='row'>\n";
	echo "<label for='left-label' class='left inline'>\n";

	if (isset($_POST["submit"])) {

		if((!empty($_POST['name'])) && (!(trim($_POST['name']) == "")) && (!empty($_POST['desc'])) && (!(trim($_POST['desc']) == ""))
	&& (!empty($_POST['date'])) && (!(trim($_POST['date']) == ""))){

		$query3 = "UPDATE JOB SET jobName = ?, typeID = ?, jobDesc = ?, comID = ?, jobDate = ?, jobURL = ? WHERE jobID = ?;";
   	$stmt3 = $mysqli->prepare($query3);
		$stmt3 -> execute([$_POST['name'], $_POST['type'], $_POST['desc'], $_POST['com'], $_POST['date'], $_POST['url'], $_POST['jobid']]);

		if($stmt3) {
			$_SESSION['message'] = $_POST['name']." has been updated";
			redirect("OMSreadjob_admins.php");
		}else{
			$_SESSION["message"] = "ERROR!! Could not update the opportunity";
			redirect("OMSreadjob_admins.php");
		}
		redirect("OMSreadjob_admins.php");

	}else{
		$_SESSION["message"] = "Unable to update an opportunity! Fill in all information!";
		redirect("OMSreadjob_admins.php");
	}

	redirect("OMSreadjob_admins.php");
}
	else {

	  if (isset($_GET["id"]) && $_GET["id"] !== "") {
		  $query = "SELECT jobID, jobName, typeID, jobDesc, comID, jobDate, jobURL
		  FROM JOB WHERE jobID = ?";
			$stmt = $mysqli->prepare($query);
			$stmt-> execute([$_GET["id"]]);


		if ($stmt)  {
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
      echo "<form action='OMSupdate_job.php' method='POST'>\n";

      echo "<p>Opportunity Name: <input type=text name='name' value = '".$row['jobName']."'></p>\n";

      echo "<p>Type Name: <select name='type'>\n";
      $query1 = "SELECT * FROM TYPE ORDER BY typeName ASC";
      $stmt1 = $mysqli -> prepare($query1);
      $stmt1 -> execute();
      while($row1 = $stmt1->fetch(PDO::FETCH_ASSOC)) {
        echo "<option value =".$row1["typeID"];
        if($row1["typeID"] == $row["typeID"]){
          echo " selected ";
        }
        echo ">".$row1["typeName"]."</option>\n";
      }
      echo "</select>\n";
      echo "</p>\n";

      echo "<p>Opportunity Description: <input type=text name='desc' value = '".$row['jobDesc']."'></p>\n";

      echo "<p>Company Name: <select name='com'>\n";
      $query2 = "SELECT * FROM COMPANY ORDER BY comName ASC";
      $stmt2 = $mysqli -> prepare($query2);
      $stmt2 -> execute();
      while($row2 = $stmt2->fetch(PDO::FETCH_ASSOC)) {
        echo "<option value =".$row2["comID"];
        if($row2["comID"] == $row["comID"]){
          echo " selected ";
        }
        echo ">".$row2["comName"]."</option>\n";
      }
      echo "</select>\n";
			echo "</p>\n";
			echo "<p>Start Date: <input type=date name='date' value = '".$row['jobDate']."'></p>\n";
			echo "<p>Opportunity URL: <input type=url name='url' value = '".$row['jobURL']."'></p>\n";
			echo "<input type = 'hidden' name = 'jobid' value = '".$row['jobID']."' />\n";
			echo "<input type='submit' name='submit' value='Update'/>\n";
			echo "</form>\n";
		  echo "<h3>".$row['jobName']." Information</h3>\n";
			echo "<br /><p>&laquo:<a href='OMSreadjob_admins.php'>Back to Main Page</a>\n";
			echo "</label>\n";
			echo "</div>\n";
		}
		else {
			$_SESSION["message"] = "Opportunity could not be found!";
			redirect("OMSreadjob_admins.php");
		}
	  }
    }

new_footer(" OMS ");
Database::dbDisconnect($mysqli);

?>
