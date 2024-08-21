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


if ((isset($_GET["id"]) && $_GET["id"] !== "") &&(isset($_SESSION["userID"])&& $_SESSION["userID"] !== "")) {
  $user = $_SESSION["userID"];
  $job = $_GET["id"];

  $query = "SELECT acID, jobID FROM FAVORITE WHERE acID = ? and jobID = ?";
  $stmt =  $mysqli->prepare($query);
  $stmt-> execute([$user, $job]);

  if($stmt){
    	if($stmt -> rowCount() == 0){
        $query2 = "INSERT INTO FAVORITE(acID, jobID) VALUES(?, ?)";
        $stmt2 = $mysqli->prepare($query2);
        $stmt2-> execute([$user, $job]);

        if ($stmt2) {
          $_SESSION['message'] = "Successfully added";
          redirect("OMSreadjob_users.php");
        }else {
          $_SESSION['message'] = "Could not be add";
          redirect("OMSreadjob_users.php");
        }

      }else{
        $_SESSION['message'] = "Already in Your Favorites!!";
        redirect("OMSreadjob_users.php");
      }

    }else{
      $_SESSION['message'] = "Error";
      redirect("OMSreadjob_users.php");
    }

  }else {
    $_SESSION["message"] = "Opportunity could not be found!";
    redirect("OMSreadjob_users.php");
  }

new_footer(" OMS ");
Database::dbDisconnect($mysqli);

?>
