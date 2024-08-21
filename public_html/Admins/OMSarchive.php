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

      $query = "SELECT jobArc FROM JOB where jobID = ?";
      $stmt = $mysqli->prepare($query);
      $stmt-> execute([$_GET["id"]]);
      $row = $stmt->fetch(PDO::FETCH_ASSOC);

  		if ($row["jobArc"] == 0) {
        $query = "UPDATE JOB SET jobArc = 1 where jobID = ?";
        $stmt = $mysqli->prepare($query);
        $stmt-> execute([$_GET["id"]]);

        $_SESSION['message'] = "Archived!!";
        redirect("OMSreadjob_admins.php");
  		}
  		else {
        $query = "UPDATE JOB SET jobArc = 0 where jobID = ?";
        $stmt = $mysqli->prepare($query);
        $stmt-> execute([$_GET["id"]]);

        $_SESSION['message'] = "Unarchived!!";
        redirect("OMSreadjob_admins.php");
  		}

  	}
  	else {
  		$_SESSION["message"] = "Opportunity could not be found!";
      redirect("OMSreadjob_admins.php");
  	}

  new_footer(" OMS ");
  Database::dbDisconnect($mysqli);

?>
