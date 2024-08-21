<?php
require_once("session.php");
require_once("included_functions_group8.php");
require_once("databasegroup8.php");



new_header("OMS");

$mysqli = Database::dbConnect();
$mysqli -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if (($output = message()) !== null) {
  echo $output;
}

    echo "<div class='row'>";
		echo "<label for='left-label' class='left inline'>";

		echo "<h3>Welcome to OMS!</h3>";

    if (isset($_POST["submit"])){

      if((isset($_POST["username"])&& $_POST["username"] !== "") &&(isset($_POST["password"]) && $_POST["password"] !== "") && (isset($_POST["first_name"]) && $_POST["first_name"] !== "")
      && (isset($_POST["last_name"]) && $_POST["last_name"] !== "") && (isset($_POST["city"]) && $_POST["city"] !== "")
      &&(isset($_POST["state"]) && $_POST["state"] !== "") && (isset($_POST["email"]) && $_POST["email"] !== "")
     && (isset($_POST["pos"]) && $_POST["pos"] !== "")){
       
       if($_POST['password'] == $_POST['password1']){


       if((!empty($_POST['username'])) && (!(trim($_POST['username']) == "")) && (!empty($_POST['password'])) && (!(trim($_POST['password']) == ""))
       && (!empty($_POST['first_name'])) && (!(trim($_POST['first_name']) == "")) && (!empty($_POST['city'])) && (!(trim($_POST['city']) == ""))
     && (!empty($_POST['last_name'])) && (!(trim($_POST['last_name']) == "")) && (!empty($_POST['email'])) && (!(trim($_POST['email']) == ""))){


      $username = $_POST["username"];
      $password = $_POST["password"];
      $hashed_password = password_encrypt($password);


      $query = "SELECT * FROM ACCOUNT WHERE acUser = ?";
      $stmt = $mysqli->prepare($query);
      $stmt-> execute([$_POST['username']]);


        if ($rowNum = $stmt -> rowCount() >= 1) {
          $_SESSION['message'] = "The username already exists";
          redirect("OMSusersignup.php");
        }else{

          $query4 = "INSERT INTO ACCOUNT(acUser, acHash, acFirst, acLast, acCity, stateNum, acEmail, posID) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
          $stmt4 = $mysqli->prepare($query4);
          $stmt4->execute([$_POST['username'], $hashed_password, $_POST['first_name'], $_POST['last_name'], $_POST['city'], $_POST['state'], $_POST['email'], $_POST['pos']]);

            if($stmt4) {
              $_SESSION['message'] = $_POST['username']." has been added. Log in!!";
              redirect("OMSlogin.php");
            }else{
              $_SESSION["message"] = "Error!! Could not add a user";
              redirect("OMSusersignup.php");
            }
          }
      }else{
        $_SESSION['message'] = "Could not sign up!! Fill in all information!";
        redirect("OMSusersignup.php");
      }

    }else{
      $_SESSION['message'] = "Password does not match!";
      redirect("OMSusersignup.php");
    }
  }else{
      $_SESSION['message'] = "Could not sign up!! Fill in all information!";
      redirect("OMSusersignup.php");
    }
  }
else{
		echo "<form action='OMSusersignup.php' method='post'>\n";
		echo "<p>Username: <input type='text' name='username'> </p>\n";
		echo "<p>Password: <input type='password' name='password'/> </p>\n";
    echo "<p>Confirm Password: <input type='password' name='password1'/> </p>\n";
		echo "<p>First Name: <input type='text' name='first_name'> </p>\n";
		echo "<p>Last Name: <input type='text' name='last_name'> </p>\n";
		echo "<p>City: <input type='text' name='city'> </p>\n";
    echo "<p>State: <select name='state'>\n";
    $query1 = "SELECT * FROM STATE ORDER BY stateCode ASC";
    $stmt1 = $mysqli -> prepare($query1);
    $stmt1 -> execute();
    while($row = $stmt1->fetch(PDO::FETCH_ASSOC)) {
      echo "<option value =".$row["stateNum"].">".$row["stateCode"]."</option>\n";
    }
    echo "</select>\n";
    echo "</p>\n";
		echo "<p>Email: <input type='email' name='email' value='' /> </p>\n";
    echo "<p>Status: <select name='pos'>\n";
    $query2 = "SELECT * FROM POS ORDER BY posID ASC";
    $stmt2 = $mysqli -> prepare($query2);
    $stmt2 -> execute();
    while($row1 = $stmt2->fetch(PDO::FETCH_ASSOC)) {
      echo "<option value =".$row1["posID"].">".$row1["posName"]."</option>\n";
    }
    echo "</select>\n";
    echo "</p>\n";
		echo "<input type='submit' name='submit' value='Sign Up' />\n";
		echo "</form>\n";
}
  echo "</label>\n";
	echo "</div>\n";
  echo "<br /><p>&laquo:<a href='OMSlogin.php'>Back to Login Page</a></p>\n";

  new_footer(" OMS ");
  Database::dbDisconnect($mysqli);
?>
