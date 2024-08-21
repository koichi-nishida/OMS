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

echo "<h3>Add a Company</h3>";
echo "<div class='row'>";
echo "<label for='left-label' class='left inline'>";

  if (isset($_POST["submit"])) {

    if((isset($_POST["name"])&& $_POST["name"] !== "") &&(isset($_POST["city"]) && $_POST["city"] !== "") && (isset($_POST["state"]) && $_POST["state"] !== "")
    && (isset($_POST["email"]) && $_POST["email"] !== "") && (isset($_POST["desc"]) && $_POST["desc"] !== "")){

				if((!empty($_POST['name'])) && (!(trim($_POST['name']) == "")) && (!empty($_POST['desc'])) && (!(trim($_POST['desc']) == ""))
			&& (!empty($_POST['city'])) && (!(trim($_POST['city']) == "")) && (!empty($_POST['email'])) && (!(trim($_POST['email']) == ""))){

        $query4 = "INSERT INTO COMPANY(comName, comCity, stateNum, comEmail, comDesc) VALUES (?, ?, ?, ?, ?)";
        $stmt4 = $mysqli->prepare($query4);
        $stmt4-> execute([$_POST['name'], $_POST['city'], $_POST['state'], $_POST['email'], $_POST['desc']]);


        if($stmt4){
          $query5 = "SELECT comID FROM COMPANY WHERE comName = ?";
          $stmt5 = $mysqli ->prepare($query5);
          $stmt5 -> execute([$_POST['name']]);
        }
        else{
          $_SESSION['message'] = "Error could not add a company\n" ;
        }

          if($stmt5) {
            $_SESSION['message'] = $_POST['name']." has been added\n";
          }else{
            $_SESSION["message"] = "Error!! Could not add " .$_POST['name']."\n";
          }
          redirect("OMSreadcompany_admins.php");

				}else{
					$_SESSION["message"] = "Unable to add a company! Fill in all information!\n";
	        redirect("OMScreate_companies.php");
				}
      }else {
        $_SESSION["message"] = "Unable to add a company! Fill in all information!\n";
        redirect("OMScreate_companies.php");
      }
			redirect("OMSreadcompany_admins.php");
}else {
      echo "<form action='OMScreate_companies.php' method='POST'>\n";
      echo "<p>Company Name: <input type=text name='name'></p>\n";
      echo "<p>City: <input type=text name='city'></p>\n";
      echo "<p>State: <select name='state'>";
      $query1 = "SELECT * FROM STATE ORDER BY stateCode ASC";
      $stmt1 = $mysqli -> prepare($query1);
      $stmt1 -> execute();
      while($row = $stmt1->fetch(PDO::FETCH_ASSOC)) {
        echo "<option value =".$row["stateNum"].">".$row["stateCode"]."</option>\n";
      }
      echo "</select>\n";
      echo "</p>\n";
      echo "<p>Company Email: <input type=email name='email'></p>\n";
      echo "<p>Company Description: <input type=text name='desc'></p>\n";
      echo "</select>\n";
      echo "</p>\n";
      echo "<input type='submit' name='submit' value='Add'/>\n";
      echo "</form>\n";
}
echo "</label>\n";
echo "</div>\n";
echo "<br /><p>&laquo:<a href='OMSreadcompany_admins.php'>Back to Main Page</a>\n";

new_footer(" OMS ");
Database::dbDisconnect($mysqli);

?>
