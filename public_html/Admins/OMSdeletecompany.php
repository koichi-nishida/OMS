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

    	if (isset($_GET["id"]) && $_GET["id"] !== "") {

      $query = "DELETE FROM COMPANY WHERE COMPANY.comID = ?";
      $stmt = $mysqli->prepare($query);
      $stmt-> execute([$_GET["id"]]);

  		if ($stmt) {
        $_SESSION['message'] = "Successfully deleted";
        redirect("OMSreadcompany_admins.php");
  		}
  		else {
        $_SESSION['message'] = "Could not be deleted";
        redirect("OMSreadcompany_admins.php");
  		}

  	}
  	else {
  		$_SESSION["message"] = "Company could not be found!";
      redirect("OMSreadcompany_admins.php");
  	}

  new_footer(" OMS ");
  Database::dbDisconnect($mysqli);

?>
