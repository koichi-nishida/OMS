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

echo "<h3>Add a User</h3>";
echo "<div class='row'>";
echo "<label for='left-label' class='left inline'>";

  if (isset($_POST["submit"])) {

    if((isset($_POST["id"])&& $_POST["id"] !== "") &&(isset($_POST["pwd"]) && $_POST["pwd"] !== "") && (isset($_POST["user"]) && $_POST["user"] !== "")
    && (isset($_POST["fname"]) && $_POST["fname"] !== "") && (isset($_POST["lname"]) && $_POST["lname"] !== "") && (isset($_POST["dob"]) && $_POST["dob"] !== "")
  && (isset($_POST["state"]) && $_POST["state"] !== "") && (isset($_POST["email"]) && $_POST["email"] !== "")&& (isset($_POST["pos"]) && $_POST["pos"] !== "")){

    $acUser = $_POST["user"];
    $acPwd = $_POST["pwd"];

    $query = "SELECT * FROM ACCOUNT WHERE acUser = ?";
    $stmt = $mysqli->prepare($query);
    $stmt-> execute([$_POST['user']]);


      if ($rowNum = $stmt -> rowCount() >= 1) {
        $_SESSION['message'] = "The username already exists";
        redirect("OMScreate_users.php");
      }else{

        $query4 = "INSERT INTO ACCOUNT(acID, acPwd, acUser, acFirst, acFirst, acLast, acDate, acCity, stateNum, acEmail, posID) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt4 = $mysqli->prepare($query4);
        $stmt4-> execute([$_POST['id'], $_POST['pwd'], $_POST['user'], $_POST['fname'], $_POST['lname'], $_POST['dob'], $_POST['state'], $_POST['email'], $_POST['pos']]);


          if($stmt4) {
            $_SESSION['message'] = $_POST['user']." has been added";
          }else{
            $_SESSION["message"] = "Error!! Could not add " .$_POST['user']."";
          }
          redirect("OMSreadusers_admins.php");
        }

      }else {
        $_SESSION["message"] = "Unable to add a user! Fill in all information!";
        redirect("OMScreate_users.php");
      }

}else {
      echo "<form action='OMScreate_users.php' method='POST'>\n";
      echo "<p>User Name: <input type=text name='user'></p>\n";
      echo "<p>Password: <input type=password name='pwd'></p>\n";
      echo "<p>First Name: <input type=text name='fname'></p>\n";
      echo "<p>Last Name: <input type=text name='lname'></p>\n";
      echo "<p>Date of Birth: <input type=date name='dob'></p>\n";
      echo "<p>City: <input type=text name='city'></p>\n";
      echo "<p>State: <select name='state'>\n";
      $query1 = "SELECT * FROM STATE ORDER BY stateCode ASC";
      $stmt1 = $mysqli -> prepare($query1);
      $stmt1 -> execute();
      while($row = $stmt1->fetch(PDO::FETCH_ASSOC)) {
        echo "<option value =".$row["stateNum"].">".$row["stateCode"]."</option>\n";
      }
      echo "</select>\n";
      echo "</p>";
      echo "<p>Email Address: <input type=text name='email'></p>\n";
      echo "<p>Status: <select name='pos'>\n";
      $query2 = "SELECT * FROM POS ORDER BY posName ASC";
      $stmt2 = $mysqli -> prepare($query2);
      $stmt2 -> execute();
      while($row = $stmt2->fetch(PDO::FETCH_ASSOC)) {
        echo "<option value =".$row["posID"].">".$row["posName"]."</option>\n";
      }
      echo "</select>\n";
      echo "</p>\n";
      echo "<input type='submit' name='submit' value='Add'/>\n";
      echo "</form>";
}
echo "</label>";
echo "</div>";
echo "<br /><p>&laquo:<a href='OMSreadusers_admins.php'>Back to Main Page</a>\n";

new_footer(" OMS ");
Database::dbDisconnect($mysqli);

?>
