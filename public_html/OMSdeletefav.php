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

    	if ((isset($_GET["id"]) && $_GET["id"] !== "") &&(isset($_SESSION['userID'])&& $_SESSION['userID'] !== "")) {

      $query = "DELETE FROM FAVORITE WHERE jobID = ? AND acID = ?";
      $stmt = $mysqli->prepare($query);
      $stmt-> execute([$_GET["id"], $_SESSION['userID']]);

  		if ($stmt) {
        $_SESSION['message'] = "Successfully deleted";
        redirect("OMSread_userprofile_users.php");
  		}
  		else {
        $_SESSION['message'] = "Could not be deleted";
        redirect("OMSread_userprofile_users.php");
  		}

  	}
  	else {
  		$_SESSION["message"] = "Opportunity could not be found!";
      redirect("OMSread_userprofile_users.php");
  	}

  new_footer(" OMS ");
  Database::dbDisconnect($mysqli);

?>
