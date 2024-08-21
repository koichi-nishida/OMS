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

echo "<h3>Post an Opportunity</h3>\n";
echo "<div class='row'>\n";
echo "<label for='left-label' class='left inline'>\n";

  if (isset($_POST["submit"])) {

    if((isset($_POST["name"])&& $_POST["name"] !== "") &&(isset($_POST["type"]) && $_POST["type"] !== "") && (isset($_POST["desc"]) && $_POST["desc"] !== "")
    && (isset($_POST["com"]) && $_POST["com"] !== "")&& (isset($_POST["date"]) && $_POST["date"] !== "")){

      if((!empty($_POST['name'])) && (!(trim($_POST['name']) == "")) && (!empty($_POST['desc'])) && (!(trim($_POST['desc']) == ""))
		&& (!empty($_POST['date'])) && (!(trim($_POST['date']) == ""))){

        $query4 = "INSERT INTO JOB(jobName, typeID, jobDesc, comID, jobDate, jobURL, jobArc) VALUES (?, ?, ?, ?, ?, ?, 0)";
        $stmt4 = $mysqli->prepare($query4);
        $stmt4-> execute([$_POST['name'], $_POST['type'], $_POST['desc'], $_POST['com'], $_POST['date'], $_POST['url']]);


        if($stmt4){
          $query5 = "SELECT jobID FROM JOB WHERE jobName = ?";
          $stmt5 = $mysqli ->prepare($query5);
          $stmt5 -> execute([$_POST['name']]);
        }
        else{
          $_SESSION['message'] = "error could not add" ;
        }

          if($stmt5) {
            $_SESSION['message'] = $_POST['name']." has been added";
          }else{
            $_SESSION["message"] = "Error!! Could not add " .$_POST['name']."";
          }
          redirect("OMSuserhome.php");

        }else{
          $_SESSION["message"] = "Unable to add an opportunity! Fill in all information!";
          redirect("OMScreate_jobs_users.php");
        }

      }else {
        $_SESSION["message"] = "Unable to add an opportunity! Fill in all information!";
        redirect("OMScreate_jobs_users.php");
      }

}else {
      echo "<form action='OMScreate_jobs_users.php' method='POST'>\n";
      echo "<p>Opportunity Name: <input type=text name='name'></p>\n";
      echo "<p>Type Name: <select name='type'>\n";
      $query1 = "SELECT * FROM TYPE ORDER BY typeName ASC";
      $stmt1 = $mysqli -> prepare($query1);
      $stmt1 -> execute();
      while($row = $stmt1->fetch(PDO::FETCH_ASSOC)) {
        echo "<option value =".$row["typeID"].">".$row["typeName"]."</option>\n";
      }
      echo "</select>\n";
      echo "</p>\n";
      echo "<p>Opportunity Description: <input type=text name='desc'></p>\n";
      echo "<p>Company Name: <select name='com'>\n";
      $query2 = "SELECT * FROM COMPANY ORDER BY comName ASC";
      $stmt2 = $mysqli -> prepare($query2);
      $stmt2 -> execute();
      while($row = $stmt2->fetch(PDO::FETCH_ASSOC)) {
        echo "<option value =".$row["comID"].">".$row["comName"]."</option>\n";
      }
      echo "</select>\n";
      echo "</p>\n";
			echo "<p>Start Date: <input type=date name='date'></p>\n";
			echo "<p>Opportunity URL: <input type=url name='url'></p>\n";
      echo "<input type='submit' name='submit' value='Add'/>\n";
      echo "</form>\n";
}
echo "</label>\n";
echo "</div>\n";
echo "<br /><p>&laquo:<a href='OMSuserhome.php'>Back to Main Page</a>\n";

new_footer(" OMS ");
Database::dbDisconnect($mysqli);

?>
