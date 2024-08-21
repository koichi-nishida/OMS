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
session_start();
$_SESSION["job"] = $_GET["id"];

if ((isset($_GET["id"]) && $_GET["id"] !== "") &&(isset($_SESSION["userID"])&& $_SESSION["userID"] !== "")) {
  $user = $_SESSION["userID"];
  $job = $_GET["id"];

  $query = "SELECT jobID, acID FROM RATING WHERE jobID = ? and acID = ?";
  $stmt =  $mysqli->prepare($query);
  $stmt-> execute([$job, $user]);

  if($stmt){
    	if($stmt -> rowCount() == 0){
        $query2 = "INSERT INTO RATING(jobID, acID) VALUES(?, ?)";
        $stmt2 = $mysqli->prepare($query2);
        $stmt2-> execute([$job, $user]);

        if ($stmt2) {
          redirect("OMScomment.php");
        }else {
          $_SESSION['message'] = "Could not rate";
          redirect("OMSreadjob_users.php");
        }

      }else{
        $query3 = "SELECT*FROM RATING WHERE rating is NULL and comment is NULL and jobID = ? and acID = ?";
        $stmt3 =  $mysqli->prepare($query3);
        $stmt3-> execute([$job, $user]);
        if($stmt3){
          if($stmt3 -> rowCount() !== 0){
              redirect("OMScomment.php");
          }else{
            $_SESSION['message'] = "Already rated!!";
            redirect("OMSreadjob_users.php");
          }
        }else{
          $_SESSION['message'] = "Error";
          redirect("OMSreadjob_users.php");
        }
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
