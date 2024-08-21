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
			if (isset($_POST["submit"])) {
				$username = $_POST["username"];
				$password = $_POST["password"];
				$query = "SELECT acHash, acUser, acID, acFirst FROM ACCOUNT WHERE acUser = ?";
				$stmt =  $mysqli->prepare($query);
				$stmt-> execute([$username]);

				if($stmt){
					if($stmt -> rowCount() !== 0){
						$row = $stmt->fetch(PDO::FETCH_ASSOC);
						if(password_check($password, $row['acHash'])){
							session_start();
							$_SESSION['username'] = $row['acUser'];
							$_SESSION['userID'] = $row['acID'];
							$_SESSION['fname'] = $row['acFirst'];
							redirect("OMSuserhome.php");
						}else{
							$_SESSION['message'] = "Username/Password Not Found";
							redirect("OMSlogin.php");
						}
					}else{
						$_SESSION['message'] = "Username/Password Not Found";
						redirect("OMSlogin.php");
					}
				}
				else{
					$_SESSION['message'] = "Username/Password Not Found";
					redirect("OMSlogin.php");
				}
			}




		echo "<div class='row'>\n";
		echo "<label for='left-label' class='left inline'>\n";

		echo "<h3>Welcome to OMS!</h3>\n";

		echo "<form action='OMSlogin.php' method='post'>\n";
		echo "<p>Username:<input type='text' name='username' value='' /> </p>\n";
		echo "<p>Password: <input type='password' name='password' value='' /> </p>\n";
		echo "<input type='submit' name='submit' value='Login' />\n";
		echo "</form>\n";
		echo "<p>New User? Sign Up <a href='OMSusersignup.php'>Here.</a></p>\n";
		echo "<p>Are you an admin? Click <a href='Admins/OMSadminlogin.php'>Here.</a></p>\n";

	echo "</div>\n";
	echo "</label>\n";
new_footer(" OMS ");
Database::dbDisconnect();



 ?>
