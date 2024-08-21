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

	echo "<h3>Update a Company</h3>\n";
	echo "<div class='row'>\n";
	echo "<label for='left-label' class='left inline'>";

	if (isset($_POST["submit"])) {

		if((!empty($_POST['name'])) && (!(trim($_POST['name']) == "")) && (!empty($_POST['desc'])) && (!(trim($_POST['desc']) == ""))
	&& (!empty($_POST['city'])) && (!(trim($_POST['city']) == "")) && (!empty($_POST['email'])) && (!(trim($_POST['email']) == ""))){


		$query3 = "UPDATE COMPANY SET comName = ?, comCity = ?, stateNum = ?, comEmail = ?, comDesc = ? WHERE comID = ?;";
   	$stmt3 = $mysqli->prepare($query3);
		$stmt3 -> execute([$_POST['name'], $_POST['city'], $_POST['state'], $_POST['email'], $_POST['desc'], $_POST['comid']]);

    if($stmt3){
      $query4 = "SELECT comID FROM COMPANY WHERE comName = ?;";
      $stmt4 = $mysqli->prepare($query4);
      $stmt4-> execute([$_POST['name']]);
    }else{
      $_SESSION['message'] = "ERROR!! Could not update" ;
    }

		if($stmt4) {
			$_SESSION['message'] = $_POST['name']." has been updated";
			redirect("OMSreadcompany_admins.php");
		}else{
			$_SESSION["message"] = "ERROR!! Could not update the company";
			redirect("OMSreadcompany_admins.php");
		}
		redirect("OMSreadcompany_admins.php");
	}else{
		$_SESSION["message"] = "ERROR!! Could not update the company";
		redirect("OMSreadcompany_admins.php");
	}
		redirect("OMSreadcompany_admins.php");
	}
	else {

	  if (isset($_GET["id"]) && $_GET["id"] !== "") {
		  $query = "SELECT comID, comName, comCity, stateNum, comEmail, comDesc
		  FROM COMPANY WHERE comID = ?";
			$stmt = $mysqli->prepare($query);
			$stmt-> execute([$_GET['id']]);


		if ($stmt)  {
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
      echo "<form action='OMSupdate_company.php' method='POST'>\n";

      echo "<p>Company Name: <input type=text name='name' value = '".$row['comName']."'></p>\n";
      echo "<p>City: <input type=text name='city' value = '".$row['comCity']."'></p>\n";

      echo "<p>State: <select name='state'>\n";
      $query2 = "SELECT * FROM STATE ORDER BY stateCode ASC";
      $stmt2 = $mysqli -> prepare($query2);
      $stmt2 -> execute();
      while($row2 = $stmt2->fetch(PDO::FETCH_ASSOC)) {
        echo "<option value =".$row2["stateNum"];
        if($row2["stateNum"]==$row["stateNum"])
        {
          echo " selected ";
        }
        echo ">".$row2["stateCode"]."</option>\n";
      }
      echo "</select>\n";
      echo "<p>Email Address: <input type=email name='email' value = ".$row['comEmail']."></p>\n";
      echo "<p>Company Description: <input type=text name='desc' value = '".$row['comDesc']."'></p>\n";
			echo "<input type = 'hidden' name = 'comid' value = '".$row['comID']."' />\n";
			echo "<input type='submit' name='submit' value='Update'/>\n";
			echo "</form>\n";
		  echo "<h3>".$row['comName']." Information</h3>\n";
			echo "<br /><p>&laquo:<a href='OMSreadcompany_admins.php'>Back to Main Page</a>\n";
			echo "</label>\n";
			echo "</div>\n";
		}
		else {
			$_SESSION["message"] = "Company could not be found!";
			redirect("OMSreadcompany_admins.php");
		}
	  }
    }

new_footer(" OMS ");
Database::dbDisconnect($mysqli);

?>
