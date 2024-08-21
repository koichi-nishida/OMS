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

        $query = "DELETE FROM ADMIN WHERE adID = ? and adID != ?";
        $stmt = $mysqli->prepare($query);
        $stmt-> execute([$_GET["id"], $_SESSION['aduserID']]);

    		if ($stmt) {
          if($stmt -> rowCount() > 0){
          $_SESSION['message'] = "Successfully deleted";
          redirect("OMSread_adminprofile.php");
        }
        else{
          $_SESSION['message'] = "Don't delete your account!!";
          redirect("OMSread_adminprofile.php");
        }
      }	else {
          $_SESSION['message'] = "Could not be deleted";
          redirect("OMSread_adminprofile.php");
    		}

  }else {
  		$_SESSION["message"] = "Admin could not be found!";
      redirect("OMSread_adminprofile.php");
  	}

  new_footer(" OMS ");
  Database::dbDisconnect($mysqli);

?>
