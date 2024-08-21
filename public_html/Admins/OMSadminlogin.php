<?php

require_once("session.php");
require_once("included_functions_group8.php");
require_once("databasegroup8.php");


new_head("OMS");
$mysqli = Database::dbConnect();
$mysqli -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	if (($output = message()) !== null) {
		echo $output;
	}
			if (isset($_POST["submit"])) {
				$username = $_POST["username"];
				$password = $_POST["password"];
				$query = "SELECT adHash, adUser, adID, adFirst FROM ADMIN WHERE adUser = ?";
				$stmt =  $mysqli->prepare($query);
				$stmt-> execute([$username]);

				if($stmt){
					if($stmt -> rowCount() !== 0){
						$row = $stmt->fetch(PDO::FETCH_ASSOC);
						if(password_check($password, $row['adHash'])){
							session_start();
							$_SESSION['adusername'] = $row['adUser'];
							$_SESSION['aduserID'] = $row['adID'];
							$_SESSION['adfname'] = $row['adFirst'];
							redirect("OMSadminhome.php");
						}else{
							$_SESSION['message'] = "Username/Password Not Found\n";
							redirect("OMSadminlogin.php");
						}
					}else{
						$_SESSION['message'] = "Username/Password Not Found\n";
						redirect("OMSadminlogin.php");
					}
				}
				else{
					$_SESSION['message'] = "Username/Password Not Found\n";
					redirect("OMSadminlogin.php");
				}
			}




		echo "<div class='row'>\n";
		echo "<label for='left-label' class='left inline'>\n";

		echo "<h3>Admin Login for OMS</h3>\n";

		echo "<form action='OMSadminlogin.php' method='post'>\n";
		echo "<p>Username:<input type='text' name='username' value='' /> </p>\n";
		echo "<p>Password: <input type='password' name='password' value='' /> </p>\n";
		echo "<input type='submit' name='submit' value='Login' />\n";
		echo "</form>";
		echo "<p>Are you a user? Click <a href='../OMSlogin.php'>Here.</a></p>\n";
	echo "</div>\n";
	echo "</label>";
new_footer(" OMS ");
Database::dbDisconnect();



 ?>
